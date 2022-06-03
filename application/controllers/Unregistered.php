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
        $this->load->model('ReceivedBranch_ViewModel');
        $this->load->model('Received_ViewModel');
         $this->load->model('Bags_ViewModel');
         $this->load->model('Despatch_ViewModel');
          $this->load->model('parcel_model');
            $this->load->model('payroll_model');
            $this->load->model('FGN_Application_model');
          $this->load->model('Posta_Mlangoni_Model');
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



  //POSTA MLANGONI START


///POSTA MLANGONI


 public function bulk_bill_postamlangoni_sender_info()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            // $Barcode = $this->input->post('Barcode');
             $sender_address = $this->input->post('s_mobilev');
             $Barcode = $this->input->post('Barcode');
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


              $serial = $this->input->post('serial');
            if(empty($serial)){
               $serial    = 'Postamlangoni'.date("YmdHis").$this->session->userdata('user_emid');

               // $serial    = 'Register'.date("YmdHis").$this->session->userdata('user_emid');

            }

            $trans = $this->input->post('transport');
            
            // $s_fname = $this->input->post('s_fname');
            // $s_address = $this->input->post('s_address');
            $type = $this->input->post('emsname');
            $weight = $this->input->post('weight');
            
            // $s_mobile = $this->input->post('s_mobile');
            // $s_email = $this->input->post('s_email');
            // $r_fname = $this->input->post('r_fname');
            // $r_address = $this->input->post('r_address');
            // $r_mobile = $this->input->post('r_mobile');

            // $o_region = $region_to = $this->input->post('region_to');
            // $rec_region = $district = $this->input->post('district');

             $o_region = $region_to = $rec_region;
            $rec_region = $district =  $rec_dropp;

            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');

             $askfor = $this->input->post('askfor');

            $price1 = $this->input->post('price');
            $I = $this->input->post('crdtid');
             $info =  $custinfo = $this->Box_Application_model->get_customer_infos($I);
             $custype =  $info->customer_type;
             $custprice = $info->price;
              
            $accno = $this->input->post('accno');
            //$price = $this->unregistered_model->unregistered_cat_price($type,$weight);

          
            $id = $emid = $this->session->userdata('user_login_id');
            //$ad_fee = $this->input->post('ad_fee');
            //$tarrif = $this->input->post('destination');
            //$item   = $this->input->post('itemtype');

         
               $price = $this->Posta_Mlangoni_Model->postamlangoni_cat_price($type,$weight);
           
               if($type=='ZONE A'){
               $paidamount = $Total = $price->tariff_cost + $price->tariff_vat;
               }
               else{
               $paidamount = $Total = $price->tariff_cost + $price->tariff_vat+$price->charge;  
               }
               
                $diffp = $custprice-$paidamount;

               if($custype == "PostPaid"){

                if($info->price < $paidamount){
                  
                  echo 'Umefikia Kiwango Cha mwisho';

                }else {

              $diffp = $custprice-$paidamount;

              if($diffp > 0) {

                 $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($region_to);
                $bagsNo = $source->reg_code . $dest->reg_code;

                $number = $this->getnumber();
                $bagsNo = $source->reg_code . $dest->reg_code;
                @$trackNo = 'PM'.@$source->reg_code . @$dest->reg_code.$number.'TZ';


                $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$trans,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'acc_no'=>$accno,'sender_type'=>$type,'track_number'=>$trackNo);
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);


            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$region_to,'reciver_branch'=>$district,'receiver_fullname'=>$r_fname);

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

              $emid = $this->session->userdata('user_login_id');
                //getting user or staff department section
                $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

                //user information
                $basicinfo = $this->employee_model->GetBasic($emid);
                $region = $basicinfo->em_region;
                $em_branch = $basicinfo->em_branch;

                //for One Man
                $office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';

              
               $trans = array();
                $trans = array(

                'serial'=>$serial,
                'paidamount'=>$Total,
                'register_id'=>$last_id,
                'Barcode'=>strtoupper($Barcode),
                'office_name'=>$office_one_name,
                'created_by'=>$emid,
                'transactionstatus'=>'POSTED',
                 'bill_status'=>'BILLING',
                  // 'paymentFor'=>'MAIL',
                  'status'=>'Paid'

                );
           

            $db2 = $this->load->database('otherdb', TRUE); 
            //$db2->insert('register_transactions',$trans);
            $lastTransId = $this->unregistered_model->save_transactions($trans);

            //for One Man
            $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';


             //for tracing
            $trace_data = array(
            'emid'=>$emid,
            'trans_type'=>'mails',
            'transid'=>$lastTransId,
            'office_name'=>$office_trance_name,
            'description'=>'Acceptance '.$em_branch,
            'status'=>'Acceptance');

            //for trace data
            $this->Box_Application_model->tracing($trace_data);


             $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


             echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>SN</b></th><th><b>Reference</b></th><th><b>Receiver</b></th><th><b>Sender</b></th><<th><b>Branch Origin</b></th><th><b>Destination Branch</b></th><th><b>Barcode</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $sn=1;
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$sn."</td><td>".$value->r_address."</td><td>".$value->receiver_fullname."</td><td>".$value->sender_fullname."</td><td>".$value->sender_branch."</td><td>".$value->reciver_branch."</td><td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                 $sn++;
                }

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                   
                        ";





                

                            }else{

                             echo 'Umefikia Kiwango Cha mwisho'; 
                
                            }

                    }

               }else{ //prepaid

                 $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($region_to);
                $bagsNo = $source->reg_code . $dest->reg_code;

                $number = $this->getnumber();
                $bagsNo = $source->reg_code . $dest->reg_code;
                @$trackNo = 'PM'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

                $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$trans,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'acc_no'=>$accno,'sender_type'=>$type,'track_number'=>$trackNo);
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);


            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$region_to,'reciver_branch'=>$district,'receiver_fullname'=>$r_fname);

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
                'Barcode'=>strtoupper($Barcode),
                'transactionstatus'=>'POSTED',
                 'bill_status'=>'PENDING',
                  // 'paymentFor'=>'MAIL',
                  'status'=>'Paid'

                );
           

            $db2 = $this->load->database('otherdb', TRUE); 
            $db2->insert('register_transactions',$trans);


             $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


             echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Reference</b></th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->r_address."</td><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>
               

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                   
                        ";



               }

               


            
            

               

          

        }else{
            redirect(base_url());
        }
    }


///POSTA MLANGONI


  //POSTA MLANGONI END
  

  public function mail_bulk_posting()
    {
    if ($this->session->userdata('user_login_access') != false)
                {
                    $this->load->view('inlandMails/mails-bulk-posting-dashboard');
                }
                else{
                    redirect(base_url());
                }
    }

    public function transfered_item_list(){
    
    $data['region'] = $this->employee_model->regselect();
        //$data['list'] = $this->unregistered_model->get_register_application_list();
        //$data['sum']  = $this->unregistered_model->get_sum_register();
    
    $this->load->view('inlandMails/transfered_item');
  }

   public function international_bulk_registered_form()
    {
        #Redirect to Admin dashboard after authentication
          if($this->session->userdata('user_type') =='ACCOUNTANT' ||
         $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

          // redirect(base_url('Parcel/international_parcel_list'));

         }
        elseif ($this->session->userdata('user_login_access') == 1){
            $data['country'] = $this->Unregistered_model->International_register_country_name();
            $this->load->view('inlandMails/register-post-international-bulk-form',$data);
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
              $checkJobAssign = 1;//$this->unregistered_model->check_job_assign1($ids);
              $data['I'] = $id = base64_decode($this->input->get('I'));
              $data['askfor'] = $this->input->get('AskFor');
            if ($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' || $this->session->userdata('user_type') == "ACCOUNTANT"|| $this->session->userdata('user_type') == "RM") {
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

    public function updateControlNumberMails($serial){

        if (!empty($serial)) {

            $check = $this->unregistered_model->get_mail_repost_bySerial($serial);

            $serial=$check->serial;
            $paidamount=$check->paidamount;
            $serviceId = 'MAIL';
            $trackno = '';

            $transaction = $this->getBillGepgBillIdMail($serial,$paidamount,$serviceId,$trackno);

            if ($transaction) {
               
                if (!empty($transaction->channel) && !empty($transaction->receipt)) {

                   $update = array('billid'=>@$transaction->controlno,'bill_status'=>'SUCCESS','receipt'=>@$transaction->receipt,'paychannel'=>@$transaction->channel,'paymentdate'=>@$transaction->paydate,'status'=>'Paid');

                }else{
                    $update = array('billid'=>@$transaction->controlno,'bill_status'=>'SUCCESS');
                }

                
                $this->unregistered_model->update_register_transactions($update,$serial);

                //redirect('Loan_Board/loan_board_transactions_list');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                //redirect('Loan_Board/loan_board_transactions_list');
                redirect($_SERVER['HTTP_REFERER']);
            }

            
        }else{
            //redirect('Loan_Board/loan_board_transactions_list');
            redirect($_SERVER['HTTP_REFERER']);
        }

    }

    public function getBillGepgBillIdMail($serial, $paidamount,$serviceId,$trackno){

    $AppID = 'POSTAPORTAL';

    $data = array(
    'AppID'=>$AppID,
    'BillAmt'=>$paidamount,
    'serial'=>$serial,
    //'District'=>$district,
    //'Region'=>$region,
    'service'=>$serviceId,
    //'item'=>$renter,
    //'mobile'=>$mobile,
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

    public function unregistered_bulk_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)

            if($this->session->userdata('user_type') =='ACCOUNTANT' || $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

              redirect(base_url('Unregistered/register_application_list'));

               }



              $ids = $this->session->userdata('user_login_id');
              $checkJobAssign = 1;//$this->unregistered_model->check_job_assign1($ids);
              $data['I'] = $id = base64_decode($this->input->get('I'));
              $data['askfor'] = $this->input->get('AskFor');
            if ($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' || $this->session->userdata('user_type') == "ACCOUNTANT"|| $this->session->userdata('user_type') == "RM") {
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


public function unregistered_rtx_bulk_form()
 {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)

            if($this->session->userdata('user_type') =='ACCOUNTANT' || $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

              redirect(base_url('Unregistered/register_application_list'));

               }
              $ids = $this->session->userdata('user_login_id');
              $data['I'] = $id = base64_decode($this->input->get('I'));
              $data['askfor'] = $this->input->get('AskFor');
              $this->load->view('inlandMails/unregistered_rtx_bulk_form',$data);
}

    

public function unregistered_bill_bulk_form()
{
    #Redirect to Admin dashboard after authentication
    if ($this->session->userdata('user_login_access') == 1)

        if($this->session->userdata('user_type') =='ACCOUNTANT' || $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

          redirect(base_url('Unregistered/register_application_list'));

           }
          $ids = $this->session->userdata('user_login_id');
          $checkJobAssign = 1;//$this->unregistered_model->check_job_assign1($ids);
          $data['I'] = $id = base64_decode($this->input->get('I'));
          $data['askfor'] = $this->input->get('AskFor');
        if ($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' || $this->session->userdata('user_type') == "ACCOUNTANT"|| $this->session->userdata('user_type') == "RM") {
                 $data['ems_cat'] = $this->Box_Application_model->ems_cat();
            $this->load->view('inlandMails/unregistered_bulk_form',$data);
          } else {

         if (empty($checkJobAssign)) {
               $data['message'] = "Please Contact your supervisor to assign a job/task for today date";
               $this->load->view('inlandMails/supervisor-sms-contact',$data);
           } else {

            $data['ems_cat'] = $this->Box_Application_model->ems_cat();
            $data['custinfo'] = $this->Bill_Customer_model->get_bill_cust_details_info($id);
            if(empty($id)){
               $this->load->view('inlandMails/unregistered_bulk_form',$data);

            }else{
               $this->load->view('inlandMails/unregistered_bill_bulk_form',$data);
            }
           

           }
         }
}



    public function unregistered_bill_bulk_post_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)

            if($this->session->userdata('user_type') =='ACCOUNTANT' || $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

              redirect(base_url('Unregistered/mail_bulk_bill_customer_list'));

               }



              $ids = $this->session->userdata('user_login_id');
              $checkJobAssign = $this->unregistered_model->check_job_assign1($ids);
              $data['I'] = $id = base64_decode($this->input->get('I'));
              $data['askfor'] = $this->input->get('AskFor');
            if ($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' || $this->session->userdata('user_type') == "ACCOUNTANT"|| $this->session->userdata('user_type') == "RM") {
                     $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('inlandMails/unregistered_bill_bulk_post_form',$data);
              } else {

             if (empty($checkJobAssign)) {
                   $data['message'] = "Please Contact your supervisor to assign a job/task for today date";
                   $this->load->view('inlandMails/supervisor-sms-contact',$data);
               } else {

                $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $data['custinfo'] = $this->Bill_Customer_model->get_bill_cust_details_info($id);
                if(empty($id))
                {
                   $this->load->view('inlandMails/unregistered_bill_bulk_post_form',$data);

                }else
                {
                   $this->load->view('inlandMails/unregistered_bill_bulk_post_form',$data);
                }
               

               }
             }
    }


 public function unregistered_latter_bulk_post_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)

            if($this->session->userdata('user_type') =='ACCOUNTANT' || $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

              redirect(base_url('Unregistered/mail_bulk_bill_customer_list'));

               }



              $ids = $this->session->userdata('user_login_id');
              $checkJobAssign = $this->unregistered_model->check_job_assign1($ids);
              $data['I'] = $id = base64_decode($this->input->get('I'));
              $data['askfor'] = $this->input->get('AskFor');
            if ($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' || $this->session->userdata('user_type') == "ACCOUNTANT"|| $this->session->userdata('user_type') == "RM") {
                     $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('inlandMails/unregistered_bill_bulk_post_form',$data);
              } else {

             if (empty($checkJobAssign)) {
                   $data['message'] = "Please Contact your supervisor to assign a job/task for today date";
                   $this->load->view('inlandMails/supervisor-sms-contact',$data);
               } else {

                $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $data['custinfo'] = $this->Bill_Customer_model->get_bill_cust_details_info($id);
                if(empty($id))
                {
                   $this->load->view('inlandMails/unregistered_latter_bulk_post_form',$data);

                }else
                {
                   $this->load->view('inlandMails/unregistered_latter_bulk_post_form',$data);
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
              
            if ($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER' ) {
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
        {

           $type = $this->input->post('tariffCat');
           $weight = $this->input->post('weight');
           $ad_fee = $this->input->post('ad_fee');
           $crdtid = $this->input->post('crdtid');

            if(!empty($crdtid)){

            

           $custinfo = $this->Box_Application_model->get_customer_infos($crdtid);
              



            if($custinfo->customer_name ==='NMB-CARD'){  
                $prs=0;

            if($weight <= 20){
                $prs=6500;

            }elseif (( $weight > 20 ) && ($weight <= 50)) {
                $prs=6600;
            }elseif (( $weight > 50 )&& ($weight <= 100)) {
                $prs=7000;
            }elseif (( $weight > 100) && ($weight <= 250)) {
                $prs=8000;
            }elseif (( $weight > 250) && ($weight <= 500)) {
                $prs=9500;
            }elseif (($weight> 500) && ($weight <= 1000)) {
                $prs=11900;
            }elseif (( $weight > 1000) && ($weight <= 2000)) {
                $prs=13100;
            }else{//inachukua tarrif ya parcel

                $types = 'Ordinary';
                $kgweight = $weight/1000;
                 $prices = $this->unregistered_model->parcel_post_land_cat_price($types,$kgweight);


                 $prs=$prices->tarrif + $prices->vat;

            }


                $emsprice = $Total = $prs;
                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                 <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                  <tr><td><b>Total Price:</b></td><td><input readonly value='".$emsprice."'/></td></tr>
             </table>
                     <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                         ";



            }elseif ($custinfo->customer_name ==='NMB-FACILITY') {
                $prs=11900;
                 $emsprice = $Total = $prs;

                  echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                 <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                  <tr><td><b>Total Price:</b></td><td><input class='dpTotalPrice' readonly value='".$emsprice."'/></td></tr>
             </table>
                     <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                         ";

            }
            else{

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
                <tr><td><b>Tariff:</b></td><td><input readonly value='".$price->price."'/></td></tr>
                <tr><td><b>Registration Fee:</b></td><td><input class='dpregFee' readonly value='".$price->s_charge."'/></td></tr>
                <tr><td><b>Registration Vat:</b></td><td><input class='dpvat' readonly value='".$price->s_vat."'/></td></tr>
                <tr><td><b>Ad Fee:</b></td><td><input readonly value='".$price->ad_fee."'/></td></tr>
                 <tr><td><b>Total Price:</b></td><td><input class='dpTotalPrice' readonly value='".$emsprice."'/></td></tr>
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
                <tr><td><b>Tariff:</b></td><td><input readonly value='".$price->price."'/></td></tr>
                 <tr><td><b>Registration Fee:</b></td><td><input class='dpregFee' readonly value='".$price->s_charge."'/></td></tr>
                 <tr><td><b>Registration Vat:</b></td><td><input class='dpvat' readonly value='".$price->s_vat."'/></td></tr>
                  <tr><td><b>Total Price:</b></td><td><input class='dpTotalPrice' readonly value='".$emsprice."'/></td></tr>
             </table>
                     <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                         ";
                
             }
                
            }
        }

    }else{

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
                <tr><td><b>Tariff:</b></td><td><input readonly value='".$price->price."'/></td></tr>
                <tr><td><b>Registration Fee:</b></td><td><input class='dpregFee' readonly value='".$price->s_charge."'/></td></tr>
                <tr><td><b>Registration Vat:</b></td><td><input class='dpvat' readonly value='".$price->s_vat."'/></td></tr>
                <tr><td><b>Ad Fee:</b></td><td><input class='dpAdFee' readonly value='".$price->ad_fee."'/></td></tr>
                 <tr><td><b>Total Price:</b></td><td><input class='dpTotalPrice' readonly value='".$emsprice."'/></td></tr>
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
                <tr><td><b>Tariff:</b></td><td><input readonly class='dprice' value='".$price->price."'/></td></tr>
                 <tr><td><b>Registration Fee:</b></td><td><input class='dpregFee' readonly value='".$price->s_charge."'/></td></tr>
                 <tr><td><b>Registration Vat:</b></td><td><input class='dpvat' readonly value='".$price->s_vat."'/></td></tr>
                  <tr><td><b>Total Price:</b></td><td><input class='dpTotalPrice' readonly value='".$emsprice."'/></td></tr>
             </table>
                     <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                         ";
                
             }
                
            }
        



    }
    }
}




     public function Olduregister_price()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
        {

           $type = $this->input->post('tariffCat');
           $weight = $this->input->post('weight');
           $ad_fee = $this->input->post('ad_fee');
           $crdtid = $this->input->post('crdtid');

            if(!empty($crdtid)){

            

           $custinfo = $this->Box_Application_model->get_customer_infos($crdtid);
              



            if($custinfo->customer_name ==='NMB-CARD'){  
                $prs=0;

            if($weight <= 20){
                $prs=6500;

            }elseif (( $weight > 20 ) && ($weight <= 50)) {
                $prs=6600;
            }elseif (( $weight > 50 )&& ($weight <= 100)) {
                $prs=7000;
            }elseif (( $weight > 100) && ($weight <= 250)) {
                $prs=8000;
            }elseif (( $weight > 250) && ($weight <= 500)) {
                $prs=9500;
            }elseif (($weight> 500) && ($weight <= 1000)) {
                $prs=11900;
            }elseif (( $weight > 1000) && ($weight <= 2000)) {
                $prs=13100;
            }else{//inachukua tarrif ya parcel

                $types = 'Ordinary';
                $kgweight = $weight/1000;
                 $prices = $this->unregistered_model->parcel_post_land_cat_price($types,$kgweight);


                 $prs=$prices->tarrif + $prices->vat;

            }




                $emsprice = $Total = $prs;
                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                 <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                  <tr><td><b>Total Price:</b></td><td>".number_format($emsprice,2)."</td></tr>
             </table>
                     <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                         ";



            }elseif ($custinfo->customer_name ==='NMB-FACILITY') {
                $prs=11900;
                 $emsprice = $Total = $prs;

                  echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                 <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                  <tr><td><b>Total Price:</b></td><td>".number_format($emsprice,2)."</td></tr>
             </table>
                     <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                         ";

            }
            else{

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

    }else{

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
    }
}


    public function latter_price()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)

           $type = $this->input->post('tariffCat');
           $weight = $this->input->post('weight');
           $quantity = $this->input->post('quantity');

           $crdtid = $this->input->post('crdtid');

            $inn = $this->input->post('inn');
           $out = $this->input->post('out');

             $customer =$this->Bill_Customer_model->get_customer_bill_credit_by_id($crdtid);
            if($customer->customer_name == 'NBAA.'){

                if($inn == 'onn'){

                     $emsprice = 900*$quantity ;

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                 <tr><td><b>Total Price:</b></td><td>".number_format($emsprice,2)."</td></tr>
                </table>
                    <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                        ";

                }elseif ($out == 'onn') {

                     $emsprice = 1000*$quantity ;

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                 <tr><td><b>Total Price:</b></td><td>".number_format($emsprice,2)."</td></tr>
                </table>
                    <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                        ";
                   
                }

               


            }else{

           if ($type == "Ordinary Latter"){
            $price = $this->unregistered_model->unregistered_cat_price($type,$weight);
            if (empty($price)) {

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th colspan='2'>Charges</th></tr>
                <tr><td><b>Price:</b></td><td>0</td></tr>
                <tr><td><b>Total Price:</b></td><td>0</td></tr>
                </table>";

            }else{

                
                $emsprice = ($price->price  + $price->s_vat)*$quantity ;

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                <tr><td><b>Tariff:</b></td><td>".number_format($price->price,2)."</td></tr>
                
                <tr><td><b> Vat:</b></td><td>".number_format($price->s_vat,2)."</td></tr>
               
                 <tr><td><b>Total Price:</b></td><td>".number_format($emsprice,2)."</td></tr>
                </table>
                    <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                        ";
            }
               
            }
        }
    }

     public function International_register_price()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)

           $type = $this->input->post('tariffCat');
           $weight = $this->input->post('weight');
           $zoneid = $this->input->post('catid');

           

           if ($type == "Document"){
            $price = $this->unregistered_model->unregistered_international_cat_price($type,$weight,$zoneid);
            if (empty($price)) {

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th colspan='2'>Charges</th></tr>
                <tr><td><b>Price:</b></td><td>0</td></tr>
                <tr><td><b>Total Price:</b></td><td>0</td></tr>
                </table>";

            }else{

                $total=$price->total;
               

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                <tr><td><b>Postage:</b></td><td>".number_format($price->postage,2)."</td></tr>
                <tr><td><b>Registration Fee:</b></td><td>".number_format($price->registration,2)."</td></tr>
                
                <tr><td><b>Ad Fee:</b></td><td>".number_format($price->add_fee,2)."</td></tr>
                 <tr><td><b>Total Price:</b></td><td>".number_format($total,2)."</td></tr>
                </table>
                    <input type='hidden' name ='price1' value='$total' class='price1'>
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




public function register_sender_info(){
    if ($this->session->userdata('user_login_access') != false){
        $userid = $this->session->userdata('user_login_id');

        $emstype = $this->input->post('emstype');
        $emsCat = $this->input->post('emsCat');
        $tariffCatCity = $this->input->post('tariffCatCity');
        $boxtypeDistrict = $this->input->post('boxtypeDistrict');
        $Barcode = $this->input->post('Barcode');
        $weight = $this->input->post('weight');
        $registerType = $this->input->post('registerType');
        $senderselect = $this->input->post('senderselect');
        $receiverselect = $this->input->post('receiverselect');

        //sender information
        $s_fname = $this->input->post('s_fname');
        $s_address = $this->input->post('s_address');
        $s_email = $this->input->post('s_email');
        $s_mobile = $this->input->post('s_mobile');
        $s_addressType = $this->input->post('s_addressType');

        //receiver information
        $r_fname = $this->input->post('r_fname');
        $r_address = $this->input->post('r_address');
        $r_mobile = $this->input->post('r_mobile');
        $r_email = $this->input->post('r_email');
        $rec_region = $this->input->post('rec_region');
        $rec_district = $this->input->post('rec_dropp');
        $r_addressType = $this->input->post('r_addressType');
        $acc_no = $this->input->post('acc_no');


        $add_type_receiver = $this->input->post('add_type_receiver');
        $add_type_sender = $this->input->post('add_type_sender');

        $price = $this->input->post('price');

        //Staff information
        $info = $this->employee_model->GetBasic($userid);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;

        //getting user or staff department section
        $staff_section = $this->employee_model->getEmpDepartmentSections($userid);

        //Timing
        $tz = 'Africa/Nairobi';
        $tz_obj = new DateTimeZone($tz);
        $today = new DateTime("now", $tz_obj);
        $CurrentDate = $today->format('Y-m-d');
        $CurrentDateTime = $today->format('YmdHis');
        // $CurrentTime = $today->format('YmdHis');
      
        $transactiondate = $CurrentDate;
        $fullname  = $s_fname;

       
        $sender_region = $o_region = $this->session->userdata('user_region');
        $sender_branch = $o_branch = $this->session->userdata('user_branch');

        
        $rondom = substr(date('dHis'), 1);
        $serial    = 'Register'.$CurrentDateTime.$this->session->userdata('user_emid');
        $billcode = '7';//bag code in tracking number
        $source = $this->employee_model->get_code_source($sender_region);
        $dest = $this->employee_model->get_code_dest($rec_region);

        $number = $this->getnumber();

        $bagsNo = $source->reg_code . $dest->reg_code;
        @$trackNo = 'Register'.@$source->reg_code . @$source->reg_code.$number.'TZ';
        

        $db2 = $this->load->database('otherdb', TRUE);

        $priceData['emsprice'] = $this->input->post('Dpprice');
        $priceData['vat'] = $this->input->post('Dpvat');
        $priceData['totalPrice'] = $this->input->post('DpTotalPrice');


        //Sender Information
       $sender = array(
        'sender_fullname'=>$s_fname,
        'sender_address'=>$s_address,
        'sender_mobile'=>$s_mobile,
        'register_type'=>$registerType,
        'sender_region'=>$o_region,
        'sender_branch'=>$sender_branch,
        'register_weght'=>$weight,
        'register_price'=>$priceData['totalPrice'],
        'operator'=>$userid,
        'acc_no'=>$acc_no,'add_type'=>$senderselect);

       $db2->insert('sender_person_info',$sender);
       $savedSenderInfoId = $db2->insert_id();


       //Receiver information
        $receiver = array(
            'sender_id'=>$savedSenderInfoId,
            'r_address'=>$r_address,
            'receiver_region'=>$rec_region,
            'reciver_branch'=>$rec_district,
            'receiver_fullname'=>$r_fname,
            'receiver_mobile'=>$r_mobile,
            'add_type'=>$receiverselect);

        $db2->insert('receiver_register_info',$receiver);
        $savedReceiverInfoId = $db2->insert_id();

         //for One Man
        $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';


           $db2 = $this->load->database('otherdb', TRUE);
            $trans = array(
            'serial'=>$serial,
            'paidamount'=>$priceData['totalPrice'],
            'register_id'=>$savedSenderInfoId,
            'Barcode'=>strtoupper($Barcode),
            'office_name'=>$office_trance_name.' receive',
            'created_by'=>$userid,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING'
            );

         
            $lastTransId = $this->unregistered_model->save_transactions($trans);
           

            //for tracing
            $trace_data = array(
            'emid'=>$userid,
            'transid'=>$lastTransId,
            'trans_type'=>'mails',
            'office_name'=>$office_trance_name,
            'description'=>'Acceptance',
            'status'=>'Acceptance');

            //for trace data
            $this->Box_Application_model->tracing($trace_data);
            //--------------------
             $renter   = $s_fname;
            $serviceId = 'MAIL';
            // $results='';


            if ($lastTransId) {
                 $results['status'] = "Success";

                 //$results['message'] = "Successfull saved";
                $transaction = $this->Control_Number_model->get_control_number($serial, $priceData['totalPrice'],$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackNo);


                 if ($transaction) {
                    //update controll number after getting from the GateWay
                    
                    $this->unregistered_model->update_register_transactions1(
                    array('billid'=>$transaction->controlno,
                        'bill_status'=>'SUCCESS'),$serial);


                      $sms ="KARIBU POSTA KIGANJANI umepatiwa ankara namba ".@$transaction->controlno." Kwaajili ya huduma ya Register,Kiasi unachotakiwa kulipia ni TSH.".number_format($priceData['totalPrice'],2);

                      //Send message
                      $this->Sms_model->send_sms_trick($s_mobile,$sms);

                      $results['message'] = $sms;

                 }else{
                    $results['message'] = 'Item yako imeshasajiliwa ila control number aijatoka, wasiliana na wataalam wa ICT';
                 }

            }

        print_r(json_encode($results));
    }else{
        redirect(base_url());
    }
}













    public function Oldregister_sender_info()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $Barcode = $this->input->post('Barcode');
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
            
             $rondom = substr(date('dHis'), 1);
              $billcode = '7';//bag code in tracking number
              $source = $this->employee_model->get_code_source($sender_region);
              $dest = $this->employee_model->get_code_dest($rec_region);


            if (@$askfor == "MAILS" || @$askfor == "Register" ) {
              
             

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
              
                    redirect(base_url('Bill_Customer/bill_customer_list?AskFor='.$askfor));

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

            $emid = $this->session->userdata('user_login_id');
            //getting user or staff department section
            $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

            //for One Man
            $office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';

            $trans = array(
            'serial'=>$serial,
            'paidamount'=>$Total,
            'register_id'=>$last_id,
            'Barcode'=>strtoupper($Barcode),
            'office_name'=>$office_one_name,
            'created_by'=>$emid,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING'
            );

            $db2 = $this->load->database('otherdb', TRUE);
            //$db2->insert('register_transactions',$trans);
            $lastTransId = $this->unregistered_model->save_transactions($trans);

            //for One Man
            $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

            //for tracing
            $trace_data = array(
            'emid'=>$emid,
            'trans_type'=>'mails',
            'transid'=>$lastTransId,
            'office_name'=>$office_trance_name,
            'description'=>'Acceptance',
            'status'=>'IN');

            //for trace data
            $this->Box_Application_model->tracing($trace_data);

            $renter   = $s_fname;
            $serviceId = 'MAIL';
             $number = $this->getnumber();
              //$bagsNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

              
              @$trackno = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';


           // $trackno = '009';

            $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

            //$controlno = $transaction->controlno;

            if (!empty(@$postbill->controlno)) {

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
                $update = array('billid'=>@$postbill->controlno,'bill_status'=>'SUCCESS');
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$postbill->controlno.' Kwaajili ya huduma ya '.$type.' Register  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
           
            //if (!empty($transaction->$controlno)) {
                
                $this->load->view('inlandMails/control-number-form',$data);
                
                $this->Sms_model->send_sms_trick($s_mobile,$sms);
            }else{

              

                $repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno); 

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($rec_region);
                $bagsNo = $source->reg_code . $dest->reg_code;

                
                $first4 = substr(@$repostbill->controlno, 4);
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
                $update = array('billid'=>@$repostbill->controlno,'bill_status'=>'SUCCESS');
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$repostbill->controlno.' Kwaajili ya huduma ya '.$type.' Register  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
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

  $Barcode = $this->input->post('Barcode');
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
              $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'acc_no'=>$acc_no,'add_type'=>$addressT,'track_number'=>$trackNo);
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

              $emid = $this->session->userdata('user_login_id');
            //getting user or staff department section
            $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

            //for One Man
            $office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';



              
           $trans = array();
            $trans = array(

            'serial'=>$serial,
            'paidamount'=>$Total,
            'register_id'=>$last_id,
             'Barcode'=>strtoupper($Barcode),
             'office_name'=>$office_one_name,
            'created_by'=>$emid,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            // $db2->insert('register_transactions',$trans);
            $lastTransId = $this->unregistered_model->save_transactions($trans);


             //for One Man
            $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

            //for tracing
            $trace_data = array(
            'emid'=>$emid,
            'trans_type'=>'mails',
            'transid'=>$lastTransId,
            'office_name'=>$office_trance_name,
            'description'=>'Acceptance',
            'status'=>'IN');

            //for trace data
            $this->Box_Application_model->tracing($trace_data);



              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


            echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->register_price,2)."</td><td>
                   <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button></td></tr>";
                }

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$$last_id." class='senders'>
                 <input type='hidden' name ='serial' value='$serial' class='serial'>
                   
                        ";


              } 
              
                   // redirect(base_url('Bill_Customer/bill_customer_list?AskFor=MAILS'));

            }else {
            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'add_type'=>$addressT,'track_number'=>$trackNo);
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);

            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$rec_region,'reciver_branch'=>$rec_dropp,'receiver_fullname'=>$r_fname,'receiver_mobile'=>$r_mobile,'add_type'=>$addressR);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('receiver_register_info',$receiver);

             $emid = $this->session->userdata('user_login_id');
            //getting user or staff department section
            $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

            //for One Man
            $office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';



              
           $trans = array();
            $trans = array(
            'serial'=>$serial,
            'paidamount'=>$Total,
            'register_id'=>$last_id,
             'Barcode'=>strtoupper($Barcode),
              'office_name'=>$office_one_name,
            'created_by'=>$emid,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            //$db2->insert('register_transactions',$trans);
            $lastTransId = $this->unregistered_model->save_transactions($trans);


            //for One Man
           $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

           //for tracing
            $trace_data = array(
            'emid'=>$emid,
            'trans_type'=>'mails',
            'transid'=>$lastTransId,
            'office_name'=>$office_trance_name,
            'description'=>'Acceptance',
            'status'=>'IN');

            //for trace data
            $this->Box_Application_model->tracing($trace_data);


              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


             echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>SN</b></th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                $sn = 0;
                foreach ($listbulk as $key => $value) { 
                    $sn++;

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr class='itemRow' style='width:100%;color:#343434;'>
                  <td>".$sn."</td>
                  <td>".$value->receiver_fullname."</td>
                  <td>".$value->sender_fullname."</td>
                  <td>".$value->sender_branch."</td>
                  <td>".$value->reciver_branch."</td>
                  <td>".$value->Barcode."</td>
                  <td>".number_format($value->register_price,2)."</td>
                  <td>
                   <button  
                       data-senderid='".$value->senderp_id ."'
                       data-serial='".$value->serial ."'
                   class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>
               

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                   
                        ";

                       

                         // <input type='hidden' name ='serial' value='$emsprice' class='price1'>


            }
            
       
    }
  
}

public function international_register_sender_bulk_info()
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
            $catid = $this->input->post('catid');
              $itmnumber = $this->input->post('itmnumber');
               $Barcode = $this->input->post('Barcode');

            //$askfor = $this->input->get('AskFor');
            $askfor = $this->input->post('askfor');

            $price1 = $this->input->post('price');
            $I = $this->input->post('crdtid');
            $accno = $this->input->post('acc_no');

            $price = $this->unregistered_model->unregistered_international_cat_price($type,$weight,$catid);
            $getdestination = $this->unregistered_model->Get_International_register_country($catid);
            $rec_region =$getdestination->c_name;
            $rec_dropp = $getdestination->c_zoneid;


            
            if ($type == "Document"){
               $paidamount = $Total = $price->total;
            } else {

                $paidamount = $Total = $price;
                
            }
            

             $rondom = substr(date('dHis'), 1);
              $billcode = '7';//bag code in tracking number
              $source = $this->employee_model->get_code_source($sender_region);
              // $dest = $this->employee_model->get_code_dest($rec_region);

             $number = $this->getnumber();
              //$bagsNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

              $bagsNo = $source->reg_code . $source->reg_code;
              @$trackNo = 'RD'.@$source->reg_code . @$source->reg_code.$number.'TZ';

            if ($askfor == "MAILS") {

              $diffp = $price1-$paidamount;

              if ($diffp > 0) {
                
              $sender = array();//,'acc_no'=>$itmnumber
              $sender = array('sender_type'=>'International','sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'add_type'=>$addressT,'track_number'=>$trackNo);
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
             'Barcode'=>strtoupper($Barcode),
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


            echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td> <td>".@$value->Barcode."</td> <td>".number_format($value->register_price,2)."</td><td>
                   <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button></td></tr>";
                }

              
               
                 
              echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name='crdtid' id='crdtid'   value=".@$custinfo->credit_id.">
                <input type='hidden' name='askfor' id='askfor'  value=".@$askfor.">
                <input type='hidden' name='price' id='price'  value=".@$custinfo->price.">
                <input type='hidden' name='accno' id='accno'  value=".@$custinfo->acc_no.">

                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                 ";



              } 
              
                   // redirect(base_url('Bill_Customer/bill_customer_list?AskFor=MAILS'));

            }else {
                $sendertype='International';
             $sender = array();//,'acc_no'=>$itmnumber
              $sender = array('sender_type'=>$sendertype,'sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'add_type'=>$addressT,'track_number'=>$trackNo);
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
             'Barcode'=>strtoupper($Barcode),
            'register_id'=>$last_id,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('register_transactions',$trans);


              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


             echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination </b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td> <td>".@$value->Barcode."</td> <td>".number_format($value->register_price,2)."</td><td>
                   <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button></td></tr>";
                }

              
               
                 
              echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name='crdtid' id='crdtid'   value=".@$custinfo->credit_id.">
                <input type='hidden' name='askfor' id='askfor'  value=".@$askfor.">
                <input type='hidden' name='price' id='price'  value=".@$custinfo->price.">
                <input type='hidden' name='accno' id='accno'  value=".@$custinfo->acc_no.">

                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                 ";

                       

                         // <input type='hidden' name ='serial' value='$emsprice' class='price1'>


            }
            
       
    }
  
}



public function register_bill_sender_bulk_post_info()
{
        #Redirect to Admin dashboard after authentication
if ($this->session->userdata('user_login_access') == 1){

  $registerType = $this->input->post('emstype');
   $Barcode = $this->input->post('Barcode');
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
             $info =  $custinfo = $this->Box_Application_model->get_customer_infos($I);
              
            $accno = $this->input->post('accno');
            $price = $this->unregistered_model->unregistered_cat_price($type,$weight);


            if($s_fname=='NMB-CARD'){
                $prs=0;

            if($weight <= 20){
                $prs=6500;

            }elseif (( $weight > 20 ) && ($weight <= 50)) {
                $prs=6600;
            }elseif (( $weight > 50 )&& ($weight <= 100)) {
                $prs=7000;
            }elseif (( $weight > 100) && ($weight <= 250)) {
                $prs=8000;
            }elseif (( $weight > 250) && ($weight <= 500)) {
                $prs=9500;
            }elseif (($weight> 500) && ($weight <= 1000)) {
                $prs=11900;
            }elseif (( $weight > 1000) && ($weight <= 2000)) {
                $prs=13100;
            }else{//inachukua tarrif ya parcel


                $types = 'Ordinary';
                $kgweight = $weight/1000;
                 $prices = $this->unregistered_model->parcel_post_land_cat_price($types,$kgweight);



                 $prs=$prices->tarrif + $prices->vat;

            }




                $paidamount = $Total = $prs;



            }elseif ($s_fname=='NMB-FACILITY') {
                $prs=11900;
                 $paidamount = $Total = $prs;

            }else{
            
            if ($type == "Document"){    
               $paidamount = $Total = $price->price + $price->s_charge + $price->s_vat + $price->ad_fee;
            } else {

                if ($ad_fee == "adfee") {
                   @$paidamount = @$Total = @$price->price + @$price->s_charge + $price->s_vat + 1800;
                } else {
                    $paidamount = $Total = $price->price + $price->s_charge + $price->s_vat;
                }
                
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


                if(@$info->customer_type == "PostPaid"){

                if($info->price < $paidamount){
                  
                  echo 'Umefikia Kiwango Cha mwisho';

                }else {

              $diffp = $price1-$paidamount;

              if($diffp > 0) {

               
                
              $sender = array();
              $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'acc_no'=>$accno,'add_type'=>$addressT,'track_number'=>$trackNo,'sender_type'=>'REGISTER BULK POSTING');
              $db2 = $this->load->database('otherdb', TRUE);
              $db2->insert('sender_person_info',$sender);

              $last_id = $db2->insert_id();

              $receiver = array();
             $receiver = array('sender_id'=>$last_id,'receiver_region'=>$rec_region,'reciver_branch'=>$rec_dropp,'receiver_fullname'=>$r_fname,'add_type'=>$addressR);

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

              //---------------Added the
              $emid = $this->session->userdata('user_login_id');

               //getting user or staff department section
                $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

                //user information
                $basicinfo = $this->employee_model->GetBasic($emid);
                $region = $basicinfo->em_region;
                $em_branch = $basicinfo->em_branch;

                //for One Man
                $office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';

              
               $trans = array();
                $trans = array(

                'serial'=>$serial,
                'paidamount'=>$Total,
                'register_id'=>$last_id,
                'Barcode'=>strtoupper($Barcode),
                 'office_name'=>$office_one_name,
                'created_by'=>$emid,
                'transactionstatus'=>'POSTED',
                 'bill_status'=>'BILLING',
                  // 'paymentFor'=>'MAIL',
                  'status'=>'Paid'

                );

            $db2 = $this->load->database('otherdb', TRUE);
           //$db2->insert('register_transactions',$trans);
            $lastTransId = $this->unregistered_model->save_transactions($trans);

             //for One Man
            $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';


            //for tracing
            $trace_data = array(
            'emid'=>$emid,
            'trans_type'=>'mails',
            'transid'=>$lastTransId,
            'office_name'=>$office_trance_name,
            'description'=>'Acceptance '.$em_branch,
            'status'=>'Acceptance');

            //for trace data
            $this->Box_Application_model->tracing($trace_data);


              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);
              // echo 'diffp kubwa '.json_encode($listbulk);


          echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>SN</b></th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Branch Origin</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $sn=1;
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;

                  $item_price = $value->register_price;

                  echo "<tr style='width:100%;color:#343434;' class='itemRow'><td>".$sn."</td><td>".$value->receiver_fullname."</td><td>".$value->sender_fullname."</td><td>".$value->sender_branch."</td><td>".$value->reciver_branch."</td> <td>".$value->Barcode."</td> <td>".number_format($value->register_price,2)."</td>
                  <td>
                   
                   <button
                  data-senderid=".$value->senderp_id."
                   data-serial=".$value->serial."
                   data-item_amount=".$item_price." 
                   class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                 $sn++;
                }  

                // number_format($alltotal,2)                      
               
              echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b id='totalAmount'>".$alltotal."</b></td></tr>
                </table>
                <input type='hidden' name='crdtid' id='crdtid'   value=".@$custinfo->credit_id.">
                <input type='hidden' name='askfor' id='askfor'  value=".@$askfor.">
                <input type='hidden' name='price' id='price'  value=".@$custinfo->price.">
                <input type='hidden' name='accno' id='accno'  value=".@$custinfo->acc_no.">

                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                   
                        ";



              }else{

                  echo 'Umefikia Kiwango Cha mwisho'; // redirect(base_url('Bill_Customer/bill_customer_list?AskFor=MAILS'));
              }

            }
              
                   

            }else {
                
            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'add_type'=>$addressT,'track_number'=>$trackNo,'sender_type'=>'REGISTER BULK POSTING');
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);

            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'receiver_region'=>$rec_region,'reciver_branch'=>$rec_dropp,'receiver_fullname'=>$r_fname,'add_type'=>$addressR);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('receiver_register_info',$receiver);



              
           $trans = array();
            $trans = array(

            'serial'=>$serial,
            'paidamount'=>$Total,
            'register_id'=>$last_id,
             'Barcode'=>strtoupper($Barcode),
            'transactionstatus'=>'POSTED',
            'bill_status'=>'BILLING',
              // 'paymentFor'=>'MAIL',
              'status'=>'Paid'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('register_transactions',$trans);


              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);

              // echo 'diffp ndogo '.json_encode($listbulk);



            echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->track_number."</td><td>".@$value->Barcode."</td> <td>".number_format($value->register_price,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }

              
              echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name='crdtid' id='crdtid'   value=".@$custinfo->credit_id.">
                <input type='hidden' name='askfor' id='askfor'  value=".@$askfor.">
                <input type='hidden' name='price' id='price'  value=".@$custinfo->price.">
                <input type='hidden' name='accno' id='accno'  value=".@$custinfo->acc_no.">

                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                 ";


            }
        
            
       
    }
  
}




public function register_bill_sender_bulk_info(){
        #Redirect to Admin dashboard after authentication
if ($this->session->userdata('user_login_access') == 1){

  $Barcode = $this->input->post('Barcode');
  $registerType = $this->input->post('emstype');
  $weight = $this->input->post('weight');
  $type = $this->input->post('emstype');

   $totalAmount = $this->input->post('totalAmount');
   $counterIterm = $this->input->post('counterIterm');


$sender_address = $this->input->post('s_mobilev');
$receiver_address = $this->input->post('r_mobilev');
$target_url = "http://192.168.33.7/api/virtual_box/";

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

$addressT = "physical";
 $s_fname = $this->input->post('s_fname');
 $s_address = $this->input->post('s_address');
 // $s_email = $this->input->post('s_email');
 $s_mobile = $mobile = $this->input->post('s_mobile');

$addressR = "physical";
 $r_fname = $this->input->post('r_fname');
 $r_address = $this->input->post('r_address');
 $r_mobile = $this->input->post('r_mobile');
 // $r_email = $this->input->post('r_email');
 $rec_region = $this->input->post('region_to');
 $rec_dropp = $this->input->post('district');



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
 $info =  $custinfo = $this->Box_Application_model->get_customer_infos($I);
  
$accno = $this->input->post('accno');
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
            $response = array();
             $rondom = substr(date('dHis'), 1);
              $billcode = '7';//bag code in tracking number
              $source = $this->employee_model->get_code_source($sender_region);
              $dest = $this->employee_model->get_code_dest($rec_region);

             $number = $this->getnumber();
              //$bagsNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

              $bagsNo = $source->reg_code . $dest->reg_code;
              @$trackNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';


            if(@$info->customer_type == "PostPaid"){

                if($info->price < $paidamount){
                  
                  $response['status'] = 'Error';
                  $response['message'] = 'Umefikia Kiwango Cha mwisho';

                }else {

              $diffp = $price1-$paidamount;

              if($diffp > 0) {
                
              $sender = array();
              $sender = array(
                'sender_fullname'=>$s_fname,
                'sender_address'=>$s_address,
                'sender_mobile'=>$s_mobile,
                'register_type'=>$registerType,
                'sender_region'=>$sender_region,
                'sender_branch'=>$sender_branch,
                'register_weght'=>$weight,
                'register_price'=>$Total,
                'operator'=>$emid,
                'acc_no'=>$accno,
                'add_type'=>$addressT,'track_number'=>$trackNo);

              $db2 = $this->load->database('otherdb', TRUE);
              $db2->insert('sender_person_info',$sender);

              $last_id = $db2->insert_id();

              $receiver = array();
             $receiver = array(
                'sender_id'=>$last_id,
                'r_address'=>$r_address,
                'receiver_region'=>$rec_region,
                'reciver_branch'=>$rec_dropp,
                'receiver_fullname'=>$r_fname,
                'receiver_mobile'=>$r_mobile,
                'add_type'=>$addressR);

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


              $emid = $this->session->userdata('user_login_id');
                //getting user or staff department section
                $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

                //for One Man
                $office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';

              
               $trans = array();
                $trans = array(

                'serial'=>$serial,
                'paidamount'=>$Total,
                'register_id'=>$last_id,
                'Barcode'=>$Barcode,
                'office_name'=>$office_one_name,
                'created_by'=>$emid,
                'transactionstatus'=>'POSTED',
                 'bill_status'=>'BILLING',
                  // 'paymentFor'=>'MAIL',
                  'status'=>'Paid'
                );

            $db2 = $this->load->database('otherdb', TRUE);
            //$db2->insert('register_transactions',$trans);
            $lastTransId = $this->unregistered_model->save_transactions($trans);


            //for One Man
            $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

            //for tracing
            $trace_data = array(
            'emid'=>$emid,
            'trans_type'=>'mails',
            'transid'=>$lastTransId,
            'office_name'=>$office_trance_name,
            'description'=>'Acceptance',
            'status'=>'IN');

            //for trace data
            $this->Box_Application_model->tracing($trace_data);


              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);

              // echo 'diffp kubwa '.json_encode($listbulk);

                $alltotal = 0;
                $response['status'] = 'Success';
                $response['message'] = 'Successfully';
                $transData="";
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  $transData .= "<tr class='receiveRowTrans' style='width:100%;color:#343434;'>
                  <td>".$value->receiver_fullname."</td>
                  <td>".$value->sender_fullname."</td>
                  <td>".$value->sender_region."</td>
                  <td>".$value->sender_branch."</td>
                  <td>".$value->receiver_region."</td>
                  <td>".$value->reciver_branch."</td>
                  <td>".$value->Barcode."</td>
                  <td>".number_format($value->register_price,2)."</td>
                  <td><button
                   data-senderid='".$value->senderp_id."'
                     data-serial='".$value->serial."'
                      data-item_amount='".$value->register_price."'
                    class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete </button></td>
                  </tr>";
                }     

                $response['counter'] = $counterIterm+1;
                $response['balance'] = $value->register_price + $totalAmount;
                $response['serial'] = $value->serial;

                $response['messageData'] = $transData;                   

              }else{
                $response['status'] = 'Error';
                $response['message'] = 'Umefikia Kiwango Cha mwisho';
              }

            }
              

            }else {
            $sender = array();
            $sender = array(
                'sender_fullname'=>$s_fname,
                'sender_address'=>$s_address,
                'sender_mobile'=>$s_mobile,
                'register_type'=>$registerType,
                'sender_region'=>$sender_region,
                'sender_branch'=>$sender_branch,
                'register_weght'=>$weight,
                'register_price'=>$Total,
                'operator'=>$emid,
                'add_type'=>$addressT,'track_number'=>$trackNo);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);

            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array(
                'sender_id'=>$last_id,
                'r_address'=>$r_address,
                'receiver_region'=>$rec_region,
                'reciver_branch'=>$rec_dropp,
                'receiver_fullname'=>$r_fname,
                'receiver_mobile'=>$r_mobile,
                'add_type'=>$addressR);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('receiver_register_info',$receiver);
              
           $trans = array();
            $trans = array(

            'serial'=>$serial,
            'paidamount'=>$Total,
            'register_id'=>$last_id,
            'Barcode'=>$Barcode,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'BILLING',
              // 'paymentFor'=>'MAIL',
              'status'=>'Paid'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('register_transactions',$trans);


              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);

              // echo 'diffp ndogo '.json_encode($listbulk);


                $alltotal = 0;
                $response['status'] = 'Success';
                $response['message'] = 'Successfully';
                $transData = "";

                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->register_price;
                  $transData .="<tr class='receiveRowTrans' style='width:100%;color:#343434;'>
                  <td>".$value->receiver_fullname."</td>
                  <td>".$value->sender_fullname."</td>
                  <td>".$value->sender_region."</td>
                  <td>".$value->sender_branch."</td>
                  <td>".$value->receiver_region."</td>
                  <td>".$value->reciver_branch."</td>
                  <td>".$value->Barcode."</td> <td>".number_format($value->register_price,2)."</td>
                  <td><button  
                   data-senderid='".$value->senderp_id."'
                     data-serial='".$value->serial."'
                      data-item_amount='".$value->register_price."'
                     class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete </button></td></tr>";
                }

                $response['counter'] = $counterIterm+1;
                $response['balance'] = $value->register_price + $totalAmount;
                $response['serial'] = $value->serial;

                $response['messageData'] = $transData;

            }
        
            
       print_r(json_encode($response));
    }
  
}




public function register_rtx_sender_bulk_info(){
  #Redirect to Admin dashboard after authentication
if ($this->session->userdata('user_login_access') == 1){

$Barcode = $this->input->post('Barcode');
$registerType = $this->input->post('emstype');
$weight = $this->input->post('weight');
$type = $this->input->post('emstype');
$edit_reason_Message = $this->input->post('edit_reason_Message');

$totalAmount = $this->input->post('totalAmount');
$counterIterm = $this->input->post('counterIterm');


$sender_address = $this->input->post('s_mobilev');
$receiver_address = $this->input->post('r_mobilev');
$target_url = "http://192.168.33.7/api/virtual_box/";

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

$addressT = "physical";
$s_fname = $this->input->post('s_fname');
$s_address = $this->input->post('s_address');
// $s_email = $this->input->post('s_email');
$s_mobile = $mobile = $this->input->post('s_mobile');

$addressR = "physical";
$r_fname = $this->input->post('r_fname');
$r_address = $this->input->post('r_address');
$r_mobile = $this->input->post('r_mobile');
// $r_email = $this->input->post('r_email');
$rec_region = $this->input->post('region_to');
$rec_dropp = $this->input->post('district');



$sender_region = $o_region = $this->session->userdata('user_region');
$sender_branch = $o_branch = $this->session->userdata('user_branch');

     
$serial = $this->input->post('serial');
if(empty($serial)){
$serial    = @$registerType.date("YmdHis").$this->session->userdata('user_emid');

}
     

$id = $emid = $this->session->userdata('user_login_id');
$ad_fee = $this->input->post('ad_fee');

//$askfor = $this->input->get('AskFor');
$askfor = $this->input->post('askfor');

$price1 = $this->input->post('price');

      $response = array();
       $rondom = substr(date('dHis'), 1);
        $billcode = '7';//bag code in tracking number
        $source = $this->employee_model->get_code_source($sender_region);
        $dest = $this->employee_model->get_code_dest($rec_region);

       $number = $this->getnumber();
        //$bagsNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

        $bagsNo = $source->reg_code . $dest->reg_code;
        @$trackNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';


        $Total=0;
        $sender = array();
        $sender = array(
          'sender_fullname'=>$s_fname,
          'sender_address'=>$s_address,
          'sender_mobile'=>$s_mobile,
          'register_type'=>$registerType,
          'sender_region'=>$sender_region,
          'sender_branch'=>$sender_branch,
          'register_weght'=>$weight,
          'register_price'=>$Total,
          'operator'=>$emid,
          'add_type'=>$addressT,'track_number'=>$trackNo);

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('sender_person_info',$sender);

        $last_id = $db2->insert_id();

        $receiver = array();
       $receiver = array(
          'sender_id'=>$last_id,
          'r_address'=>$r_address,
          'receiver_region'=>$rec_region,
          'reciver_branch'=>$rec_dropp,
          'receiver_fullname'=>$r_fname,
          'receiver_mobile'=>$r_mobile,
          'add_type'=>$addressR);

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('receiver_register_info',$receiver);

        $trackno = array();
        $trackno = array('track_number'=>$trackNo,'payment_type'=>'Rtx');
        $info = $this->employee_model->GetBasic($id);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;
        $data = array();
        $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

        $this->Box_Application_model->save_location($data);
        $this->unregistered_model->update_sender_info($last_id,$trackno);


        $emid = $this->session->userdata('user_login_id');
          //getting user or staff department section
          $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

          //for One Man
          $office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';

        
         $trans = array();
          $trans = array(

          'serial'=>$serial,
          'paidamount'=>$Total,
          'register_id'=>$last_id,
          'Barcode'=>$Barcode,
          'office_name'=>$office_one_name,
          'created_by'=>$emid,
          'transactionstatus'=>'POSTED',
          'edit_reason_Message'=>$edit_reason_Message,
           'bill_status'=>'Rtx'
          );

      $db2 = $this->load->database('otherdb', TRUE);
      //$db2->insert('register_transactions',$trans);
      $lastTransId = $this->unregistered_model->save_transactions($trans);


      //for One Man
      $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

      //for tracing
      $trace_data = array(
      'emid'=>$emid,
      'trans_type'=>'mails',
      'transid'=>$lastTransId,
      'office_name'=>$office_trance_name,
      'description'=>'Acceptance',
      'status'=>'IN');

      //for trace data
      $this->Box_Application_model->tracing($trace_data);


        $sender_id=$last_id;
        $operator=$emid;
        $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);

        // echo 'diffp kubwa '.json_encode($listbulk);

          $alltotal = 0;
          $response['status'] = 'Success';
          $response['message'] = 'Successfully';
          $transData="";
          foreach ($listbulk as $key => $value) { 

            $alltotal =$alltotal + $value->register_price;
            $transData .= "<tr class='receiveRowTrans' style='width:100%;color:#343434;'>
            <td>".$value->receiver_fullname."</td>
            <td>".$value->sender_fullname."</td>
            <td>".$value->sender_region."</td>
            <td>".$value->sender_branch."</td>
            <td>".$value->receiver_region."</td>
            <td>".$value->reciver_branch."</td>
            <td>".$value->Barcode."</td>
            <td>".number_format($value->register_price,2)."</td>
            <td><button
             data-senderid='".$value->senderp_id."'
               data-serial='".$value->serial."'
                data-item_amount='".$value->register_price."'
              class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete </button></td>
            </tr>";
          }     

          $response['counter'] = $counterIterm+1;
          $response['balance'] = 0;
          $response['serial'] = $serial;

          $response['messageData'] = $transData;                   

          print_r(json_encode($response)); 
      }
        



}









public function Oldregister_bill_sender_bulk_info()
{
        #Redirect to Admin dashboard after authentication
if ($this->session->userdata('user_login_access') == 1){

  $Barcode = $this->input->post('Barcode');
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
             $info =  $custinfo = $this->Box_Application_model->get_customer_infos($I);
              
            $accno = $this->input->post('accno');
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


                if(@$info->customer_type == "PostPaid"){

                if($info->price < $paidamount){
                  
                  echo 'Umefikia Kiwango Cha mwisho';

                }else {

              $diffp = $price1-$paidamount;

              if($diffp > 0) {
                
              $sender = array();
              $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'acc_no'=>$accno,'add_type'=>$addressT,'track_number'=>$trackNo);
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


              $emid = $this->session->userdata('user_login_id');
                //getting user or staff department section
                $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

                //for One Man
                $office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';

              
               $trans = array();
                $trans = array(

                'serial'=>$serial,
                'paidamount'=>$Total,
                'register_id'=>$last_id,
                'Barcode'=>strtoupper($Barcode),
                'office_name'=>$office_one_name,
                'created_by'=>$emid,
                'transactionstatus'=>'POSTED',
                 'bill_status'=>'BILLING',
                  // 'paymentFor'=>'MAIL',
                  'status'=>'Paid'

                );

            $db2 = $this->load->database('otherdb', TRUE);
            //$db2->insert('register_transactions',$trans);
            $lastTransId = $this->unregistered_model->save_transactions($trans);


            //for One Man
            $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

            //for tracing
            $trace_data = array(
            'emid'=>$emid,
            'trans_type'=>'mails',
            'transid'=>$lastTransId,
            'office_name'=>$office_trance_name,
            'description'=>'Acceptance',
            'status'=>'IN');

            //for trace data
            $this->Box_Application_model->tracing($trace_data);


              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);

              // echo 'diffp kubwa '.json_encode($listbulk);


          echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->track_number."</td><td>".$value->Barcode."</td> <td>".number_format($value->register_price,2)."</td>
                  <td>
                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }                        
               
              echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name='crdtid' id='crdtid'   value=".@$custinfo->credit_id.">
                <input type='hidden' name='askfor' id='askfor'  value=".@$askfor.">
                <input type='hidden' name='price' id='price'  value=".@$custinfo->price.">
                <input type='hidden' name='accno' id='accno'  value=".@$custinfo->acc_no.">

                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                   
                        ";



              }else{

                  echo 'Umefikia Kiwango Cha mwisho'; // redirect(base_url('Bill_Customer/bill_customer_list?AskFor=MAILS'));
              }

            }
              
                   

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
            'Barcode'=>strtoupper($Barcode),
            'transactionstatus'=>'POSTED',
            'bill_status'=>'BILLING',
              // 'paymentFor'=>'MAIL',
              'status'=>'Paid'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('register_transactions',$trans);


              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);

              // echo 'diffp ndogo '.json_encode($listbulk);



            echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->track_number."</td><td>".$value->Barcode."</td> <td>".number_format($value->register_price,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }

              
              echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name='crdtid' id='crdtid'   value=".@$custinfo->credit_id.">
                <input type='hidden' name='askfor' id='askfor'  value=".@$askfor.">
                <input type='hidden' name='price' id='price'  value=".@$custinfo->price.">
                <input type='hidden' name='accno' id='accno'  value=".@$custinfo->acc_no.">

                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                 ";


            }
        
            
       
    }
  
}


public function latter_bill_sender_bulk_info()
{
        #Redirect to Admin dashboard after authentication
if ($this->session->userdata('user_login_access') == 1){

  $registerType = $this->input->post('emstype');
  $weight = $this->input->post('weight');
  $type = $this->input->post('emstype');


if(empty($sender_address)){
 $addressT = "physical";
 $s_fname = $this->input->post('s_fname');
 $s_address = $this->input->post('s_address');
 $s_email = $this->input->post('s_email');
 $s_mobile = $mobile = $this->input->post('s_mobile');
}
            $sender_region = $o_region = $this->session->userdata('user_region');
            $sender_branch = $o_branch = $this->session->userdata('user_branch');

           
            $serial = $this->input->post('serial');
            if(empty($serial)){
               $serial    = 'Latter'.date("YmdHis").$this->session->userdata('user_emid');

            }
           

            $id = $emid = $this->session->userdata('user_login_id');
            $quantity = $this->input->post('quantity');

            //$askfor = $this->input->get('AskFor');
            $askfor = $this->input->post('askfor');

            $price1 = $this->input->post('price');
            $I = $this->input->post('crdtid');
             $info =  $custinfo = $this->Box_Application_model->get_customer_infos($I);
              
            $accno = $this->input->post('accno');
            $price = $this->unregistered_model->unregistered_cat_price($type,$weight);


             $inn = $this->input->post('inn');
           $out = $this->input->post('out');

            if($s_fname == 'NBAA.'){

                if($inn == 'onn'){

                      $paidamount = $Total = $emsprice = 900*$quantity ;

                }elseif ($out == 'onn') {
                      $paidamount = $Total = $emsprice = 1000*$quantity ;
                   
                }

            }else{
            
            if ($type == "Ordinary Latter"){    
               $paidamount = $Total = ($price->price + $price->s_vat)* $quantity;
            } 
            }
            



                if(@$info->customer_type == "PostPaid"){

                if($info->price < $paidamount){
                  
                  echo 'Umefikia Kiwango Cha mwisho';

                }else {

              $diffp = $price1-$paidamount;

              if($diffp > 0) {
                
              $sender = array(); 
              $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'acc_no'=>$accno,'add_type'=>$quantity,'payment_type'=>'Bill','track_number'=>$serial,'sender_type'=>'LATTER BULK POSTING');
              $db2 = $this->load->database('otherdb', TRUE);
              $db2->insert('sender_person_info',$sender);

              $last_id = $db2->insert_id();


           $trans = array();
            $trans = array(

            'serial'=>$serial,
            'paidamount'=>$Total,
            'register_id'=>$last_id,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'BILLING',
              // 'paymentFor'=>'MAIL',
              'status'=>'Paid'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('register_transactions',$trans);


             

              $save = array();
              $save = array('price'=>$diffp);
              $this->Bill_Customer_model->update_credit_bill_customer($save,$I);


              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkLatter($operator,$serial);

              // echo 'diffp kubwa '.json_encode($listbulk);


          echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Weight</b></th><th><b>Quantity</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->register_weght."</td><td>".$value->add_type."</td> <td>".number_format($value->register_price,2)."</td>
                  <td>
                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }                        
               
              echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name='crdtid' id='crdtid'   value=".@$custinfo->credit_id.">
                <input type='hidden' name='askfor' id='askfor'  value=".@$askfor.">
                <input type='hidden' name='price' id='price'  value=".@$custinfo->price.">
                <input type='hidden' name='accno' id='accno'  value=".@$custinfo->acc_no.">

                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                   
                        ";



              }else{

                  echo 'Umefikia Kiwango Cha mwisho'; // redirect(base_url('Bill_Customer/bill_customer_list?AskFor=MAILS'));
              }

            }
              
                   

            }
        
            
       
    }
  
}




public function save_register_sender_bulk_info(){

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

            // print_r($postbill);
            // die();

            //$controlno = $transaction->controlno;

            if (!empty($postbill->controlno)) {
                $response['status'] = 'Success';
               
                $update = array();
                $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya  Register  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2).'';
           
                 $this->Sms_model->send_sms_trick($s_mobile,$sms);

                 $response['message'] = $sms;
               
          
            }else{
                $response['status'] = 'Error';
                $response['message'] = 'Hakuna ela inayolipiwa kwa huduma';
            }

            print_r(json_encode($response));

    }





public function Oldsave_register_sender_bulk_info()
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

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya  Register  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2).'';
           
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

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$repostbill->controlno.' Kwaajili ya huduma ya  Register  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2).'';

                 $this->Sms_model->send_sms_trick($s_mobile,$sms);
                 echo $sms;
                //$this->load->view('inlandMails/control-number-form',$data);    

                 //$this->session->set_flashdata('success','Saved Successfull');
                  
            }

          

}






public function save_register_bill_sender_bulk_info()
{

  $id  = $this->session->userdata('user_login_id');
   $info = $this->employee_model->GetBasic($id);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
   $serial = $this->input->post('serial');
   $AskFor = $this->input->post('askfor');
   $operator = $this->input->post('operator');
   $crdtid = $this->input->post('crdtid');

 // echo json_encode($operator).' na hii  '.json_encode($serial);


    $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);
     $alltotal = 0;
     
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->register_price;
                   $s_mobile = $value->sender_mobile;
   
                
                $data = array();
                $data = array('track_no'=>$value->track_number,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                if($AskFor == 'Register'){
                     $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa track number hii hapa'. ' '.$value->track_number.' Kwaajili ya huduma ya  Register '.'';
                  $this->Sms_model->send_sms_trick($s_mobile,$sms);

                }else{
                     $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa track number hii hapa'. ' '.$value->track_number.' Kwaajili ya huduma ya  Parcel '.'';
                  $this->Sms_model->send_sms_trick($s_mobile,$sms);

                }

                
              }

             
           $renter   = $listbulk[0]->sender_fullname;
            $serviceId = 'MAIL';
            $paidamount   = $alltotal;
            $sender_region = $listbulk[0]->sender_region;
            $sender_branch = $listbulk[0]->sender_branch;
             $s_mobile = $listbulk[0]->sender_mobile;
              $trackno   = $serial;
              //$type = $listbulk[0]->s_mobile;

            //    $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya  Register  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2).'';
           
            // //if (!empty($transaction->$controlno)) {
            //     

              // $credit_id=$crdtid;
              // redirect(base_url('unregistered/unregistered_bill_bulk_form?I='.base64_encode($credit_id).'&&AskFor='.$AskFor));

         

          

}


public function save_later_bill_sender_bulk_info()
{

  $id  = $this->session->userdata('user_login_id');
   $info = $this->employee_model->GetBasic($id);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
   $serial = $this->input->post('serial');
   $AskFor = $this->input->post('askfor');
   $operator = $this->input->post('operator');
   $crdtid = $this->input->post('crdtid');

 // echo json_encode($operator).' na hii  '.json_encode($serial);


    $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);
     $alltotal = 0;
     
              
             
           $renter   = $listbulk[0]->sender_fullname;
            $serviceId = 'MAIL';
            $paidamount   = $alltotal;
            $sender_region = $listbulk[0]->sender_region;
            $sender_branch = $listbulk[0]->sender_branch;
             $s_mobile = $listbulk[0]->sender_mobile;
              $trackno   = $serial;
            
              // $credit_id=$crdtid;
              // redirect(base_url('unregistered/unregistered_bill_bulk_form?I='.base64_encode($credit_id).'&&AskFor='.$AskFor));

         

          

}


public function deleteRegisterSenderInfo(){
    $senderid = $this->input->post('senderid');
    $this->unregistered_model->delete_bulk_bysenderid($senderid);
}

public function delete_register_sender_bulk_info(){
    $senderid = $this->input->post('senderid');
    $serial = $this->input->post('serial');
    $this->unregistered_model->delete_bulk_bysenderid($senderid);

    $response['status'] = 'Success';
}

public function Olddelete_register_sender_bulk_info(){


           $senderid = $this->input->post('senderid');
            $serial = $this->input->post('serial');
            //echo $senderid;
             // echo $serial;

           // $senderid = base64_decode($this->input->get('I')); 
           //  $serial = base64_decode($this->input->get('S')); 

           $this->unregistered_model->delete_bulk_bysenderid($senderid);

               $emid  = $this->session->userdata('user_login_id');
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


            echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>SN</b></th><th><b>Receiver</b></th><th><b>Sender</b></th>
                <th><b>Branch Origin</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";

                $sn=1;

                $alltotal = 0;
                $sn = 0;
                foreach ($listbulk as $key => $value) {
                    $sn++;

                  $alltotal =$alltotal + $value->register_price;
                 
                  echo "<tr class='itemRow' style='width:100%;color:#343434;'>
                  <td>".$sn."</td>
                  <td>".$value->receiver_fullname."</td>
                  <td>".$value->sender_fullname."</td>
                  <td>".$value->sender_branch."</td><td>".$value->reciver_branch."</td>
                  <td>".$value->Barcode."</td> <td>".number_format($value->register_price,2)."</td><td>
                    <button  
                        data-senderid='".$value->senderp_id."'
                        data-serial='".$value->serial."'
                    class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete </button>
                    </td></tr>";


                 $sn++;
                }  

              echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                  <input type='hidden' name ='senders' value=".$senderid." id='senders' class='senders'>
                   
                        ";


          // $this->session->set_flashdata('success','Deleted Successfull');
}

public function delete_later_sender_bulk_info()
{


           $senderid = $this->input->post('senderid');
            $serial = $this->input->post('serial');

           $this->unregistered_model->delete_bulk_post_bysenderid($senderid);

               $emid  = $this->session->userdata('user_login_id');
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkLatter($operator,$serial);


            echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Weight</b></th><th><b>Quantity</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->register_weght."</td><td>".$value->add_type."</td> <td>".number_format($value->register_price,2)."</td>
                  <td>
                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }                        
               
              echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
               

                <input type='hidden' name ='senders' value=".$senderid." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                   
                        ";


          // $this->session->set_flashdata('success','Deleted Successfull');
}


public function delete_International_register_sender_bulk_info()
{


           $senderid = $this->input->post('senderid');
            $serial = $this->input->post('serial');
            //echo $senderid;
             // echo $serial;

           // $senderid = base64_decode($this->input->get('I')); 
           //  $serial = base64_decode($this->input->get('S')); 

           $this->unregistered_model->delete_bulk_bysenderid($senderid);

               $emid  = $this->session->userdata('user_login_id');
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


             echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination </b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".@$value->Barcode."</td> <td>".number_format($value->register_price,2)."</td><td>
                    <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                    </td></tr>";
                }  

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                  <input type='hidden' name ='senders' value=".$senderid." id='senders' class='senders'>
                   
                        ";


          // $this->session->set_flashdata('success','Deleted Successfull');
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


$ids = $this->session->userdata('user_login_id');
            $infos = $this->employee_model->GetBasic($ids);
            $o_regions = $infos->em_region;
            $o_branchs = $infos->em_branch;
              $users = $infos->em_code.'  '.$infos->first_name.' '.$infos->middle_name.' '.$infos->last_name;




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
    $sender = array('ems_type'=>$registerType,'weight'=>$weight,'s_fullname'=>$info->customer_name,'s_address'=>$info->customer_address,'s_email'=>$info->cust_email,'s_mobile'=>$info->cust_mobile,'s_region'=>$o_regions,'s_district'=>$o_branchs,'track_number'=>$trackingno,'s_pay_type'=>$info->customer_type,'bill_cust_acc'=>$info->acc_no,'operator'=>$i->em_id);

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
      'region'=>$o_regions,
      'district'=>$o_branchs,
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

                
                $first4 = substr(@$repostbill->controlno, 4);
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
                $update = array('billid'=>@$repostbill->controlno,'bill_status'=>'SUCCESS');
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$repostbill->controlno.' Kwaajili ya huduma ya Small Packets  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
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

            $source = $this->employee_model->get_code_source($sender_region);
             $dest = $this->employee_model->get_code_dest($rec_region);
            $number = $this->getnumber();
            $bagsNo = 'PCG'.@$source->reg_code . @$dest->reg_code.$number.'TZ';
            // $serial    = 'EMS'.date("YmdHis").$source->reg_code;
             $trackno = $bagsNo;
            
            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'track_number'=>$trackno,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'sender_type'=>'Posts-Cargo');
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

            $renter   = @$s_fname;
            $serviceId = 'POST_CARGO';
            $trackno = $trackno;
            $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

            //$controlno = $transaction->controlno;

            if (!empty($postbill->controlno)) {

                // $source = $this->employee_model->get_code_source($sender_region);
                // $dest = $this->employee_model->get_code_dest($region_to);
                // $bagsNo = $source->reg_code . $dest->reg_code;

                // $first4 = substr($postbill->controlno, 4);
                // $trackNo = $bagsNo.$first4;
                // $trackno = array();
                // $trackno = array('track_number'=>$trackNo);
                $trackNo =  $trackno;
                $info = $this->employee_model->GetBasic($id);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                // $this->unregistered_model->update_sender_info($last_id,$trackno);
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

                // $source = $this->employee_model->get_code_source($sender_region);
                // $dest = $this->employee_model->get_code_dest($region_to);
                // $bagsNo = $source->reg_code . $dest->reg_code;

                
                // $first4 = substr($repostbill->controlno, 4);
                // $trackNo = $bagsNo.$first4;
                // $trackno = array();
                // $trackno = array('track_number'=>$trackNo);
                 $trackNo =  $trackno;
                $info = $this->employee_model->GetBasic($id);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                // $this->unregistered_model->update_sender_info($last_id,$trackno);

                @$serial = $repostbill->billid;
                $update = array();
                $update = array('billid'=>@$repostbill->controlno,'bill_status'=>'SUCCESS');
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$repostbill->controlno.' Kwaajili ya huduma ya Post Cargo  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
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
             //$data['sum']  = $this->unregistered_model->get_sum_register();

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
                    //$data['sum']  = $this->unregistered_model->get_register_sum_search($date,$month,$status,$branch,$region);
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
                      $checkPay = $this->unregistered_model->check_payment_sender_info($id);
                        if (!empty($checkPay)) {
                        $last_id = $checkPay->id;// $check[$i];
                        $trackno = array();
                        $trackno = array('office_name'=>'Back');
                        $this->unregistered_model->update_transactions($last_id,$trackno);
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



 public function Mails_Delivery_Backoffice(){

    if ($this->session->userdata('user_login_access') != false)
    {
    $this->load->view('inlandMails/mails-Delivery-backoffice-dashboard');
    }
    else{
    redirect(base_url());
    }

    }


public function registered_domestic_Delivery()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $search  = $this->input->post('search');
            $type = $this->input->post('type');
             $action = $this->input->post('action');
            $check = $this->input->post('I');
            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $data['region'] = $this->employee_model->regselect();
            $data['emselect'] = $this->employee_model->delivereselect();

            $service_type = $this->input->get('Ask_for');

            $this->session->set_userdata('service_type',$service_type);

              // $data['ems'] = $this->unregistered_model->count_ems();
              // $data['bags'] = $this->unregistered_model->count_bags();
              // $data['despout'] = $this->unregistered_model->count_despatch();
              // $data['despin'] = $this->unregistered_model->count_despatch_in();

              $date = $this->input->post('date');
              $month = $this->input->post('month');
              $status = $this->input->post('status');

              //echo $type. 'first';
              if(empty($type)){ $type="WaitingDelivery";}
            

            if ($type == "WaitingDelivery") { //from counter or branch Received
              
              $data['type'] = $type;
              $data['status'] =$status = 'WaitingDelivery';

            if (!empty($search)) {
               

               $emslists = array();
              

                $frombranch = $this->unregistered_model->get_register_application_search_back_Inward($date,$month,$status);
                foreach ($frombranch as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'WAITING', $value->Barcode);
                        
                }

                $data['list']=$emslists;

            }else{
              $emslists = array();
              
                
                $frombranch = $this->unregistered_model->get_register_application_list_back_from_outside($status);
                foreach ($frombranch as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'WAITING', $value->Barcode);
                        
                }

               $data['list']=$emslists;
                 
            }

            }elseif ($type == "Assigned") { //from region Received
              
              $data['type'] = $type;
              $data['status'] =$status ='Assigned';
               $data['bagss'] = $this->unregistered_model->get_bags_number_mails($service_type);

            if (!empty($search)) {
               $emslists = array();
               $fromcounter = $this->unregistered_model->get_register_application_search_back_Inward($date,$month,$status);//LIST FROM COUNTER
                foreach ($fromcounter as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'Assigned', $value->Barcode);
                        
                }


               $data['list']=$emslists;

              
              //$data['list'] = $this->unregistered_model->get_register_application_search_back($date,$month,$status);

            }else{
               $emslists = array();
              


                $frombranch = $this->unregistered_model->get_register_application_list_back_from_outside($status);
                foreach ($frombranch as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'Assigned', $value->Barcode);
                        
                }

               $data['list']=$emslists;

            }

             

            }  elseif ($type == "Derivery") { //from region Received
              
              $data['type'] = $type;
              $data['status'] =$status ='Derivery';
               $data['bagss'] = $this->unregistered_model->get_bags_number_mails($service_type);

            if (!empty($search)) {
               $emslists = array();
               $fromcounter = $this->unregistered_model->get_register_application_search_back_Inward($date,$month,$status);//LIST FROM COUNTER
                foreach ($fromcounter as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'Derivery', $value->Barcode);
                        
                }


               $data['list']=$emslists;

              
              //$data['list'] = $this->unregistered_model->get_register_application_search_back($date,$month,$status);

            }else{
               $emslists = array();
              


                $frombranch = $this->unregistered_model->get_register_application_list_back_from_outside($status);
                foreach ($frombranch as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'Derivery', $value->Barcode);
                        
                }

               $data['list']=$emslists;

            }

             

            }


            elseif ($type == "wixy") {   // action
              
               $data['type'] = $type=$status;
              $data['status']=$status;
              
            if (!empty($check)) {

                $action = $this->input->post('action');
                 $emid = $this->input->post('operator');


                

          if($action=='reasign'){ //Pass To

         if(empty($emid)){
          $data['errormessage'] = "Please select Operator";
               
            }else{

        for ($i=0; $i <sizeof($check) ; $i++) { 

           $id = $last_id = $check[$i];  //  $id = $check[$i];
              
        
        $data = array();
        $data = array(
            'em_id'=>$emid,
            'item_id'=>$check[$i],
            'service_type'=>$service_type
        );

        $this->Box_Application_model->update_delivery_info($data,$id);

        //$this->Box_Application_model->assigned_for_delivery($iid[$i]);

        
    }

    $data['message'] = "Successful Reassigned Item";
}


    }else{

        if($action=='Assign'){
            $serial    = 'serial'.date("YmdHis");
            if(empty($emid)){
                $data['errormessage'] = "Please select Operator";

            }else{

                for ($i=0; $i <sizeof($check) ; $i++) { 
        
        $data = array();
        $data = array(
            'em_id'=>$emid,
             'serial'=>$serial,
            'item_id'=>$check[$i],
            'service_type'=>$service_type
        );

        $this->Box_Application_model->save_delivery_info($data);
         $id = $last_id = $check[$i];  //  $id = $check[$i];
              $trackno = array();
              $trackno = array('sender_status'=>'Assigned');
              $this->unregistered_model->update_sender_info($last_id,$trackno);

       

            }

             

        
    }

   $data['message'] = "Successful Assigned Item";


        }else{

             if($action=='Return'){

                 for ($i=0; $i <sizeof($check) ; $i++) {
                 $id=$check[$i];                 

                  $id = $last_id = $check[$i];  //  $id = $check[$i];
              $trackno = array();
              $trackno = array('sender_status'=>'BackReceive');
              $this->unregistered_model->update_sender_info($last_id,$trackno);
                }


                $data['message'] = "Successful Returned";

                 
             }

        }
      }

       

    
            

       
        } else {
            $data['errormessage'] = "Please Select Atleast One Item To Receive";
        }

              $emslists = array();
                $frombranch = $this->unregistered_model->get_register_application_list_back_from_outside($status);
                foreach ($frombranch as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'INWARD', $value->Barcode);
                        
                }

               $data['list']=$emslists;

            } 


            else {

             $emslists = array();
                $frombranch = $this->unregistered_model->get_register_application_list_back_from_outside($status);
                foreach ($frombranch as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'INWARD', $value->Barcode);
                        
                }

               $data['list']=$emslists;

            }

         $this->load->view('inlandMails/registered_domestic_Delivery',$data);

        
      }else{
                redirect(base_url());
            }
       
      }

      public function get_delivery_info(){

    $sndid = $this->input->get('senderid');
    // $AskFor = $this->input->get('AskFor');
    //  $data['askFor'] =$AskFor;
       $service_type = $this->session->userdata('service_type');
       $this->session->set_userdata('service_type',$service_type);
    $data['hovyo'] = $this->Box_Application_model->get_delivery_info_by_id($sndid);

    $this->load->view('inlandMails/delivery_info',$data);
 }

 public function registered_domestic_Inward()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $search  = $this->input->post('search');
             $data['emselect'] = $this->employee_model->delivereselect();
            $type = $this->input->post('type');
             $action = $this->input->post('action');
            $check = $this->input->post('I');
            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $service_type = $this->input->get('Ask_for');

            $this->session->set_userdata('service_type',$service_type);

              $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();

              $date = $this->input->post('date');
              $month = $this->input->post('month');
              $status = $this->input->post('status');

              //echo $type. 'first';
              if(empty($type)){ $type="Back";}
            

            if ($type == "Back") { //from counter or branch Received
              
              $data['type'] = $type;
              $data['status'] =$status = 'Back';

            if (!empty($search)) {
               

               $emslists = array();
              

                $frombranch = $this->unregistered_model->get_register_application_search_back_Inward($date,$month,$status);
                foreach ($frombranch as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'INWARD', $value->Barcode);
                        
                }

                $data['list']=$emslists;

            }else{
              $emslists = array();
              
                
                $frombranch = $this->unregistered_model->get_register_application_list_back_from_outside($status);
                foreach ($frombranch as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'BRANCH', $value->Barcode);
                        
                }

               $data['list']=$emslists;
                 
            }

            }elseif ($type == "BackReceive") { //from region Received
              
              $data['type'] = $type;
              $data['status'] =$status ='BackReceive';
               $data['bagss'] = $this->unregistered_model->get_bags_number_mails($service_type);

            if (!empty($search)) {
               $emslists = array();
               $fromcounter = $this->unregistered_model->get_register_application_search_back_Inward($date,$month,$status);//LIST FROM COUNTER
                foreach ($fromcounter as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'INWARD', $value->Barcode);
                        
                }


               $data['list']=$emslists;

              
              //$data['list'] = $this->unregistered_model->get_register_application_search_back($date,$month,$status);

            }else{
               $emslists = array();
              


                $frombranch = $this->unregistered_model->get_register_application_list_back_from_outside($status);
                foreach ($frombranch as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'INWARD', $value->Barcode);
                        
                }

               $data['list']=$emslists;

            }

             

            }elseif ($type == "receive") {   //receive action
              
               $data['type'] = 'Back';
              $data['status']=$status = 'Back';
              
            if (!empty($check)) {

                 $getInfo = $this->employee_model->GetBasic($emid);
                            $users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
                           // $location= $info->em_region.' - '.$info->em_branch;
                  $location= ' - '.$getInfo->em_branch;
                   $loc= ' - '.$getInfo->em_branch;


               
                for ($i=0; $i <@sizeof($check) ; $i++) {
                    $last_id = $check[$i];

                     $senderperson = $this->unregistered_model->get_senderperson_by_senderp_id11($last_id);
              
                   $trackno=@$senderperson->track_number;
                    $Barcode=@$senderperson->Barcode;

                     $love = array();//from counter or region - receive item
                    $love = array(
                      'track_no'=>$Barcode,
                      'event'=>$service_type,
                      'region'=>$sender_region,
                      'branch'=>$sender_branch,
                      'user'=>$emid,
                      'name'=>'BackReceive',
                      'status'=>'Received',
                      'type'=>'MailReceive'
                    );

                    $this->unregistered_model->save_event($love);


                    

                    $trackno = array();
                    $trackno = array('sender_status'=>'BackReceive');
                    $this->unregistered_model->update_sender_info($last_id,$trackno);


                     // $getInfo = $this->employee_model->GetBasic($emid);
                       //      $users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
                       //      $loc = $getInfo->em_region.' - '.$getInfo->em_branch;



                               $db='sender_person_info';
                               $senderinfo = $this->unregistered_model->CheckintransactionsBYSENDERPRS($db,$last_id);

                                  $Barcode=@$senderinfo->Barcode;

                            $event = "Sorting Facility";
                            $location ='Received Sorting Facility '.$loc;
                            $data2 = array();
                             $data2 = array('track_no'=>@$Barcode,'location'=>$location,'user'=>@$users,'event'=>$event);

                             $this->Box_Application_model->save_location($data2);

                              $smobile =@$senderinfo->sender_mobile;
                              $rmobile =@$senderinfo->receiver_mobile;
                             $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umepokelewa '.' '.$getInfo->em_region.' - '.$getInfo->em_branch;
                                 $this->Sms_model->send_sms_trick($smobile,$stotal);
                                 $this->Sms_model->send_sms_trick($rmobile,$stotal);

                }

                          $data['message'] = "Item Received";
                          } else {
                              $data['errormessage'] = "Please Select Atleast One Item To Receive";
                          }

              $emslists = array();
                $frombranch = $this->unregistered_model->get_register_application_list_back_from_outside($status);
                foreach ($frombranch as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'INWARD', $value->Barcode);
                        
                }

               $data['list']=$emslists;

            }elseif ($type == "bagclose") { //action

               $data['type'] = 'BackReceive';
              $data['status']=$status = 'BackReceive';
               $data['bagss'] = $this->unregistered_model->get_bags_number_mails($service_type);
            
             if (!empty($check)) {

             //$id = $check[0];
             
               
                  $rec_region = $this->input->post('region');
                  $rec_branch = $this->input->post('district');

                 $source = $this->employee_model->get_code_source($sender_region);
                 $dest = $this->employee_model->get_code_dest($rec_region);
                 //$number = rand(10000000,20000000);

                  $weight =  $this->input->post('weight');
                    $bagno =  $this->input->post('bagss');
                    $action = $this->input->post('action');
                 

                 //$angalia = $this->unregistered_model->get_bag_number_by_date($rec_region,$rec_branch);




      if($action=='exchage'){
      for ($i=0; $i <@sizeof($check) ; $i++) {

    $id = $last_id = $check[$i];  //  $id = $check[$i];
    $trackno = array();
    $trackno = array('sender_status'=>'Officeofexchange');
    $this->unregistered_model->update_sender_info($last_id,$trackno);
  }
   $data['message'] = "Successfully Transfered To Office of Exchange";
}
  elseif($action=='Delivery'){

      for ($i=0; $i <@sizeof($check) ; $i++) {

    $id = $last_id = $check[$i];  //  $id = $check[$i];
     $trackno = array();
    $trackno = array('sender_status'=>'WaitingDelivery');
    $this->unregistered_model->update_sender_info($last_id,$trackno);
}

      
        $data['message'] = "Successfully Transfered for Delivery";

  }else{
                                 $getInfo = $this->employee_model->GetBasic($emid);
                            $users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
                            $loc = ' - '.$getInfo->em_branch;   


                 if ($bagno=='New Bag') {
                $year = date("y");
                //$number = $this->getbagnumber();
                 $number = $this->getbagnumber_branch($getInfo->em_branch);
                  if($service_type =='Register'){  $bagsNo = 'REGISTER-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
    elseif ($service_type =='Parcels-Post') { $bagsNo = 'PARCEL-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
    elseif ($service_type =='Small-Packets') {  $bagsNo = 'PACKETS-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  elseif ($service_type =='Posts-Cargo') { $bagsNo = 'CARGO-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  elseif ($service_type =='Private-Bag') { $bagsNo = 'PRIVATE-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  elseif ($service_type =='Foreign-Parcel') { $bagsNo = 'FOREIGN-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  else{
    $bagsNo = 'REGISTER-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; 
  }

  if(@sizeof($check) > 0){

 


                 $save = array();
                 $save = array(
                               'bag_number'=>$bagsNo,
                               'bag_origin_region'=>$sender_region,
                               'bag_branch_origin'=>$sender_branch,
                               'bag_region_to'=>$rec_region,
                               'bag_branch_to'=>$rec_branch,
                               'bag_created_by'=>$emid,
                               'service_category'=>$service_type,
                               'bag_weight'=>$weight
                               );
                 $this->unregistered_model->save_mails_bags($save);
                  }

                  for ($i=0; $i <@sizeof($check) ; $i++) {

                       $id = $last_id = $check[$i];
                       //$get = $this->unregistered_model->get_dest_region($id);
                       // $rec_region = $get->receiver_region;
                       // $rec_branch = $get->reciver_branch;
                      
                      $trackno = array();
                      $trackno = array('sender_bag_number'=>$bagsNo,'sender_status'=>'Bag');
                      $this->unregistered_model->update_sender_info($last_id,$trackno);

                       // $getInfo = $this->employee_model->GetBasic($emid);
                       //      $users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
                       //      $loc = $getInfo->em_region.' - '.$getInfo->em_branch;

                               $db='sender_person_info';
                               $senderinfo = $this->unregistered_model->CheckintransactionsBYSENDERPRS( $db,$id);

                                  $Barcode=@$senderinfo->Barcode;

                            $event = "Sorting Facility";
                            $location ='Ready for Transit '.$loc;
                            $data2 = array();
                             $data2 = array('track_no'=>@$Barcode,'location'=>$location,'user'=>@$users,'event'=>$event);

                             $this->Box_Application_model->save_location($data2);

                              $smobile =@$senderinfo->sender_mobile;
                              $rmobile =@$senderinfo->receiver_mobile;
                             $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umesafirishwa '.'kutoka '.$getInfo->em_region.' - '.$getInfo->em_branch;
                                 $this->Sms_model->send_sms_trick($smobile,$stotal);
                                 $this->Sms_model->send_sms_trick($rmobile,$stotal);

                    }

                     //$sum = $this->unregistered_model->get_sum_weight($bagsNo);
                     //$weight = $sum->register_weght + $this->input->post('bagno');

                    


                 } else {


                      
                      for ($i=0; $i <@sizeof($check) ; $i++) {

                       $id = $last_id = $check[$i];
                      $trackno = array();
                      $trackno = array('sender_bag_number'=>$bagno,'sender_status'=>'Bag');
                      $this->unregistered_model->update_sender_info($last_id,$trackno);


                      // $bagsNo =  $angalia->bag_number;
                      // $sum = $this->unregistered_model->get_sum_weight($bagsNo);

                      //$weight = $sum->register_weght + $angalia->bag_weight;
                      $upbag = array();
                      $upbag = array('bag_weight'=>$weight);
                      $this->unregistered_model->update_bag_info($upbag,$bagno);


                       $db='sender_person_info';
                               $senderinfo = $this->unregistered_model->CheckintransactionsBYSENDERPRS($db,$id);

                                  $Barcode=@$senderinfo->Barcode;

                            $event = "Sorting Facility";
                            $location ='Ready for Transit '.$loc;
                            $data2 = array();
                             $data2 = array('track_no'=>@$Barcode,'location'=>$location,'user'=>@$users,'event'=>$event);

                             $this->Box_Application_model->save_location($data2);

                              $smobile =@$senderinfo->sender_mobile;
                              $rmobile =@$senderinfo->receiver_mobile;
                             $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umesafirishwa '.'kutoka '.$getInfo->em_region.' - '.$getInfo->em_branch;
                                 $this->Sms_model->send_sms_trick($smobile,$stotal);
                                 $this->Sms_model->send_sms_trick($rmobile,$stotal);
                    }

                 
              }

              $data['message'] = "Item Closed In Bag";

            }

            $emslists = array();
                $frombranch = $this->unregistered_model->get_register_application_list_back_from_outside($status);
                foreach ($frombranch as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'INWARD', $value->Barcode);
                        
                }

               $data['list']=$emslists;
             
             }
              else {
                $data['errormessage'] = "Please Select Atleast One Item";

             }


             
            } else {

             $emslists = array();
                $frombranch = $this->unregistered_model->get_register_application_list_back_from_outside($status);
                foreach ($frombranch as $key => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'INWARD', $value->Barcode);
                        
                }

               $data['list']=$emslists;

            }

         $this->load->view('inlandMails/registered-domestic-from-Out',$data);

        
      }else{
                redirect(base_url());
            }
       
      }

     


 public function deliver_bulk_scanned_item()
{
if ($this->session->userdata('user_login_access') != false){

     $emid=   $this->session->userdata('user_login_id');
   $trackno = $this->input->post('identifier');
    $operator = $this->input->post('operator');
 $serial = $this->input->post('serial');
 $serial    = 'serial'.date("YmdHis");
   
    $emid=$emid;

      $info = $this->employee_model->GetBasic($emid);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;



     $db='sender_person_info';
             $senderperson = $this->unregistered_model->get_senderperson($db,$trackno);
        
         
      if(!empty($senderperson))//which table
          {
             //check payment
            $senderp_id=@$senderperson->senderp_id;
            //$serial=@$senderperson->serial;
            
         $DB='register_transactions';
         $transactions2 = $this->unregistered_model->CheckintransactionsBYSENDERPRS($DB,$senderp_id);
         $DB='parcel_international_transactions';
         $transactions4 = $this->unregistered_model->Checkintransactions3($DB,$senderp_id);

        
 if( !empty($transactions2) || !empty($transactions4)){

        

         if($senderperson->sender_status != 'BackReceive0'){ //haijawa received?
                //echo 'Please check6 operator '.$trackno.' '.$operator;


    $serial = $this->input->post('serial');
             if($serial =='not'){
                 $check=$this->unregistered_model->check_event($trackno);
            if(empty(@$check)){
                $serial    = 'Mailderivery'.date("YmdHis");
                

            }else{ 
                //$serial = @$check->name;
                $serial    = 'Mailderivery'.date("YmdHis");
                //delete and update barcode
                
                 $this->unregistered_model->delete_event($trackno);
            }
               

              }else{$check=$this->unregistered_model->check_event($trackno); $this->unregistered_model->delete_event($trackno);}
           

                    $love = array();//from counter or region - receive item
                    $love = array(
                      'track_no'=>$trackno,
                      'event'=>$info->em_role,
                      'region'=>$info->em_region,
                      'branch'=>$info->em_branch,
                      'user'=>$emid,
                      'name'=>$serial,
                      'status'=>'Mailderivery',
                      'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);

                    $service_type= 'MAIL';
                     $senderp_id=@$senderperson->senderp_id;

                     $listbulk= @$this->unregistered_model->GetMailListbulkTrans_delivey($emid,$serial);

                  

                  
                     echo "
                    <table id='' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."</td></tr></table>
                     <table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
                <tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                 $sn=1;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->paidamount;
                  echo "<tr style='width:100%;color:#343434;'>
                   <td>".$sn."</td><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                 $sn++;
                }
             
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$senderp_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'  id='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
               
                        ";
                 




             
            }
             }    
         
            

        }else{

            

         // echo '  <span class ="price" style="color: red;font-weight: 60px;font-size: 22px;align-content:center ;"> Huduma Haijalipiwa</span>';

          $serial = $this->input->post('serial');
            if(empty($serial)){
                 $check=$this->unregistered_model->check_event($trackno);
            if(empty(@$check)){
                $serial    = 'Mailderivery'.date("YmdHis");
                

            }else{ 
                //$serial = @$check->name;
                $serial    = 'Mailderivery'.date("YmdHis");
                //delete and update barcode
                
                 $this->unregistered_model->delete_event($trackno);
            }
               

            }
           

                    $service_type= 'MAIL';
                    $senderp_id=@$senderperson->senderp_id;

                     $listbulk= @$this->unregistered_model->GetMailListbulkTrans_delivey($emid,$serial);

                  

                      echo "
                    <table id='' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."<span class ='price' style='color: red;font-weight: 60px;font-size: 22px;align-content:center ;'> Huduma Haijalipiwa</span></td></tr></table>
                     <table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
                <tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                 $sn=1;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->paidamount;
                  echo "<tr style='width:100%;color:#343434;'>
                   <td>".$sn."</td><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                 $sn++;
                }
             
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$senderp_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'  id='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
               
                        ";

     }

   



}
else{
redirect(base_url());
}

}



public function delete_deliver_bulk_scanned_itemS()
{
if ($this->session->userdata('user_login_access') != false){

     $emid=   $this->session->userdata('user_login_id');
   $trackno = $this->input->post('identifier');
    $operator = $this->input->post('operator');
$serial = $this->input->post('serial');



   
    $emid=$emid;

      $info = $this->employee_model->GetBasic($emid);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;



     $db='sender_person_info';
             $senderperson = $this->unregistered_model->get_senderperson_barcode($db,$trackno);
        
         
          if(!empty(@$senderperson))//which table
          {
             $this->unregistered_model->delete_bulk_by_event($trackno);

             if(!empty(@$trackno))//which table
          {
            

            //check payment
                  $senderp_id=@$senderperson->senderp_id;

                 $this->Box_Application_model->delete_delivery_info($senderp_id);

                 $track_number=@$senderperson->track_number;
                 

                    $data = array();//update sender status
                    $data = array('sender_status'=>'BackReceive');
                    $this->unregistered_model->update_acceptance_sender_person_info($trackno,$data);

                  
             
            }

                     $listbulk= @$this->unregistered_model->GetMailListbulkTrans_delivey($emid,$serial);
                                         $senderp_id=@$senderperson->senderp_id;

                           echo "
                    <table id='' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."</td></tr></table>
                     <table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
                <tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                 $sn=1;
                foreach ($listbulk as $key => $value) { 

                    $alltotal =$alltotal + $value->paidamount;
                  echo "<tr style='width:100%;color:#343434;'>
                   <td>".$sn."</td><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                  <td>


                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                 $sn++;
                }
             
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$senderp_id." class='senders'>
                 <input type='hidden' name ='serial1' value=".$serial." class='serial1'  id='serial1'>
                 <input type='hidden' name ='operator1' value=".$operator." class='operator1'>
               
                        ";

                  

         
            

        }

   



}
else{
redirect(base_url());
}

}




 public function close_bag_bulk_scanned_item()
{
if ($this->session->userdata('user_login_access') != false){

     $emid=   $this->session->userdata('user_login_id');
   $trackno = $this->input->post('identifier');
    $weight = $this->input->post('weight');
     $region = $this->input->post('region');
      $branch = $this->input->post('branch');
 $serial    = 'serial'.date("YmdHis");
   
    $emid=$emid;

      $info = $this->employee_model->GetBasic($emid);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;
         $loc= $info->em_region.' - '.$info->em_branch;



    $db='sender_person_info';
             $senderperson = $this->unregistered_model->get_senderperson_barcode($db,$trackno);
              
        
         
          if(!empty(@$senderperson))//which table
          {
            
            //check payment
          $senderp_id=@$senderperson->senderp_id;
            //$trackno=@$senderperson->Barcode;
            //$serial=@$senderperson->serial;
            
         $DB='register_transactions';
         $transactions2 = $this->unregistered_model->CheckintransactionsBYSENDERPRS($DB,$senderp_id);
         $DB='parcel_international_transactions';
         $transactions4 = $this->unregistered_model->Checkintransactions3($DB,$senderp_id);

  if( !empty($transactions2) || !empty($transactions4)){


        

          if($senderperson->sender_status != 'BackReceive0'){
                //echo 'Please check6 operator '.$trackno.' '.$operator;


          $serial = $this->input->post('serial');
       
            if($serial =='not'){
                
                 $check=$this->unregistered_model->check_event($trackno);
            if(empty(@$check)){
                $serial    = 'mailclosebag'.date("YmdHis");
                

            }else{ 
                // $serial = @$check->name;
                $serial    = 'mailclosebag'.date("YmdHis");
                //delete and update barcode
                
                 $this->unregistered_model->delete_event($trackno);
            }
               

            }else{$check=$this->unregistered_model->check_event($trackno); $this->unregistered_model->delete_event($trackno);}

            // echo 'event '.$serial;

           

                    $love = array();//from counter or region - receive item
                    $love = array(
                      'track_no'=>$trackno,
                      'event'=>$info->em_role,
                      'region'=>$info->em_region,
                      'branch'=>$info->em_branch,
                      'user'=>$emid,
                      'name'=>$serial,
                      'status'=>'mailclosebag',
                      'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);

                    $service_type= 'MAIL';
                       $senderp_id=@$senderperson->senderp_id;

                     $listbulk= @$this->unregistered_model->GetMailListbulkTrans_delivey($emid,$serial);

                  

                     echo "
                    <table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."</td></tr></table>
                     <table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                 $sn=1;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->paidamount;
                  echo "<tr style='width:100%;color:#343434;'>
                   <td>".$sn."</td><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                 $sn++;
                }

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>
               

             
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$senderp_id." class='senders' >
                 <input type='hidden' name ='serial' value=".$serial." class='serial'  id='serial'>
                   
                        ";
                 
             
            }
             }    
         
            

        }else{

            $serial = $this->input->post('serial');
            if(empty($serial)){
                 $check=$this->unregistered_model->check_event($trackno);
            if(empty(@$check)){
                $serial    = 'mailclosebag'.date("YmdHis");
                

            }else{ 
                // $serial = @$check->name;
                $serial    = 'mailclosebag'.date("YmdHis");
                //delete and update barcode
                
                 $this->unregistered_model->delete_event($trackno);
            }
               

            }

            // echo '  <span class ="price" style="color: red;font-weight: 60px;font-size: 22px;align-content:center ;"> Huduma Haijalipiwa</span>';


             $listbulk= @$this->unregistered_model->GetMailListbulkTrans_delivey($emid,$serial);

                  

                     echo "
                    <table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."  <span class ='price' style='color: red;font-weight: 60px;font-size: 22px;align-content:center ;'> Huduma Haijalipiwa</span></td></tr></table>
                     <table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                 $sn=1;
                foreach ($listbulk as $key => $value) { 

                 
                  $alltotal =$alltotal + $value->paidamount;
                  echo "<tr style='width:100%;color:#343434;'>
                   <td>".$sn."</td><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                  <td>


                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                 $sn++;
                }

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>
               

             
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
               
                 <input type='hidden' name ='serial' value=".$serial." class='serial'  id='serial'>
                   
                        ";
                         // <input type='hidden' name ='senders' value=".$sender_id." class='senders'>

}

   



}
else{
redirect(base_url());
}

}

public function delete_bag_close_bulk_scanned_item()
{
if ($this->session->userdata('user_login_access') != false){

     $emid=   $this->session->userdata('user_login_id');
   $trackno = $this->input->post('identifier');
    $operator = $this->input->post('operator');
$serial = $this->input->post('serial');



   
    $emid=$emid;

      $info = $this->employee_model->GetBasic($emid);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;



       $db='sender_person_info';
             $senderperson = $this->unregistered_model->get_senderperson_barcode($db,$trackno);
              
        if(!empty($senderperson))//which table
          {
             $this->unregistered_model->delete_bulk_by_event($trackno);

                     $listbulk= $this->unregistered_model->GetMailListbulkTrans_delivey($emid,$serial);
                                              $senderp_id=@$senderperson->senderp_id;

                  

                     echo "
                    <table id='' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."</td></tr></table>
                     <table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
                <tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                 $sn=1;
                foreach ($listbulk as $key => $value) { 

                  
                  $alltotal =$alltotal + $value->paidamount;
                  echo "<tr style='width:100%;color:#343434;'>
                   <td>".$sn."</td><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                 $sn++;
                }
             
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$senderp_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial' id='serial' >
               
                        ";
                 




             
            
               
         
            

        }

   



}
else{
redirect(base_url());
}

}



public function Save_bulk_closebag_scanned(){

   $emid=   $this->session->userdata('user_login_id');
    $tracknos = $this->input->post('identifier');
    // $operator = $this->input->post('operator');


     $Nill = $this->input->post('Nill');
      $weight = $this->input->post('weight');
     $region = $this->input->post('region');
      $branch = $this->input->post('branch');
      $bagss = $this->input->post('bagss');
      $service_type = $this->input->post('service_type');
      

   
    $emid=$emid;
   //$serial    = 'serial'.date("YmdHis");

    if(empty($emid)){    

    echo 'Please Input weight ';       

    }else{
    $word = 'DS';

    $getInfo = $this->employee_model->GetBasic($emid);
    $users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
    $loc = $getInfo->em_region.' - '.$getInfo->em_branch;
    $info = $this->employee_model->GetBasic($emid);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;
        $loc= ' - '.$info->em_branch;
        $o_region = $info->em_region;
         $o_branch = $info->em_branch;

        $source = $this->employee_model->get_code_source($o_region);
    $dest = $this->employee_model->get_code_dest($region);

if($Nill =='Nill'){

     $year = date("y");//getbagnumber_branch
                //$number = $this->getbagnumber();
                $number = $this->getbagnumber_branch($o_branch);

                   if($service_type =='Register'){  $bagsNo = 'REGISTER-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
    elseif ($service_type =='Parcels-Post') { $bagsNo = 'PARCEL-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
    elseif ($service_type =='Small-Packets') {  $bagsNo = 'PACKETS-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  elseif ($service_type =='Posts-Cargo') { $bagsNo = 'CARGO-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  elseif ($service_type =='Private-Bag') { $bagsNo = 'PRIVATE-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  elseif ($service_type =='Foreign-Parcel') { $bagsNo = 'FOREIGN-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  else{
    $bagsNo = 'REGISTER-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; 
  }

   if($bagss == 'New Bag'){

                     $save = array();
                 $save = array(
                               'bag_number'=>$bagsNo,
                               'bag_origin_region'=>$o_region,
                               'bag_branch_origin'=>$o_branch,
                               'bag_region_to'=>$region,
                               'bag_branch_to'=>$branch,
                               'bag_created_by'=>$emid,
                               'service_category'=>$service_type,
                               'bag_weight'=>$weight
                               );
                 $this->unregistered_model->save_mails_bags($save);
             }



}else{


    if(strpos($tracknos, $word) === false ){
        $weight = $this->input->post('weight');
        




    
      $serial = $this->input->post('serial');
      if(!empty($serial)){

 
       $getbarcode =  $this->unregistered_model->check_events_serial($serial);
       if(!empty(@$getbarcode)){

        
           $year = date("y");
                //$number = $this->getbagnumber();

                 $number = $this->getbagnumber_branch($getInfo->em_branch);

                   if($service_type =='Register'){  $bagsNo = 'REGISTER-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
    elseif ($service_type =='Parcels-Post') { $bagsNo = 'PARCEL-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
    elseif ($service_type =='Small-Packets') {  $bagsNo = 'PACKETS-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  elseif ($service_type =='Posts-Cargo') { $bagsNo = 'CARGO-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  elseif ($service_type =='Private-Bag') { $bagsNo = 'PRIVATE-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  elseif ($service_type =='Foreign-Parcel') { $bagsNo = 'FOREIGN-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  else{
    $bagsNo = 'REGISTER-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; 
  }


                // $bagsNo = 'EMS-BAG'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ';

                if($bagss == 'New Bag'){

                     $save = array();
                 $save = array(
                               'bag_number'=>$bagsNo,
                               'bag_origin_region'=>$o_region,
                               'bag_branch_origin'=>$o_branch,
                               'bag_region_to'=>$region,
                               'bag_branch_to'=>$branch,
                               'bag_created_by'=>$emid,
                               'service_category'=>$service_type,
                               'bag_weight'=>$weight
                               );
                 $this->unregistered_model->save_mails_bags($save);

                 $db='sender_person_info';

                 foreach ($getbarcode as $key => $value) {
                     

                       $Barcode = $value->track_no;
                       $senderperson = $this->unregistered_model->get_senderperson_barcodes($db,$Barcode);
                        $track_number = @$senderperson->track_number;
                      
                      
                      $data = array();
                      $data = array('sender_bag_number'=>$bagsNo,'sender_status'=>'Bag');
                      $this->unregistered_model->update_acceptance_sender_person_info($track_number,$data);




                               //$db='sender_person_info';
                               $senderinfo = $this->unregistered_model->get_senderperson_barcodes($db,$Barcode);

                                  $track_number=$senderinfo->track_number;

                                   $event = "Sorting Facility";
                            $location ='Received Sorting  Facility '.$loc;
                            $data2 = array();
                             $data2 = array('track_no'=>@$track_number,'location'=>$location,'user'=>@$users,'event'=>$event);

                             $this->Box_Application_model->save_location($data2);

                            $event = "Sorting Facility";
                            $location ='Ready for Transit '.$loc;
                            $data21 = array();
                             $data21 = array('track_no'=>@$track_number,'location'=>$location,'user'=>@$users,'event'=>$event);

                             $this->Box_Application_model->save_location($data21);

                              $smobile =@$senderinfo->sender_mobile;
                              $rmobile =@$senderinfo->receiver_mobile;
                             $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umesafirishwa '.'kutoka '.$getInfo->em_region.' - '.$getInfo->em_branch;
                                 $this->Sms_model->send_sms_trick($smobile,$stotal);
                                 $this->Sms_model->send_sms_trick($rmobile,$stotal);


                    }

      

         echo 'Successful Bag Closed ';

        }else{
            $db='sender_person_info';

          $upbag = array();
                      $upbag = array('bag_weight'=>$weight);
                      $this->unregistered_model->update_bag_info($upbag,$bagss);

        foreach ($getbarcode as $key => $value) {

                      
                     // $senderperson = $this->unregistered_model->get_senderperson_barcode($db,$tracknos);

                       $Barcode = $value->track_no;
                        $senderperson = $this->unregistered_model->get_senderperson_barcode($db,$Barcode);
                        $track_number = @$senderperson->track_number;
                      
                      
                      $data = array();
                      $data = array('sender_bag_number'=>$bagss,'sender_status'=>'Bag');
                      $this->unregistered_model->update_acceptance_sender_person_info($track_number,$data);


                      // $bagsNo =  $angalia->bag_number;
                      // $sum = $this->unregistered_model->get_sum_weight($bagsNo);

                      //$weight = $sum->register_weght + $angalia->bag_weight;

                       //$db='sender_person_info';
                               $senderinfo = $this->unregistered_model->get_senderperson_barcodes($db,$Barcode);

                                  $track_number=$senderinfo->track_number;

                                     $event = "Sorting Facility";
                            $location ='Received Sorting Facility '.$loc;
                            $data2 = array();
                             $data2 = array('track_no'=>@$track_number,'location'=>$location,'user'=>@$users,'event'=>$event);

                             $this->Box_Application_model->save_location($data2);

                            $event = "Sorting Facility";
                            $location ='Ready for Transit '.$loc;
                            $data21 = array();
                             $data21 = array('track_no'=>@$track_number,'location'=>$location,'user'=>@$users,'event'=>$event);

                             $this->Box_Application_model->save_location($data21);

                              $smobile =@$senderinfo->sender_mobile;
                              $rmobile =@$senderinfo->receiver_mobile;
                             $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umesafirishwa '.'kutoka '.$getInfo->em_region.' - '.$getInfo->em_branch;
                                 $this->Sms_model->send_sms_trick($smobile,$stotal);
                                 $this->Sms_model->send_sms_trick($rmobile,$stotal);

                    
                    }



         echo 'Successful Bag Closed ';



        }

       }
       
  }else{
        echo 'Failed';
      }
}
}
}
}
             
            

        




public function Save_bulk_Delivery_scanned(){

   $emid=   $this->session->userdata('user_login_id');
    $tracknos = $this->input->post('identifier');
    $operator = $this->input->post('operator');

    $emid=$emid;
   $serial    = 'serial'.date("YmdHis");

     // $arr = array(array('emid'=>$emid,'identifier'=>$trackno));
     //                  $list["data"]=$arr; 
    
                 //    header('Content-Type: application/json');
                 //    echo json_encode($list);


    if(empty($operator)){

                           
                            echo 'Please Select operator ';
       

    }else{
    $word = 'DS';
    if(strpos($tracknos, $word) === false ){
        
        $info = $this->employee_model->GetBasic($emid);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= ' - '.$info->em_branch;

    
      $serial = $this->input->post('serial');
      if(!empty($serial)){

 
       $getbarcode =  $this->unregistered_model->check_events_serial($serial);
       if(!empty(@$getbarcode)){
         

        foreach ($getbarcode as $key => $value) {
            
            $trackno = $value->track_no;

         $db='sender_person_info';
             $senderperson = $this->unregistered_model->get_senderperson_barcode($db,$trackno);
        
         
          if(!empty(@$senderperson))//which table
          {         

            //check payment
                  $senderp_id=@$senderperson->senderp_id;
                     $service_type= 'MAIL';

                     $checkReassigned = $this->Box_Application_model->check_reassign($senderp_id,$operator);

          if(!empty($checkReassigned)){

                         $data = array();
                      $data = array(
                    'em_id'=>$operator,
                    'item_id'=>$senderp_id,
                     'serial'=>$serial,
                    'service_type'=>$service_type
                );
                        $this->Box_Application_model->update_delivery_info($data,$senderp_id);

         }else{

                $data = array();
                $data = array(
                    'em_id'=>$operator,
                    'item_id'=>$senderp_id,
                    'serial'=>$serial,
                    'service_type'=>$service_type
                );

                 $this->Box_Application_model->save_delivery_info($data);

                 $track_number=@$senderperson->track_number;
                 

                    $data = array();//update sender status
                    $data = array('sender_status'=>'Assigned');
                    $this->unregistered_model->update_acceptance_sender_person_info($track_number,$data); 


                       $event = "Delivery Facility";
                            $location ='Ready for derivery';
                            $data21 = array();
                             $data21 = array('track_no'=>@$track_number,'location'=>$location,'user'=>@$user,'event'=>$event);

                             $this->Box_Application_model->save_location($data21);

                  

                     
                 }

                  

                     
                 }

             
            }

                // code...
        }

         echo 'Successful Saved';

       }
      
  }else{
        echo 'Please Scan Barcode';
      }
}
}

public function delete_deliver_bulk_scanned_item()
{
if ($this->session->userdata('user_login_access') != false){

     $emid=   $this->session->userdata('user_login_id');
   $trackno = $this->input->post('identifier');
    $operator = $this->input->post('operator');
$serial = $this->input->post('serial');



   
    $emid=$emid;

      $info = $this->employee_model->GetBasic($emid);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;



     $db='sender_person_info';
             $senderperson = $this->unregistered_model->get_senderperson_barcode($db,$trackno);
        
         
          if(!empty(@$senderperson))//which table
          {
             $this->unregistered_model->delete_bulk_by_event($trackno);

             if(!empty(@$trackno))//which table
          {
            

            //check payment
                  $senderp_id=@$senderperson->senderp_id;

                 $this->Box_Application_model->delete_delivery_info($senderp_id);

                 $track_number=@$senderperson->track_number;
                 

                    $data = array();//update sender status
                    $data = array('sender_status'=>'BackReceive');
                    $this->unregistered_model->update_acceptance_sender_person_info($trackno,$data);

                  
             
            }

                     $listbulk= @$this->unregistered_model->GetMailListbulkTrans_delivey($emid,$serial);
                                         $senderp_id=@$senderperson->senderp_id;

                           echo "
                    <table id='' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."</td></tr></table>
                     <table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
                <tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                 $sn=1;
                foreach ($listbulk as $key => $value) { 

                    $alltotal =$alltotal + $value->paidamount;
                  echo "<tr style='width:100%;color:#343434;'>
                   <td>".$sn."</td><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                  <td>


                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                 $sn++;
                }
             
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$senderp_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'  id='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
               
                        ";

                  

         
            

        }

   



}
else{
redirect(base_url());
}

}


 public function deliver_bulk_scanned_items()
{
if ($this->session->userdata('user_login_access') != false){

     $emid=   $this->session->userdata('user_login_id');
   $trackno = $this->input->post('identifier');
    $operator = $this->input->post('operator');
 $serial = $this->input->post('serial');
 $serial    = 'serial'.date("YmdHis");
   
    $emid=$emid;

      $info = $this->employee_model->GetBasic($emid);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;



   $db='sender_person_info';
             $senderperson = $this->unregistered_model->get_senderperson($db,$trackno);
              
        if(!empty($senderperson))//which table
          {
             //check payment
            $senderp_id=@$senderperson->senderp_id;
            //$serial=@$senderperson->serial;
            
         $DB='register_transactions';
         $transactions2 = $this->unregistered_model->CheckintransactionsBYSENDERPRS($DB,$senderp_id);
         $DB='parcel_international_transactions';
         $transactions4 = $this->unregistered_model->Checkintransactions3($DB,$senderp_id);

        
 if( !empty($transactions2) || !empty($transactions4)){

            

            
            if($senderperson->sender_status != 'BackReceive0'){ //haijawa received?
                //echo 'Please check6 operator '.$trackno.' '.$operator;


    $serial = $this->input->post('serial');
             if($serial =='not'){
                 $check=$this->unregistered_model->check_event($trackno);
            if(empty(@$check)){
                $serial    = 'Mailderivery'.date("YmdHis");
                

            }else{ 
                //$serial = @$check->name;
                $serial    = 'Mailderivery'.date("YmdHis");
                //delete and update barcode
                
                 $this->unregistered_model->delete_event($trackno);
            }
               

              }else{$check=$this->unregistered_model->check_event($trackno); $this->unregistered_model->delete_event($trackno);}
           

                    $love = array();//from counter or region - receive item
                    $love = array(
                      'track_no'=>$trackno,
                      'event'=>$info->em_role,
                      'region'=>$info->em_region,
                      'branch'=>$info->em_branch,
                      'user'=>$emid,
                      'name'=>$serial,
                      'status'=>'Mailderivery',
                      'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);

                    $service_type= 'MAIL';
                                

                     $getbarcode =  $this->unregistered_model->check_events_serial($serial);
      
          if(!empty(@$trackno))//which table
          {
            

            //check payment
                  $senderp_id=@$senderperson->senderp_id;
                     $service_type= 'MAIL';

                     $checkReassigned = $this->Box_Application_model->check_reassign($senderp_id,$operator);

                     if(!empty($checkReassigned)){

                         $data = array();
                      $data = array(
                    'em_id'=>$operator,
                    'item_id'=>$senderp_id,
                     'serial'=>$serial,
                    'service_type'=>$service_type
                );
                        $this->Box_Application_model->update_delivery_info($data,$senderp_id);

                     }else{

                $data = array();
                $data = array(
                    'em_id'=>$operator,
                    'item_id'=>$senderp_id,
                    'serial'=>$serial,
                    'service_type'=>$service_type
                );

                 $this->Box_Application_model->save_delivery_info($data);

                 $track_number=@$senderperson->track_number;
                 

                    $data = array();//update sender status
                    $data = array('sender_status'=>'Assigned');
                    $this->unregistered_model->update_acceptance_sender_person_info($track_number,$data); 

                  
                       $event = "Delivery Facility";
                            $location ='Ready for derivery';
                            $data21 = array();
                             $data21 = array('track_no'=>@$track_number,'location'=>$location,'user'=>@$user,'event'=>$event);

                             $this->Box_Application_model->save_location($data21);

                  

                     
                 
                     
                 }

             
            }


                     $listbulk= @$this->unregistered_model->GetMailListbulkTrans_delivey($emid,$serial);

                  

                     echo "
                    <table id='' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."</td></tr></table>
                     <table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
                <tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                 $sn=1;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->paidamount;
                  echo "<tr style='width:100%;color:#343434;'>
                   <td>".$sn."</td><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue1('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                 $sn++;
                }
             
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders1' value=".$senderp_id." class='senders1'>
                 <input type='hidden' name ='serial1' value=".$serial." class='serial1'  id='serial1'>
                 <input type='hidden' name ='operator1' value=".$operator." class='operator1'>
               
                        ";


             
            }
             }    
         
            

        }else{

            

         // echo '  <span class ="price" style="color: red;font-weight: 60px;font-size: 22px;align-content:center ;"> Huduma Haijalipiwa</span>';

          $serial = $this->input->post('serial');
            if(empty($serial)){
                 $check=$this->unregistered_model->check_event($trackno);
            if(empty(@$check)){
                $serial    = 'Mailderivery'.date("YmdHis");
                

            }else{ 
                //$serial = @$check->name;
                $serial    = 'Mailderivery'.date("YmdHis");
                //delete and update barcode
                
                 $this->unregistered_model->delete_event($trackno);
            }
               

            }
           

                    $service_type= 'MAIL';
                     $senderp_id=@$senderperson->senderp_id;

                      $listbulk= @$this->unregistered_model->GetMailListbulkTrans_delivey($emid,$serial);

                  

                     echo "
                    <table id='' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)." <span class ='price' style='color: red;font-weight: 60px;font-size: 22px;align-content:center ;'> Huduma Haijalipiwa</span></td></tr></table>
                    <table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
                <tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                 $sn=1;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->paidamount;
                  echo "<tr style='width:100%;color:#343434;'>
                   <td>".$sn."</td><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue1('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                 $sn++;
                }
             
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders1' value=".$senderp_id." class='senders1'>
                 <input type='hidden' name ='serial1' value=".$serial." class='serial1'  id='serial1'>
                 <input type='hidden' name ='operator1' value=".$operator." class='operator1'>
               
                        ";

     }

   



}
else{
redirect(base_url());
}

}

 public function Receive_scanned_item()
{
if ($this->session->userdata('user_login_access') != false){

     $service_type = $this->input->get('Ask_for');

$emid = base64_decode($this->input->get('I'));
$data['region'] = $this->employee_model->regselect();
$data['emselect'] = $this->employee_model->delivereselect();
$data['agselect'] = $this->employee_model->agselect();

     $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();


    $data['bags'] = $this->Box_Application_model->count_bags();

    
   
    
    $this->load->view('inlandMails/Receive_scanned_item',$data);

}
else{
redirect(base_url());
}

}

/*public function close_bag_items()
{
if ($this->session->userdata('user_login_access') != false){

     $service_type = $this->input->get('Ask_for');

$emid = base64_decode($this->input->get('I'));
$data['region'] = $this->employee_model->regselect();
$data['emselect'] = $this->employee_model->delivereselect();
$data['agselect'] = $this->employee_model->agselect();

    $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();


 $data['bagss'] = $this->unregistered_model->get_bags_number_mails($service_type);
    
   
    
    $this->load->view('inlandMails/close_bag_items',$data);

}
else{
redirect(base_url());
}

}*/

public function close_bag_items(){
if ($this->session->userdata('user_login_access') != false){

     $service_type = $this->input->get('Ask_for');

    $emid = base64_decode($this->input->get('I'));
    $data['region'] = $this->employee_model->regselect();
    $data['emselect'] = $this->employee_model->delivereselect();
    $data['agselect'] = $this->employee_model->agselect();

    $data['ems'] = $this->unregistered_model->count_ems();
      $data['bags'] = $this->unregistered_model->count_bags();
      $data['despout'] = $this->unregistered_model->count_despatch();
      $data['despin'] = $this->unregistered_model->count_despatch_in();


    $data['bagss'] = $this->unregistered_model->get_bags_number_mails($service_type);
    
   
    
    $this->load->view('inlandMails/close_bag_items',$data);

}
else{
redirect(base_url());
}

}

public function delete_selected_bag(){
    if ($this->session->userdata('user_login_access') != false){
        $bagsNo = $_GET['bagno'];
        $returnto = $_GET['returnto'];

        if ($bagsNo) {
            $this->unregistered_model->deleteBagInfo($bagsNo);
        }

        redirect('unregistered/'.$returnto);

    }else{
        redirect(base_url());
    }
}


public function get_bag_itemlist(){
    if ($this->session->userdata('user_login_access') != false){
        $bagnoText = $this->input->post('bagnoText');
        $emid = $this->session->userdata('user_login_id');

        if (!empty($bagnoText)) {

            $emslist = $this->unregistered_model->getBagItemListBybagNumber($bagnoText);

            if ($emslist) {

                $temp = '';
                $count = 1;

                foreach ($emslist as $key => $value) {
                    $sn = $count++;

                    $temp .="<tr data-transid='".$value['t_id']."' class='".$value['Barcode']." tr".$value['t_id']." receiveRowd'
                        id='tr".$value['t_id']."'
                        > <td>".$sn."</td>
                         <td>".$value['sender_fullname']."</td>
                         <td>".$value['receiver_fullname']."</td>
                         <td>".$value['sender_date_created']."</td>
                         <td>".$value['sender_branch']."</td>
                         <td>".$value['reciver_branch']."</td>
                         <td>".$value['Barcode']."</td>
                         <td>
                         <div class='form-check' style='padding-left: 53px;float:left'>
                         <input type='checkbox' name='transactions' value='".$value['t_id']."' class='form-check-input ".$value['Barcode']."' style='padding-right:50px;' />
                                <label class='form-check-label' for='remember-me'></label>
                                </div>
                                <button data-transid='".$value['t_id']."' href='#' onclick='Deletevalue(this)' title='Cancel' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-trash-o'></i></button>
                                </td></tr>";

                }

                $response['status'] = "Success";
                $response['msg'] = $temp;
                $response['total'] = sizeof($emslist);
                
            }else{
                $response['status'] = "Error";
                $response['msg'] = "No data";
            }
        }else{
            $response['status'] = "Error";
            $response['msg'] = "No Barcode number";
        }

        print_r(json_encode($response));
    }else{
        redirect(base_url());
    }
}


public function createNillBag(){
    if ($this->session->userdata('user_login_access') != false){
        $bagnoText = $this->input->post('bagnoText');
        $rec_region = $this->input->post('rec_region');
        $rec_branch = $this->input->post('rec_branch');

        $emid = $this->session->userdata('user_login_id');
        $service_type = $this->session->userdata('service_type');

        if ($bagnoText == 'New Bag') {

             if (!empty($emid)) {
                 $basicinfo = $this->employee_model->GetBasic($emid);
                $region = $basicinfo->em_region;
                $em_branch = $basicinfo->em_branch;

                $bagno = $this->unregistered_model->createbagNumber($rec_branch,$em_branch);

                //process of saving the bag information
                $now = date("Y-m-d H:i:s");
                $bagInfor = array(
                    'bag_number' =>$bagno['num'], 
                    'bag_region_to' =>$rec_region, 
                    'bag_branch_to' =>$rec_branch, 
                    'date_created' =>$now, 
                    'dc'=>$bagno['dc'], 
                    'service_category' =>$service_type, 
                    'bag_origin_region ' =>$region, 
                    'bag_branch_origin' =>$em_branch,
                    'bag_created_by ' =>$emid
                );

                $bagnoId = $this->unregistered_model->save_bag($bagInfor);
                $select = '<option selected value="'.$bagnoId.'">'.$bagno['num'].'</option>';

                $bagnoText = $bagno['num'];//bag name

                $response['status'] = "Success";
                $response['msg'] = "Nill bag created ".$bagno['num'];
                $response['select'] = $select;

             }else{
                $response['status'] = "Error";
                $response['msg'] = "Bag not created";
             }
                
        }else{
            $response['status'] = "Error";
            $response['msg'] = "Bag not created";
        }

        print_r(json_encode($response));
    }else{
        redirect(base_url());
    }
}


public function assign_item_bag_process(){
    if ($this->session->userdata('user_login_access') != false){
        $barcode = $this->input->post('barcode');
        $rec_region = $this->input->post('rec_region');
        $rec_branch = $this->input->post('rec_branch');
        $bagssno = $this->input->post('bagno');
        $bagnoText = $this->input->post('bagnoText');
        $emid = $this->session->userdata('user_login_id');
        $pass_to = $this->session->userdata('user_login_id');
        $sn = $this->input->post('sn');

        $service_type= $this->session->userdata('service_type');

        if (!empty($emid)) {
            //user information
            $basicinfo = $this->employee_model->GetBasic($emid);
            $region = $basicinfo->em_region;
            $em_branch = $basicinfo->em_branch;

            $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

            $office_trace_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'';


            //$emslist = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode,'Despatch receive',$emid,$pass_to);

            $db='sender_person_info';
            //$emslist = $this->unregistered_model->getMailTransactionsOfficeBybarcode($barcode,'InLand registration receive',$emid);
            // $emslist = $this->unregistered_model->get_senderperson_barcode($db,$barcode);

             /*if ($office_trace_name) {
                $emslist = $this->unregistered_model->getMailTransactionsOfficeBybarcode($barcode,$office_trace_name,$emid);
            }else{
                $emslist = $this->unregistered_model->get_senderperson_barcode($db,$barcode);
            }*/

            $emslist = $this->unregistered_model->get_senderperson_barcode($db,$barcode);

            if ($emslist) {

                if ($bagnoText == 'New Bag') {
                
                    $bagno = $this->unregistered_model->createbagNumber($rec_branch,$em_branch);

                    //process of saving the bag information
                    $now = date("Y-m-d H:i:s");
                    $bagInfor = array(
                        'bag_number' =>$bagno['num'], 
                        'bag_region_to' =>$rec_region, 
                        'bag_branch_to' =>$rec_branch, 
                        'date_created' =>$now, 
                        'dc'=>$bagno['dc'], 
                        'service_category' =>$service_type, 
                        'bag_origin_region ' =>$region, 
                        'bag_branch_origin' =>$em_branch,
                        'bag_created_by ' =>$emid
                    );

                    $bagnoId = $this->unregistered_model->save_bag($bagInfor);


                    $select = '<option selected value="'.$bagnoId.'">'.$bagno['num'].'</option>';

                    $bagnoText = $bagno['num'];//bag name
                }else{
                    $bagnoId = $bagssno;//bag Id
                    $bagnoText = $bagnoText; //bag name
                }

                //update the sender infor
                 $this->unregistered_model->update_sender_info(
                    $emslist[0]['senderp_id'],array(
                        'sender_bag_number'=>$bagnoText,
                        'sender_status'=>'Bag'));

                if ($emslist[0]['status'] == 'Paid' || $emslist[0]['bill_status'] == 'Rtx') {
                    $paymentStatus = 1;
                }else{
                    $paymentStatus = 0;
                }


                if ($paymentStatus) {

                //process of assigning the items in the bag
                $transData = array(
                'isBagNo'=>$bagnoText,
                'isBagBy'=>$emid,
                'office_name'=>'Back',
                'bag_status'=>'isBag');

                $this->unregistered_model->update_back_office_Barcode($barcode,$transData);

                
                //for tracing
                $trace_data = array(
                'emid'=>$emid,
                'transid'=>$emslist[0]['t_id'],
                'office_name'=>'Despatch',
                'trans_type'=>'mails',
                'description'=>'Received sorting facility '.$em_branch,
                'status'=>'BAG');

                $this->Box_Application_model->tracing($trace_data);


                //for track
                $track_data = array(
                'emid'=>$emid,
                'transid'=>$emslist[0]['t_id'],
                'office_name'=>'Despatch',
                'trans_type'=>'mails',
                'description'=>'Sorting Facility from '.$em_branch,
                'type'=>1,
                'status'=>'Sorting Facility');

                $this->Box_Application_model->tracing($track_data);

                    $temp = '';
                    foreach ($emslist as $key => $value) {

                        if ($value['status'] == 'NotPaid') {
                                $pay_status  = "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
                        }else{
                            $pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
                        }

                        $temp .="<tr style='background:blue;color:white;' data-transid='".$value['t_id']."' class='".$value['Barcode']." tr".$value['t_id']." receiveRow'
                            id='tr".$value['t_id']."'
                            > <td>".$sn."</td>
                             <td>".$value['sender_fullname']."</td>
                             <td>".$value['receiver_fullname']."</td>
                             <td>".$value['sender_date_created']."</td>
                             <td>".$value['sender_branch']."</td>
                             <td>".$value['reciver_branch']."</td>
                             <td>".$value['Barcode']."</td>
                             <td>
                             <div class='form-check' style='padding-left: 53px;float:left'>
                             <input type='checkbox' name='transactions' value='".$value['t_id']."' class='form-check-input ".$value['Barcode']."' style='padding-right:50px;' />
                                    <label class='form-check-label' for='remember-me'></label>
                                    </div>
                                    <button data-transid='".$value['t_id']."' href='#' onclick='Deletevalue(this)' title='Cancel' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-trash-o'></i></button>
                                    </td></tr>";

                    }

                    $response['status'] = "Success";
                    $response['msg'] = $temp;
                    $response['total'] = sizeof($emslist);
                    if(!empty($select)) $response['select'] = $select;

                }else{
                    $response['status'] = "Error";
                    $response['msg'] = "Huduma Haijalipiwa";
                }
                
            }else{
                $response['status'] = "Error";
                $response['msg'] = "No data";
            }
        }else{
            $response['status'] = "Error";
            $response['msg'] = "No pf number";
        }

        print_r(json_encode($response));
    }else{
        redirect(base_url());
    }
}


    public function registered_domestic_dashboard()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $search  = $this->input->post('search');
             $data['emselect'] = $this->employee_model->delivereselect();

            $type = $this->input->post('type');
            $check = $this->input->post('I');
            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $service_type = $this->input->get('Ask_for');

            $this->session->set_userdata('service_type',$service_type);

              $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();

              $date = $this->input->post('date');
              $month = $this->input->post('month');
              $status = $this->input->post('status');

              //echo $type. 'first';
              if(empty($type)){ $type="Back";}
            

            if ($type == "Back") { //from counter or branch Received
              
              $data['type'] = $type;
              $data['status'] =$status = 'Back';

            if (!empty($search)) {
                //echo $type. 'Second search';
               //$data['list']= $this->unregistered_model->get_register_application_search_back($date,$month,$status);
                //$data['list']=$this->unregistered_model->get_register_application_search_back_BRANCH($date,$month,$status);
              //  $data['list']=$emslists;

               $emslists = array();
              //echo $type. 'third search';
                //$data['list'] =$this->unregistered_model->get_register_application_list_back();
                 // $emslists[]= $this->unregistered_model->get_register_application_list_general($status);
                 // $emslists[]= $this->unregistered_model->get_register_application_list_back_from_Branch();
                 //  $data['list']=$emslists;

               if($service_type == 'Register'){


                $fromcounter[] = $this->unregistered_model->get_register_application_search_back($date,$month,$status); //LIST FROM COUNTER
                $frombranc[] = $this->unregistered_model->get_register_application_search_back_BRANCH($date,$month,$status);

                //BulkPosting bill
                $bulk='REGISTER BULK POSTING';
                $fromcounter[] = $this->unregistered_model->get_register_bulk_posting_application_search_back($date,$month,$status,$bulk); //LIST FROM COUNTER
                $frombranch[] = $this->unregistered_model->get_register_bulk_posting_application_search_back_BRANCH($date,$month,$status,$bulk);


               }else{

                 if($service_type == 'Parcels-Post'){

                     $bulk='PARCEL BULK POSTING';
                $fromcounter[] = $this->unregistered_model->get_register_bulk_posting_application_search_back($date,$month,$status,$bulk); //LIST FROM COUNTER
                $frombranch[] = $this->unregistered_model->get_register_bulk_posting_application_search_back_BRANCH($date,$month,$status,$bulk);

                }
                 $fromcounter = $this->unregistered_model->get_register_application_search_back($date,$month,$status); //LIST FROM COUNTER
                 $frombranch = $this->unregistered_model->get_register_application_search_back_BRANCH($date,$month,$status);

               }

                 

                foreach ($fromcounter as $key => $values) {
                    foreach ($values as $key1 => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'COUNTER', $value->Barcode);
                        
                }
            }
                
                
                foreach ($frombranch as $key => $values) {
                    foreach ($values as $key1 => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'BRANCH', $value->Barcode);
                        
                }
            }

                $data['list']=$emslists;

            }else{
              $emslists = array();
              //echo $type. 'third search';
                //$data['list'] =$this->unregistered_model->get_register_application_list_back();
                  //$data['list']= $this->unregistered_model->get_register_application_list_general($status);
                  //$data['list'] = $this->unregistered_model->get_register_application_list_back_from_Branch();
                 //  $data['list']=$emslists;

               if($service_type == 'Register'){


                $fromcounter[] = $this->unregistered_model->get_register_application_list_general($status); //LIST FROM COUNTER 
                $frombranch[] = $this->unregistered_model->get_register_application_list_back_from_Branch($status);

                //BulkPosting bill
                $bulk='REGISTER BULK POSTING';
                $fromcounter[] = $this->unregistered_model->get_register_application_list_bulk_posting_general($status,$bulk); //LIST FROM COUNTER
                $frombranch[] = $this->unregistered_model->get_register_application_bulk_posting_list_back_from_Branch($status,$bulk);


               }else{

                if($service_type == 'Parcels-Post'){

                     $bulk='PARCEL BULK POSTING';
                 $fromcounter[] = $this->unregistered_model->get_register_application_list_bulk_posting_general($status,$bulk); //LIST FROM COUNTER
                $frombranch[] = $this->unregistered_model->get_register_application_bulk_posting_list_back_from_Branch($status,$bulk);


                }


                 $fromcounter[] = $this->unregistered_model->get_register_application_list_general($status); //LIST FROM COUNTER 
                $frombranch[] = $this->unregistered_model->get_register_application_list_back_from_Branch($status);

               }

                
                foreach ($fromcounter as $key => $values) {
                    foreach ($values as $key1 => $value) {
                        // code...
                  
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'COUNTER', $value->Barcode);
                        
                }
                  }
                
                foreach ($frombranch as $key => $value) {//$value = (object)$value;
                    foreach ($values as $key1 => $value) {
                        // code...
                  
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'BRANCH' , $value->Barcode);
                        
                }
                  }

               $data['list']=$emslists;
                 
            }

             

            }elseif ($type == "BackReceive") { //from counter or branch Received
              
              $data['type'] = $type;
              $data['status'] =$status;
               $data['bagss'] = $this->unregistered_model->get_bags_number_mails($service_type);

             if (!empty($search)) {
                //echo $type. 'Second search';
               //$data['list']= $this->unregistered_model->get_register_application_search_back($date,$month,$status);
                //$data['list']=$this->unregistered_model->get_register_application_search_back_BRANCH($date,$month,$status);
              //  $data['list']=$emslists;

               $emslists = array();
              //echo $type. 'third search';
                //$data['list'] =$this->unregistered_model->get_register_application_list_back();
                 // $emslists[]= $this->unregistered_model->get_register_application_list_general($status);
                 // $emslists[]= $this->unregistered_model->get_register_application_list_back_from_Branch();
                 //  $data['list']=$emslists;

               if($service_type == 'Register'){


                $fromcounter[] = $this->unregistered_model->get_register_application_search_back($date,$month,$status); //LIST FROM COUNTER
                $frombranch[] = $this->unregistered_model->get_register_application_search_back_BRANCH($date,$month,$status);

                //BulkPosting bill
                $bulk='REGISTER BULK POSTING';
                $fromcounter[] = $this->unregistered_model->get_register_bulk_posting_application_search_back($date,$month,$status,$bulk); //LIST FROM COUNTER
                $frombranch[] = $this->unregistered_model->get_register_bulk_posting_application_search_back_BRANCH($date,$month,$status,$bulk);


               }else{

                 if($service_type == 'Parcels-Post'){

                     $bulk='PARCEL BULK POSTING';
                $fromcounter[] = $this->unregistered_model->get_register_bulk_posting_application_search_back($date,$month,$status,$bulk); //LIST FROM COUNTER
                $frombranch[] = $this->unregistered_model->get_register_bulk_posting_application_search_back_BRANCH($date,$month,$status,$bulk);

                }



                 $fromcounter = $this->unregistered_model->get_register_application_search_back($date,$month,$status); //LIST FROM COUNTER
                 $frombranch = $this->unregistered_model->get_register_application_search_back_BRANCH($date,$month,$status);

               }
               
               //echo json_encode($fromcounter);
                 
 
                foreach ($fromcounter as $key => $values) {//$value = (object)$value['data'];//$value = (object)$value;
                    foreach ($values as $key1 => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'COUNTER', $value->Barcode);
                        
                }
            }
                
                 foreach ($frombranch as $key => $values) {//$value = (object)$value;
                    foreach ($values as $key1 => $value) {
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'BRANCH', $value->Barcode);
                        
                }
            }

                $data['list']=$emslists;

            }else{
              $emslists = array();
              //echo $type. 'third search';
                //$data['list'] =$this->unregistered_model->get_register_application_list_back();
                  //$data['list']= $this->unregistered_model->get_register_application_list_general($status);
                  //$data['list'] = $this->unregistered_model->get_register_application_list_back_from_Branch();
                 //  $data['list']=$emslists;

               if($service_type == 'Register'){


                $fromcounter[] = $this->unregistered_model->get_register_application_list_general($status); //LIST FROM COUNTER 
                $frombranch[] = $this->unregistered_model->get_register_application_list_back_from_Branch($status);

                //BulkPosting bill
                $bulk='REGISTER BULK POSTING';
                $fromcounter[] = $this->unregistered_model->get_register_application_list_bulk_posting_general($status,$bulk); //LIST FROM COUNTER
                $frombranch[] = $this->unregistered_model->get_register_application_bulk_posting_list_back_from_Branch($status,$bulk);


               }else{
                if($service_type == 'Parcels-Post'){

                     $bulk='PARCEL BULK POSTING';
                $fromcounter[] = $this->unregistered_model->get_register_application_list_bulk_posting_general($status,$bulk); //LIST FROM COUNTER
                $frombranch[] = $this->unregistered_model->get_register_application_bulk_posting_list_back_from_Branch($status,$bulk);

                }

                 $fromcounter[] = $this->unregistered_model->get_register_application_list_general($status); //LIST FROM COUNTER 
                
                $frombranch[] = $this->unregistered_model->get_register_application_list_back_from_Branch($status);

               }

                
                foreach ($fromcounter as $key => $values) {
                    foreach ($values as $key1 => $value) {
                        // code...
                  
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'COUNTER', $value->Barcode);
                        
                }
                  }
                
                foreach ($frombranch as $key => $value) {//$value = (object)$value;
                    foreach ($values as $key1 => $value) {
                        // code...
                  
                  $emslists[] = $this->Received_ViewModel->view_data($value->sender_fullname,$value->sender_date_created, $value->register_type, $value->register_weght, $value->sender_date_created,
            $value->register_price, $value->payment_type,$value->sender_region, $value->sender_branch,$value->receiver_region, $value->reciver_branch,$value->billid,$value->track_number,$value->sender_status, $value->senderp_id, 'BRANCH', $value->Barcode);
                        
                }
                  }

               $data['list']=$emslists;
                 
            }
             

            }elseif ($type == "receive") {   //receive action
              
               $data['type'] = 'Back';
              $data['status']=$status = 'Back';



              
            if (!empty($check)) {
                $getInfo = $this->employee_model->GetBasic($emid);
                            $users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
                            //$loc = $getInfo->em_region.' - '.$getInfo->em_branch;
                             $loc =' - '.$getInfo->em_branch;


                for ($i=0; $i <@sizeof($check) ; $i++) {
                    $last_id = $check[$i];

                     $senderperson = $this->unregistered_model->get_senderperson_by_senderp_id11($last_id);
              
                   $trackno=@$senderperson->track_number;
                    $Barcode=@$senderperson->Barcode;

                     $love = array();//from counter or region - receive item
                    $love = array(
                      'track_no'=>$Barcode,
                      'event'=>$service_type,
                      'region'=>$sender_region,
                      'branch'=>$sender_branch,
                      'user'=>$emid,
                      'name'=>'BackReceive',
                      'status'=>'Received',
                      'type'=>'MailReceive'
                    );

                    $this->unregistered_model->save_event($love);




                    $trackno = array();
                    $trackno = array('sender_status'=>'BackReceive');
                    $this->unregistered_model->update_sender_info($last_id,$trackno);


                      // $getInfo = $this->employee_model->GetBasic($emid);
                       //      $users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
                       //      $loc = $getInfo->em_region.' - '.$getInfo->em_branch;



                               $db='sender_person_info';
                               $senderinfo = $this->unregistered_model->CheckintransactionsBYSENDERPRS($db,$last_id);

                                  $Barcode=@$senderinfo->Barcode;

                            $event = "Sorting Facility";
                            $location ='Received Sorting Facility '.$loc;
                            $data2 = array();
                             $data2 = array('track_no'=>@$Barcode,'location'=>$location,'user'=>@$users,'event'=>$event);

                             $this->Box_Application_model->save_location($data2);

                              $smobile =@$senderinfo->sender_mobile;
                              $rmobile =@$senderinfo->receiver_mobile;
                             $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umepokelewa '.' '.$getInfo->em_region.' - '.$getInfo->em_branch;
                                 $this->Sms_model->send_sms_trick($smobile,$stotal);
                                 $this->Sms_model->send_sms_trick($rmobile,$stotal);
                }

                          $data['message'] = "Item Received";
                          } else {
                              $data['errormessage'] = "Please Select Atleast One Item To Receive";
                          }

              //$data['list'] = $this->unregistered_model->get_register_application_list_back();
              $data['list'] = $this->unregistered_model->get_register_application_list_general($status);
               $data['list'] =$this->unregistered_model->get_register_application_list_back_from_Branch($status);




            }elseif ($type == "bagclose") { //action


                 $getInfo = $this->employee_model->GetBasic($emid);
                            $users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
                            //$loc = $getInfo->em_region.' - '.$getInfo->em_branch;
                             $loc =' - '.$getInfo->em_branch;

               $data['type'] = 'BackReceive';
              $data['status']=$status = 'BackReceive';
               $data['bagss'] = $this->unregistered_model->get_bags_number_mails($service_type);
            
             if (!empty($check)) {

             //$id = $check[0];
             
               
                  $rec_region = $this->input->post('region');
                  $rec_branch = $this->input->post('district');

                 $source = $this->employee_model->get_code_source($sender_region);
                 $dest = $this->employee_model->get_code_dest($rec_region);
                 // $number = rand(10000000,20000000);

                  $weight =  $this->input->post('weight');
                    $bagno =  $this->input->post('bagss');
                 

                 //$angalia = $this->unregistered_model->get_bag_number_by_date($rec_region,$rec_branch);

                 if ($bagno=='New Bag') { 



                    $year = date("y");
                //$number = $this->getbagnumber();
                 $number = $this->getbagnumber_branch($getInfo->em_branch);
                  if($service_type =='Register'){  $bagsNo = 'REGISTER-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
    elseif ($service_type =='Parcels-Post') { $bagsNo = 'PARCEL-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
    elseif ($service_type =='Small-Packets') {  $bagsNo = 'PACKETS-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  elseif ($service_type =='Posts-Cargo') { $bagsNo = 'CARGO-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  elseif ($service_type =='Private-Bag') { $bagsNo = 'PRIVATE-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  elseif ($service_type =='Foreign-Parcel') { $bagsNo = 'FOREIGN-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
  else{
    $bagsNo = 'REGISTER-BAG-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; 
  }               


                 $save = array();
                 $save = array(
                               'bag_number'=>$bagsNo,
                               'bag_origin_region'=>$sender_region,
                               'bag_branch_origin'=>$sender_branch,
                               'bag_region_to'=>$rec_region,
                               'bag_branch_to'=>$rec_branch,
                               'bag_created_by'=>$emid,
                               'service_category'=>$service_type,
                               'bag_weight'=>$weight
                               );
                 $this->unregistered_model->save_mails_bags($save);

                  for ($i=0; $i <@sizeof($check) ; $i++) {

                       $id = $last_id = $check[$i];
                       //$get = $this->unregistered_model->get_dest_region($id);
                       // $rec_region = $get->receiver_region;
                       // $rec_branch = $get->reciver_branch;
                      
                      $trackno = array();
                      $trackno = array('sender_bag_number'=>$bagsNo,'sender_status'=>'Bag');
                      $this->unregistered_model->update_sender_info($last_id,$trackno);


                       // $getInfo = $this->employee_model->GetBasic($emid);
                       //      $users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
                       //      $loc = $getInfo->em_region.' - '.$getInfo->em_branch;

                               $db='sender_person_info';
                               $senderinfo = $this->unregistered_model->CheckintransactionsBYSENDERPRS( $db,$id);

                                  $Barcode=@$senderinfo->Barcode;

                            $event = "Sorting Facility";
                            $location ='Ready for Transit '.$loc;
                            $data2 = array();
                             $data2 = array('track_no'=>@$Barcode,'location'=>$location,'user'=>@$users,'event'=>$event);

                             $this->Box_Application_model->save_location($data2);

                              $smobile =@$senderinfo->sender_mobile;
                              $rmobile =@$senderinfo->receiver_mobile;
                             $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umesafirishwa '.'kutoka '.$getInfo->em_region.' - '.$getInfo->em_branch;
                                 $this->Sms_model->send_sms_trick($smobile,$stotal);
                                 $this->Sms_model->send_sms_trick($rmobile,$stotal);

                    }

                     //$sum = $this->unregistered_model->get_sum_weight($bagsNo);
                     //$weight = $sum->register_weght + $this->input->post('bagno');

                    


                 } else {


                      
                      for ($i=0; $i <@sizeof($check) ; $i++) {

                       $id = $last_id = $check[$i];
                      $trackno = array();
                      $trackno = array('sender_bag_number'=>$bagno,'sender_status'=>'Bag');
                      $this->unregistered_model->update_sender_info($last_id,$trackno);


                      // $bagsNo =  $angalia->bag_number;
                      // $sum = $this->unregistered_model->get_sum_weight($bagsNo);

                      //$weight = $sum->register_weght + $angalia->bag_weight;
                      $upbag = array();
                      $upbag = array('bag_weight'=>$weight);
                      $this->unregistered_model->update_bag_info($upbag,$bagno);

                       $db='sender_person_info';
                               $senderinfo = $this->unregistered_model->CheckintransactionsBYSENDERPRS( $db,$id);

                                  $Barcode=@$senderinfo->Barcode;

                            $event = "Sorting Facility";
                            $location ='Ready for Transit '.$loc;
                            $data2 = array();
                             $data2 = array('track_no'=>@$Barcode,'location'=>$location,'user'=>@$users,'event'=>$event);

                             $this->Box_Application_model->save_location($data2);

                              $smobile =@$senderinfo->sender_mobile;
                              $rmobile =@$senderinfo->receiver_mobile;
                             $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umesafirishwa '.'kutoka '.$getInfo->em_region.' - '.$getInfo->em_branch;
                                 $this->Sms_model->send_sms_trick($smobile,$stotal);
                                 $this->Sms_model->send_sms_trick($rmobile,$stotal);
                    }

                 
              }

              $data['message'] = "Item Closed In Bag";
             
             } else {
                $data['errormessage'] = "Please Select Atleast One Item To Receive";

             }
             $data['list'] = $this->unregistered_model->get_register_application_list_general($status);
              $data['list'] =$this->unregistered_model->get_register_application_list_back_from_Branch($status);

             
            } else {

              $data['list'] = $this->unregistered_model->get_register_application_list_general($status);
               $data['list'] =$this->unregistered_model->get_register_application_list_back_from_Branch($status);

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
            $emid = $this->session->userdata('user_login_id');

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


            $staff_section = $this->employee_model->getEmpDepartmentSections($emid);
            
            $data['current_section'] = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'';

            $data['current_controller'] = (!empty($staff_section[0]['controller']))? $staff_section[0]['controller']:'';



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

     public function despatch_out_combine()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

              $date = $this->input->post('date');
              $month = $this->input->post('month');
              $status = $this->input->post('status');
              $search = $this->input->post('search');
              $this->session->set_userdata('despatch','Despout');
              $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_combine_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();
              $this->session->set_userdata('service_type',$this->input->get('Ask_for'));

              if ($search == "search") {
                 //$data['list'] = $this->unregistered_model->get_despatch_out_search($date,$month,$status);

                  $emslists = array();

               $Mail= $this->unregistered_model->get_despatch_out_combine_search($date,$month,$status);
                 foreach ($Mail as $key => $value) {

                  $emslists[] = $this->Despatch_ViewModel->view_data($value->datetime,$value->desp_no, $value->origin_region, $value->branch_origin, $value->region_to,
                    $value->branch_to, $value->despatch_status,$value->item_number, $value->desp_id,$value->service_type, 'MAIL');
                }

                $EMS= $this->Box_Application_model->get_despatch_out_combine_ems_search($date,$month,$status);
                 foreach ($EMS as $key => $value) {

                  $emslists[] = $this->Despatch_ViewModel->view_data($value->datetime,$value->desp_no, $value->region_from, $value->branch_from, $value->region_to,
                    $value->branch_to, $value->despatch_status,$value->item_number, $value->desp_id,$value->service_type, 'EMS');
                }
                $data['list'] = $emslists;



              } else {
                 //$data['list'] = $this->unregistered_model->get_despatch_list();

                 $emslists = array();

                 $Mail= $this->unregistered_model->get_combine_despatch_out_list();
                 foreach ($Mail as $key => $value) {

                  $emslists[] = $this->Despatch_ViewModel->view_data($value->datetime,$value->desp_no, $value->origin_region, $value->branch_origin, $value->region_to,
                    $value->branch_to, $value->despatch_status,$value->item_number, $value->desp_id,$value->service_type, 'MAIL');
                }

                $EMS= $this->Box_Application_model->get_combine_despatch_out_ems_list();
                 foreach ($EMS as $key => $value) {

                  $emslists[] = $this->Despatch_ViewModel->view_data($value->datetime,$value->desp_no, $value->region_from, $value->branch_from, $value->region_to,
                    $value->branch_to, $value->despatch_status,$value->item_number, $value->desp_id,$value->service_type, 'EMS');
                }
                $data['list'] = $emslists;

              }
              
              $this->load->view('inlandMails/despatch_out_combine',$data);

        }else{
                redirect(base_url());
            }
    }

    public function Mail_list_delivery_bills_despatched()
{
if ($this->session->userdata('user_login_access') != false)
{
   //$type  = $this->session->userdata('service_type');
   $type  = 'MAIL';
   $despno = base64_decode($this->input->get('despno'));
                 // $type = $this->input->get('type');
              //$despno = $this->input->get('despno'); 
              $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();

$data['itemlist'] = $this->unregistered_model->take_Mail_bags_desp_list($type,$despno);
$data['itemdata'] = $this->unregistered_model->take_Mail_bags_desp_listtwo($type,$despno);

$this->load->view('inlandMails/delivery_mail_bills_despatched_list',@$data);
}
else{
redirect(base_url());
}
}

 public function Combine_list_delivery_bills_despatched()
{
if ($this->session->userdata('user_login_access') != false) 
{
   //$type  = $this->session->userdata('service_type');
   $type  = 'MAIL';
   $despno = base64_decode($this->input->get('despno'));
                 // $type = $this->input->get('type');
              //$despno = $this->input->get('despno'); 
              $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();


                     $emslists = array();
                $mail= $this->unregistered_model->get_combine_bags_list_by_despatch_out($despno);
                 foreach ($mail as $key => $value) {

                  $emslists[] = $this->Bags_ViewModel->view_data($value->date_created,$value->bag_number, $value->bag_origin_region, $value->bag_branch_origin, $value->bag_region_to,
                    $value->bag_branch_to, $value->bag_weight,$value->item_number, $value->bags_status,$value->bag_id,$value->service_category, 'MAIL');
                }

                 $ems = $this->Box_Application_model->get_ems_bags_list_by_despatch_out($despno);
                 foreach ($ems as $key => $value) {

                  $emslists[] = $this->Bags_ViewModel->view_data($value->date_created,$value->bag_number, $value->bag_region_from, $value->bag_branch_from, $value->bag_region,
               $value->bag_branch, $value->bag_weight,$value->item_number, $value->bags_status,$value->bag_id, $value->ems_category, 'EMS');
                }

                $data['itemlist'] =$emslists;


                //$data['itemdata'] =$emslists2;


// $data['itemlist'] = $this->unregistered_model->take_Mail_bags_desp_list($type,$despno);
$data['itemdata'] = $this->unregistered_model->get_despatch_by_despNo($despno);

$this->load->view('inlandMails/Combine_list_delivery_bills_despatched',@$data);
}
else{
redirect(base_url());
}
}

public function despatch_in(){
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

           $emid = $this->session->userdata('user_emid');
           $check = $this->input->post('I');
           $receive = $this->input->post('receive');
            $date = $this->input->post('date');
              $month = $this->input->post('month');
              $status = $this->input->post('status');
              $search = $this->input->post('search');
              $this->session->set_userdata('despatch','Despin');

               $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();


               $staff_section = $this->employee_model->getEmpDepartmentSections($emid);
            
            $data['current_section'] = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'';

            $data['current_controller'] = (!empty($staff_section[0]['controller']))? $staff_section[0]['controller']:'';



              $this->session->set_userdata('service_type',$this->input->get('Ask_for'));             

              if ($search == "search") {
                 //$data['list'] = $this->unregistered_model->get_despatch_in_search($date,$month,$status); 

                 $data['list'] = $this->unregistered_model->get_despatch_bytype_search($date,$month,$status);
              } else {

                 if (!empty($check)) {

                for ($i=0; $i <@sizeof($check) ; $i++) {
                    $desp_id = $check[$i];

                         $updes = array();
                         $updes = array('despatch_status'=>'Received','received_by'=>$emid);
                         $this->unregistered_model->update_despatch_info_byID($updes,$desp_id);
                   
                         $listbags = $this->unregistered_model->get_Mail_bags_desp_list($desp_id);

                         foreach ($listbags as $key => $value) {
                           # code...
                          $id =$value->bag_id;

                           $update1 = array();
                            $update1 = array('bags_status'=>'isReceived','bag_received_by'=>$emid);
                            $this->unregistered_model->update_bags_info($update1,$id);


                            //update content za bags
                            $listitems = $this->unregistered_model->get_list_of_all_bags($id);
                              foreach ($listitems as $value) {

                                $last_id = $value->senderp_id;
                                $update2 = array();
                                $update2 = array('sender_status'=>'Back',);
                                $this->unregistered_model->update_sender_info($last_id,$update2);
                              }


                         }

                    
                }

                $data['message'] = "Item Received";
                } else {
                    $data['errormessage'] = "Please Select Atleast One Item To Receive";
                }
                 $data['list'] = $this->unregistered_model->get_despatch_in_list();
              }
              
              $this->load->view('inlandMails/despatch_in',$data);

        }else{
                redirect(base_url());
            }
    }

     /*public function despatch_in(){
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

           $emid = $this->session->userdata('user_emid');
           $check = $this->input->post('I');
           $receive = $this->input->post('receive');
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

                 if (!empty($check)) {

                for ($i=0; $i <@sizeof($check) ; $i++) {
                    $desp_id = $check[$i];



                         $updes = array();
                         $updes = array('despatch_status'=>'Received','received_by'=>$emid);
                         $this->unregistered_model->update_despatch_info_byID($updes,$desp_id);
                   
                         $listbags = $this->unregistered_model->get_Mail_bags_desp_list($desp_id);

                         foreach ($listbags as $key => $value) {
                           # code...
                          $id =$value->bag_id;

                           $update1 = array();
                            $update1 = array('bags_status'=>'isReceived','bag_received_by'=>$emid);
                            $this->unregistered_model->update_bags_info($update1,$id);


                            //update content za bags
                            $listitems = $this->unregistered_model->get_list_of_all_bags($id);
                              foreach ($listitems as $value) {

                                $last_id = $value->senderp_id;
                                $update2 = array();
                                $update2 = array('sender_status'=>'Back',);
                                $this->unregistered_model->update_sender_info($last_id,$update2);
                              }


                         }

                    
                }

                $data['message'] = "Item Received";
                } else {
                    $data['errormessage'] = "Please Select Atleast One Item To Receive";
                }
                 $data['list'] = $this->unregistered_model->get_despatch_in_list();
              }
              
              $this->load->view('inlandMails/despatch_in',$data);

        }else{
                redirect(base_url());
            }
    }*/


    public function receiveBags(){
    if ($this->session->userdata('user_login_access') != false){
        $type  = 'MAILS';
        $despno = $this->input->post('despno');
        $despatchid = $this->input->post('despatchid');
        $emid = $this->session->userdata('user_emid');

        //update the despatch list
        $updes = array('despatch_status'=>'Received','received_by'=>$emid);
        $this->unregistered_model->update_despatch_info_byID($updes,$despatchid);

        //getting bag list from the despatch
        $itemList = $this->unregistered_model->get_bags_list_by_despatch($despno);
        
        echo "<table id='fromServer1' class='display nowrap table table-bordered fromServer2 receiveTable' cellspacing='0' width='100%'>
                <thead>
                <tr><th colspan='6'>Receive Bag(s)  for dispatch - ".$despno."</th></tr>
                <tr>
                    <th>Bag Number</th>
                    <th>Bag Source</th>
                    <th>Bag Destination</th>
                    <th>Date Bag Created</th>
                    <th>Total Item Number</th>
                    <th>Bag Received By</th>
                  </tr>
            </thead>
            <tbody class=''>";
            $count = 0;

            foreach ($itemList as $key => $value) {
                $count++;
                $bagsId = $value->bag_id;
                $bagsNo = $value->bag_number;

                $updatebag = array('bags_status'=>'isReceived','bag_received_by'=>$emid);
                $this->unregistered_model->update_bags_info($updatebag,$bagsId);

                //$totalBag = $this->Box_Application_model->count_bags_desp_list($bagsNo);

                echo "<tr class='receiveRow'>
                        <td>
                        <button class='btn btn-warning' 
                        data-bagid='$bagsId'
                        data-bagno='$bagsNo' 
                        data-despno='$despno' 
                        onclick='receiveBagItems(this)'>".$value->bag_number."</button></td>
                        <td>".$value->bag_origin_region."</td>
                        <td>".$value->bag_branch_origin."</td>
                        <td>".$value->date_created."</td>
                        <td>".$value->item_number."</td>
                        <td>".$value->bag_received_by."</td>
                    </tr>";
            }

            echo "</tbody></table>
            <table class='table' style='width: 100%;'><tr><td style='float: right;'>
            <div class='statusText'></div></td></tr></table>";

    }else{
        redirect(base_url());
    }
}


public function receiveBagItems(){
    if ($this->session->userdata('user_login_access') != false){
        $emid = $this->session->userdata('user_emid');
        //receive despatch number from the view
        $despatchNo = $this->input->post('despatchno');
        //receive bagNo number from the view
        $bagno = $this->input->post('bagno');
        $bagsId = $this->input->post('bagid');

         //user information
        $basicinfo = $this->employee_model->GetBasic($emid);
        $region = $basicinfo->em_region;
        $em_branch = $basicinfo->em_branch;

        //update_bag_status
        $updateDataBag = array('bag_isopen'=>1,'bag_openby'=>$emid);
        $this->unregistered_model->update_bags_info($updateDataBag,$bagsId);

        //update the bag status ->backoffice
        /*$this->Box_Application_model->update_list($bagno,
            array(
                'office_name'=>'InWard receive',
                'created_by' => $emid
            ));*/

        //retrieve the bag item from the list
        //$listItem = $this->Box_Application_model->get_item_from_bags_list($bagno);

        $listItem = $this->unregistered_model->get_register_bag_items_by_bagno($bagno);

        //process of getting despatch items
        //method='POST' action='receive_action' enctype='multipart/form-data'
        echo "<table id='fromServer1' class='display nowrap table table-bordered fromServer2 receiveTable' cellspacing='0' width='100%'>
                <thead>
                <tr>
                <th colspan='6'>Receive Bag (".$bagno.") Item (s)  for dispatch - ".$despatchNo."</th>
                    <th>
                       <div class='input-group'>
                          <input id='edValue' type='text' class='form-control edValue' onInput='edValueKeyPress();' onChange='edValueKeyPress();'>
                          <br /><br /></div>
                          <div class='input-group'>
                           <span id='lblValue' class='lblValue'>Barcode scan: </span><br /></div>
                           <div class='input-group'>
                           <span id='results' class='results' style='color: red;'></span>
                      </div>
                    </th>
                </tr>

                <tr>
                    <th>S/No</th>
                    <th>Date registered</th>
                    <th>Branch Origin</th>
                    <th>Destination Origin</th>
                    <th>Barcode Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class=''>";
            $count = 0;
            foreach ($listItem as $key => $value) {
                $count++;

                    $statusItem = 'InWard receive';
                // if ($value->office_name == 'InWard receive'){
                //     $statusItem = 'InWard receive';
                // }else if ($value->office_name == 'Back'){
                //     $statusItem = 'BackOffice';
                // }else if($value->office_name == 'Received'){
                //     $statusItem = 'Successfull Received';
                // }

                    //for tracing
                    $trace_data = array(
                    'emid'=>$emid,
                    'transid'=>$value->t_id,
                    'office_name'=>'InWard',
                    'trans_type'=>'mails',
                    'description'=>'Received sorting Facility '.$em_branch,
                    'status'=>'BAG receive');

                    $this->Box_Application_model->tracing($trace_data);

                    //for track
                    $track_data = array(
                    'emid'=>$emid,
                    'transid'=>$value->t_id,
                    'office_name'=>'InWard',
                    'trans_type'=>'mails',
                    'description'=>'Sorting Facility '.$em_branch,
                    'type'=>1,
                    'status'=>'Sorting Facility');

                    $this->Box_Application_model->tracing($track_data);

                echo "<tr class='receiveRow'>
                        <td>".$count."</td>
                        <td>".$value->sender_date_created."</td>
                        <td>".$value->sender_region."</td>
                        <td>".$value->sender_branch."</td>
                        <td>".$value->Barcode."</td>
                        <td>".$statusItem."</td>
                        <td>
                            <div class='form-check' style='padding-left: 53px;float:left'>
                            <input type='checkbox' name='I' class='form-check-input checkSingle ".$value->Barcode."' id='remember-me".$key."' value='".$value->t_id."'></div>
                            <div style='cursor: pointer;float:right' class='badge' data-itemid='".$value->t_id."' onclick='enquaryItem(this)'>Equary</div>
                        </td>
                    </tr>";
            }

            echo "</tbody></table>";
            echo "<table class='table' style='width: 100%;'>
                <tbody>
                <tr><td style='float: right;'>
                <div class='statusText'></div></td></tr>
                <tr><td colspan='11'></td><td style='float: right;'>
                <button data-despno=".$despatchNo." onclick='return formSubmit(this);' class='btn btn-success'>Receive</button>
                    </td></tr></tbody></table>";
    }

}


public function receive_action(){
    $select = $this->input->post('selected');
    $despatchno = $this->input->post('despatchno');
    $Barcode = $this->input->post('barcode');

    if ($this->session->userdata('user_login_access') != false){

        $emid = $this->session->userdata('user_emid');
        $getInfo = $this->employee_model->GetBasic($emid);
        $o_region = $getInfo->em_region;
        $o_branch = $getInfo->em_branch;

         //get the pending bags which does not open
        $pendingBag = $this->unregistered_model->take_mails_bags_desp_not_received($despatchno);

        //getting user or staff department section
        $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

        $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';

        if (!empty($select)) {
            //explode the array by comma the loop throught
            $selectArray  = explode(',',$select);

             $update2 = array(
            'item_received_by'=>$emid,
            'office_name'=>$office_trance_name,
            'created_by'=>$emid);

            foreach ($selectArray as $key => $tid) {
                //for tracing
                $trace_data = array(
                'emid'=>$emid,
                'trans_type'=>'mails',
                'transid'=>$tid,
                'office_name'=>$office_trance_name,
                //'description'=>'Acceptance',
                'status'=>'IN');

                //for trace data
                $this->Box_Application_model->tracing($trace_data);

                $this->unregistered_model->update_transactions_by_Barcode($update2,$tid);
            }

            // <th>Total Item Number</th>
            echo "<table id='fromServer1' class='display nowrap table table-bordered fromServer2 receiveTable' cellspacing='0' width='100%'>
                    <thead>
                    <tr>
                        <th>Bag Number</th>
                        <th>Bag Source</th>
                        <th>Bag Destination</th>
                        <th>Date Bag Created</th>
                        <th>Bag Received By</th>
                      </tr>
                </thead>
                <tbody class=''>";

            if($pendingBag){

                $count = 0;

                foreach ($pendingBag as $key => $value) {
                    $count++;
                    $bagsId = $value->bag_id;
                    $bagsNo = $value->bag_number;

                    $updatebag = array('bags_status'=>'isReceived','bag_received_by'=>$emid);
                    $this->unregistered_model->update_bags_info($updatebag,$bagsId);


                    echo "<tr class='receiveRow'>
                            <td>
                            <button class='btn btn-warning' 
                            data-bagid='$bagsId'
                            data-bagno='$bagsNo' 
                            data-despno='$despatchno' 
                            onclick='receiveBagItems(this)'>".$value->bag_number."</button></td>
                            <td>".$value->bag_region_from."</td>
                            <td>".$value->bag_region."</td>
                            <td>".$value->date_created."</td>
                            <td>".$value->bag_received_by."</td>
                        </tr>";
                }
                //<td>".$totalBag."</td>  
            }else{

                echo "<tr><td colspan='6'><h4 style='color: blue;'>No pending bag (s) for dispatch - ".$despatchno."</h4></td></tr>";
            }

            echo "</tbody></table>
                <table class='table' style='width: 100%;'><tr><td style='float: right;'>
                <div class='statusText'></div></td></tr></table>";

        }else{
            echo "Please Select Atleast One Box";
        }

    }else{
        redirect(base_url());
    }
}



     public function despatch_in_combine(){
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

           $emid = $this->session->userdata('user_emid');
           $check = $this->input->post('I');
           $receive = $this->input->post('receive');
            $date = $this->input->post('date');
              $month = $this->input->post('month');
              $status = $this->input->post('status');
              $search = $this->input->post('search');
              $this->session->set_userdata('despatch','Despin');

               $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_combine_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_combine_despatch_in();

              // $data['bags'] = $this->Box_Application_model->count_bags();
              // $data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
              // $data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
              //$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
              //$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();

              $this->session->set_userdata('service_type',$this->input->get('Ask_for'));             

              if ($search == "search") {
            //     ($datetime,$desp_no, $region_from, $branch_from, $region_to,
            // $branch_to, $despatch_status,$item_number, $desp_id,$service_category, $type)
                 
                 $emslists = array();

               $Mail= $this->unregistered_model->get_despatch_in_combine_search($date,$month,$status);
                 foreach ($Mail as $key => $value) {

                  $emslists[] = $this->Despatch_ViewModel->view_data($value->datetime,$value->desp_no, $value->origin_region, $value->branch_origin, $value->region_to,
                    $value->branch_to, $value->despatch_status,$value->item_number, $value->desp_id,$value->service_type, 'MAIL');
                }

                $EMS= $this->Box_Application_model->get_despatch_in_combine_ems_search($date,$month,$status);
                 foreach ($EMS as $key => $value) {

                  $emslists[] = $this->Despatch_ViewModel->view_data($value->datetime,$value->desp_no, $value->region_from, $value->branch_from, $value->region_to,
                    $value->branch_to, $value->despatch_status,$value->item_number, $value->desp_id,$value->service_type, 'EMS');
                }
                $data['list'] = $emslists;


              } else {

                 if (!empty($check)) {

                for ($i=0; $i <@sizeof($check) ; $i++) {
                    //$desp_id = $check[$i];
                     $m = explode('-', $check[$i]);

                     $desp_id = @$m[0];
                         $cate = @$m[1];
                       
                       if($cate=='EMS'){

                        $update = array();
                        $update = array('despatch_status'=>'Received','received_by'=>$emid);
                        $this->Box_Application_model->update_despatch_list_byId($desp_id,$update);

                        $listbags = $this->Box_Application_model->get_ems_bags_desp_list($desp_id);
                        foreach ($listbags as $key => $value) {
                           # code...
                          $id =$value->bag_id;

                          $update1 = array();
                        $update1 = array('bags_status'=>'isReceived','bag_received_by'=>$emid);
                        $this->Box_Application_model->update_bags_list($id,$update1);

                        $bag_number = $value->bag_number;
                        $getBagNoitemlist = $this->Box_Application_model->get_bag_itemlist($bag_number);
                        foreach ($getBagNoitemlist as $value) {

                            //$ids = $value->bag_number;
                            $update2 = array();
                            $update2 = array('office_name'=>'Back');
                            $this->Box_Application_model->update_list($bag_number,$update2);
                        }
                    }


                      

                        
                                                 

                       }else{

                         $updes = array();
                         $updes = array('despatch_status'=>'Received','received_by'=>$emid);
                         $this->unregistered_model->update_despatch_info_byID($updes,$desp_id);
                   
                         $listbags = $this->unregistered_model->get_Mail_bags_desp_list($desp_id);

                         foreach ($listbags as $key => $value) {
                           # code...
                          $id =$value->bag_id;

                           $update1 = array();
                            $update1 = array('bags_status'=>'isReceived','bag_received_by'=>$emid);
                            $this->unregistered_model->update_bags_info($update1,$id);


                            //update content za bags
                            $listitems = $this->unregistered_model->get_list_of_all_bags($id);
                              foreach ($listitems as $value) {

                                $last_id = $value->senderp_id;
                                $update2 = array();
                                $update2 = array('sender_status'=>'Back',);
                                $this->unregistered_model->update_sender_info($last_id,$update2);
                              }


                         }
                       }



                        

                    
                }

                $data['message'] = "Item Received";
                } else {
                    $data['errormessage'] = "Please Select Atleast One Item To Receive";
                }
                

                  $emslists = array();

                 $Mail= $this->unregistered_model->get_combine_despatch_in_list();
                 foreach ($Mail as $key => $value) {

                  $emslists[] = $this->Despatch_ViewModel->view_data($value->datetime,$value->desp_no, $value->origin_region, $value->branch_origin, $value->region_to,
                    $value->branch_to, $value->despatch_status,$value->item_number, $value->desp_id,$value->service_type, 'MAIL');
                }

                $EMS= $this->Box_Application_model->get_combine_despatch_in_ems_list();
                 foreach ($EMS as $key => $value) {

                  $emslists[] = $this->Despatch_ViewModel->view_data($value->datetime,$value->desp_no, $value->region_from, $value->branch_from, $value->region_to,
                    $value->branch_to, $value->despatch_status,$value->item_number, $value->desp_id,$value->service_type, 'EMS');
                }
                $data['list'] = $emslists;


              }
              
              $this->load->view('inlandMails/despatch_in_combine',$data);

        }else{
                redirect(base_url());
            }
    }

    public function getdespatchnumber(){

        $getuniquelastnumber= $this->Box_Application_model->get_last_despatchnumber();

            //check length
            if(empty($getuniquelastnumber) || is_null($getuniquelastnumber)){
                $number = 1;
                 $nmbur = array();
                 $nmbur = array('number'=>$number);

                 $db2 = $this->load->database('otherdb', TRUE);
                 $db2->insert('despatchnumber',$nmbur);
               
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
                 $db2->insert('despatchnumber',$nmbur);
               

            }

            return $number;
    }

     public function getdespatchnumber_branch($branch){

        $getuniquelastnumber= $this->Box_Application_model->get_last_despatchnumber_branch($branch);

            //check length
            if(empty($getuniquelastnumber) || is_null($getuniquelastnumber)){
                $number = 1;
                 $nmbur = array();
                 $nmbur = array('number'=>$number,'branch'=>$branch);

                 $db2 = $this->load->database('otherdb', TRUE);
                 $db2->insert('despatchnumber',$nmbur);
               
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
                 $nmbur = array('number'=>$numbers,'branch'=>$branch);
                 $db2 = $this->load->database('otherdb', TRUE);
                 $db2->insert('despatchnumber',$nmbur);
               

            }

            return $number;
    }


  public function getbagnumber_branch($branch){

        $getuniquelastnumber= $this->Box_Application_model->get_last_bagnumber_branch($branch);

            //check length
            if(empty($getuniquelastnumber) || is_null($getuniquelastnumber)){
                $number = 1;
                 $nmbur = array();
                 $nmbur = array('number'=>$number,'branch'=>$branch);

                 $db2 = $this->load->database('otherdb', TRUE);
                 $db2->insert('bagnumber',$nmbur);
               
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
                 $nmbur = array('number'=>$numbers,'branch'=>$branch);
                 $db2 = $this->load->database('otherdb', TRUE);
                 $db2->insert('bagnumber',$nmbur);
               

            }

            return $number;
    }

    public function getbagnumber(){

        $getuniquelastnumber= $this->Box_Application_model->get_last_bagnumber();

            //check length
            if(empty($getuniquelastnumber) || is_null($getuniquelastnumber)){
                $number = 1;
                 $nmbur = array();
                 $nmbur = array('number'=>$number);

                 $db2 = $this->load->database('otherdb', TRUE);
                 $db2->insert('bagnumber',$nmbur);
               
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
                 $db2->insert('bagnumber',$nmbur);
               

            }

            return $number;
    }

    /*public function total_numbers_of_bags()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

              $search    = $this->input->post('search');
              $despatch  = $this->input->post('despatch');
              $check     = $this->input->post('I');

               $type    = $this->input->post('type');


              $sender_region = $this->session->userdata('user_region');
              $sender_branch = $this->session->userdata('user_branch');
              $emid = $this->session->userdata('user_login_id');

              $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();
              $data['recieved'] = $this->unregistered_model->count_item_received();

               $this->session->set_userdata('Ask_for',$this->input->get('Ask_for')); 

              $service_type = $this->input->get('Ask_for');


                                $emid=   $this->session->userdata('user_login_id');
                        $getInfo = $this->employee_model->GetBasic($emid);
                    $users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
                     //$loc = $getInfo->em_region.' - '.$getInfo->em_branch;
                             $loc =' - '.$getInfo->em_branch;

              if ($search == "search"){

                echo $date = $this->input->post('date');
                $month = $this->input->post('month');
                $status = $this->input->post('status');

                $data['list'] = $this->unregistered_model->get_number_of_bags_search($date,$month,$status);


              }elseif($despatch){

                if($type=="combine")
                {
                    //update bags
                     if (empty($check)) {
                  $data['errormessage'] = "Please Select Atleast One Bag ";
                   } else {

                     for ($i=0; $i <sizeof($check) ; $i++) { 
                       $id = $check[$i];

                    $update = array();
                    $update = array('type'=>'Combine');

                    $this->unregistered_model->update_bags_info($update,$id);
                  }

                $data['message'] = "Successfull Bags Sent in combine";
                $data['list'] = $this->unregistered_model->get_number_of_bags();

                 }


                }else{                

                if (empty($check)) {
                  $data['errormessage'] = "Please Select Atleast One Bag To Despatch";
                } else {
                
                //$id = $check[0];
                  $transt = $this->input->post('transport_type');
                  $transname = $this->input->post('transport_name');
                  $regno = $this->input->post('reg_no');
                  $rec_region = $this->input->post('region');
                  $branch_to = $this->input->post('district');
                  $transcost = $this->input->post('transport_cost');
                  $bagregfrom = $this->session->userdata('user_region');
                   $Seal     = $this->input->post('Seal');
                    $remarks    = @$this->input->post('remarks');

                     $remarkslist    = @$this->input->post('fn');
                      $desc    = @$this->input->post('ln');

                  $bagreg     = $this->input->post('region');
                  $id = $this->session->userdata('user_login_id');
                  $info = $this->Box_Application_model->GetBasic($id);
                  $o_region = $info->em_region;
                  $o_branch = $info->em_branch;

                // $transt = $this->input->post('transtype');
                // $transname = $this->input->post('transname');
                // $regno = $this->input->post('regno');
                // $transcost = $this->input->post('transcost');
                // $region = $this->input->post('region');
                // $district = $this->input->post('district');
                   $bagregfrom = $this->session->userdata('user_region');

                //check in despatch number by date and region destionation

                 $remarks='';
                 if(!empty($remarkslist)){


                   for ($i=0; $i <sizeof(@$remarkslist) ; $i++) { 
                       $list = $remarkslist[$i];
                       $txt = $desc[$i];
                       $remarks    =$remarks.$list.' - '.$txt.', ';
                   }

                    }
               
                //$get = $this->unregistered_model->get_bag_destination_region($id);
                // $rec_region = $get->bag_region_to;
                // $branch_to  = $get->bag_branch_to;
                $source = $this->employee_model->get_code_source($o_region);
                $dest = $this->employee_model->get_code_dest($rec_region);

                $year = date("y");


                //$number = $this->getdespatchnumber();
                 $number = $this->getdespatchnumber_branch($o_branch);

              //$desno = 'Despatch-'.@$source->reg_code . @$dest->reg_code.$year.$number.'TZ';

                //$number = rand(100000,200000);

              if($service_type =='Register'){  $desp_no = 'DESPATCH-REGISTER-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
                elseif ($service_type =='Parcels-Post') { $desp_no = 'DESPATCH-PARCEL-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
                elseif ($service_type =='Small-Packets') {  $desp_no = 'DESPATCH-PACKETS-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
              elseif ($service_type =='Posts-Cargo') { $desp_no = 'DESPATCH-CARGO-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
              elseif ($service_type =='Private-Bag') { $desp_no = 'DESPATCH-PRIVATE-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
              elseif ($service_type =='Foreign-Parcel') { $desp_no = 'DESPATCH-FOREIGN-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; }
              else{
                $desp_no = 'DESPATCH-REGISTER-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; 
              }

               // $desp_no = 'REGISTER'.$source->reg_code . $dest->reg_code . $number;

                //check in despatch number by date and region destionation
                //$angalia = $this->unregistered_model->get_despatch_number_by_date($rec_region,$branch_to);
                
                
                  
                    $love = array();
                    $love = array(
                      'desp_no'=>$desp_no,
                      'origin_region'=>$o_region,
                      'branch_origin'=>$o_branch,
                      'region_to'=>$rec_region,
                      'branch_to'=>$branch_to,
                      'transport_type'=>$transt,
                      'transport_name'=>$transname,
                      'registration_number'=>$regno,
                      'transport_cost'=>$transcost,
                      'despatch_status'=>'Sent',
                      'despatch_by'=>$emid,
                      'service_type'=>$service_type,
                       'remarks'=>$remarks,
                      'Seal'=>$Seal
                    );

                    $this->unregistered_model->save_despatch_number($love);
                     for ($i=0; $i <sizeof($check) ; $i++) { 
                       $id = $check[$i];

                       $checkRegion = $this->unregistered_model->get_bag_mail_bag($id);

                    $update = array();
                    $update = array('despatch_no'=>$desp_no,'bags_status'=>'isDespatch');

                    $this->unregistered_model->update_bags_info($update,$id);


                  $senderinfo = $this->unregistered_model->get_list_of_all_bags($id);

                      foreach ($senderinfo as $key => $value) {  //sasa
                               $track_number=$value->track_number;
                                //$Barcode=@$value->Barcode;

                            $event = "Despatch Facility";
                            $location ='On Transit From '.$loc;
                            $data = array();
                             $data = array('track_no'=>@$track_number,'location'=>$location,'user'=>@$users,'event'=>$event);

                             $this->Box_Application_model->save_location($data);

                              $smobile =@$value->sender_mobile;
                              $rmobile =@$value->receiver_mobile;
                             $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$track_number. ' umesafirishwa '.'kutoka '.$getInfo->em_region.' - '.$getInfo->em_branch;
                             $this->Sms_model->send_sms_trick($smobile,$stotal);
                                   $this->Sms_model->send_sms_trick($rmobile,$stotal);
                               }


                  }

                $data['message'] = "Successfull Bags Despatch";
                $data['list'] = $this->unregistered_model->get_number_of_bags();

              
              }
             }
            }
            else{
               $data['list'] = $this->unregistered_model->get_number_of_bags();

            }
            $this->load->view('inlandMails/total_numbers_of_bags',$data);

        }else{
                redirect(base_url());
            }
    }*/


    public function total_numbers_of_bags(){
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

              $search    = $this->input->post('search');
              $despatch  = $this->input->post('despatch');
              $check     = $this->input->post('I');

               $type    = $this->input->post('type');

              $sender_region = $this->session->userdata('user_region');
              $sender_branch = $this->session->userdata('user_branch');
              $emid = $this->session->userdata('user_login_id');

              $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();
              $data['recieved'] = $this->unregistered_model->count_item_received();


              $staff_section = $this->employee_model->getEmpDepartmentSections($emid);
            $data['current_section'] = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'';
            $data['current_controller'] = (!empty($staff_section[0]['controller']))? $staff_section[0]['controller']:'';

              $service_type = $this->input->get('Ask_for');

              if ($search == "search"){

                $date = $this->input->post('date');
                $month = $this->input->post('month');
                $status = $this->input->post('status');

                $data['list'] = $this->unregistered_model->get_number_of_bags_search($date,$month,$status);
                //$data['list'] = $this->unregistered_model->get_bag_lists_search($date,$month,$status);

              }elseif($despatch){

                if($type=="combine"){
                    //update bags
                     if (empty($check)) {
                            $data['errormessage'] = "Please Select Atleast One Bag ";
                       } else {

                         for ($i=0; $i <sizeof($check) ; $i++) { 
                           $id = $check[$i];

                            $update = array();
                            $update = array('type'=>'Combine');

                            $this->unregistered_model->update_bags_info($update,$id);
                      }

                        $data['message'] = "Successfull Bags Sent in combine";
                        $data['list'] = $this->unregistered_model->get_number_of_bags();
                    }

                }else{                

                if (empty($check)) {

                  $data['errormessage'] = "Please Select Atleast One Bag To Despatch";

                } else {
                
                //$id = $check[0];
                  $transt = $this->input->post('transport_type');
                  $transname = $this->input->post('transport_name');
                  $regno = $this->input->post('reg_no');
                  $rec_region = $this->input->post('region');
                  $branch_to = $this->input->post('district');
                  $transcost = $this->input->post('transport_cost');
                  $bagregfrom = $this->session->userdata('user_region');
                  $Seal     = $this->input->post('Seal');
                  $Weight     = $this->input->post('Weight');
                  //$remarks    = @$this->input->post('remarks');
                  $remarkslist    = @$this->input->post('fn');
                  $desc    = @$this->input->post('ln');
                  $bagreg     = $this->input->post('region');

                  //sender details
                  $id = $this->session->userdata('user_login_id');
                  $info = $this->Box_Application_model->GetBasic($id);
                  $o_region = $info->em_region;
                  $o_branch = $info->em_branch;
                  $bagregfrom = $this->session->userdata('user_region');

                //check in despatch number by date and region destionation
                  $remarks='';
                  if ($remarkslist) {
                       for ($i=0; $i <sizeof($remarkslist) ; $i++) { 
                           $list = $remarkslist[$i];
                           $txt = $desc[$i];
                           $remarks    =$remarks.$list.' - '.$txt.', ';
                       }
                  }

                $despno_number = $this->unregistered_model->createDespatchNumber($o_branch,$branch_to);

                    $love = array(
                      'desp_no'=>$despno_number['num'],
                      'dc'=>$despno_number['dc'],
                      'origin_region'=>$o_region,
                      'branch_origin'=>$o_branch,
                      'region_to'=>$rec_region,
                      'branch_to'=>$branch_to,
                      'transport_type'=>$transt,
                      'transport_name'=>$transname,
                      'registration_number'=>$regno,
                      'transport_cost'=>$transcost,
                      'despatch_status'=>'Sent',
                      'despatch_by'=>$emid,
                      'service_type'=>$service_type,
                      'Seal'=>$Seal,
                      'weight'=>$Weight
                    );

                    if ($remarks) {
                        $love['remarks'] = $remarks;
                        $remarkData = $remarks;
                    }else{
                        $remarkData = 'Nill';
                    }

                    $this->unregistered_model->save_despatch_number($love);

                     for ($i=0; $i <sizeof($check) ; $i++) { 
                       $id = $check[$i];
                       $checkRegion = $this->unregistered_model->get_bag_mail_bag($id);
                        $update = array(
                            'remarks'=>$remarkData,
                            'bag_weight'=>$Weight,
                            'despatch_no'=>$despno_number['num'],
                            'bags_status'=>'isDespatch');

                        $this->unregistered_model->update_bags_info($update,$id);

                        //----item list
                        $mail_itemlist = $this->unregistered_model->getBagItemListBybagNumber($checkRegion->bag_number);

                        foreach ($mail_itemlist as $key => $item) {
                            
                            //for tracing
                            $trace_data = array(
                            'emid'=>$emid,
                            'transid'=>$item['t_id'],
                            'office_name'=>'Despatch',
                            'trans_type'=>'mails',
                            'description'=>'On transit from '.$sender_branch,
                            'status'=>'BAG Closed');

                            $this->Box_Application_model->tracing($trace_data);

                            //for track
                            $track_data = array(
                            'emid'=>$emid,
                            'transid'=>$item['t_id'],
                            'office_name'=>'Despatch',
                            'trans_type'=>'mails',
                            'description'=>'On Transit from '.$sender_branch,
                            'type'=>1,
                            'status'=>'On Transit');
                            
                            $this->Box_Application_model->tracing($track_data);

                        }
                        
                    }

                    $data['message'] = "Successfull Bags Despatch";
                    //$data['list'] = $this->unregistered_model->get_number_of_bags();
                    $data['list'] = $this->unregistered_model->get_bag_lists();
              
              }
             }
            }else{
               $data['list'] = $this->unregistered_model->get_number_of_bags();
               //$data['list'] = $this->unregistered_model->get_bag_lists();

            }
            $this->load->view('inlandMails/total_numbers_of_bags',$data);

        }else{
                redirect(base_url());
            }
    }


     public function total_combine_bags()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

              $search    = $this->input->post('search');
              $despatch  = $this->input->post('despatch');
              $check     = $this->input->post('I');

               $category     = $this->input->post('C');

              $type    = $this->input->post('type');

              $sender_region = $this->session->userdata('user_region');
              $sender_branch = $this->session->userdata('user_branch');
              $emid = $this->session->userdata('user_login_id');

              $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_combine_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();
              // $data['recieved'] = $this->unregistered_model->count_item_received();

              // $emslists1 = array();
              //   $mail= $this->unregistered_model->count_combine_bags();
              //    foreach ($mail as $key => $value) {

              //     $emslists1[] = $this->Bags_ViewModel->view_data($value->date_created,$value->bag_number, $value->bag_origin_region, $value->bag_branch_origin, $value->bag_region_to,
              //       $value->bag_branch_to, $value->bag_weight,$value->item_number, $value->bags_status,$value->bag_id,$value->service_category, 'MAIL');
              //   }

              //    $ems = $this->Box_Application_model->get_ems_combine_bags_list();
              //    foreach ($ems as $key => $value) {

              //     $emslists1[] = $this->Bags_ViewModel->view_data($value->date_created,$value->bag_number, $value->bag_region_from, $value->bag_branch_from, $value->bag_region,
              //  $value->bag_branch, $value->bag_weight,$value->item_number, $value->bags_status,$value->bag_id, $value->ems_category, 'EMS');
              //   }

              //   $data['bags'] =$emslists1;



              $service_type = $this->input->get('Ask_for');

              if ($search == "search"){

                 $date = $this->input->post('date');
                $month = $this->input->post('month');
                $status = $this->input->post('status');

                $emslists = array();

                // date_created,$bag_number, $bag_origin_region, $bag_branch_origin, $bag_region_to,
                // $bag_branch_to, $bag_weight,$item_number, $bags_status,$bag_id,$service_category, $type

                $mail= $this->unregistered_model->get_combine_bags_search($date,$month,$status);
                 foreach ($mail as $key => $value) {

                  $emslists[] = $this->Bags_ViewModel->view_data($value->date_created,$value->bag_number, $value->bag_origin_region, $value->bag_branch_origin, $value->bag_region_to,
                    $value->bag_branch_to, $value->bag_weight,$value->item_number, $value->bags_status,$value->bag_id,$value->service_category, 'MAIL');
                }

                $ems = $this->Box_Application_model->get_combine_bags_ems_search($date,$month,$status);
                 foreach ($ems as $key => $value) {

                  $emslists[] = $this->Bags_ViewModel->view_data($value->date_created,$value->bag_number, $value->bag_region_from, $value->bag_branch_from, $value->bag_region,
               $value->bag_branch, $value->bag_weight,$value->item_number, $value->bags_status,$value->bag_id, $value->ems_category, 'EMS');
                }

                $data['list'] =$emslists;

              }elseif($despatch){

                if($type=="remove")
                {
                    //update bags
                     if (empty($check)) {
                  $data['errormessage'] = "Please Select Atleast One Bag ";
                   } else {



                     for ($i=0; $i <sizeof($check) ; $i++) { 
                         $m = explode('-', $check[$i]);
                         $id = @$m[0];
                         $cate = @$m[1];
                       // $id = $check[$i];
                       // $cate  = $category[$i];   

                       if($cate=='EMS'){
                         $update = array();
                        $update = array('type'=>'Normal');

                        $this->Box_Application_model->update_bags_info($update,$id);

                       }else{
                         $update = array();
                         $update = array('type'=>'Normal');

                        $this->unregistered_model->update_bags_info($update,$id);
                       }


                   
                  }

                $data['message'] = "Successfull Bags Removed";
                $emslists = array();
                $mail= $this->unregistered_model->get_combine_bags();
                 foreach ($mail as $key => $value) {

                  $emslists[] = $this->Bags_ViewModel->view_data($value->date_created,$value->bag_number, $value->bag_origin_region, $value->bag_branch_origin, $value->bag_region_to,
                    $value->bag_branch_to, $value->bag_weight,$value->item_number, $value->bags_status,$value->bag_id,$value->service_category, 'MAIL');
                }

                 $ems = $this->Box_Application_model->get_ems_combine_bags_list();
                 foreach ($ems as $key => $value) {

                  $emslists[] = $this->Bags_ViewModel->view_data($value->date_created,$value->bag_number, $value->bag_region_from, $value->bag_branch_from, $value->bag_region,
               $value->bag_branch, $value->bag_weight,$value->item_number, $value->bags_status,$value->bag_id, $value->ems_category, 'EMS');
                }

                $data['list'] =$emslists;

                 }


                }else{                

                if (empty($check)) {
                  $data['errormessage'] = "Please Select Atleast One Bag To Despatch";
                } else {
                
                //$id = $check[0];
                  $transt = $this->input->post('transport_type');
                  $transname = $this->input->post('transport_name');
                  $regno = $this->input->post('reg_no');
                  $rec_region = $this->input->post('region');
                  $branch_to = $this->input->post('district');
                  $transcost = $this->input->post('transport_cost');
                  $bagregfrom = $this->session->userdata('user_region');
                   $Seal     = $this->input->post('Seal');

                  $bagreg     = $this->input->post('region');
                  $id = $this->session->userdata('user_login_id');
                  $info = $this->Box_Application_model->GetBasic($id);
                  $o_region = $info->em_region;
                  $o_branch = $info->em_branch;

                // $transt = $this->input->post('transtype');
                // $transname = $this->input->post('transname');
                // $regno = $this->input->post('regno');
                // $transcost = $this->input->post('transcost');
                // $region = $this->input->post('region');
                // $district = $this->input->post('district');
                   $bagregfrom = $this->session->userdata('user_region');

                //check in despatch number by date and region destionation

               

               
                //$get = $this->unregistered_model->get_bag_destination_region($id);
                // $rec_region = $get->bag_region_to;
                // $branch_to  = $get->bag_branch_to;
                $source = $this->employee_model->get_code_source($o_region);
                $dest = $this->employee_model->get_code_dest($rec_region);

                $year = date("y");


               // $number = $this->getdespatchnumber();
                 $number = $this->getdespatchnumber_branch($o_branch);

            
                $desp_no = 'DESPATCH-COMBINE-'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ'; 
              

               // $desp_no = 'REGISTER'.$source->reg_code . $dest->reg_code . $number;

                //check in despatch number by date and region destionation
                //$angalia = $this->unregistered_model->get_despatch_number_by_date($rec_region,$branch_to);
                
                
                  
                    $love = array();
                    $love = array(
                      'desp_no'=>$desp_no,
                      'origin_region'=>$o_region,
                      'branch_origin'=>$o_branch,
                      'region_to'=>$rec_region,
                      'branch_to'=>$branch_to,
                      'transport_type'=>$transt,
                      'transport_name'=>$transname,
                      'registration_number'=>$regno,
                      'transport_cost'=>$transcost,
                      'despatch_status'=>'Sent',
                      'despatch_by'=>$emid,
                      'service_type'=>'Combine',
                      'Seal'=>$Seal
                    );

                    $this->unregistered_model->save_despatch_number($love);
                     for ($i=0; $i <sizeof($check) ; $i++) { 
                       $m = explode('-', $check[$i]);
                         $id = @$m[0];
                         $cate = @$m[1];
                       // $id = $check[$i];
                       // $cate  = $category[$i];   

                       if($cate == 'EMS'){

                         $update = array();
                            $update = array('despatch_no'=>$desp_no,'bags_status'=>'isDespatch');

                            $this->Box_Application_model->update_bags_info($update,$id);

                       }else{
                         $update = array();
                            $update = array('despatch_no'=>$desp_no,'bags_status'=>'isDespatch');

                            $this->unregistered_model->update_bags_info($update,$id);

                       }


                   
                  }

                $data['message'] = "Successfull Bags Despatch";
               $emslists = array();
                $mail= $this->unregistered_model->get_combine_bags();
                 foreach ($mail as $key => $value) {

                  $emslists[] = $this->Bags_ViewModel->view_data($value->date_created,$value->bag_number, $value->bag_origin_region, $value->bag_branch_origin, $value->bag_region_to,
                    $value->bag_branch_to, $value->bag_weight,$value->item_number, $value->bags_status,$value->bag_id,$value->service_category, 'MAIL');
                }

                 $ems = $this->Box_Application_model->get_ems_combine_bags_list();
                 foreach ($ems as $key => $value) {

                  $emslists[] = $this->Bags_ViewModel->view_data($value->date_created,$value->bag_number, $value->bag_region_from, $value->bag_branch_from, $value->bag_region,
               $value->bag_branch, $value->bag_weight,$value->item_number, $value->bags_status,$value->bag_id, $value->ems_category, 'EMS');
                }

                $data['list'] =$emslists;

              
              }
             }
            }
            else{
               $data['list'] = $this->unregistered_model->get_combine_bags();

            }
            $this->load->view('inlandMails/total_combine_bags',$data);

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

                $emid = $this->session->userdata('user_login_id');
                $info = $this->employee_model->GetBasic($emid);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
               // $location= $info->em_region.' - '.$info->em_branch;
                  $location= ' - '.$info->em_branch;
                 $results=$this->unregistered_model->get_tracknumber($last_id);


                    $love = array();//from counter or region - receive item
                    $love = array(
                      'track_no'=>$results->track_number,
                      'event'=>$info->em_role,
                      'region'=>$info->em_region,
                      'branch'=>$info->em_branch,
                      'user'=>$emid,
                      'name'=>'BackReceive',
                      'status'=>'Received',
                      'type'=>'qrscan'
                    );

                    $this->unregistered_model->save_event($love);

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

    /*public function mails_item_list_bags(){

if ($this->session->userdata('user_login_access') != false)
{
//$data['emslist'] = $this->Box_Application_model->get_ems_back_list_per_date();
//$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
//$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
 $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();

 $trn = $this->input->get('trn');

 $data['getInfo'] = $this->unregistered_model->get_mail_item_from_bags($trn);

 $data['getbags'] = $this->unregistered_model->get_mail_item_from_bagstwo($trn);
 $data['bagno'] = $trn;


$this->load->view('inlandMails/mail_item_list_bags',$data);
}
else{
redirect(base_url());
}

}*/

public function mails_item_list_bags(){

        if ($this->session->userdata('user_login_access') != false){
             $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();

             $trn = $this->input->get('trn');

             $data['getInfo'] = $this->unregistered_model->get_mail_item_from_bags($trn);

             $data['getbags'] = $this->unregistered_model->get_mail_item_from_bagstwo($trn);

             $data['bagno'] = $trn;

            $this->load->view('inlandMails/mail_item_list_bags',$data);
        }else{
            redirect(base_url());
        }

    }

 public function mails_item_list_bags_word(){

if ($this->session->userdata('user_login_access') != false)
{
//$data['emslist'] = $this->Box_Application_model->get_ems_back_list_per_date();
//$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
//$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
 // $data['ems'] = $this->unregistered_model->count_ems();
 //              $data['bags'] = $this->unregistered_model->count_bags();
 //              $data['despout'] = $this->unregistered_model->count_despatch();
 //              $data['despin'] = $this->unregistered_model->count_despatch_in();

 $trn = $this->input->get('trn');

 $data['getInfo'] = $this->unregistered_model->get_mail_item_from_bags($trn);

 $data['getbags'] = $this->unregistered_model->get_mail_item_from_bagstwo($trn);
 $data['bagno'] = $trn;


$this->load->view('inlandMails/mails_item_list_bags_word',$data);
}
else{
redirect(base_url());
}

}


public function editBarcodeprocess(){
        if ($this->session->userdata('user_login_access') != false) {
            $Barcode = $this->input->post('barcode');
            $transid = $this->input->post('transid');
            $reasonMessage = $this->input->post('reasonMessage');

           $checkdata  = $this->unregistered_model->mail_searchTransaction($transid,$Barcode,$mobile='');

            if(!empty($checkdata)) {
                $res['status'] = 'error';
                $res['message'] = 'Barcode hii '.$checkdata[0]['Barcode'].' Imeshatumika';
            }else{
                //update process
                $updateData = array('Barcode' =>$Barcode,'edit_reason_Message'=>$reasonMessage);
                $this->unregistered_model->update_old_transactions($updateData,$transid);
                 $res['status'] = 'Success';
                 $res['message'] = 'Edited Successfully'.$transid;
            }
            //response
            print_r(json_encode($res));

        }else{
            redirect(base_url());
        }
    }

public function Mail_list_delivery_bills_despatched_word()  {
if ($this->session->userdata('user_login_access') != false)
{
   //$type  = $this->session->userdata('service_type');
   $type  = 'MAIL';
   $despno = base64_decode($this->input->get('despno'));
                 // $type = $this->input->get('type');
              //$despno = $this->input->get('despno'); 
              // $data['ems'] = $this->unregistered_model->count_ems();
              // $data['bags'] = $this->unregistered_model->count_bags();
              // $data['despout'] = $this->unregistered_model->count_despatch();
              // $data['despin'] = $this->unregistered_model->count_despatch_in();

$data['itemlist'] = $this->unregistered_model->take_Mail_bags_desp_list($type,$despno);
$data['itemdata'] = $this->unregistered_model->take_Mail_bags_desp_listtwo($type,$despno);

$this->load->view('inlandMails/delivery_mail_bills_despatched_list_word',@$data);

    }
else{
redirect(base_url());
}
}



public function combine_item_list_bags(){

if ($this->session->userdata('user_login_access') != false)
{
//$data['emslist'] = $this->Box_Application_model->get_ems_back_list_per_date();
//$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
//$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
 $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();

 $trn = $this->input->get('trn');
  $m = explode('$', $trn);
                         $bagno = @$m[0];
                         $cate = @$m[1];
                       // $id = $check[$i];
                       // $cate  = $category[$i];   

                       if($cate=='EMS'){

                       $data['bagno'] = $bagno;

                         $data['getInfo'] = $this->Box_Application_model->get_item_from_bags($bagno);

                         $data['getbags'] = $this->Box_Application_model->get_item_from_bagstwo($bagno);

                         $this->load->view('inlandMails/combine_ems_item_list_bags',$data);

                       }else{

                        $data['getInfo'] = $this->unregistered_model->get_mail_item_from_bags($bagno);

                         $data['getbags'] = $this->unregistered_model->get_mail_item_from_bagstwo($bagno);
                         $data['bagno'] = $bagno;

                         $this->load->view('inlandMails/combine_item_list_bags',$data);

                       }

 



}
else{
redirect(base_url());
}

}

public function mail_item_list_bags_remove(){

if ($this->session->userdata('user_login_access') != false)
{
$data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();

 $trck =$senderp_id= $this->input->get('trck');
  $bagno = $this->input->get('bagno');
  $data['bagno'] = $bagno;

  $data['getInfo'] = $this->unregistered_model->get_mail_item_from_bags($bagno);

 $data['getbags'] =$bag= $this->unregistered_model->get_mail_item_from_bagstwo($bagno);

 $item= $this->unregistered_model->get_bag_number_mails($senderp_id);


             //UPDATE BAG WEIGHT
                      $itemweight=$item->register_weght;
                      $weights = ($bag->bag_weight * 1000) - $itemweight;
                      $weight =$weights/1000;
                        $upbag = array();
                      $upbag = array('bag_weight'=>$weight);
                      $this->unregistered_model->update_bag_info($upbag,$bagno);  


                        $trackno = array();
                      $trackno = array('sender_bag_number'=>'1','sender_status'=>'BackReceive');
                      $this->unregistered_model->update_sender_info($trck,$trackno);




 


$this->load->view('inlandMails/mail_item_list_bags_update',$data);
}
else{
redirect(base_url());
}

}



public function Receive_scanned(){

   $emid=   $this->session->userdata('user_login_id');
   $trackno = $this->input->post('identifier',TRUE);

   
    $emid=$emid;


     // $arr = array(array('emid'=>$emid,'identifier'=>$trackno));
     //                  $list["data"]=$arr; 
    
                 //    header('Content-Type: application/json');
                 //    echo json_encode($list);

     $getInfo = $this->employee_model->GetBasic($emid);
                            $users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
                           // $loc = $getInfo->em_region.' - '.$getInfo->em_branch;
                            $loc = ' - '.$getInfo->em_branch;


    if(empty($emid)){

                            $value = array();
                            $value = array('message'=>'Empty emid','status'=>'404');
                             $list["data"] = $value; 
            
                            header('Content-Type: application/json');
                            echo 'Empty emid';
       

    }else{
    $word = 'DS';
    if(strpos($trackno, $word) === false ){

        $info = $this->employee_model->GetBasic($emid);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
         // $location= $info->em_region.' - '.$info->em_branch;
                  $location= ' - '.$info->em_branch;
                   $loc= ' - '.$info->em_branch;


            $db='sender_person_info';
             $senderperson = $this->unregistered_model->get_senderperson_barcode($db,$trackno);
              
        if(!empty($senderperson))//which table
          {
             //check payment
            $senderp_id=@$senderperson->senderp_id;
            $trackno=@$senderperson->track_number;
            //$serial=@$senderperson->serial;
            
         $DB='register_transactions';
         $transactions2 = $this->unregistered_model->CheckintransactionsBYSENDERPRS($DB,$senderp_id);
         $DB='parcel_international_transactions';
         $transactions4 = $this->unregistered_model->Checkintransactions3($DB,$senderp_id);

  if( !empty($transactions2) || !empty($transactions4)){

             if(!empty($senderperson)){

            
            if($senderperson->sender_status != 'BackReceive0'){ //haijawa received?


                    $love = array();//from counter or region - receive item
                    $love = array(
                      'track_no'=>$trackno,
                      'event'=>$info->em_role,
                      'region'=>$info->em_region,
                      'branch'=>$info->em_branch,
                      'user'=>$emid,
                      'name'=>'BackReceive',
                      'status'=>'Received',
                      'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);


                    $data = array();//update sender status
                    $data = array('sender_status'=>'BackReceive');
                    $this->unregistered_model->update_acceptance_sender_person_info_barcode($senderp_id,$data); 

                       $arr = array(array('message'=>'Successful Received','status'=>'200'));
                      $list["data"]=$arr; 


                            

                                  $Barcode=@$senderperson->Barcode;

                            $event = "Sorting Facility";
                            $location ='Received Sorting Facility '.$loc;
                            $data2 = array();
                             $data2 = array('track_no'=>@$trackno,'location'=>$location,'user'=>@$user,'event'=>$event);

                             $this->Box_Application_model->save_location($data2);

                              $smobile =@$senderperson->sender_mobile;
                              $rmobile =@$senderperson->receiver_mobile;
                               $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.' '.$getInfo->em_region.' - '.$getInfo->em_branch;

                                 $this->Sms_model->send_sms_trick($smobile,$stotal);
                                 $this->Sms_model->send_sms_trick($rmobile,$stotal);
    
                    header('Content-Type: application/json');
                    // echo json_encode($list);
                     echo 'Successful Received';

                    

             
            }else{


                     $arr = array(array('message'=>'Already Scanned','status'=>'404'));
                      $list["data"]=$arr; 
    
                    header('Content-Type: application/json');
                    // echo json_encode($list);
                    echo 'Already Scanned';

            }}
             }else{


                     $arr = array(array('message'=>'Payment not Received','status'=>'404'));
                      $list["data"]=$arr; 
    
                    header('Content-Type: application/json');
                    // echo json_encode($list);
                     echo 'Payment not Received';
         }
            



        }else{ echo 'Not Found';}
    }
        }
  
     
    
   
    
  }


public function mail_item_list_bags_update(){

if ($this->session->userdata('user_login_access') != false)
{
$data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();


 $trn = $this->input->get('trn');
  $data['bagno'] = $trn;

$data['getInfo'] = $this->unregistered_model->get_mail_item_from_bags($trn);

 $data['getbags'] = $this->unregistered_model->get_mail_item_from_bagstwo($trn);



$this->load->view('inlandMails/mail_item_list_bags_update',$data);
}
else{
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

      public function posts_cargo_bulk_group()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
                $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('inlandMails/posts-cargo-bulk-group-form',$data);
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

    public function parcel_domestic_dashboard()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            
            $this->load->view('inlandMails/parcel-domestic-dashboard');
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

     public function parcel_post_domestic_bulk_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

                $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('inlandMails/parcel-post-domestic-bulk-form',$data);

        }else{
            redirect(base_url());
        }

    }

     public function parcel_bill_domestic_bulk_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $id = base64_decode($this->input->get('I'));
              $data['askfor'] = $this->input->get('AskFor');
                $data['custinfo'] = $this->Bill_Customer_model->get_bill_cust_details_info($id);

                $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('inlandMails/parcel-bill-domestic-bulk-form',$data);

        }else{
            redirect(base_url());
        }

    }

    public function parcel_bill_bulk_post_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $id = base64_decode($this->input->get('I'));
              $data['askfor'] = $this->input->get('AskFor');
                $data['custinfo'] = $this->Bill_Customer_model->get_bill_cust_details_info($id);

                $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('inlandMails/parcel_bill_bulk_post_form',$data);

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


     public function parcel_post_price_bulk()
    {
       
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

           $type = $this->input->post('tariffCat');
           $weight = $this->input->post('weight');
           $trans = $this->input->post('trans');

           $crdtid = $this->input->post('crdtid');

           $Pickup = $this->input->post('Pickup');
           $Advice = $this->input->post('Advice');
           $Delivery = $this->input->post('Delivery');
            $additional = 0;
            $rest='';

            $customer =$this->Bill_Customer_model->get_customer_bill_credit_by_id($crdtid);
            if($customer->customer_name == 'NHIF.'){

                if($weight > 15){

                    $getidadi = $weight - 15;
                    $sum = $getidadi * 1500;
                     $emsprice=45000 +  $sum;

                       echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                 <tr><td><b>Total Price:</b></td><td>".number_format($emsprice,2)."</td></tr>
                </table>
                    <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                        ";



                }else{

                    $emsprice=45000;

                      echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                 <tr><td><b>Total Price:</b></td><td>".number_format($emsprice,2)."</td></tr>
                </table>
                    <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                        ";




                }

            }else{

             if ($trans == "InLand") {
             $price = $this->unregistered_model->parcel_post_land_cat_price($type,$weight);

             if($Pickup == 'onn' && $Delivery == 'onn' && $Advice == 'onn'){
                 $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');
                   $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Pickup->price +$Delivery->price + $Advice->price ;

               $rest= "<tr><td><b>Advice Fee:</b></td><td>".number_format($Advice->price,2)."</td></tr>
                <tr><td><b>Pickup Fee:</b></td><td>".number_format($Pickup->price,2)."</td></tr>
                 <tr><td><b>Delivery Fee:</b></td><td>".number_format($Delivery->price,2)."</td></tr>";

               

             }elseif($Pickup == 'onn' && $Delivery == 'onn' ){
                $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');
                 
                $additional = $Pickup->price +$Delivery->price ;
                 $rest= " <tr><td><b>Pickup Fee:</b></td><td>".number_format($Pickup->price,2)."</td></tr>
                 <tr><td><b>Delivery Fee:</b></td><td>".number_format($Delivery->price,2)."</td></tr>";

                

             }elseif($Pickup == 'onn' && $Advice == 'onn' ){

                $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                  
                   $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Pickup->price  + $Advice->price ;
                 $rest= "<tr><td><b>Advice Fee:</b></td><td>".number_format($Advice->price,2)."</td></tr>
                <tr><td><b>Pickup Fee:</b></td><td>".number_format($Pickup->price,2)."</td></tr>";

               

             }elseif($Delivery == 'onn' && $Advice == 'onn' ){


                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');
                   $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Delivery->price + $Advice->price ;
                 $rest= "<tr><td><b>Advice Fee:</b></td><td>".number_format($Advice->price,2)."</td></tr>
                 <tr><td><b>Delivery Fee:</b></td><td>".number_format($Delivery->price,2)."</td></tr>";


               

             }elseif($Delivery == 'onn' ){
                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');
                $additional = $Delivery->price  ;
                $rest= "tr><td><b>Delivery Fee:</b></td><td>".number_format($Delivery->price,2)."</td></tr>";


                

             }elseif( $Advice == 'onn' ){
                 $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Advice->price  ;
                $rest= "<tr><td><b>Advice Fee:</b></td><td>".number_format($Advice->price,2)."</td></tr>";


              

             }elseif($Pickup == 'onn'  ){
                 $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                $additional = $Pickup->price  ;
                $rest= "<tr><td><b>Pickup Fee:</b></td><td>".number_format($Pickup->price,2)."</td></tr>";

             }

               

           } else {
               $price = $this->unregistered_model->parcel_post_water_cat_price($type,$weight);

                if($Pickup == 'onn' && $Delivery == 'onn' && $Advice == 'onn'){
                 $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');
                   $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Pickup->price +$Delivery->price + $Advice->price ;

               $rest= "<tr><td><b>Advice Fee:</b></td><td>".number_format($Advice->price,2)."</td></tr>
                <tr><td><b>Pickup Fee:</b></td><td>".number_format($Pickup->price,2)."</td></tr>
                 <tr><td><b>Delivery Fee:</b></td><td>".number_format($Delivery->price,2)."</td></tr>";

               

             }elseif($Pickup == 'onn' && $Delivery == 'onn' ){
                $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');
                 
                $additional = $Pickup->price +$Delivery->price ;
                 $rest= " <tr><td><b>Pickup Fee:</b></td><td>".number_format($Pickup->price,2)."</td></tr>
                 <tr><td><b>Delivery Fee:</b></td><td>".number_format($Delivery->price,2)."</td></tr>";

                

             }elseif($Pickup == 'onn' && $Advice == 'onn' ){

                $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                  
                   $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Pickup->price  + $Advice->price ;
                 $rest= "<tr><td><b>Advice Fee:</b></td><td>".number_format($Advice->price,2)."</td></tr>
                <tr><td><b>Pickup Fee:</b></td><td>".number_format($Pickup->price,2)."</td></tr>";

               

             }elseif($Delivery == 'onn' && $Advice == 'onn' ){


                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');
                   $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Delivery->price + $Advice->price ;
                 $rest= "<tr><td><b>Advice Fee:</b></td><td>".number_format($Advice->price,2)."</td></tr>
                 <tr><td><b>Delivery Fee:</b></td><td>".number_format($Delivery->price,2)."</td></tr>";


               

             }elseif($Delivery == 'onn' ){
                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');
                $additional = $Delivery->price  ;
                $rest= "tr><td><b>Delivery Fee:</b></td><td>".number_format($Delivery->price,2)."</td></tr>";


                

             }elseif( $Advice == 'onn' ){
                 $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Advice->price  ;
                $rest= "<tr><td><b>Advice Fee:</b></td><td>".number_format($Advice->price,2)."</td></tr>";


              

             }elseif($Pickup == 'onn'  ){
                 $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                $additional = $Pickup->price  ;
                $rest= "<tr><td><b>Pickup Fee:</b></td><td>".number_format($Pickup->price,2)."</td></tr>";

             }

           }

            
            if (empty($price)) {

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th colspan='2'>Charges</th></tr>
                <tr><td><b>Price:</b></td><td>0</td></tr>
                <tr><td><b>Total Price:</b></td><td>0</td></tr>
                </table>";

            }else{

                 $emsprice = $price->tarrif + $price->vat + $additional;


                
              

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                <tr><td><b>Tariff:</b></td><td>".number_format($price->tarrif,2)."</td></tr>
                <tr><td><b>Vat:</b></td><td>".number_format($price->vat,2)."</td></tr>".$rest."
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



public function parcel_post_sender_info(){
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $Barcode = $this->input->post('Barcode');
            $sender_address = $this->input->post('s_mobilev');
            $receiver_address = $this->input->post('r_mobilev');

            //-------------- Start here
            $emid = $this->session->userdata('user_login_id');
            //getting user or staff department section
            $staff_section = $this->employee_model->getEmpDepartmentSections($emid);


            $addressT = "physical";
             $addressR = "physical";
             $s_fname = $this->input->post('s_fname');
             $s_address = $this->input->post('s_address');
             //$s_email = $this->input->post('s_email');
             $s_mobile = $mobile = $this->input->post('s_mobile');
             $r_fname = $this->input->post('r_fname');
             $r_address = $this->input->post('r_address');
             $r_mobile = $this->input->post('r_mobile');
             //$r_email = $this->input->post('r_email');
             $rec_region = $this->input->post('region_to');
             $rec_dropp = $this->input->post('district');

             $addressT = "physical";
             $s_fname = $this->input->post('s_fname');
             $s_address = $this->input->post('s_address');
             $s_email = $this->input->post('s_email');
             $s_mobile = $mobile = $this->input->post('s_mobile');

             $addressR = "physical";
             $r_fname = $this->input->post('r_fname');
             $r_address = $this->input->post('r_address');
             $r_mobile = $this->input->post('r_mobile');
             $r_email = $this->input->post('r_email');
             $rec_region = $this->input->post('rec_region');
             $rec_dropp = $this->input->post('rec_dropp');

            $trans = $this->input->post('transport');
            $weight = $this->input->post('weight');
            $type = $this->input->post('emstype');
       

            $o_region = $region_to = $rec_region;
            $rec_region = $district =  $rec_dropp;

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

            $source = $this->employee_model->get_code_source($sender_region);
            $dest = $this->employee_model->get_code_dest($region_to);
            $bagsNo = $source->reg_code . $dest->reg_code;

            $number = $this->getnumber();
            $bagsNo = $source->reg_code . $dest->reg_code;
            @$trackNo = 'CD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';


             $db2 = $this->load->database('otherdb', TRUE);

                $sender = array(
                'sender_fullname'=>$s_fname,
                'sender_address'=>$s_address,
                'sender_mobile'=>$s_mobile,
                'register_type'=>$trans,
                'sender_region'=>$sender_region,
                'sender_branch'=>$sender_branch,
                'register_weght'=>$weight,
                'register_price'=>$Total,
                'operator'=>$emid,
                'sender_type'=>'Parcels-Post',
                'track_number'=>$trackNo);

               
                $db2->insert('sender_person_info',$sender);
                $last_id = $db2->insert_id();

               
                $receiver = array(
                'sender_id'=>$last_id,
                'r_address'=>$r_address,
                'receiver_region'=>$region_to,
                'reciver_branch'=>$district,
                'receiver_fullname'=>$r_fname,
                'receiver_mobile'=>$r_mobile);

           
                $db2->insert('receiver_register_info',$receiver);

                //for One Man
                $office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';

                $trans = array();
                $trans = array(

                'serial'=>$serial,
                'paidamount'=>$Total,
                'register_id'=>$last_id,
                'Barcode'=>$Barcode,
                'office_name'=>$office_one_name,
                'created_by'=>$emid,
                'transactionstatus'=>'POSTED',
                'bill_status'=>'PENDING');

                $lastTransId = $this->unregistered_model->save_transactions($trans);


                //for One Man
                $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

                //for tracing
                $trace_data = array(
                'emid'=>$emid,
                'trans_type'=>'mails',
                'transid'=>$lastTransId,
                'office_name'=>$office_trance_name,
                'description'=>'Acceptance',
                'status'=>'IN');

                //for trace data
                $this->Box_Application_model->tracing($trace_data);
                //------------------End

                $renter   = $s_fname;
                $serviceId = 'MAIL';


            if ($lastTransId) {

                 //$trackno = '009';
                $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackNo);

                // print_r($postbill);
                // die();

                    if (!empty($postbill->controlno)) {
                         $response['status'] = 'Success';

                        $trackno = array();
                        $trackno = array('track_number'=>$trackNo);
                        $info = $this->employee_model->GetBasic($id);
                        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                        $location= $info->em_region.' - '.$info->em_branch;
                        $data = array();
                        $data = array(
                            'track_no'=>$trackNo,
                            'location'=>$location,
                            'user'=>$user,
                            'event'=>'Counter');

                        $this->Box_Application_model->save_location($data);

                        $this->unregistered_model->update_sender_info($last_id,$trackNo);
                        $serial = $postbill->billid;
                        $update = array();
                        $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
                        $this->unregistered_model->update_register_transactions1($update,$serial);

                        $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Parcel Post  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                        
                        $this->Sms_model->send_sms_trick($s_mobile,$sms);

                    $response['message'] = $sms;

                }else{
                    $response['status'] = 'Error';
                    $response['message'] = 'Item yako imeshasajiliwa ila control number aijatoka, wasiliana na wataalam wa ICT';
                }
            }else{
                $response['status'] = 'Error';
                $response['message'] = 'Item yako aijasajiliwa vizuri';
            }

            print_r(json_encode($response));
        }else{
            redirect(base_url());
        }
}


    public function Oldparcel_post_sender_info()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $Barcode = $this->input->post('Barcode');
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


            $trans = $this->input->post('transport');
            $weight = $this->input->post('weight');
            // $s_fname = $this->input->post('s_fname');
            // $s_address = $this->input->post('s_address');
            $type = $this->input->post('emsname');
            // $s_mobile = $this->input->post('s_mobile');
            // $s_email = $this->input->post('s_email');
            // $r_fname = $this->input->post('r_fname');
            // $r_address = $this->input->post('r_address');
            // $r_mobile = $this->input->post('r_mobile');

            // $o_region = $region_to = $this->input->post('region_to');
            // $rec_region = $district = $this->input->post('district');

             $o_region = $region_to = $rec_region;
            $rec_region = $district =  $rec_dropp;

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

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($region_to);
                $bagsNo = $source->reg_code . $dest->reg_code;

                $number = $this->getnumber();
                $bagsNo = $source->reg_code . $dest->reg_code;
                @$trackNo = 'CD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';
            
            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$trans,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'sender_type'=>'Parcels-Post','track_number'=>$trackNo);
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);


            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$region_to,'reciver_branch'=>$district,'receiver_fullname'=>$r_fname,'receiver_mobile'=>$r_mobile);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('receiver_register_info',$receiver);

             //-------------- Start here
            $emid = $this->session->userdata('user_login_id');
            //getting user or staff department section
            $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

            //for One Man
            $office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';

            $trans = array();
            $trans = array(

            'serial'=>$serial,
            'paidamount'=>$Total,
            'register_id'=>$last_id,
            'Barcode'=>strtoupper($Barcode),
            'office_name'=>$office_one_name,
            'created_by'=>$emid,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING'

            );

            $db2 = $this->load->database('otherdb', TRUE); 
            //$db2->insert('register_transactions',$trans);
            $lastTransId = $this->unregistered_model->save_transactions($trans);

            //for One Man
            $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

            //for tracing
            $trace_data = array(
            'emid'=>$emid,
            'trans_type'=>'mails',
            'transid'=>$lastTransId,
            'office_name'=>$office_trance_name,
            'description'=>'Acceptance',
            'status'=>'IN');

            //for trace data
            $this->Box_Application_model->tracing($trace_data);
            //------------------End
               

            $renter   = $s_fname;
            $serviceId = 'MAIL';



                      //create logs
              $userid  = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($userid);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                 $tz = 'Africa/Nairobi';
                $tz_obj = new DateTimeZone($tz);
                $today = new DateTime("now", $tz_obj);
                $dates = $today->format('Y-m-d');
                $dates2 = date('Y-m-d h:i:s');

                    $latest=json_encode($trans);
                    $latest2=json_encode($sender);
                    $lg = array(
                        'status'=> 'Send to gepg',
                        'description'=>$user.' Save '.$latest.' on'.$dates,
                        'service'=>'Parcel',
                        'action'=>'save',
                        'previous'=>$latest2,
                        'latest'=> $latest,
                        'date'=>$dates2,
                         'em_id' => $last_id,
                         'changedby'=>$userid

                    );
                       $this->payroll_model->save_emplogs($lg);


            //$trackno = '009';
            $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackNo);

            //$controlno = $transaction->controlno;

            if (!empty($postbill->controlno)) {

                // $source = $this->employee_model->get_code_source($sender_region);
                // $dest = $this->employee_model->get_code_dest($region_to);
                // $bagsNo = $source->reg_code . $dest->reg_code;

                // $first4 = substr($postbill->controlno, 4);
                // $trackNo = $bagsNo.$first4;
                $trackno = array();
                $trackno = array('track_number'=>$trackNo);
                $info = $this->employee_model->GetBasic($id);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                $this->unregistered_model->update_sender_info($last_id,$trackNo);
                $serial = $postbill->billid;
                $update = array();
                $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Parcel Post  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
           
            //if (!empty($transaction->$controlno)) {
                
                $this->load->view('inlandMails/parcel-post-control-number-form',$data);
                
                $this->Sms_model->send_sms_trick($s_mobile,$sms);

            }else{

                $repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackNo); 


                // $source = $this->employee_model->get_code_source($sender_region);
                // $dest = $this->employee_model->get_code_dest($region_to);
                // $bagsNo = $source->reg_code . $dest->reg_code;

                
                // $first4 = substr($repostbill->controlno, 4);
                // $trackNo = $bagsNo.$first4;
                $trackno = array();
                $trackno = array('track_number'=>$trackNo);
                $info = $this->employee_model->GetBasic($id);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                $this->unregistered_model->update_sender_info($last_id,$trackNo);

                @$serial = $repostbill->billid;
                $update = array();
                $update = array('billid'=>@$repostbill->controlno,'bill_status'=>'SUCCESS');
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$repostbill->controlno.' Kwaajili ya huduma ya Parcel Post  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                $this->load->view('inlandMails/parcel-post-control-number-form',$data);    
            }

        }else{
            redirect(base_url());
        }
    }


public function save_parcel_post_sender_info_info()
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

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya  Parcel Post  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2).'';
           
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

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$repostbill->controlno.' Kwaajili ya huduma ya  Parcel Post  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2).'';

                 $this->Sms_model->send_sms_trick($s_mobile,$sms);
                 echo $sms;
                //$this->load->view('inlandMails/control-number-form',$data);    

                 //$this->session->set_flashdata('success','Saved Successfull');
                  
            }

          

}

 public function bulk_parcel_post_sender_info()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $sender_address = $this->input->post('s_mobilev');
             $Barcode = $this->input->post('Barcode');
            $receiver_address = $this->input->post('r_mobilev');
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

            $addressT = "physical";
             $s_fname = $this->input->post('s_fname');
             $s_address = $this->input->post('s_address');
             $s_email = $this->input->post('s_email');
             $s_mobile = $mobile = $this->input->post('s_mobile');

             $addressR = "physical";
             $r_fname = $this->input->post('r_fname');
             $r_address = $this->input->post('r_address');
             $r_mobile = $this->input->post('r_mobile');
             $r_email = $this->input->post('r_email');
             $rec_region = $this->input->post('region_to');
             $rec_dropp = $this->input->post('district');


              //-------------- Start here
            $emid = $this->session->userdata('user_login_id');
            //getting user or staff department section
            $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

            $serial = $this->input->post('serial');
            if(empty($serial)){
               $serial    = 'Parcel'.date("YmdHis").$this->session->userdata('user_emid');
            }

            $trans = $this->input->post('transport');
            $weight = $this->input->post('weight');
            $type = $this->input->post('emsname');

             $o_region = $region_to = $rec_region;
            $rec_region = $district =  $rec_dropp;

            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');

          
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

            $source = $this->employee_model->get_code_source($sender_region);
            $dest = $this->employee_model->get_code_dest($region_to);
            $bagsNo = $source->reg_code . $dest->reg_code;

            $number = $this->getnumber();
            $bagsNo = $source->reg_code . $dest->reg_code;
            @$trackNo = 'CD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

             $db2 = $this->load->database('otherdb', TRUE);
            
            $sender = array();
            $sender = array(
            'sender_fullname'=>$s_fname,
            'sender_address'=>$s_address,
            'sender_mobile'=>$s_mobile,
            'register_type'=>$trans,
            'sender_region'=>$sender_region,
            'sender_branch'=>$sender_branch,
            'register_weght'=>$weight,
            'register_price'=>$Total,
            'operator'=>$emid,
            'sender_type'=>'Parcels-Post',
            'track_number'=>$trackNo);

           
            $db2->insert('sender_person_info',$sender);
            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array(
            'sender_id'=>$last_id,
            'r_address'=>$r_address,
            'receiver_region'=>$region_to,
            'reciver_branch'=>$district,
            'receiver_fullname'=>$r_fname,
            'receiver_mobile'=>$r_mobile);

           
            $db2->insert('receiver_register_info',$receiver);

              //for One Man
            $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

            $trans = array();
            $trans = array(
            'serial'=>$serial,
            'paidamount'=>$Total,
            'register_id'=>$last_id,
             'Barcode'=>$Barcode,
             'office_name'=>$office_trance_name,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING');

            $lastTransId = $this->unregistered_model->save_transactions($trans);

             //for tracing
            $trace_data = array(
            'emid'=>$emid,
            'trans_type'=>'mails',
            'transid'=>$lastTransId,
            'office_name'=>$office_trance_name,
            'description'=>'Acceptance',
            'status'=>'IN');

            //for trace data
            $this->Box_Application_model->tracing($trace_data);
            //------------------End


            $sender_id = $last_id;
            $operator = $emid;

            

            if ($lastTransId) {
                //get list of saved transaction
                $listbulk = $this->unregistered_model->getRegisterTransa($lastTransId,$operator);

                $value = $listbulk[0];

                $totalAmount = $this->input->post('totalAmount');
                $counterIterm = $this->input->post('counterIterm');

                $response['status'] = 'Success';

                 $transData =  "<tr class='receiveRowTrans' style='width:100%;color:#343434;'>
                     <td>".$value->receiver_fullname."</td>
                     <td>".$value->sender_fullname."</td>
                     <td>".$value->sender_branch."</td>
                     <td>".$value->reciver_branch."</td>
                     <td>".$value->Barcode."</td>
                     <td>".number_format($value->register_price,2)."</td>
                     <td>
                     <button  
                     data-senderid='".$value->senderp_id."'
                     data-serial='".$value->serial."'
                     data-item_amount='".$value->register_price."'
                     class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete </button>
                     </td>
                 </tr>";


                $response['counter'] = $counterIterm+1;
                $response['balance'] = $value->register_price + $totalAmount;
                $response['serial'] = $value->serial;


                $response['messageData'] = $transData;

            }else{
                $response['status'] = 'Error';
                $response['message'] = 'Item yako aijasajiliwa vizuri';
            }
               
            print_r(json_encode($response));
        }else{
            redirect(base_url());
        }
    }


     public function Oldbulk_parcel_post_sender_info()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $sender_address = $this->input->post('s_mobilev');
             $Barcode = $this->input->post('Barcode');
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


              $serial = $this->input->post('serial');
            if(empty($serial)){
               $serial    = 'Parcel'.date("YmdHis").$this->session->userdata('user_emid');

               // $serial    = 'Register'.date("YmdHis").$this->session->userdata('user_emid');

            }

            $trans = $this->input->post('transport');
            $weight = $this->input->post('weight');
            // $s_fname = $this->input->post('s_fname');
            // $s_address = $this->input->post('s_address');
            $type = $this->input->post('emsname');
            // $s_mobile = $this->input->post('s_mobile');
            // $s_email = $this->input->post('s_email');
            // $r_fname = $this->input->post('r_fname');
            // $r_address = $this->input->post('r_address');
            // $r_mobile = $this->input->post('r_mobile');

            // $o_region = $region_to = $this->input->post('region_to');
            // $rec_region = $district = $this->input->post('district');

             $o_region = $region_to = $rec_region;
            $rec_region = $district =  $rec_dropp;

            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');

          
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

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($region_to);
                $bagsNo = $source->reg_code . $dest->reg_code;

                $number = $this->getnumber();
                $bagsNo = $source->reg_code . $dest->reg_code;
                @$trackNo = 'CD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';
            
            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$trans,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'sender_type'=>'Parcels-Post','track_number'=>$trackNo);
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
             'Barcode'=>strtoupper($Barcode),
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING'

            );

            $db2 = $this->load->database('otherdb', TRUE); 
            $db2->insert('register_transactions',$trans);


             $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


             echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->register_price,2)."</td>
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

public function bulk_bill_parcel_post_sender_info(){
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            // $Barcode = $this->input->post('Barcode');
             $sender_address = $this->input->post('s_mobilev');
             $Barcode = $this->input->post('Barcode');
            $receiver_address = $this->input->post('r_mobilev');
            $target_url = "http://192.168.33.7/api/virtual_box/";

            $totalAmount = $this->input->post('totalAmount');
            $counterIterm = $this->input->post('counterIterm');


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

            $addressT = "physical";
             $s_fname = $this->input->post('s_fname');
             $s_address = $this->input->post('s_address');
             $s_email = $this->input->post('s_email');
             $s_mobile = $mobile = $this->input->post('s_mobile');

            $addressR = "physical";
             $r_fname = $this->input->post('r_fname');
             $r_address = $this->input->post('r_address');
             $r_mobile = $this->input->post('r_mobile');
             $r_email = $this->input->post('r_email');
             $rec_region = $this->input->post('region_to');
             $rec_dropp = $this->input->post('district');


              $serial = $this->input->post('serial');
            if(empty($serial)){
               $serial    = 'Parcel'.date("YmdHis").$this->session->userdata('user_emid');
            }

            $trans = $this->input->post('transport');
            $weight = $this->input->post('weight');
            // $s_fname = $this->input->post('s_fname');
            // $s_address = $this->input->post('s_address');
            $type = $this->input->post('emsname');

             $o_region = $region_to = $rec_region;
            $rec_region = $district =  $rec_dropp;

            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');

             $askfor = $this->input->post('askfor');

            $price1 = $this->input->post('price');
            $I = $this->input->post('crdtid');
             $info =  $custinfo = $this->Box_Application_model->get_customer_infos($I);
              
            $accno = $this->input->post('accno');
            //$price = $this->unregistered_model->unregistered_cat_price($type,$weight);

          
            $id = $emid = $this->session->userdata('user_login_id');
            $ad_fee = $this->input->post('ad_fee');
            $tarrif = $this->input->post('destination');
            $item   = $this->input->post('itemtype');

            $response = array();

            if ($trans == "Land") {
                $price = $this->unregistered_model->parcel_post_land_cat_price($type,$weight);
            } else {
                $price = $this->unregistered_model->parcel_post_water_cat_price($type,$weight);
            }
          
               $paidamount = $Total = $price->tarrif + $price->vat ;
                $diffp = $price1-$paidamount;

               if(@$info->customer_type == "PostPaid"){

                if($info->price < $paidamount){
                  
                   $response['status'] = 'Error';
                  $response['message'] = 'Umefikia Kiwango Cha mwisho';

                }else {

              $diffp = $price1-$paidamount;

              if($diffp > 0) {

                 $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($region_to);
                $bagsNo = $source->reg_code . $dest->reg_code;

                $number = $this->getnumber();
                $bagsNo = $source->reg_code . $dest->reg_code;
                @$trackNo = 'CD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';


                $sender = array();
            $sender = array(
                'sender_fullname'=>$s_fname,
                'sender_address'=>$s_address,
                'sender_mobile'=>$s_mobile,
                'register_type'=>$trans,
                'sender_region'=>$sender_region,
                'sender_branch'=>$sender_branch,
                'register_weght'=>$weight,
                'register_price'=>$Total,
                'operator'=>$emid,
                'acc_no'=>$accno,
                'sender_type'=>'Parcels-Post',
                'track_number'=>$trackNo);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);


            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array(
                'sender_id'=>$last_id,
                'r_address'=>$r_address,
                'receiver_region'=>$region_to,
                'reciver_branch'=>$district,
                'receiver_fullname'=>$r_fname,
                'receiver_mobile'=>$r_mobile);

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
                'Barcode'=>$Barcode,
                'transactionstatus'=>'POSTED',
                 'bill_status'=>'BILLING',
                  // 'paymentFor'=>'MAIL',
                  'status'=>'Paid');
           

            $db2 = $this->load->database('otherdb', TRUE); 
            $db2->insert('register_transactions',$trans);


             $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


            
                $alltotal = 0;
                $response['status'] = 'Success';
                 $response['message'] = 'Successfully';
                $transData = "";
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  $transData .= "<tr class='receiveRowTrans' style='width:100%;color:#343434;'>
                  <td>".$value->receiver_fullname."</td>
                  <td>".$value->sender_fullname."</td>
                  <td>".$value->sender_region."</td>
                  <td>".$value->sender_branch."</td>
                  <td>".$value->receiver_region."</td>
                  <td>".$value->reciver_branch."</td>
                   <td>".$value->Barcode."</td>
                  <td>".number_format($value->register_price,2)."</td>
                  <td>
                  <button  

                   data-senderid='".$value->senderp_id."'
                     data-serial='".$value->serial."'
                     data-item_amount='".$value->register_price."'

                     class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }

                $response['counter'] = $counterIterm+1;
                $response['balance'] = $value->register_price + $totalAmount;
                $response['serial'] = $value->serial;

                $response['messageData'] = $transData;

            }else{

                             $response['status'] = 'Error';
                  $response['message'] = 'Umefikia Kiwango Cha mwisho';
                
                            }

                    }

               }else{ //prepaid

                 $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($region_to);
                $bagsNo = $source->reg_code . $dest->reg_code;

                $number = $this->getnumber();
                $bagsNo = $source->reg_code . $dest->reg_code;
                @$trackNo = 'CD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

                $sender = array();
            $sender = array(
                'sender_fullname'=>$s_fname,
                'sender_address'=>$s_address,
                'sender_mobile'=>$s_mobile,
                'register_type'=>$trans,
                'sender_region'=>$sender_region,
                'sender_branch'=>$sender_branch,
                'register_weght'=>$weight,
                'register_price'=>$Total,
                'operator'=>$emid,
                'acc_no'=>$accno,
                'sender_type'=>'Parcels-Post',
                'track_number'=>$trackNo);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);


            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array(
                'sender_id'=>$last_id,
                'r_address'=>$r_address,
                'receiver_region'=>$region_to,
                'reciver_branch'=>$district,
                'receiver_fullname'=>$r_fname,
                'receiver_mobile'=>$r_mobile);

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
                'Barcode'=>$Barcode,
                'transactionstatus'=>'POSTED',
                 'bill_status'=>'BILLING',
                  // 'paymentFor'=>'MAIL',
                  'status'=>'Paid');
           

            $db2 = $this->load->database('otherdb', TRUE); 
            $db2->insert('register_transactions',$trans);


             $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


                $alltotal = 0;
                $response['status'] = 'Success';
                $response['message'] = 'Successfully';
                $transData = "";
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  $transData .= "<tr class='receiveRowTrans' style='width:100%;color:#343434;'>
                  <td>".$value->receiver_fullname."</td>
                  <td>".$value->sender_fullname."</td>
                  <td>".$value->sender_region."</td>
                  <td>".$value->sender_branch."</td>
                  <td>".$value->receiver_region."</td>
                  <td>".$value->reciver_branch."</td>
                  <td>".$value->Barcode."</td>
                  <td>".number_format($value->register_price,2)."</td>
                  <td>
                  <button  

                   data-senderid='".$value->senderp_id."'
                     data-serial='".$value->serial."'
                     data-item_amount='".$value->register_price."'

                     class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }


                $response['counter'] = $counterIterm+1;
                $response['balance'] = $value->register_price + $totalAmount;
                $response['serial'] = $value->serial;

                $response['messageData'] = $transData;

               }

               print_r(json_encode($response));
        }else{
            redirect(base_url());
        }
    }


 public function Oldbulk_bill_parcel_post_sender_info()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            // $Barcode = $this->input->post('Barcode');
             $sender_address = $this->input->post('s_mobilev');
             $Barcode = $this->input->post('Barcode');
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


              $serial = $this->input->post('serial');
            if(empty($serial)){
               $serial    = 'Parcel'.date("YmdHis").$this->session->userdata('user_emid');

               // $serial    = 'Register'.date("YmdHis").$this->session->userdata('user_emid');

            }

            $trans = $this->input->post('transport');
            $weight = $this->input->post('weight');
            // $s_fname = $this->input->post('s_fname');
            // $s_address = $this->input->post('s_address');
            $type = $this->input->post('emsname');
            // $s_mobile = $this->input->post('s_mobile');
            // $s_email = $this->input->post('s_email');
            // $r_fname = $this->input->post('r_fname');
            // $r_address = $this->input->post('r_address');
            // $r_mobile = $this->input->post('r_mobile');

            // $o_region = $region_to = $this->input->post('region_to');
            // $rec_region = $district = $this->input->post('district');

             $o_region = $region_to = $rec_region;
            $rec_region = $district =  $rec_dropp;

            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');

             $askfor = $this->input->post('askfor');

            $price1 = $this->input->post('price');
            $I = $this->input->post('crdtid');
             $info =  $custinfo = $this->Box_Application_model->get_customer_infos($I);
              
            $accno = $this->input->post('accno');
            //$price = $this->unregistered_model->unregistered_cat_price($type,$weight);

          
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
                $diffp = $price1-$paidamount;

               if(@$info->customer_type == "PostPaid"){

                if($info->price < $paidamount){
                  
                  echo 'Umefikia Kiwango Cha mwisho';

                }else {

              $diffp = $price1-$paidamount;

              if($diffp > 0) {

                 $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($region_to);
                $bagsNo = $source->reg_code . $dest->reg_code;

                $number = $this->getnumber();
                $bagsNo = $source->reg_code . $dest->reg_code;
                @$trackNo = 'CD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';


                $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$trans,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'acc_no'=>$accno,'sender_type'=>'Parcels-Post','track_number'=>$trackNo);
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);


            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$region_to,'reciver_branch'=>$district,'receiver_fullname'=>$r_fname,'receiver_mobile'=>$r_mobile);

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
                'Barcode'=>strtoupper($Barcode),
                'transactionstatus'=>'POSTED',
                 'bill_status'=>'BILLING',
                  // 'paymentFor'=>'MAIL',
                  'status'=>'Paid'

                );
           

            $db2 = $this->load->database('otherdb', TRUE); 
            $db2->insert('register_transactions',$trans);


             $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


             echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->register_price,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                   
                        ";





                

                            }else{

                             echo 'Umefikia Kiwango Cha mwisho'; 
                
                            }

                    }

               }else{ //prepaid

                 $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($region_to);
                $bagsNo = $source->reg_code . $dest->reg_code;

                $number = $this->getnumber();
                $bagsNo = $source->reg_code . $dest->reg_code;
                @$trackNo = 'CD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

                $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$trans,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'acc_no'=>$accno,'sender_type'=>'Parcels-Post','track_number'=>$trackNo);
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);


            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$region_to,'reciver_branch'=>$district,'receiver_fullname'=>$r_fname,'receiver_mobile'=>$r_mobile);

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
                'Barcode'=>strtoupper($Barcode),
                'transactionstatus'=>'POSTED',
                 'bill_status'=>'BILLING',
                  // 'paymentFor'=>'MAIL',
                  'status'=>'Paid'

                );
           

            $db2 = $this->load->database('otherdb', TRUE); 
            $db2->insert('register_transactions',$trans);


             $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


             echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->register_price,2)."</td>
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



               }

               


            
            

               

          

        }else{
            redirect(base_url());
        }
    }


      public function Delivery_scanned(){

   $emid=   $this->session->userdata('user_login_id');
   $trackno = $this->input->post('identifier');
    $operator = $this->input->post('operator');
     $serial = $this->input->post('serial');
 $serial    = 'serial'.date("YmdHis");
   
    $emid=$emid;

    if(empty($operator)){
                           
          echo 'Please Select operator ';

    }else{
    $word = 'DS';
    if(strpos($trackno, $word) === false ){

        $info = $this->employee_model->GetBasic($emid);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        // $location= $info->em_region.' - '.$info->em_branch;
                  $location= ' - '.$info->em_branch;

            
            $db='sender_person_info';
             $senderperson = $this->unregistered_model->get_senderperson_barcode($db,$trackno);
              
        if(!empty($senderperson))//which table
          {
             //check payment
            $senderp_id=@$senderperson->senderp_id;
            $trackno=@$senderperson->Barcode;
            //$serial=@$senderperson->serial;
            
         $DB='register_transactions';
         $transactions2 = $this->unregistered_model->CheckintransactionsBYSENDERPRS($DB,$senderp_id);
         $DB='parcel_international_transactions';
         $transactions4 = $this->unregistered_model->Checkintransactions3($DB,$senderp_id);

      if( !empty($transactions2) || !empty($transactions4)){

             if(!empty($senderperson)){

            
            if($senderperson->sender_status != 'BackReceive0'){ //haijawa received?


                    $love = array();//from counter or region - receive item
                    $love = array(
                      'track_no'=>$trackno,
                      'event'=>$info->em_role,
                      'region'=>$info->em_region,
                      'branch'=>$info->em_branch,
                      'user'=>$emid,
                      'name'=>'Delivery',
                      'status'=>'Delivery',
                      'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);

                     $service_type= 'MAIL';
                     $sender_id=@$senderperson->senderp_id;

                     $checkReassigned = $this->Box_Application_model->check_reassign($sender_id,$operator);

                     if(!empty($checkReassigned)){

                         $data = array();
                      $data = array(
                    'em_id'=>$operator,
                    'item_id'=>$sender_id,
                     'serial'=>$serial,
                    'service_type'=>$service_type
                );
                        $this->Box_Application_model->update_delivery_info($data,$sender_id);

                     }else{

                $data = array();
                $data = array(
                    'em_id'=>$operator,
                    'item_id'=>$sender_id,
                     'serial'=>$serial,
                    'service_type'=>$service_type
                );

                 $this->Box_Application_model->save_delivery_info($data);

                 $trackno=@$senderperson->track_number;


                    $data = array();//update sender status
                    $data = array('sender_status'=>'Assigned');
                    $this->unregistered_model->update_acceptance_sender_person_info($trackno,$data); 

                      
                      echo 'Successful Assigned';
             
            }           
            }

        }
             }
         }else{

           echo '  <span class ="" style="color: red;font-weight: 60px;font-size: 22px;align-content:center ;"> Huduma Haijalipiwa</span>';

           }
            echo '  <span class ="" style="color: red;font-weight: 60px;font-size: 22px;align-content:center ;"> Huduma Haijalipiwa</span>';


            
        }


        }
    
}



     public function bulk_bill_POST_parcel_post_sender_info()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $sender_address = $this->input->post('s_mobilev');
            $Barcode = $this->input->post('Barcode');
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


              $serial = $this->input->post('serial');
            if(empty($serial)){
               $serial    = 'Parcel'.date("YmdHis").$this->session->userdata('user_emid');

               // $serial    = 'Register'.date("YmdHis").$this->session->userdata('user_emid');

            }

            $trans = $this->input->post('transport');
            $weight = $this->input->post('weight');
            // $s_fname = $this->input->post('s_fname');
            // $s_address = $this->input->post('s_address');
            $type = $this->input->post('emsname');
            // $s_mobile = $this->input->post('s_mobile');
            // $s_email = $this->input->post('s_email');
            // $r_fname = $this->input->post('r_fname');
            // $r_address = $this->input->post('r_address');
            // $r_mobile = $this->input->post('r_mobile');

            // $o_region = $region_to = $this->input->post('region_to');
            // $rec_region = $district = $this->input->post('district');

             $o_region = $region_to = $rec_region;
            $rec_region = $district =  $rec_dropp;

            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');

             $askfor = $this->input->post('askfor');

            $price1 = $this->input->post('price');
            $I = $this->input->post('crdtid');
             $info =  $custinfo = $this->Box_Application_model->get_customer_infos($I);
              
            $accno = $this->input->post('accno');
            //$price = $this->unregistered_model->unregistered_cat_price($type,$weight);

          
            $id = $emid = $this->session->userdata('user_login_id');
            $ad_fee = $this->input->post('ad_fee');
            $tarrif = $this->input->post('destination');
            $item   = $this->input->post('itemtype');

              $Pickup = $this->input->post('Pickup');
                   $Advice = $this->input->post('Advice');
                   $Delivery = $this->input->post('Delivery');
                    $additional = 0;


            // $customer =$this->Bill_Customer_model->get_customer_bill_credit_by_id($I);
            if($s_fname == 'NHIF.'){

                if($weight > 15){

                    $getidadi = $weight - 15;
                    $sum = $getidadi * 1500;
                     $paidamount = $Total = 45000 +  $sum;

                       


                }else{
                     $paidamount = $Total =45000;

                }
            }else{


            if ($trans == "InLand") {
                   $price = $this->unregistered_model->parcel_post_land_cat_price($type,$weight);

             if($Pickup == 'onn' && $Delivery == 'onn' && $Advice == 'onn'){
                 $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');
                   $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Pickup->price +$Delivery->price + $Advice->price ;

             }elseif($Pickup == 'onn' && $Delivery == 'onn' ){
                $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');

             }elseif($Pickup == 'onn' && $Advice == 'onn' ){

                $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                  
                   $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Pickup->price  + $Advice->price ;

             }elseif($Delivery == 'onn' && $Advice == 'onn' ){

                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');
                   $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Delivery->price + $Advice->price ;

             }elseif($Delivery == 'onn' ){
                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');
                $additional = $Delivery->price  ;

             }elseif( $Advice == 'onn' ){
                 $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Advice->price  ;
              

             }elseif($Pickup == 'onn'  ){
                 $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                $additional = $Pickup->price  ;
                
             }

            } else {

                   $price = $this->unregistered_model->parcel_post_water_cat_price($type,$weight);

                    if($Pickup == 'onn' && $Delivery == 'onn' && $Advice == 'onn'){
                 $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');
                   $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Pickup->price +$Delivery->price + $Advice->price ;

             }elseif($Pickup == 'onn' && $Delivery == 'onn' ){
                $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');

             }elseif($Pickup == 'onn' && $Advice == 'onn' ){

                $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                  
                   $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Pickup->price  + $Advice->price ;

             }elseif($Delivery == 'onn' && $Advice == 'onn' ){

                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');
                   $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Delivery->price + $Advice->price ;

             }elseif($Delivery == 'onn' ){
                  $Delivery = $this->unregistered_model->parcel_post_add_price('delivery charge');
                $additional = $Delivery->price  ;

             }elseif( $Advice == 'onn' ){
                 $Advice = $this->unregistered_model->parcel_post_add_price('advice fee');
                $additional = $Advice->price  ;
              

             }elseif($Pickup == 'onn'  ){
                 $Pickup = $this->unregistered_model->parcel_post_add_price('pickup charge');
                $additional = $Pickup->price  ;
                
             }

            }

            $paidamount = $Total = $price->tarrif + $price->vat + $additional ;
        }
          
               
                $diffp = $price1-$paidamount;

               if(@$info->customer_type == "PostPaid"){

                if($info->price < $paidamount){
                  
                  echo 'Umefikia Kiwango Cha mwisho';

                }else {

              $diffp = $price1-$paidamount;

              if($diffp > 0) {

                 $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($region_to);
                $bagsNo = $source->reg_code . $dest->reg_code;

                $number = $this->getnumber();
                $bagsNo = $source->reg_code . $dest->reg_code;
                @$trackNo = 'CD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';


                $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$trans,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'acc_no'=>$accno,'sender_type'=>'Parcels-Post','track_number'=>$trackNo,'sender_type'=>'PARCEL BULK POSTING');
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);


            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'receiver_region'=>$region_to,'reciver_branch'=>$district,'receiver_fullname'=>$r_fname);

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

              $emid = $this->session->userdata('user_login_id');
                //getting user or staff department section
                $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

                //user information
                $basicinfo = $this->employee_model->GetBasic($emid);
                $region = $basicinfo->em_region;
                $em_branch = $basicinfo->em_branch;

                //for One Man
                $office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';

              
               $trans = array();
                $trans = array(

                'serial'=>$serial,
                'paidamount'=>$Total,
                'register_id'=>$last_id,
                 'Barcode'=>strtoupper($Barcode),
                'office_name'=>$office_one_name,
                'created_by'=>$emid,
                'transactionstatus'=>'POSTED',
                 'bill_status'=>'BILLING',
                  // 'paymentFor'=>'MAIL',
                  'status'=>'Paid'

                );
           

            $db2 = $this->load->database('otherdb', TRUE); 
            //$db2->insert('register_transactions',$trans);
            $lastTransId = $this->unregistered_model->save_transactions($trans);

            //for One Man
            $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

            //for tracing
            $trace_data = array(
            'emid'=>$emid,
            'trans_type'=>'mails',
            'transid'=>$lastTransId,
            'office_name'=>$office_trance_name,
            'description'=>'Acceptance '.$em_branch,
            'status'=>'Acceptance');

            //for trace data
            $this->Box_Application_model->tracing($trace_data);


             $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


             echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Branch Origin</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $sn=1;
                $alltotal = 0;
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr class='".$value->Barcode."' style='width:100%;color:#343434;'><td>".$sn."</td><td>".$value->receiver_fullname."</td><td>".$value->sender_fullname."</td><td>".$value->sender_branch."</td><td>".$value->reciver_branch."</td><td>".$value->Barcode."</td> <td>".number_format($value->register_price,2)."</td>
                  <td>

                   
                   <button  

                   data-registerid='".$value->register_id."'
                   data-barcodeno='".$value->Barcode."'
                   data-item_amount='".$value->register_price."'

                   class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                 $sn++;
                }

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b><input type='text' id='totalAmount' readonly value='".$alltotal."'/></b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                   
                        ";
                            }else{

                             echo 'Umefikia Kiwango Cha mwisho'; 
                
                            }

                    }

               }else{ //prepaid

                 $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($region_to);
                $bagsNo = $source->reg_code . $dest->reg_code;

                $number = $this->getnumber();
                $bagsNo = $source->reg_code . $dest->reg_code;
                @$trackNo = 'CD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

                $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$trans,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'acc_no'=>$accno,'sender_type'=>'Parcels-Post','track_number'=>$trackNo,'sender_type'=>'PARCEL BULK POSTING');
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);


            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'receiver_region'=>$region_to,'reciver_branch'=>$district,'receiver_fullname'=>$r_fname);

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
                 'Barcode'=>strtoupper($Barcode),
                'transactionstatus'=>'POSTED',
                 'bill_status'=>'BILLING',
                  // 'paymentFor'=>'MAIL',
                  'status'=>'Paid'

                );
           

            $db2 = $this->load->database('otherdb', TRUE); 
            $db2->insert('register_transactions',$trans);


             $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


             echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>SN</b></th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Branch Origin</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $sn=1;
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr class='".$value->Barcode."' style='width:100%;color:#343434;'><td>".$sn."</td><td>".$value->receiver_fullname."</td><td>".$value->sender_fullname."</td><td>".$value->sender_branch."</td><td>".$value->reciver_branch."</td><td>".$value->Barcode."</td> <td>".number_format($value->register_price,2)."</td>
                  <td>

                   
                   <button  
                   data-registerid='".$value->register_id."'
                   data-barcodeno='".$value->Barcode."' 
                   data-item_amount='".$value->register_price."' 
                   class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                 $sn++;
                }

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>
               

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b><input type='text' id='totalAmount' readonly value='".$alltotal."'/></b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                   
                        ";



               }

               


            
            

               

          

        }else{
            redirect(base_url());
        }
    }

public function save_parcel_post_application_bulk_info(){

        $id  = $this->session->userdata('user_login_id');
        $info = $this->employee_model->GetBasic($id);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;


          //Sender information
        $s_region = $this->input->post('s_region');
        $s_district = $this->input->post('s_district');
        $s_fullname = $this->input->post('s_fname');
        $s_address = $this->input->post('s_address');
        $s_mobile =  $this->input->post('s_mobile');
        $paidamount  = $this->input->post('paidamount');

        $serial = $this->input->post('serial');
        $operator = $this->input->post('operator');

             
        $renter   = $s_fullname;
        $serviceId = 'MAIL';

        $sender_region = $this->session->userdata('user_region');
        $sender_branch = $this->session->userdata('user_branch');

       
        $trackno   = $serial;


        if ($paidamount) {

             $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

            if (!empty($postbill->controlno)) {
           
                $update = array();
                $update = array(
                    'billid'=>$postbill->controlno,
                    'bill_status'=>'SUCCESS');

                $this->unregistered_model->update_register_transactions1($update,$serial);

                $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya  Parcel  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2).'';
        
                 $this->Sms_model->send_sms_trick($s_mobile,$sms);

                  $response['message'] = $sms;
          
            }else{
                $response['status'] = 'Error';
                $response['message'] = 'Control number aijatoka, wasiliana na wataalam wa ICT';
            }
            

        }else{
            $response['status'] = 'Error';
            $response['message'] = 'Hakuna tarrif iliyowekwa, rudia muamala au wasiliana na wataalam wa ICT';
        }

    print_r(json_encode($response));
}


    public function Oldsave_parcel_post_application_bulk_info()
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

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya  Parcel  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2).'';
           
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

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$repostbill->controlno.' Kwaajili ya huduma ya  Register  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2).'';

                 $this->Sms_model->send_sms_trick($s_mobile,$sms);
                 echo $sms;
                //$this->load->view('inlandMails/control-number-form',$data);    

                 //$this->session->set_flashdata('success','Saved Successfull');
                  
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


public function parcel_bulk_post_application_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            $data['list'] = $this->unregistered_model->get_parcel_post_application_list();
            $data['sum']  = $this->unregistered_model->get_parcel_post_sum_register();
             $data['askfor'] = $this->input->get('AskFor');
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
                    
                $this->load->view('inlandMails/parcel_bulk_post_application_list',$data);

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

                   $this->load->view('inlandMails/parcel_bulk_post_application_list',$data);
                }
            
    }else{

        redirect(base_url());
    }
}


public function parcel_mail_bulk_post_application_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
           
             $data['askfor'] = $this->input->get('AskFor');
            $check = $this->input->post('I');
            $db2 = $this->load->database('otherdb', TRUE);
            $ids = $this->session->userdata('user_login_id');
            $search = $this->input->post('search');

            if (empty($search)) {

             $data['list'] = $this->unregistered_model->get_mail_parcel_post_application_list();
            $data['sum']  = $this->unregistered_model->get_mail_parcel_post_sum_register();
          }

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
                    
                $this->load->view('inlandMails/parcel_mail_bulk_post_application_list',$data);

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
                           
                        $data['list'] = $this->unregistered_model->search_bulk_pacel_post_application_list($date,$month,$region,$branch,$status);
                        $data['sum']  = $this->unregistered_model->get_parcel_post_mail_sum_search($date,$month,$region,$branch,$status);
                       }else
                       {
                              $data['list'] = $this->unregistered_model->search_bulk_pacel_post_application_list($date,$month,$region,$branch,$status);
                                  $data['sum']  = $this->unregistered_model->get_parcel_post_mail_sum_search($date,$month,$region,$branch,$status);

                       }

                    
                  }

                   $this->load->view('inlandMails/parcel_mail_bulk_post_application_list',$data);
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


    public function save_small_packets_derivery(){
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
               $ident = $this->input->post('identifier');
               $name = $this->input->post('cname');
               $paidamount = $this->input->post('hndlcharges');
               $sender_region = $this->session->userdata('user_region');
               $sender_branch = $this->session->userdata('user_branch');
               $emid = $this->session->userdata('user_login_id');
               $s_mobile = $this->input->post('mobile_number');
               $Barcodez = $this->input->post('edValue');
               $Total = $this->input->post('Total');


               $serial    = 'Derivery'.date("YmdHis").$this->session->userdata('user_emid');

               if(!empty($_POST['Barcodes'])){
                $myArray = $_POST['Barcodes'];
                $Barcodes    = json_decode($myArray);
            
               }
                if($Total > 0){
            foreach ($Barcodes as $key => $variable) {

              $Barcode = $variable->barcode;

                              
               $data = array();
               $data = array(
                'identifier'=>$ident,
                'customer_name'=>$name,
                'amount'=>$paidamount,
                'region'=>$sender_region,
                'branch'=>$sender_branch,
                'mobile'=>$s_mobile,
                'Barcode'=>$Barcode,
                'operator'=>$emid);
               
               $db2 = $this->load->database('otherdb', TRUE);
               $db2->insert('derivery_info',$data);
               //update fgnsmall packets
               $this->FGN_Application_model->Update_small_packet_delivered_byBarcode($Barcode,$emid);

            $last_id = $db2->insert_id();
            
            $trans = array();
            
            
            $trans = array(
            'serial'=>$serial,
            'paidamount'=>$paidamount,
            'register_id'=>$last_id,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING');

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('derivery_transactions',$trans);

            }
          }else{


            $Barcode = $Barcodez;

                              
            $data = array();
            $data = array(
             'identifier'=>$ident,
             'customer_name'=>$name,
             'amount'=>$paidamount,
             'region'=>$sender_region,
             'branch'=>$sender_branch,
             'mobile'=>$s_mobile,
             'Barcode'=>$Barcode,
             'operator'=>$emid);
            
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('derivery_info',$data);
            //update fgnsmall packets
            $this->FGN_Application_model->Update_small_packet_delivered_byBarcode($Barcode,$emid);

         $last_id = $db2->insert_id();
         
         $trans = array();
         
         
         $trans = array(
         'serial'=>$serial,
         'paidamount'=>$paidamount,
         'register_id'=>$last_id,
         'transactionstatus'=>'POSTED',
         'bill_status'=>'PENDING');

         $db2 = $this->load->database('otherdb', TRUE);
         $db2->insert('derivery_transactions',$trans);


          }

            $renter   = $name;
            $serviceId = 'MAIL';
            $trackno = '009';
            $postbill='';
            if(!empty($_POST['Barcodes'])){
              $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);
              }

            //$postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

            //$controlno = $transaction->controlno;

            if (!empty(@$postbill->controlno)) {

                $serial = $postbill->billid;
                $update = array();
                $update = array(
                    'billid'=>$postbill->controlno,
                    'bill_status'=>'SUCCESS');
                $this->unregistered_model->update_delivery_transactions($update,$serial);

                $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Small Packets  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                
                $this->Sms_model->send_sms_trick($s_mobile,$sms);

                $results['status'] = 'Success';
                $results['message'] = $sms;

            }else{
                $results['message'] = 'Item yako imeshasajiliwa ila control number aijatoka, wasiliana na wataalam wa ICT';
            }
            
            print_r(json_encode($results));
        }else{
            redirect(base_url());
        }

    }

    public function Oldsave_small_packets_derivery(){
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

            $renter   =  $name;
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

    public function small_packet_deriver_application_list(){
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){



          /*$dates = $this->input->post('date');
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

         }*/


                //$data['region'] = $this->employee_model->regselect();
                $this->load->view('inlandMails/small_packet_deriver_application_list');

        }else{
            redirect(base_url());
        }

    }

    public function find_small_packet_deriver_application_list(){


          $fromdate = $this->input->post('fromdate');
          $todate = $this->input->post('todate');
          //$status = $this->input->post('status');
                    //$branch = $this->input->post('branch');
          //$region = $this->input->post('region');
          //$data['region'] = $this->employee_model->regselect();

               
           $data['list'] = $this->unregistered_model->new_get_parcel_post_delivery_application_Searchlist($fromdate,$todate);
           //$data['sum']  = $this->unregistered_model->get_parcel_post_sum_Search_delivery($dates,$month,$status,$region);
        
         
                 //$data['list'] = $this->unregistered_model->get_parcel_post_delivery_application_list();
                 //$data['sum']  = $this->unregistered_model->get_parcel_post_sum_delivery();

         
                 
       $this->load->view('inlandMails/small_packet_deriver_application_list',$data);
    
    }

    public function GetOthersmallpacketsbulkdetails()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
        {

           $serial = $this->input->post('serial');
           $list = $this->unregistered_model->get_bulk_small_packets_list($serial);
           
         
    

            if (empty($list)) {
                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Customer Name</th><th>Barcode </th><th>Mobile Number </th></tr>
                <tr><td colspan='3'>No Other item available</td></tr>
                </table>";

            }else{
                //echo json_encode($list);
                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Customer Name</th><th>Barcode </th><th>Mobile Number </th></tr>";
                $rows ="";

                foreach ($list as $value) {
                    
                $rows1 = "<tr><td>".$value->customer_name."</td><td>".$value->Barcode."</td><td>".$value->mobile."</td>";

                $rows =$rows.$rows1;
                }
                echo $rows;
                
                echo  "<tr><td></td><td></td><td></td></tr></table> ";

                
            }
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

    public function combine_bags_item_list_by_despatchno()
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
                    // $data['list'] = $this->unregistered_model->get_bags_list_by_despatch($despno);

                     $emslists = array();
                $mail= $this->unregistered_model->get_combine_bags_list_by_despatch_in($despno);
                 foreach ($mail as $key => $value) {

                  $emslists[] = $this->Bags_ViewModel->view_data($value->date_created,$value->bag_number, $value->bag_origin_region, $value->bag_branch_origin, $value->bag_region_to,
                    $value->bag_branch_to, $value->bag_weight,$value->item_number, $value->bags_status,$value->bag_id,$value->service_category, 'MAIL');
                }

                 $ems = $this->Box_Application_model->get_ems_bags_list_by_despatch($despno);
                 foreach ($ems as $key => $value) {

                  $emslists[] = $this->Bags_ViewModel->view_data($value->date_created,$value->bag_number, $value->bag_region_from, $value->bag_branch_from, $value->bag_region,
               $value->bag_branch, $value->bag_weight,$value->item_number, $value->bags_status,$value->bag_id, $value->ems_category, 'EMS');
                }

                $data['list'] =$emslists;

                  } else {
                    //$data['list'] = $this->unregistered_model->get_bags_list_by_despatch_out($despno);


                     $emslists = array();
                $mail= $this->unregistered_model->get_combine_bags_list_by_despatch_out($despno);
                 foreach ($mail as $key => $value) {

                  $emslists[] = $this->Bags_ViewModel->view_data($value->date_created,$value->bag_number, $value->bag_origin_region, $value->bag_branch_origin, $value->bag_region_to,
                    $value->bag_branch_to, $value->bag_weight,$value->item_number, $value->bags_status,$value->bag_id,$value->service_category, 'MAIL');
                }

                 $ems = $this->Box_Application_model->get_ems_bags_list_by_despatch_out($despno);
                 foreach ($ems as $key => $value) {

                  $emslists[] = $this->Bags_ViewModel->view_data($value->date_created,$value->bag_number, $value->bag_region_from, $value->bag_branch_from, $value->bag_region,
               $value->bag_branch, $value->bag_weight,$value->item_number, $value->bags_status,$value->bag_id, $value->ems_category, 'EMS');
                }

                $data['list'] =$emslists;
                  }
                  
                  $this->load->view('inlandMails/combine_bags_item_list_by_despatchno',$data);

        }else{
            redirect(base_url());
        }

    }

    public function item_list_by_bag_no(){
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
                    //$data['list'] = $this->unregistered_model->get_register_application_list_back_by_bagno($bagno);
                    $data['list'] = $this->unregistered_model->get_register_bag_items_by_bagno($bagno);

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



     public function registered_international_List(){
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();

           $this->load->view('inlandMails/registered_international_List',$data);
        } else {
            redirect(base_url());
        }
        
    }

     public function search_registered_international_List(){
        if ($this->session->userdata('user_login_access') != false) {
            $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
            $todate = date("Y-m-d",strtotime($this->input->post('todate')));
            $result =  $this->unregistered_model->list_registered_international_list_search($fromdate,$todate);
            if($result){
            $data['list'] = $this->unregistered_model->list_registered_international_list_search($fromdate,$todate);
            $this->load->view('inlandMails/registered_international_List',$data);
            }
            else{
            $this->session->set_flashdata('message','Report not found, Please try again');  
            redirect($this->agent->referrer());
            }

           
        } else {
            redirect(base_url());
        }
        
    }

    
    /*
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
    */


    public function registered_bulk_international_transaction_List()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
          $data['region'] = $this->employee_model->regselect();

             $data['list'] = $this->unregistered_model->get_International_register_application_list();
             $data['sum']  = $this->unregistered_model->get_sum_international_register();

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
                    
                $this->load->view('inlandMails/register-international-application-list',$data);

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

                    $data['list'] = $this->unregistered_model->search_register_international_application_list($date,$month,$status,$branch,$region);
                    $data['sum']  = $this->unregistered_model->get_international_register_sum_search($date,$month,$status,$branch,$region);
                  }
                   $this->load->view('inlandMails/register-international-application-list',$data);
                }
            
    }else{

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



public function Save_registered_international(){
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
            'Created_byId'=>$info->em_code);

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
            $renter   = 'RDP/FPl';
            $serviceId = 'MAIL';
            $trackno = '009'.$bagsNo;


            $transaction = $this->getBillGepgBillIdStamp($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
            $serial1 = $serial;

            if (!empty($transaction->controlno)) {

                $update = array(
                    'billid'=>$transaction->controlno,
                    'bill_status'=>'SUCCESS');

                $this->billing_model->update_transactions($update,$serial1);

                $first4 = substr($transaction->controlno, 4);
                $trackNo = '90'.$bagsNo.$first4;

                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                 $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Registered International,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                $this->Sms_model->send_sms_trick($mobile,$sms);

                $results['status'] = 'Success';
                $results['message'] = $sms;

            }else{
                 $results['message'] = 'Item yako imeshasajiliwa ila control number aijatoka, wasiliana na wataalam wa ICT';
            }

            print_r(json_encode($results));
        } else {
            redirect(base_url());
        }    
}



 public function OldSave_registered_international()
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

 public function Outbound_Ems_Exchange(){  
        if ($this->session->userdata('user_login_access') != false) {

            $this->load->view('ems/Outbound_ems_exchange_dashboard');

        }else{
            redirect(base_url());
        }

        
    }
     public function inbound_Ems_Exchange(){  
        if ($this->session->userdata('user_login_access') != false) {

            $this->load->view('ems/inbound_ems_exchange_dashboard');

        }else{
            redirect(base_url());
        }

        
    }
     public function Outbound_Exchange(){  
        if ($this->session->userdata('user_login_access') != false) {

            $this->load->view('inlandMails/outbound-exchange-dashboard');

        }else{
            redirect(base_url());
        }

        
    }
     public function inbound_Exchange(){  
        if ($this->session->userdata('user_login_access') != false) {

            $this->load->view('inlandMails/inbound-exchange-dashboard');

        }else{
            redirect(base_url());
        }

        
    }

     public function inbound_mail_Exchange(){  
        if ($this->session->userdata('user_login_access') != false) {

            $this->load->view('inlandMails/inbound-mail-exchange-dashboard');

        }else{
            redirect(base_url());
        }

        
    }
    public function outbound_mail_Exchange(){  
        if ($this->session->userdata('user_login_access') != false) {

            $this->load->view('inlandMails/outbound-mail-exchange-dashboard');

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

////////////////////////////////////////////////////////

public function international_register_sender_bulk_info_bill()
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
               $serial    = 'RegisterINT'.date("YmdHis").$this->session->userdata('user_emid');

            }
           

            $id = $emid = $this->session->userdata('user_login_id');
            $catid = $this->input->post('catid');
              $itmnumber = $this->input->post('itmnumber');
               $Barcode = $this->input->post('Barcode');

            //$askfor = $this->input->get('AskFor');
            $askfor = $this->input->post('askfor');

            $price1 = $this->input->post('price');
            $I = $this->input->post('crdtid');
            $accno = $this->input->post('acc_no');

            $price = $this->unregistered_model->unregistered_international_cat_price($type,$weight,$catid);
            $getdestination = $this->unregistered_model->Get_International_register_country($catid);
            $rec_region =$getdestination->c_name;
            $rec_dropp = $getdestination->c_zoneid;


            
            if ($type == "Document"){
               $paidamount = $Total = $price->total;
            } else {

                $paidamount = $Total = $price;
                
            }
            

             $rondom = substr(date('dHis'), 1);
              $billcode = '7';//bag code in tracking number
              $source = $this->employee_model->get_code_source($sender_region);
              // $dest = $this->employee_model->get_code_dest($rec_region);

             $number = $this->getnumber();
              //$bagsNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

              $bagsNo = $source->reg_code . $source->reg_code;
              @$trackNo = 'RD'.@$source->reg_code . @$source->reg_code.$number.'TZ';

            if ($askfor == "MAILS") {

              $diffp = $price1-$paidamount;

              if ($diffp > 0) {
                
              $sender = array();//,'acc_no'=>$itmnumber
              $sender = array('sender_type'=>'International','sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'add_type'=>$addressT,'track_number'=>$trackNo);
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
             'Barcode'=>strtoupper($Barcode),
            'paidamount'=>$Total,
            'register_id'=>$last_id,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'BILLING'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('register_transactions',$trans);



              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


            echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td> <td>".@$value->Barcode."</td> <td>".number_format($value->register_price,2)."</td><td>
                   <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button></td></tr>";
                }

              
               
                 
              echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name='crdtid' id='crdtid'   value=".@$custinfo->credit_id.">
                <input type='hidden' name='askfor' id='askfor'  value=".@$askfor.">
                <input type='hidden' name='price' id='price'  value=".@$custinfo->price.">
                <input type='hidden' name='accno' id='accno'  value=".@$custinfo->acc_no.">

                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                 ";



              } 
              
                   // redirect(base_url('Bill_Customer/bill_customer_list?AskFor=MAILS'));

            }else {
                $sendertype='International';
             $sender = array();//,'acc_no'=>$itmnumber
              $sender = array('sender_type'=>$sendertype,'sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'add_type'=>$addressT,'track_number'=>$trackNo);
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
             'Barcode'=>strtoupper($Barcode),
            'register_id'=>$last_id,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'BILLING'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('register_transactions',$trans);


              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


             echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination </b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td> <td>".@$value->Barcode."</td> <td>".number_format($value->register_price,2)."</td><td>
                   <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button></td></tr>";
                }

              
               
                 
              echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name='crdtid' id='crdtid'   value=".@$custinfo->credit_id.">
                <input type='hidden' name='askfor' id='askfor'  value=".@$askfor.">
                <input type='hidden' name='price' id='price'  value=".@$custinfo->price.">
                <input type='hidden' name='accno' id='accno'  value=".@$custinfo->acc_no.">

                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                 ";

                       

                         // <input type='hidden' name ='serial' value='$emsprice' class='price1'>


            }
            
       
    }
  
}





public function save_internation_register_sender_bulk_info_bill()
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

                  $alltotal =$alltotal + $value->register_price;   $s_mobile = $value->sender_mobile;
   
                
                $data = array();
                $data = array('track_no'=>$value->track_number,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);


                  $sms ='KARIBU POSTA KIGANJANI umepatiwa track number hii hapa'. ' '.$value->track_number.' Kwaajili ya huduma ya  Register International '.'';
                  $this->Sms_model->send_sms_trick($s_mobile,$sms);
              }

             


          

}

///////////////////////////////////////////////////////

    
}