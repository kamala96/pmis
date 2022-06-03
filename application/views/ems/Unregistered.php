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
        $this->load->model('job_assign_model');
    }
    
	public function Dashboard()
	{
		#Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            
			$this->load->view('inlandMails/unregistered_dashboard');
	}

    public function unregistered_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)

              $ids = $this->session->userdata('user_login_id');
              $checkJobAssign = $this->unregistered_model->check_job_assign($ids);
              if ($this->session->userdata('user_type') == "ADMIN") {
                    $data['ems_cat'] = $this->Box_Application_model->ems_cat();
               $this->load->view('inlandMails/unregistered_form',$data);
              } else {
                  if (empty($checkJobAssign)) {
                  $data['message'] = "Please Contact your supervisor to assign a job/task for today date";
                  $this->load->view('inlandMails/supervisor-sms-contact',$data);
              } else {

               $data['ems_cat'] = $this->Box_Application_model->ems_cat();
               $this->load->view('inlandMails/unregistered_form',$data);

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

    public function register_sender_info()
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
            
            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid);
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

            $renter   = $type.'_Register';
            $serviceId = 'EMS_POSTAGE';
            $trackno = '009';
            $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

            //$controlno = $transaction->controlno;

            if (!empty($postbill->controlno)) {

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($o_region);
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

                $data['sms'] = $sms ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya '.$type.' Register  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
           
            //if (!empty($transaction->$controlno)) {
                
                $this->load->view('inlandMails/control-number-form',$data);
                
                $this->Sms_model->send_sms_trick($s_mobile,$sms);
            }else{

                $repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno); 

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($o_region);
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

                $data['sms'] = $sms ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya '.$type.' Register  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                $this->load->view('inlandMails/control-number-form',$data);    
            }

        }else{
            redirect(base_url());
        }
    }

    public function register_application_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            $data['list'] = $this->unregistered_model->get_register_application_list();
            $data['sum']  = $this->unregistered_model->get_sum_register();
            $check = $this->input->post('I');
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

                  }
                   $this->load->view('inlandMails/register-application-list',$data);
                }
            
    }else{

        redirect(base_url());
    }
}

    public function registered_domestic_dashboard()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $data['ems'] = $this->unregistered_model->count_ems();
            $data['bags'] = $this->unregistered_model->count_bags();
            $data['recieved'] = $this->unregistered_model->count_item_received();
            $data['list'] = $this->unregistered_model->get_register_application_list_back();
            $this->load->view('inlandMails/registered-domestic-dashboard',$data);

        }else{
                redirect(base_url());
            }
    }

    public function registered_domestic_received_item()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $data['ems'] = $this->unregistered_model->count_ems();
            $data['recieved'] = $this->unregistered_model->count_item_received();
            $data['list'] = $this->unregistered_model->get_register_application_list_back_received();
            $this->load->view('inlandMails/registered-domestic-back_received',$data);

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

    public function close_item_in_bag()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $check = $this->input->post('I');
            $sender_region = $this->session->userdata('user_region');
            $emid = $this->session->userdata('user_login_id');
            $sender_branch = $this->session->userdata('user_branch');
            $o_region = $this->input->post('region_to');
            $branch_to = $this->input->post('branch_to');
            $bag_weight = $this->input->post('number');
            $source = $this->employee_model->get_code_source($sender_region);
            $dest = $this->employee_model->get_code_dest($o_region);
            $number = rand(100000000,200000000);
            $bagsNo = $source->reg_code . $dest->reg_code . $number;


            if (!empty($check)) {

                $save = array();
                $save = array(
                              'bag_number'=>$bagsNo,
                              'bag_origin'=>$o_region,
                              'bag_branch'=>$branch_to,
                              'bag_region_from'=>$sender_region,
                              'bag_branch_from'=>$sender_branch,
                              'bag_created_by'=>$emid
                              );
                $this->unregistered_model->save_mails_bags($save);

                 for ($i=0; $i <@sizeof($check) ; $i++) {

                     $last_id = $check[$i];
                     $trackno = array();
                     $trackno = array('sender_bag_number'=>$bagsNo,'sender_status'=>'Bag');
                     $this->unregistered_model->update_sender_info($last_id,$trackno);
                 }
            $sum = $this->unregistered_model->get_sum_weight($bagsNo);
            $weight = $sum->register_weght + $bag_weight;

            $upbag = array();
            $upbag = array('bag_weight'=>$weight);
            $this->unregistered_model->update_bag_info($upbag,$bagsNo);

            $data['message'] = "Item Closed In Bag";
            } else {
                $data['errormessage'] = "Please Select Atleast One Item To Receive";
            }
            
            $data['ems'] = $this->unregistered_model->count_ems();
            $data['recieved'] = $this->unregistered_model->count_item_received();
            $data['list'] = $this->unregistered_model->get_register_application_list_back_received();
            $this->load->view('inlandMails/registered-domestic-back_received',$data);
            
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
}