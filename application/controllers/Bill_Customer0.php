 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bill_Customer extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('employee_model');
        $this->load->model('Bill_Customer_model');
        $this->load->model('unregistered_model');
        $this->load->model('job_assign_model');
        $this->load->model('Box_Application_model');
        $this->load->model('Control_Number_model');
    }
    
	public function bill_customer_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') !=false){
           $crdtid = base64_decode($this->input->get('I'));
           $data['askfor'] = $this->input->get('AskFor');
           $this->session->set_userdata('askfor',@$askfor);
           $data['edit'] = $this->Bill_Customer_model->get_customer_bill_credit_by_id($crdtid);
            $this->load->view('inlandMails/bill-customer-register-form',$data);
            
            }else{
                redirect(base_ur());
            }
    }

    public function service_to_other()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $data['cust'] = base64_decode($this->input->get('I'));
            $data['region'] = $this->employee_model->regselect();

            $custid = $this->input->post('cust_name');
            $regid  = $this->input->post('reg');
            $braid  = $this->input->post('branch');
            $data['cust1'] = $this->input->post('cust_name');

            for ($i=0; $i <@sizeof($regid) ; $i++) {

               $insert = array();
               $insert = array('customer'=>$custid,'region'=>$regid[$i],'branch'=>$braid[$i]);
               $this->Bill_Customer_model->save_region_branch($insert);

               $data['message'] = "Item Saved"; 
            }

            $this->load->view('inlandMails/service-to-other-region-branch',$data);

         }else{
            redirect(base_url());
         }
           
    }
    
    public function bill_customer_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

           // $data['bill'] = $this->Bill_Customer_model->get_all_bill_customer_saved_to();
            $AskFor = $this->input->get('AskFor');
            $this->session->set_userdata('askfor',$AskFor);
            
            $data['check'] = $this->Bill_Customer_model->check_credit_customer($AskFor);
            if($AskFor == 'MAILS')
            {
                $this->load->view('inlandMails/bill-customer-list',$data);

            }else
            {
                $this->load->view('inlandMails/bill-customer-list-Ems',$data);
            }
            

         }else{
            redirect(base_url());
         }
           
    }

    public function Prepare_Customer_Bills(){
            if ($this->session->userdata('user_login_access') != false){

            $I = base64_decode($this->input->get('I'));
            $data['askfor'] = $askfor = $this->input->get('AskFor');
            $month =    $this->input->post('datetime'); 
            $info = $this->Box_Application_model->get_customer_infos($I);
            $acc_no = $info->acc_no;
            $data['acc_no'] = $acc_no;
            $data['month'] = $month;
            $data['credit_id'] = $I;
            $type   = $info->customer_type;
            $data['type1'] = $info->customer_type;
            $data['tinnumber'] = $info->tin_number;
            
            $data['emslist'] = $this->Bill_Customer_model->get_credit_customer_list_byAccnoMonth($acc_no,$month);
        $data['sum'] = $this->Bill_Customer_model->get_credit_customer_sum_byAccnoMonth($acc_no,$month,$askfor);
            $this->load->view('inlandMails/bill_customer_list_mail',$data);
            }
            else{
                redirect(base_url());
                }

            }


            public function Credit_Customer_Prepare_Bill(){
            if ($this->session->userdata('user_login_access') != false){

            $I = base64_decode($this->input->get('I'));
            $data['askfor'] = $askfor = $this->input->get('AskFor');
            $month =    $this->input->post('datetime'); 
            $info = $this->Box_Application_model->get_customer_infos($I);
            $acc_no = $info->acc_no;
            $data['acc_no'] = $acc_no;
            $data['month'] = $month;
            $data['credit_id'] = $I;
            $type   = $info->customer_type;
            $data['type1'] = $info->customer_type;
            $data['tinnumber'] = $info->tin_number;

            $data['emslist'] = $this->Box_Application_model->get_credit_customer_list_byAccnoMonth($acc_no,$month);
            $data['sum'] = $this->Box_Application_model->get_credit_customer_sum_byAccnoMonth($acc_no,$month,$askfor);

            if($askfor ='MAILS')
            {
                $this->load->view('inlandMails/bill_customer_list_mail',$data);

            }else{
                $this->load->view('inlandMails/bill_customer_list',$data);

            }

            
            }
            else{
                redirect(base_url());
                }

            }


public function Credit_Customer_Search(){
    if ($this->session->userdata('user_login_access') != false){

        $I = $this->input->post('acc_no');
        $month =    $this->input->post('datetime'); 

        $info = $this->Box_Application_model->get_customer_infos1($I);
        $acc_no = $I;
        $data['acc_no'] = $acc_no;
        $data['credit_id'] = $I;
        $type   = $info->customer_type;
        $data['type1'] = $info->customer_type;
        $data['tinnumber'] = $info->tin_number;
        $data['emslist'] = $this->Box_Application_model->get_credit_customer_list_byAccnoMonth($acc_no,$month);
        $data['sum'] = $this->Box_Application_model->get_credit_customer_sum_byAccnoMonth($acc_no,$month);
        $this->load->view('ems/bill_customer_list',$data);
        }
        else{
        redirect(base_url());
            }

    }

    public function bill_transactions_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $cusname = $this->input->post('custname');
            $status = $this->input->post('status');
            if (!empty($cusname)) {
               $data['billing'] = $this->Bill_Customer_model->get_bill_transactions_list_search($cusname,$status);
            } else {
                $data['billing'] = $this->Bill_Customer_model->get_bill_transactions_list();
            }
            
            $this->load->view('inlandMails/customer-bill-transactions-list',$data);

         }else{
            redirect(base_url());
         }
           
    }

    public function bill_transactions_list_postal_global()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $cusname = $this->input->post('custname');
            $status = $this->input->post('status');
            if (!empty($cusname)) {
               $data['billing'] = $this->Bill_Customer_model->get_bill_transactions_list_search_posta_global($cusname,$status);
            } else {
                $data['billing'] = $this->Bill_Customer_model->get_bill_transactions_list_posta_global();
            }
            
            $this->load->view('inlandMails/customer-bill-transactions-list-posta-global',$data);

         }else{
            redirect(base_url());
         }
           
    }

    public function bill_transactions_process()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $cust = base64_decode($this->input->get('I'));
            $data['bill'] = $this->Bill_Customer_model->get_bill_customer_by_id($cust);
            $this->load->view('inlandMails/bill-transactions-process-form',$data);

         }else{
            redirect(base_url());
         }
           
    }

    public function Prepare_Customer_Bill()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $cust = base64_decode($this->input->get('I'));
            $data['bill'] = $this->Bill_Customer_model->get_bill_customer_by_id($cust);
            $this->load->view('inlandMails/bill-transactions-process-form',$data);

         }else{
            redirect(base_url());
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
            $amount = $this->input->post('amount');
            
            $id = $emid = $this->session->userdata('user_login_id');

            $price = $this->unregistered_model->unregistered_cat_price($type,$weight);
            $paidamount = $Total = $price->price + $price->s_charge + $price->s_vat;
            $remain = $amount-$paidamount;
            $custid = $this->input->post('custid');

            $cid = array();
            $cid = array('price'=>$remain);
            $this->Bill_Customer_model->update_customer_price($custid,$cid);

            $source = $this->employee_model->get_code_source($sender_region);
            $dest = $this->employee_model->get_code_dest($o_region);
            $bagsNo = $source->reg_code . $dest->reg_code;
            $number = rand(100000000,200000000);
            $first4 = substr($number, 4);
            $trackNo = $bagsNo.$first4;

            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'payment_type'=>'Bill','track_number'=>$trackNo);
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);


            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$region_to,'reciver_branch'=>$district,'receiver_fullname'=>$r_fname,'receiver_mobile'=>$r_mobile);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('receiver_register_info',$receiver);

            redirect('bill_customer/bill_customer_list');
            
        }else{
            redirect(base_url());
        }
    }

    public function register_bill_transaction_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            $data['list'] = $this->Bill_Customer_model->get_register_bill_list();
            $data['sum']  = $this->Bill_Customer_model->get_sum_register();
            $check = $this->input->post('I');
            $data['askfor'] = $this->input->get('AskFor');
            $db2 = $this->load->database('otherdb', TRUE);
            $ids = $this->session->userdata('user_login_id');

            if (!empty($check)) {

                if (!empty($this->input->post('backofice'))) {

                    for ($i=0; $i <@sizeof($check) ; $i++) {

                      $id = $check[$i];
                      // $checkPay = $this->unregistered_model->check_payment($id);
                      //   if (!empty($checkPay)) {
                        $last_id = $check[$i];
                        $trackno = array();
                        $trackno = array('sender_status'=>'Back');
                        $this->unregistered_model->update_sender_info($last_id,$trackno);
                        $data['message'] = "Successfull Sent To Back Office";
                    // }else{
                    //     $data['errormessage'] = "Please Some Item Not Paid";
                    // }
                    
                }
                    
                $this->load->view('inlandMails/register-bill-transactions-list',$data);

                }elseif (!empty($this->input->post('qrcode'))) {
                
                for ($i=0; $i <@sizeof($check) ; $i++) {

                 $id = $check[$i];
                // $checkPay = $this->unregistered_model->check_payment($id);
                //         if (!empty($checkPay)) {
                           $getTrack = $this->unregistered_model->getTrackNo($id);
                           $data1[] = $getTrack->track_number;
                        // } else{
                        //     $data1[] = '';
                        // }
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

                    $checkItemStatus = $this->Bill_Customer_model->check_item_status($ids);
                    if (!empty($checkItemStatus)) {

                        $data['errormessage'] = "Shift Not End Propery Clear Item Either Payment Or Send To Backoffice";

                    }else{

                        @$getCI =  $this->unregistered_model->check_job_assign($ids);
                        @$task_id = @$getCI->task_id;
                        $db2->set('status', 'OFF');//if 2 columns
                        $db2->where('task_id', @$task_id);
                        $db2->update('taskjobassign');

                        $counter1 = @$getCI->counter_id;
                        $csup1 = array();
                        $csup1 = array('c_status'=>'NotAssign');
                        $this->job_assign_model->Update_Counterss($csup1,$counter1);

                        //$data['message'] = "Successfull Shift End";

                        redirect('dashboard/dashboard');
                    }

                  }
                   $this->load->view('inlandMails/register-bill-transactions-list',$data);
                }
            
    }else{

        redirect(base_url());
    }
}
    public function GetBranch(){

      if ($this->input->post('region_id') != '') {
          
          echo $this->Bill_Customer_model->GetBranchById($this->input->post('region_id'));
      }

    }

public function Customer_Register(){
    
    if ($this->session->userdata('user_login_access') != false){

    $id = $this->session->userdata('user_login_id');
    $basic = $this->employee_model->GetBasic($id);
    $service = $this->input->post('service_type');
    $name = $this->input->post('cust_name');
    $mobile = $this->input->post('cust_mobile');
    $tinnumber = $this->input->post('tin_number');
    $address = $this->input->post('cust_address');
    $paytype = $this->input->post('payment_type');
    $price = $this->input->post('price');
    $rvn = $this->input->post('vrn');
    $askfor = $this->input->get('AskFor');
    $this->session->set_userdata('askfor',$askfor);
    $id = $this->session->userdata('user_login_id');
    $info = $this->employee_model->GetBasic($id);
    $operator = $info->em_id;
    $o_region = $info->em_region;
    $o_branch = $info->em_branch;
    $branch   = $this->input->post('branch');
    $category_type = $this->input->post('category_type');
    $accno   = $this->input->post('accno');
    $I   = $this->input->post('crdtid');
    $branch = $this->input->post('branch');

    if ($paytype == "PostPaid") {

    if (!empty($I)) {
        
       $save = array();
       $save = array('customer_name'=>$name,'customer_type'=>$paytype,'services_type'=>$service,'customer_region'=>$o_region,'customer_branch'=>$o_branch,'created_by'=>$operator,'cust_mobile'=>$mobile,'customer_address'=>$address,'price'=>$price,'tin_number'=>$tinnumber,'vrn'=>$rvn);

       if (empty($branch))
       {
         $this->Bill_Customer_model->update_credit_bill_customer($save,$I);
       } else {

          $this->Box_Application_model->delete_entries($accno);

          for ($i=0; $i <sizeof(@$branch) ; $i++)
          { 

            @$bra =  @$branch[$i];
            //$this->Box_Application_model->delete_entries($accno,$reg,$bra);
            $getregion = $this->employee_model->getRegion($bra);

            foreach ($getregion as  $value) {

                $reg = $value->region_name;
                
                $save1 = array();
                $save1 = array(

                        'acc_no'=>$accno,
                        'customer_region'=>$value->region_name,
                        'customer_branch'=>$value->branch_name
                    );

            $this->Bill_Customer_model->save_credit_bill_branch_customer($save1);

            }

          }

       }

        } else {

        $last = $this->Box_Application_model->check_if_any($paytype);

        if (empty($last)) {

        $data = array();
        $data = array('number'=>1,'cust_type'=>$paytype);
        $this->Box_Application_model->Save_number_info($data);
        $accnumber = strtoupper($paytype).'-'.'1';

        } else {

        $number = $last->number + 1;
        $accnumber = strtoupper($paytype).'-'.$number;
        $ids     = $last->no_id;

        $data = array();
        $data = array('number'=>$number,'cust_type'=>$paytype);
        $this->Box_Application_model->Save_number_info($data);

        }   
     
       $save = array();
       $save = array('acc_no'=>$accnumber,'customer_name'=>$name,'customer_type'=>$paytype,'services_type'=>$service,'customer_region'=>$o_region,'customer_branch'=>$o_branch,'created_by'=>$operator,'cust_mobile'=>$mobile,'customer_address'=>$address,'price'=>$price,'tin_number'=>$tinnumber,'vrn'=>$rvn);

       if (empty($branch))
       {

           $this->Bill_Customer_model->save_credit_bill_customer($save);

       } else {

          $this->Bill_Customer_model->save_credit_bill_customer($save);

          for ($i=0; $i <sizeof(@$branch) ; $i++) 
          { 

            @$bra =  @$branch[$i];
            $getregion = $this->employee_model->getRegion($bra);

            foreach ($getregion as  $value) {
                
                $save1 = array();
                $save1 = array(

                        'acc_no'=>$accnumber,
                        'customer_region'=>$value->region_name,
                        'customer_branch'=>$value->branch_name
                    );

            $this->Bill_Customer_model->save_credit_bill_branch_customer($save1);

            }

          }

       }
        }
        
      $this->session->set_flashdata('message','Successfully Customer Saved');
      redirect(base_url('Bill_Customer/bill_customer_form?I='.base64_encode($I).'&&'.'AskFor='.$askfor),'refresh');

    }else {
       
    if (!empty($I)) {
        
       $save = array();
       $save = array('customer_name'=>$name,'customer_type'=>$paytype,'services_type'=>$service,'customer_region'=>$o_region,'customer_branch'=>$o_branch,'created_by'=>$operator,'cust_mobile'=>$mobile,'customer_address'=>$address,'price'=>$price,'tin_number'=>$tinnumber,'vrn'=>$rvn);

       if (empty($branch))
       {
         $this->Bill_Customer_model->update_credit_bill_customer($save,$I);
       } else {

          $this->Box_Application_model->delete_entries($accno);

          for ($i=0; $i <sizeof(@$branch) ; $i++)
          { 

            @$bra =  @$branch[$i];
            //$this->Box_Application_model->delete_entries($accno,$reg,$bra);
            $getregion = $this->employee_model->getRegion($bra);

            foreach ($getregion as  $value) {

                $reg = $value->region_name;
                
                $save1 = array();
                $save1 = array(

                        'acc_no'=>$accno,
                        'customer_region'=>$value->region_name,
                        'customer_branch'=>$value->branch_name
                    );

            $this->Bill_Customer_model->save_credit_bill_branch_customer($save1);

            }

          }

       }

        } else {

        $last = $this->Box_Application_model->check_if_any($paytype);

        if (empty($last)) {

        $data = array();
        $data = array('number'=>1,'cust_type'=>$paytype);
        $this->Box_Application_model->Save_number_info($data);
        $accnumber = strtoupper($paytype).'-'.'1';

        } else {

        $number = $last->number + 1;
        $accnumber = strtoupper($paytype).'-'.$number;
        $ids     = $last->no_id;

        $data = array();
        $data = array('number'=>$number,'cust_type'=>$paytype);
        $this->Box_Application_model->Save_number_info($data);

        }   
     
       $save = array();
       $save = array('acc_no'=>$accnumber,'customer_name'=>$name,'customer_type'=>$paytype,'services_type'=>$service,'customer_region'=>$o_region,'customer_branch'=>$o_branch,'created_by'=>$operator,'cust_mobile'=>$mobile,'customer_address'=>$address,'price'=>$price,'tin_number'=>$tinnumber,'vrn'=>$rvn);

       if (empty($branch))
       {

           $this->Bill_Customer_model->save_credit_bill_customer($save);

       } else {

          $this->Bill_Customer_model->save_credit_bill_customer($save);

          for ($i=0; $i <sizeof(@$branch) ; $i++) 
          { 

            @$bra =  @$branch[$i];
            $getregion = $this->employee_model->getRegion($bra);

            foreach ($getregion as  $value) {
                
                $save1 = array();
                $save1 = array(

                        'acc_no'=>$accnumber,
                        'customer_region'=>$value->region_name,
                        'customer_branch'=>$value->branch_name
                    );

            $this->Bill_Customer_model->save_credit_bill_branch_customer($save1);

            }

          }

       }
        }
        
      $this->session->set_flashdata('message','Successfully Customer Saved');
      redirect(base_url('Bill_Customer/bill_customer_form?I='.base64_encode($I).'&&'.'AskFor='.$askfor),'refresh');

    }

    }else{
        redirect(base_url());
        }
    }

    

    public function getControlNo(){

    if ($this->session->userdata('user_login_access') != false){

        $crdtid = $this->input->post('crdid');
        
        $info = $this->Bill_Customer_model->get_customer_bill_credit_by_id($crdtid);

        $o_region = $info->customer_region;
        $rec_region = $info->customer_branch;
        $id = $this->session->userdata('user_login_id');
        $source = $this->employee_model->get_code_source($o_region);
        $dest = $this->employee_model->get_code_dest($rec_region);

        $bagsNo = @$source->reg_code . @$dest->reg_code;
        $serial = 'B'.date("dHs").$source->reg_code.$id;

        $data = array();
        $data = array(

        //'transactiondate'=>$date_time,
        'serial'=>$serial,
        'paidamount'=>$info->price,
        'CustomerID'=>$info->credit_id,
        'Customer_mobile'=>$info->cust_mobile,
        'region'=>$info->customer_region,
        'district'=>$info->customer_branch,
        'transactionstatus'=>'POSTED',
        'bill_status'=>'PENDING',
        'paymentFor'=>'EMSBILLING',
        'customer_acc'=>$info->acc_no

    );

    $this->Box_Application_model->save_transactions($data);

    $paidamount = $info->price;
    $district   = $info->customer_branch;
    $region     = $info->customer_region;
    $mobile     = $info->cust_mobile;
    $renter     = 'EmsBilling';
    $serviceId  = 'EMS_POSTAGE';
    $trackno    = 6;

    $transaction = $this->Control_Number_model->get_control_number($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
    @$serial1 = $transaction->billid;

    $update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
    $this->Box_Application_model->update_transactions($update,$serial1);

     echo @$transaction->controlno;

    }   else{
        redirect(base_url());
    }

}
    
}