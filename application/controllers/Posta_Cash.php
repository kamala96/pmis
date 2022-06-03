 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posta_Cash extends CI_Controller {

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
        $this->load->model('Sms_model');
        $this->load->model('Box_Application_model');
        $this->load->model('Control_Number_model');
        $this->load->model('Posta_Cash_Model');
        $this->load->helper('url');
        
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') != 1){
        redirect(base_url());   
        }
        
    }

    public function postacash_agents_dashboard(){ 
    $data['pendinagents'] = $this->Posta_Cash_Model->counter_get_pending_agents();
    $this->load->view('postacash/agents_dashboard',$data);  
    }

    public function register_agent(){ 
     $data['region'] = $this->Posta_Cash_Model->regselect_by_restriction();
    $this->load->view('postacash/register_agent',$data); 
    }

    public function registered_agent(){
    $data['region'] = $this->Posta_Cash_Model->regselect_by_restriction();
    $this->load->view('postacash/registered_agent',$data); 
    }

    public function registered_agent_wallet_transactions(){
    $data['region'] = $this->Posta_Cash_Model->regselect_by_restriction();
    $this->load->view('postacash/agent_wallet_transactions',$data); 
    }

    public function find_agent_wallat_transactions(){
    $fromdate = $this->input->post('fromdate');
    $todate = $this->input->post('todate');
    $region = $this->input->post('region');
    $branch = $this->input->post('branch');
    
    $data['region'] = $this->Posta_Cash_Model->regselect_by_restriction();
    $data['list'] =$this->Posta_Cash_Model->find_agent_wallat_transactions($fromdate,$todate,$region,$branch);
    if(!empty($data['list'])){
    $this->load->view('postacash/agent_wallet_transactions',$data); 
    } else {
    $this->session->set_flashdata('feedback','No transactions Found, Please try again');
    redirect('Posta_Cash/registered_agent_wallet_transactions');
    }
    }

    public function postacash_transactions(){
    $this->load->view('postacash/transfered_money_list'); 
    }

    public function find_postacash_transactions(){
    $fromdate = $this->input->post('fromdate');
    $todate = $this->input->post('todate');
    $keywords = $this->input->post('keywords');
     
    $data['list'] =$this->Posta_Cash_Model->find_postacash_transactions($fromdate,$todate,$keywords);
    if(!empty($data['list'])){
    $this->load->view('postacash/transfered_money_list',$data); 
    } else {
    $this->session->set_flashdata('feedback','No transactions Found, Please try again');
    redirect('Posta_Cash/postacash_transactions');
    }

    }

    public function postacash_commissions(){
    $this->load->view('postacash/postacash_commissions'); 
    }

    public function find_postacash_commissions(){
    $fromdate = $this->input->post('fromdate');
    $todate = $this->input->post('todate');
    $keywords = $this->input->post('keywords');
     
    $data['list'] =$this->Posta_Cash_Model->find_postacash_commissions($fromdate,$todate,$keywords);
    if(!empty($data['list'])){
    $this->load->view('postacash/postacash_commissions',$data); 
    } else {
    $this->session->set_flashdata('feedback','No Commission Found, Please try again');
    redirect('Posta_Cash/postacash_commissions');
    }
    }

    public function pending_agent(){
    $data['list'] = $this->Posta_Cash_Model->get_pending_agents();
    $this->load->view('postacash/pending_agent',$data); 
    }

    public function find_agents(){
    $fromdate = $this->input->post('fromdate');
    $todate = $this->input->post('todate');
    $region = $this->input->post('region');
    $branch = $this->input->post('branch');
    
    $data['region'] = $this->Posta_Cash_Model->regselect_by_restriction();
    $data['list'] =$this->Posta_Cash_Model->find_agents($fromdate,$todate,$region,$branch);
    if(!empty($data['list'])){
    $this->load->view('postacash/registered_agent',$data); 
    } else {
    $this->session->set_flashdata('feedback','No Posta Cash Agents Found, Please try again');
    redirect('Posta_Cash/registered_agent');
    }
    }

    public function agent_details(){
    $agentid = base64_decode($this->input->get('I'));
    $data['info'] = $this->Posta_Cash_Model->agent_details($agentid);
    $data['region'] = $this->Posta_Cash_Model->regselect_by_restriction();
    $this->load->view('postacash/agent_details',$data); 
    }

    public function postacash_dashboard(){ 
    $this->load->view('postacash/postacash_dashboard');  
    }

    public function send_money(){ 
    $data['region'] = $this->employee_model->regselect();
    $this->load->view('postacash/send_money',$data);  
    }

    public function receive_money(){ 
    $this->load->view('postacash/receive_money');  
    }

    public function postacash_list(){ 
    $data['listtrans']= $this->Posta_Cash_Model->list_sendmoney();
    $this->load->view('postacash/postacash_list',$data);  
    }

    public function search_pin(){ 
    $pin = $this->input->post('pin');
    $results = $this->Posta_Cash_Model->check_transaction($pin);
    if($results)
    {
    $data['listtrans']= $this->Posta_Cash_Model->check_transaction($pin);
    $this->load->view('postacash/receive_money',$data);
    }
    else
    {
    $this->session->set_flashdata('feedback','Invalid PIN number, Please try again');
    redirect($this->agent->referrer());
    }
    
    } 

    public function save_sendmoney(){
    $empid = $this->session->userdata('user_emid');
    $sender_name = $this->input->post('sender_name');
    $sender_phone = $this->input->post('sender_phone');
    $receiver_name = $this->input->post('receiver_name');
    $region = $this->input->post('region');
    $branch = $this->input->post('branch');
    $currency = $this->input->post('currency');
    $amount = $this->input->post('amount');
    $r_amount = $this->input->post('r_amount');
    $commission = $this->input->post('commission');
    $pin = strtoupper(substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 4));
    $transactioncode = strtoupper(substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 10));
    $sms = $sender_name.' '.', KARIBU POSTA CASH, Umefanikiwa kutuma kiasi cha '.number_format($amount,2).', Makato '.number_format($commission,2).', Kwenda kwa '.$receiver_name.' kiasi cha '.number_format($r_amount,2).', kwenye huduma ya Posta Cash, Mpatie mpokeaji Pin namba '.$pin.' kwa ajili ya kupokea fedha';
    
    $send_money = array();
    $send_money= array('sender_name'=>$sender_name,
        'sender_phone'=>$sender_phone,
        'receiver_name'=>$receiver_name,
        'receiver_region'=>$region,
        'receiver_branch'=>$branch,
        'currency'=>$currency,
        'amount'=>$amount,
        'operator'=>$empid,
        'posta_commission'=>$commission,
        'pin'=>$pin,
        'transactioncode'=>$transactioncode,
        'r_amount'=>$r_amount
        );

    $this->Posta_Cash_Model->save_sendmoney($send_money);
    $this->session->set_flashdata('success','Money has been successfully sent');
    //Send SMS
    $this->Sms_model->send_sms_trick($sender_phone,$sms);
     redirect($this->agent->referrer());
   }

   /*public function generate_agent_no(){
   $value = 1000;
   echo str_pad($value, 8, '0', STR_PAD_LEFT);
   }*/

   public function save_agent_information(){
    $createdby = $this->session->userdata('user_emid');
    $fname = $this->input->post('fname');
    $mname = $this->input->post('mname');
    $lname = $this->input->post('lname');
    $region = $this->input->post('region');
    $branch = $this->input->post('branch');
    $email = $this->input->post('email');
    $phone = $this->input->post('phone');
    $address = $this->input->post('address');
    $tinnumber = $this->input->post('tinnumber');
    $licencenumber = $this->input->post('licencenumber');
    $nationalidnumber = $this->input->post('nationalidnumber');
    $agentno = substr(str_shuffle("0123456789"), 0, 6);

    $checkagent = $this->Posta_Cash_Model->get_postacash_agent($email,$phone);
    if(!empty($checkagent)){
    $this->session->set_flashdata('feedback','Agent E-mail Address or Phone number Exist, Please try again');
    } else {

            if($_FILES['licencefile']['name']){
            $file_name = $_FILES['licencefile']['name'];
            $fileSize = $_FILES["licencefile"]["size"]/1024;
            $fileType = $_FILES["licencefile"]["type"];

            $config = array(
                'upload_path' => "./assets/images/poshacash_files",
                'allowed_types' => "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG|docx|doc|pdf",
                'overwrite' => False,
                'max_size' => 0,
                'remove_spaces'=> TRUE,
                'encrypt_name'=> TRUE
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('licencefile')) {
                  $errorreceipt =  $this->upload->display_errors();
                   $this->session->set_flashdata('feedback',"Failed to submit licence file, Please try again!".' '.$errorreceipt.' ');
                   redirect($this->agent->referrer());
            } else {
            $path = $this->upload->data();
            $licencefile = $path['file_name'];
            }
            }

            if($_FILES['tinfile']['name']){
            $file_name = $_FILES['tinfile']['name'];
            $fileSize = $_FILES["tinfile"]["size"]/1024;
            $fileType = $_FILES["tinfile"]["type"];

            $config = array(
                'upload_path' => "./assets/images/poshacash_files",
                'allowed_types' => "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG|docx|doc|pdf",
                'overwrite' => False,
                'max_size' => 0,
                'remove_spaces'=> TRUE,
                'encrypt_name'=> TRUE
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('tinfile')) {
                  $errorreceipt =  $this->upload->display_errors();
                   $this->session->set_flashdata('feedback',"Failed to submit tin file, Please try again!".' '.$errorreceipt.' ');
                   redirect($this->agent->referrer());
            } else {
            $path = $this->upload->data();
            $tinfile = $path['file_name'];
            }
            }

            if($_FILES['nationalidfile']['name']){
            $file_name = $_FILES['nationalidfile']['name'];
            $fileSize = $_FILES["nationalidfile"]["size"]/1024;
            $fileType = $_FILES["nationalidfile"]["type"];

            $config = array(
                'upload_path' => "./assets/images/poshacash_files",
                'allowed_types' => "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG|docx|doc|pdf",
                'overwrite' => False,
                'max_size' => 0,
                'remove_spaces'=> TRUE,
                'encrypt_name'=> TRUE
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('nationalidfile')) {
                  $errorreceipt =  $this->upload->display_errors();
                   $this->session->set_flashdata('feedback',"Failed to submit National ID file, Please try again!".' '.$errorreceipt.' ');
                   redirect($this->agent->referrer());
            } else {
            $path = $this->upload->data();
            $nationalidfile = $path['file_name'];
            }
            }

    $sms = @$fname.' '.', KARIBU POSTA CASH, Umefanikiwa kusajiliwa kwenye huduma ya POSTA CASH AGENT. Utatumiwa ujumbe kwenye simu yako baada ya uhakiki wa taarifa zako kukamilika';
    
    $data= array(
        'agent_fname'=>@$fname,
        'agent_mname'=>@$mname,
        'agent_lname'=>@$lname,
        'agent_region'=>@$region,
        'agent_branch'=>@$branch,
        'agent_tin'=>@$tinnumber,
        'agent_nationalid'=>@$nationalidnumber,
        'agent_licencenumber'=>@$licencenumber,
        'agent_business_licence_file'=>@$licencefile,
        'agent_tin_number_file'=>@$tinfile,
        'agent_nida_file'=>@$nationalidfile,
        'agent_address'=>@$address,
        'agent_email'=>@$email,
        'agent_password'=>sha1($phone),
        'agent_phone'=>@$phone,
        'agent_no'=>@$agentno,
        'agent_status'=>'Pending',
        'agent_registered_by'=>@$createdby
        );

    $this->Posta_Cash_Model->save_agent($data);
    $this->session->set_flashdata('success','Agent information has been successfully saved');
    //Send SMS
    $this->Sms_model->send_sms_trick($phone,$sms);


    $SaveLogs =  array('status'=>'registration','created_by'=>@$createdby,'agentno'=>@$agentno,'description'=>'Agent Registration has been Successfully');
    $this->Posta_Cash_Model->Save_logs($SaveLogs);
    
   } 
   redirect($this->agent->referrer());
   }

    public function update_agent_information(){
    $agentid = $this->input->post('agentid');
    $fname = $this->input->post('fname');
    $mname = $this->input->post('mname');
    $lname = $this->input->post('lname');
    $region = $this->input->post('region');
    $branch = $this->input->post('branch');
    $email = $this->input->post('email');
    $phone = $this->input->post('phone');
    $address = $this->input->post('address');
    $tinnumber = $this->input->post('tinnumber');
    $licencenumber = $this->input->post('licencenumber');
    $nationalidnumber = $this->input->post('nationalidnumber');


            if($_FILES['licencefile']['name']){
            $file_name = $_FILES['licencefile']['name'];
            $fileSize = $_FILES["licencefile"]["size"]/1024;
            $fileType = $_FILES["licencefile"]["type"];

            $config = array(
                'upload_path' => "./assets/images/poshacash_files",
                'allowed_types' => "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG|docx|doc|pdf",
                'overwrite' => False,
                'max_size' => 0,
                'remove_spaces'=> TRUE,
                'encrypt_name'=> TRUE
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('licencefile')) {
                  $errorreceipt =  $this->upload->display_errors();
                   $this->session->set_flashdata('feedback',"Failed to submit licence file, Please try again!".' '.$errorreceipt.' ');
                   redirect($this->agent->referrer());
            } else {
            $path = $this->upload->data();
            $licencefile = $path['file_name'];
            $UpdateFile3 = array('agent_business_licence_file'=>@$licencefile);
            $this->Posta_Cash_Model->update_agent($UpdateFile3,$agentid);
            }
            }

            if($_FILES['tinfile']['name']){
            $file_name = $_FILES['tinfile']['name'];
            $fileSize = $_FILES["tinfile"]["size"]/1024;
            $fileType = $_FILES["tinfile"]["type"];

            $config = array(
                'upload_path' => "./assets/images/poshacash_files",
                'allowed_types' => "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG|docx|doc|pdf",
                'overwrite' => False,
                'max_size' => 0,
                'remove_spaces'=> TRUE,
                'encrypt_name'=> TRUE
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('tinfile')) {
                  $errorreceipt =  $this->upload->display_errors();
                   $this->session->set_flashdata('feedback',"Failed to submit tin file, Please try again!".' '.$errorreceipt.' ');
                   redirect($this->agent->referrer());
            } else {
            $path = $this->upload->data();
            $tinfile = $path['file_name'];
            $UpdateFile2 = array('agent_tin_number_file'=>@$tinfile);
            $this->Posta_Cash_Model->update_agent($UpdateFile2,$agentid);
            }
            }

            if($_FILES['nationalidfile']['name']){
            $file_name = $_FILES['nationalidfile']['name'];
            $fileSize = $_FILES["nationalidfile"]["size"]/1024;
            $fileType = $_FILES["nationalidfile"]["type"];

            $config = array(
                'upload_path' => "./assets/images/poshacash_files",
                'allowed_types' => "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG|docx|doc|pdf",
                'overwrite' => False,
                'max_size' => 0,
                'remove_spaces'=> TRUE,
                'encrypt_name'=> TRUE
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('nationalidfile')) {
                  $errorreceipt =  $this->upload->display_errors();
                   $this->session->set_flashdata('feedback',"Failed to submit National ID file, Please try again!".' '.$errorreceipt.' ');
                   redirect($this->agent->referrer());
            } else {
            $path = $this->upload->data();
            $nationalidfile = $path['file_name'];
            $UpdateFile1 = array('agent_nida_file'=>@$nationalidfile);
            $this->Posta_Cash_Model->update_agent($UpdateFile1,$agentid);
            }
            }
    
    $Updatedata= array(
        'agent_fname'=>@$fname,
        'agent_mname'=>@$mname,
        'agent_lname'=>@$lname,
        'agent_region'=>@$region,
        'agent_branch'=>@$branch,
        'agent_tin'=>@$tinnumber,
        'agent_nationalid'=>@$nationalidnumber,
        'agent_licencenumber'=>@$licencenumber,
        'agent_address'=>@$address,
        'agent_email'=>@$email,
        'agent_phone'=>@$phone
        );
    $this->Posta_Cash_Model->update_agent($Updatedata,$agentid);
    $this->session->set_flashdata('success','Agent information has been successfully Updated');

    redirect($this->agent->referrer());
   }

    
    public function update_agent_account_details(){
    $agentid = $this->input->post('agentid');
    $status = $this->input->post('status');

    $Updatedata= array('agent_status'=>@$status);
    $this->Posta_Cash_Model->update_agent($Updatedata,$agentid);
    $this->session->set_flashdata('success','Agent Account Details has been successfully Updated');

    redirect($this->agent->referrer());
   }

   public function approve_agent(){
    $createdby = $this->session->userdata('user_login_id');
    $agentid = $this->input->post('agentid');
    $desc = $this->input->post('desc');
    $status = $this->input->post('status');

    if(!empty($agentid)){

    foreach ($agentid as $value) {
    ///////Agent Information
    $info = $this->Posta_Cash_Model->agent_details($value);

    $Updatedata= array('agent_status'=>@$status);
    $this->Posta_Cash_Model->update_agent($Updatedata,$value);

    if($status=="Active"){

    if(!empty($desc)){
    ///////Customization Message
$sms = 'POSTA CASH, Habari '.@$info->agent_fname.', Uhakiki wa taarifa zako umekamilika namba yako ya uwakala (Posta Cash Agent No.): '.@$info->agent_no.'.Ingia kwenye POSTA KIGANJANI PORTAL au APP , Neno lako la siri (Username): '.@$info->agent_email.' Na Nywila(Password): '.@$info->agent_phone.' .Maelezo ya ziada: '.$desc.'';
    } else {
    /////Active Message
$sms = 'POSTA CASH, Habari '.@$info->agent_fname.', Uhakiki wa taarifa zako umekamilika namba yako ya uwakala (Posta Cash Agent No.): '.@$info->agent_no.'.Ingia kwenye POSTA KIGANJANI PORTAL au APP , Neno lako la siri (Username): '.@$info->agent_email.' Na Nywila(Password): '.@$info->agent_phone.'';
    }

    } else {

    if(!empty($desc)){
    ///////Customization Message
$sms = 'POSTA CASH, Habari '.@$info->agent_fname.',Taarifa zako za kuwa wakala wa Posta Cash haujakamilika. Tafadhali nenda kwenye ofisi ya Posta uliyojiandikisha kwa msaada zaidi. Maelezo ya ziada: '.$desc.'';
    } else {
    /////Active Message
$sms = 'POSTA CASH, Habari '.@$info->agent_fname.',Taarifa zako za kuwa wakala wa Posta Cash haujakamilika. Tafadhali nenda kwenye ofisi ya Posta uliyojiandikisha kwa msaada zaidi';
    }


    }


$this->Sms_model->send_sms_trick(@$info->agent_phone,$sms);
$SaveLogs =  array('status'=>@$status,'created_by'=>@$createdby,'agentno'=>@$info->agent_no,'description'=>'Agent information has been Successfully '.$status.'');
$this->Posta_Cash_Model->Save_logs($SaveLogs);

    }

$this->session->set_flashdata('message','Agent information has been successfully '.$status.'');

} else {
$this->session->set_flashdata('feedback','Please select agent to continue');
}

    redirect($this->agent->referrer());
   }

    public function reset_agent_password(){
    $agentid = $this->input->post('agentid');
    $password = $this->input->post('password');

    $info = $this->Posta_Cash_Model->agent_details($agentid);

$sms = 'POSTA CASH, Habari '.@$info->agent_fname.' Nywila Mpya (New Password) ni:  '.$password.', Tafadhali ingia kwenye mfumo na mabadili nywila yako!';
$this->Sms_model->send_sms_trick(@$info->agent_phone,$sms);

    $Updatedata= array('agent_password'=>sha1(@$password));
    $this->Posta_Cash_Model->update_agent($Updatedata,$agentid);
    $this->session->set_flashdata('success','Agent password has been successfully reseted');

    redirect($this->agent->referrer());
   }


   public function save_receivemoney(){
    $empid = $this->session->userdata('user_emid');
    $identitycard = $this->input->post('identitycard');
    $identitynumber = $this->input->post('identitynumber');
    $sendmoneyid = $this->input->post('sendmoneyid');
    $received_created_at = date('Y-m-d');
    $info = $this->Posta_Cash_Model->get_senderinfo($sendmoneyid);
    //sender information
    $phone = $info->sender_phone;
    $sender_name = $info->sender_name;
    $receiver_name = $info->receiver_name;
    $amount = $info->r_amount;

    $sms = 'POSTA CASH, Habari '.$sender_name.' kiasi cha '.number_format($amount,2).' kimepokelewa na '.$receiver_name.' kwenye huduma ya Posta Cash';
    
    $receive_money = array();
    $receive_money= array('identitycard'=>$identitycard,
        'identitynumber'=>$identitynumber,
        'received_created_at'=>$received_created_at,
        'receive_operator'=>$empid,
        'sendmoney_status'=>'Received'
        );

    $this->Posta_Cash_Model->save_receivemoney($receive_money,$sendmoneyid);

    $this->session->set_flashdata('success','Money has been successfully received');
    /////////////SEND SMS
    $this->Sms_model->send_sms_trick($phone,$sms);
    
   redirect('Posta_Cash/receive_money');
   }
    
    
    
    
}