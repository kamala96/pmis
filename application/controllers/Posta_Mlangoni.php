 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posta_Mlangoni extends CI_Controller {

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
          $this->load->model('Posta_Mlangoni_Model');
		
		#Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') != 1){
		redirect(base_url());	
		}
		
    }

public function checkBarcodeIsReuse(){
        if ($this->session->userdata('user_login_access') != false) {
            $Barcode = $this->input->post('barcode');

            $checkdata = $this->Posta_Mlangoni_Model->check_barcode($Barcode);

            if(!empty($checkdata)) {
                $res['status'] = 'available';
                $res['message'] = 'Barcode hii '.$checkdata['Barcode'].' Imeshatumika';
            }else{
                 $res['status'] = 'not available';
                 $res['message'] = 'not used';
            }
            //response
            print_r(json_encode($res));

        }else{
            redirect(base_url());
        }
    }
	
	//Posta Mlangoni Bill Customer List
    public function bill_customer_list()
    {
            $AskFor = $this->input->get('AskFor');
            $billtype = $this->input->post('billtype'); //Posta Mlangoni
            $this->session->set_userdata('askfor',$AskFor);
            $data['region'] = $this->employee_model->regselect();
            $data['check'] = $this->Bill_Customer_model->check_credit_customer($AskFor);
            if(empty($billtype)){
            $data['billtype']=$AskFor;
            }else{$data['billtype']=$billtype;}
            $this->load->view('Posta_Mlangoni/bill-customer-list',@$data);
    }
	
	//Search Bill Customer
	public function bill_customer_list_Search()
    {
            $AskFor = $this->input->post('AskFor');
            $this->session->set_userdata('askfor',$AskFor);
            $billtype = $this->input->post('billtype'); //Register  Parcel

                $id = $this->session->userdata('user_login_id');
                $info = $this->employee_model->GetBasic($id);
                $region2 =$info->em_region;
                $branch = $info->em_branch;
                $o_region = $this->session->userdata('user_region');
    
           $custname = $this->input->post('custname');
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');
           $data['region'] = $this->employee_model->regselect();

           $data['check'] = $this->Bill_Customer_model->check_credit_customer_search_employee($AskFor,$region,$month,$date,$custname);
           if(empty($billtype)){
           $data['billtype']=$AskFor;
           }else{$data['billtype']=$billtype;}
           $this->load->view('Posta_Mlangoni/bill-customer-list',$data);    
    }
	
	//Route to add Posta Mlangoni Bill Customer
	    public function bill_customer_form()
    {
        #Redirect to Admin dashboard after authentication
           $crdtid = base64_decode($this->input->get('I'));
           $data['askfor'] = $this->input->get('AskFor');
           $this->session->set_userdata('askfor',@$askfor);
           $data['edit'] = $this->Bill_Customer_model->get_customer_bill_credit_by_id($crdtid);
           $this->load->view('Posta_Mlangoni/bill-customer-register-form',$data);
    }
	
	//Add Posta Mlangoni Customer
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

     
     redirect(base_url('Posta_Mlangoni/bill_customer_form?I='.base64_encode($I).'&&'.'AskFor='.$askfor),'refresh');


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
     
                 redirect(base_url('Posta_Mlangoni/bill_customer_form?I='.base64_encode($I).'&&'.'AskFor='.$askfor),'refresh');
    }

    }else{
        redirect(base_url());
        }
    }
	
	   //Prepare Posta Mlangoni Bill
	    public function Prepare_Customer_Bills(){
            $I = base64_decode($this->input->get('I'));
            $data['askfor'] = $askfor = $this->input->get('AskFor');
            $month =    $this->input->post('datetime'); 
            $info = $this->Box_Application_model->get_customer_infos($I);
            $acc_no = $info->acc_no;
            $data['acc_no'] = $acc_no;
            $data['month'] = $month;
            $data['credit_id'] = $I;
            $type = $info->customer_type;
            $data['type1'] = $info->customer_type;
            $data['tinnumber'] = $info->tin_number;
            $data['emslist'] = $this->Bill_Customer_model->get_credit_customer_MAIL_list_byAccnoMonth($acc_no,$month);
            $data['sum'] = $this->Bill_Customer_model->get_credit_MAIL_customer_sum_byAccnoMonth($acc_no,$month);
            $this->load->view('Posta_Mlangoni/bill_customer_list_mail',$data);
        }
		
		//Generate Posta Mlangoni Bill
		    public function Credit_Customer_Prepare_Bill(){
            $I = base64_decode($this->input->get('I'));
            $data['askfor'] = $askfor = $this->input->get('AskFor');
            $month =    $this->input->post('datetime'); 
            $date =    $this->input->post('date'); 
            $info = $this->Box_Application_model->get_customer_infos($I);
            $acc_no = $info->acc_no;
            $data['acc_no'] = $acc_no;
            $data['month'] = $month;
            $data['date'] = $date;
            $data['credit_id'] = $I;
            $type   = $info->customer_type;
            $data['type1'] = $info->customer_type;
            $data['tinnumber'] = $info->tin_number;
			
            $data['emslist'] = $this->Bill_Customer_model->get_credit_customer_MAIL_list_byAccnoMonth_bill($acc_no,$month,$date);
            $data['sum'] = $this->Bill_Customer_model->get_credit_MAIL_customer_sum_byAccnoMonth_bill($acc_no,$month,$date);

            $this->load->view('Posta_Mlangoni/bill_customer_list_mail',$data);
            }
			
			//List Bill Transactions
    public function bill_transactions_list()
    {
                $AskFor = $this->input->get('AskFor');
                $this->session->set_userdata('askfor',$AskFor);
                $data['billing'] = $this->Posta_Mlangoni_Model->bill_transactions_list($AskFor);
                $this->load->view('Posta_Mlangoni/customer-bill-transactions-list',$data);
   
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
                    
                $this->load->view('Posta_Mlangoni/register-bill-transactions-list',$data);

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
                   $this->load->view('Posta_Mlangoni/register-bill-transactions-list',$data);
                }
            
    }else{

        redirect(base_url());
    }
}


	public function bill_domestic_bulk_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $id = base64_decode($this->input->get('I'));
              $data['askfor'] = $this->input->get('AskFor');
                $data['custinfo'] = $this->Bill_Customer_model->get_bill_cust_details_info($id);

                $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('Posta_Mlangoni/bill-domestic-bulk-form',$data);

        }else{
            redirect(base_url());
        }

    }
	
		public function postamlangoni_price()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

           $type = $this->input->post('tariffCat');
           $weight = $this->input->post('weight');
		   
            $price = $this->Posta_Mlangoni_Model->postamlangoni_cat_price($type,$weight);

            if (empty($price)) {

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th colspan='2'>Charges</th></tr>
                <tr><td><b>Price:</b></td><td>0</td></tr>
                <tr><td><b>Total Price:</b></td><td>0</td></tr>
                </table>";

            }else{

                $emsprice = $price->tariff_cost + $price->tariff_vat;

                if($type=="ZONE A"){
                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
				<tr><td><b>Tariff:</b></td><td>".number_format($price->tariff_cost,2)."</td></tr>
                <tr><td><b>Vat:</b></td><td>".number_format($price->tariff_vat,2)."</td></tr>
                <tr><td><b>Total Price:</b></td><td>".number_format($emsprice,2)."</td></tr>
                </table>
                 <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                ";
               }
               else
               {
               $emsprice = $emsprice + $price->charge;
               echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                <tr><td><b>Tariff:</b></td><td>".number_format($price->tariff_cost,2)."</td></tr>
                <tr><td><b>Vat:</b></td><td>".number_format($price->tariff_vat,2)."</td></tr>
                <tr><td><b>Cost:</b></td><td>".number_format($price->charge,2)."</td></tr>
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
                     $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa track number hii hapa'. ' '.$value->track_number.' Kwaajili ya huduma ya  Posta Mlangoni '.'';
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
                <tr style='width:100%;color:#3895D3;'><th><b>Reference</b></th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->r_address."</td><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
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


           
}