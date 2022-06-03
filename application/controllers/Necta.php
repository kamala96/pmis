 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Necta extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('Necta_model');
        $this->load->model('Box_Application_model');
        $this->load->model('billing_model');
        $this->load->model('Control_Number_model');
        $this->load->model('Sms_model');
        $this->load->helper('url');
    }

    
public function necta_online_dashboard(){
    if ($this->session->userdata('user_login_access') != false) {
        $this->session->set_userdata('heading','Necta Online Dashboard');
       $this->load->view('domestic_ems/nectaonline_transactions');
    } else {
       redirect(base_url());
    }
    
}


public function necta_online_trans_results(){
    if ($this->session->userdata('user_login_access') != false){
    $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
    $todate =  date("Y-m-d",strtotime($this->input->post('todate')));
    $status =  $this->input->post('status');
    $controlnumber =  $this->input->post('controlnumber');
    
    // if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
    //     redirect('Necta/necta_online_dashboard');
    // }

    if(!empty($controlnumber) || !empty($fromdate) || !empty($todate)  ){
    
    $data['design'] = $this->employee_model->getdesignation();
    if(!empty($controlnumber)){
        $results = $this->Box_Application_model->getonline_transaction_bycontrol($controlnumber);

    }else{
        $results = $this->Box_Application_model->nectaonline_transaction_list($fromdate,$todate,$status);
    }
    
    if($results){
    $data['list'] = $results;//$this->Box_Application_model->nectaonline_transaction_list($fromdate,$todate,$status);
    $this->load->view('domestic_ems/nectaonline_transactionslist',$data);
    }
}
    else{
    $this->session->set_flashdata('message','Transcation not found, Please try again!');
    redirect("Necta/necta_online_dashboard");
    }
    
    }
    else{
    redirect(base_url());
    }
    }

    
public function update_nectaonline_trans(){
    $barcode = $this->input->post('barcode');
    $serial = $this->input->post('serial');
    
       
    
         $sender = $this->Box_Application_model->get_requestid_byserial($serial);

             //-------------- Start here
             $emid = $this->session->userdata('user_login_id');
          //getting user or staff department section
          $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

          //for One Man
          $office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';
          $data = array();
          $data = array('Barcode'=>$barcode,'office_name'=>$office_one_name,
          'created_by'=>$emid);
          $this->Box_Application_model->update_mct_transaction($data,$serial);

          $lastTransId = @$sender->id;

         
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
          $controlnumber=@$sender->billid;
          $s_mobile=@$sender->Customer_mobile;
          $sms ='KARIBU POSTA KIGANJANI, Ndugu mteja umepatiwa track-namba '. ' '.@$barcode.' Yenye control number '.$controlnumber.' Uliyolipia kwa huduma ya Necta';

           $this->Sms_model->send_sms_trick($s_mobile,$sms);
    
    
     $this->session->set_flashdata('message',"Transaction Inofrmation has been successfully updated");
     redirect('Necta/necta_online_dashboard');
    
    }
    
	public function necta_info(){

        if ($this->session->userdata('user_login_access') != false) {

            $this->load->view('domestic_ems/necta_form');

        }else{
            redirect(base_url());
        }

    }

        public function necta_delete_form(){

        if ($this->session->userdata('user_login_access') != false) {

            $this->load->view('domestic_ems/necta_delete_form');

        }else{
            redirect(base_url());
        }

    }
    

    public function bulk_necta()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
                //$data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('domestic_ems/bulk_necta',@$data);
        }else{
            redirect(base_url());
        }
    }



public function Save_bulk_necta(){
        if ($this->session->userdata('user_login_access') != false) {
           
            $r_name = $this->input->post('r_name');
            $r_region = $this->input->post('r_region');
            $r_address = $this->input->post('r_address');
            $r_zipcode = $this->input->post('r_zipcode');
            $r_phone = $this->input->post('r_phone');
            $r_email = $this->input->post('r_email');

            $emstype = 'Document';
            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');



            $TotalNonweightamounts = $this->input->post('TotalNonweightamounts');
            $TotalNonweightvalues = $this->input->post('TotalNonweightvalues');
            
            if(!empty($_POST['NonweightArray'])){
                $myArray = $_POST['NonweightArray'];
                $NonweightArray    = json_decode($myArray);

            }

            $source = $this->employee_model->get_code_source($o_region);
            $dest = $this->employee_model->get_code_dest($r_region);

              $s_mobile = '';

            $bagsNo = @$source->reg_code.@$dest->reg_code;
            $serial    = 'EMS'.date("YmdHis").@$source->reg_code.$this->session->userdata('user_login_id');


            if($TotalNonweightamounts > 0 ){


                if($TotalNonweightvalues == 0){

                    $item = $NonweightArray[0]->item;
                    $destination =$NonweightArray[0]->destination;


                    $category =$destination;
                    $s_rnumber = $item;

                    $addtype = "Physical";
                    
                    $rec_region = "Dar es Salaam";
                    $rec_branch = "GPO";

                    if ($addtype == "Physical") {
                        $add = 'physical';
                        $s_fullname = $item;
                        $s_address = $o_region;
                        $s_mobile = $s_mobile;
                    }

                    $sender = array();
                    $sender = array(
                        'ems_type'=>$category,
                        'rnumber'=>$s_rnumber,
                        's_fullname'=>$s_fullname,
                        's_address'=>$s_address,
                        's_mobile'=>$s_mobile,
                        's_region'=>$o_region,
                        's_district'=>$o_branch,
                        'operator'=>$id,
                        'add_type'=>$add,'serial'=>$serial);

                        $db2 = $this->load->database('otherdb', TRUE);
                        $db2->insert('sender_info',$sender);
                        $last_id = $db2->insert_id();


                        $month = date('m');
                        $day   = date('d');

                        if ($category == "ACSEE") {

                            if (($month <= "09") ) {
                               $price = 8500;
                            }elseif(($month >= "10")){
                                $price = 8500;
                            }
                            
                        } elseif ($category == "CSEE") {
                            
                            if (($month <= "09") ) {
                               $price = 8500;
                            }elseif(($month >= "10")){
                                $price = 8500;
                            }
                        }else {
                            
                            if (($month <= "09") ) {
                               $price = 8500;
                            }elseif(($month >= "10")){
                                $price = 8500;
                            }
                        }
                        
                        $totalprice = $price;
                       

                        $receiver = array();
                        $receiver = array(
                            'from_id'=>$last_id,
                            'fullname'=>$r_name,
                            'address'=>$r_address,
                            'email'=>$r_email,
                            'mobile'=>$r_phone,
                            'r_region'=>$r_region,
                            'branch'=>$rec_branch);

                        $db2->insert('receiver_info',$receiver);

                }else{

                     $totalprice = 0;
                    
                    foreach ($NonweightArray as $key => $variable) {

                            $item = $variable->item;
                            $destination =$variable->destination;

                            $category =$destination;
                            $s_rnumber = $item;

                            $addtype ="Physical";
                            
                            $rec_region = "Dar es Salaam";
                            $rec_branch = "GPO";

                            if ($addtype == "Physical") {
                                $add = 'physical';
                                $s_fullname = $item;
                                $s_address = $o_region;
                                $s_mobile = '';
                            }


                            $sender = array();
                            $sender = array(
                                'ems_type'=>$category,
                                'rnumber'=>$s_rnumber,
                                's_fullname'=>$s_fullname,
                                's_address'=>$s_address,
                                's_mobile'=>$s_mobile,
                                's_region'=>$o_region,
                                's_district'=>$o_branch,
                                'operator'=>$id,'add_type'=>$add,
                                'serial'=>$serial);

                            $db2 = $this->load->database('otherdb', TRUE);
                            $db2->insert('sender_info',$sender);
                            $last_id = $db2->insert_id();


                            $month = date('m');
                            $day   = date('d');

                            if ($category == "ACSEE") {

                                if (($month <= "09") ) {
                                   $price = 8500;
                                }elseif(($month >= "10")){
                                    $price = 8500;
                                }
                                
                            } elseif ($category == "CSEE") {
                                
                                if (($month <= "09") ) {
                                   $price = 8500;
                                }elseif(($month >= "10")){
                                    $price = 8500;
                                }
                            }else {
                                
                                if (($month <= "09") ) {
                                   $price = 8500;
                                }elseif(($month >= "10")){
                                    $price = 8500;
                                }
                            }

                            $receiver = array();
                            $receiver = array(
                                'from_id'=>$last_id,
                                'fullname'=>$r_name,
                                'address'=>$r_address,
                                'email'=>$r_email,
                                'mobile'=>$r_phone,
                                'r_region'=>$r_region,
                                'branch'=>$rec_branch);

                            $db2->insert('receiver_info',$receiver);

                             $totalprice =  $totalprice + $price;

                     }

                 }
                
            }


            $mobile='';

           
             $data = array();
             $data = array(
                'serial'=>$serial,
                'paidamount'=>$totalprice,
                'CustomerID'=>$serial,
                'Customer_mobile'=>$mobile,
                'region'=>$o_region,
                'district'=>$o_branch,
                'transactionstatus'=>'POSTED',
                'bill_status'=>'PENDING',
                'paymentFor'=>'NECTA');

            $this->Box_Application_model->save_transactions($data);

            $paidamount = $totalprice;
            $region = $o_region;
            $district = $o_branch;
            $renter   = $s_fullname;
            $serviceId = 'NECTA';
            $trackno = $bagsNo;


            $transaction = $this->getBillGepgBillIdEMS($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

            $serial1 = $serial;

            if (@$transaction->controlno != '') {
                 $response['status'] = 'Success';
                    # code...
                $update = array('billid'=>@$transaction->controlno,'bill_status'=>'SUCCESS');
                $this->billing_model->update_transactions($update,$serial1);

                $first4 = substr(@$transaction->controlno, 4);
                $trackNo = $bagsNo.$first4;

                $data1 = array();
                $data1 = array('track_number'=>$trackNo);

                // $this->Loan_Board_model->update_sender_international($last_id,$data);
                $this->billing_model->update_sender_info($last_id,$data1);

                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                $sms ='KARIBU POSTA KIGANJANI umepatiwa ankara namba hii hapa'. ' '.@$transaction->controlno.' Kwaajili ya huduma ya EMS NECTA,Kiasi unachotakiwa kulipia ni TSH.'.number_format(@$paidamount,2);

                //$this->Sms_model->send_sms_trick($s_mobile,$sms);

                $response['message'] = $sms;

            }else{
                 $response['status'] = 'Error';
                 $response['message'] = 'Item yako imeshasajiliwa ila control number aijatoka, wasiliana na wataalam wa ICT';
            }   

            print_r(json_encode($response));
        } else {
            redirect(base_url());
        }    
}



    public function OldSave_bulk_necta(){
        if ($this->session->userdata('user_login_access') != false) {
           
            $r_name = $this->input->post('r_name');
            $r_region = $this->input->post('r_region');
            $r_address = $this->input->post('r_address');
            $r_zipcode = $this->input->post('r_zipcode');
            $r_phone = $this->input->post('r_phone');
            $r_email = $this->input->post('r_email');


           

          
            $emstype = 'Document';
            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');



          $TotalNonweightamounts = $this->input->post('TotalNonweightamounts');
            $TotalNonweightvalues = $this->input->post('TotalNonweightvalues');
            //$OutstandingArray = $this->input->post('OutstandingArray');
            //$myArray2 = $_REQUEST['OutstandingArray'];
            if(!empty($_POST['NonweightArray']))
            {
                $myArray = $_POST['NonweightArray'];
                $NonweightArray    = json_decode($myArray);

            }
             //$this->Loan_Board_model->Save_Receiver_Info($data);

            $source = $this->employee_model->get_code_source($o_region);
            $dest = $this->employee_model->get_code_dest($r_region);

            //echo json_encode($source);
            //echo json_encode($dest);

              $s_mobile = '';

            $bagsNo = @$source->reg_code.@$dest->reg_code;
            $serial    = 'EMS'.date("YmdHis").@$source->reg_code.$this->session->userdata('user_login_id');

// echo  $bagsNo;
// echo  $serial;
// echo 'DEV'.$TotalNonweightamounts;
// echo $TotalNonweightvalues ;
// echo json_encode($NonweightArray);

if($TotalNonweightamounts > 0 )
{


    if($TotalNonweightvalues == 0){

    //echo json_encode($OutstandingArray);

        $item = $NonweightArray[0]->item;
            $destination =$NonweightArray[0]->destination;


              $category =$destination;
               $s_rnumber = $item;

            $addtype = "Physical";
            
            $rec_region = "Dar es Salaam";
            $rec_branch = "GPO";

            if ($addtype == "Physical") {
            $add = 'physical';
            $s_fullname = $item;
            $s_address = $o_region;
            $s_mobile = $s_mobile;

            }


        $sender = array();
            $sender = array('ems_type'=>$category,'rnumber'=>$s_rnumber,'s_fullname'=>$s_fullname,'s_address'=>$s_address,'s_mobile'=>$s_mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$id,'add_type'=>$add,'serial'=>$serial);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();


            $month = date('m');
            $day   = date('d');

            if ($category == "ACSEE") {

                if (($month <= "09") ) {
                   $price = 8500;
                }elseif(($month >= "10")){
                    $price = 8500;
                }else{
                    $this->load->view('domestic_ems/necta_form');
                }
                
            } elseif ($category == "CSEE") {
                
                if (($month <= "09") ) {
                   $price = 8500;
                }elseif(($month >= "10")){
                    $price = 8500;
                }else{
                    $this->load->view('domestic_ems/necta_form');
                }
            }
            else {
                
                if (($month <= "09") ) {
                   $price = 8500;
                }elseif(($month >= "10")){
                    $price = 8500;
                }else{
                    $this->load->view('domestic_ems/necta_form');
                }
            }
            
            $totalprice = $price;
           

            $receiver = array();
            $receiver = array('from_id'=>$last_id,'fullname'=>$r_name,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_phone,'r_region'=>$r_region,'branch'=>$rec_branch);

            $db2->insert('receiver_info',$receiver);

    }
    else
    {

         $totalprice = 0;
        
    foreach ($NonweightArray as $key => $variable) {

            $item = $variable->item;
            $destination =$variable->destination;

              $category =$destination;
               $s_rnumber = $item;

            $addtype ="Physical";
            
            $rec_region = "Dar es Salaam";
            $rec_branch = "GPO";

            if ($addtype == "Physical") {
            $add = 'physical';
            $s_fullname = $item;
            $s_address = $o_region;
            $s_mobile = '';

            }


            $sender = array();
            $sender = array('ems_type'=>$category,'rnumber'=>$s_rnumber,'s_fullname'=>$s_fullname,'s_address'=>$s_address,'s_mobile'=>$s_mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$id,'add_type'=>$add,'serial'=>$serial);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();


            $month = date('m');
            $day   = date('d');

            if ($category == "ACSEE") {

                if (($month <= "09") ) {
                   $price = 8500;
                }elseif(($month >= "10")){
                    $price = 8500;
                }else{
                    $this->load->view('domestic_ems/necta_form');
                }
                
            } elseif ($category == "CSEE") {
                
                if (($month <= "09") ) {
                   $price = 8500;
                }elseif(($month >= "10")){
                    $price = 8500;
                }else{
                    $this->load->view('domestic_ems/necta_form');
                }
            }
            else {
                
                if (($month <= "09") ) {
                   $price = 8500;
                }elseif(($month >= "10")){
                    $price = 8500;
                }else{
                    $this->load->view('domestic_ems/necta_form');
                }
            }
            
           

            $receiver = array();
            $receiver = array('from_id'=>$last_id,'fullname'=>$r_name,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_phone,'r_region'=>$r_region,'branch'=>$rec_branch);

            $db2->insert('receiver_info',$receiver);

             $totalprice =  $totalprice + $price;
    

     }

     }
    
}


            $mobile='';

           
             $data = array();
             $data = array(

            'serial'=>$serial,
            'paidamount'=>$totalprice,
            'CustomerID'=>$serial,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'district'=>$o_branch,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING',
            'paymentFor'=>'NECTA'

            );

            $this->Box_Application_model->save_transactions($data);

            $paidamount = $totalprice;
            $region = $o_region;
            $district = $o_branch;
            $renter   = $s_fullname;
            $serviceId = 'NECTA';
            $trackno = $bagsNo;


            $transaction = $this->getBillGepgBillIdEMS($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

             //echo json_encode($transaction) ;
             //echo $paidamount;

            $serial1 = $serial;

            if (@$transaction->controlno != '') {
                    # code...
                $update = array('billid'=>@$transaction->controlno,'bill_status'=>'SUCCESS');
                $this->billing_model->update_transactions($update,$serial1);

                $first4 = substr(@$transaction->controlno, 4);
                $trackNo = $bagsNo.$first4;

                $data1 = array();
                $data1 = array('track_number'=>$trackNo);

                // $this->Loan_Board_model->update_sender_international($last_id,$data);
                $this->billing_model->update_sender_info($last_id,$data1);

                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                

            }

            $data['result'] ='KARIBU POSTA KIGANJANI ankara namba hii hapa'. ' '.@$transaction->controlno.' Kwaajili ya huduma ya EMS NECTA,Kiasi unachotakiwa kulipia ni TSH.'.number_format(@$paidamount,2);

                 $sms = $total ='KARIBU POSTA KIGANJANI umepatiwa ankara namba hii hapa'. ' '.@$transaction->controlno.' Kwaajili ya huduma ya EMS NECTA,Kiasi unachotakiwa kulipia ni TSH.'.number_format(@$paidamount,2);

               // $this->Sms_model->send_sms_trick($s_mobile,$sms);

               echo json_encode($sms);

               //$this->load->view('domestic_ems/necta_control_number',$data);
            
        } else {
            redirect(base_url());
        }    
}


public function GetNectaRegNo()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
        {

           $serial = $this->input->post('serial');
           $list = $this->Necta_model->get_bulk_necta_RegNo_list($serial);
           
         
    

            if (empty($list)) {
                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Regstration Number</th><th>Category </th></tr>
                <tr><td colspan='2'>No Registration Number available</td></tr>
                </table>";

            }else{
                //echo json_encode($list);
                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Regstration Number</th><th>Category </th></tr>";
                $rows ="";

                foreach ($list as $value) {
                    
                $rows1 = "<tr><td>".$value->rnumber."</td><td>".$value->ems_type."</td>";

                $rows =$rows.$rows1;
                }
                echo $rows;
                
                echo  "<tr><td></td><td></td></tr></table> ";

                
            }
          }
            
    }



public function Save_necta_Info(){
        if ($this->session->userdata('user_login_access') != false) {
           
            $Barcode = $this->input->post('Barcode');
            $r_name = $this->input->post('r_fname');
            $r_region = $this->input->post('r_region');
            $r_address = $this->input->post('r_address');
            $r_zipcode = $this->input->post('r_zipcode');
            $r_phone = $this->input->post('r_phone');
            $r_email = $this->input->post('r_email');
            $s_rnumber = $this->input->post('rnumber');
            $category = $this->input->post('category');

            $emstype = 'Document';

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');

            $addtype = $this->input->post('addtype');
            
            $rec_region = "Dar es Salaam";
            $rec_branch = "GPO";

            $add = 'physical';
            $s_fullname = $this->input->post('s_fullname');
            $s_address = $this->input->post('s_address');
            $s_mobile = $mobile = $this->input->post('s_mobile');
            

            $month = date('m');
            $day   = date('d');

            if ($category == "ACSEE") {

                if (($month <= "09") ) {
                   $price = 8500;
                }elseif(($month >= "10")){
                    $price = 8500;
                }
                
            } elseif ($category == "CSEE") {
                
                if (($month <= "09") ) {
                   $price = 8500;
                }elseif(($month >= "10")){
                    $price = 8500;
                }

            }else {
                
                if (($month <= "09") ) {
                   $price = 8500;
                }elseif(($month >= "10")){
                    $price = 8500;
                }
            }

            $db2 = $this->load->database('otherdb', TRUE);
            
            $sender = array();
            $sender = array(
                'ems_type'=>$category,
                'rnumber'=>$s_rnumber,
                's_fullname'=>$s_fullname,
                's_address'=>$s_address,
                's_mobile'=>$mobile,
                's_region'=>$o_region,
                's_district'=>$o_branch,
                'operator'=>$id,
                'add_type'=>$add);

            
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array(
                'from_id'=>$last_id,
                'fullname'=>$r_name,
                'address'=>$s_address,
                'email'=>$r_email,
                'mobile'=>$r_phone,
                'r_region'=>$r_region,
                'branch'=>$rec_branch);

            $db2->insert('receiver_info',$receiver);


            $source = $this->employee_model->get_code_source($o_region);
            $dest = $this->employee_model->get_code_dest($rec_region);

            $bagsNo = @$source->reg_code.$dest->reg_code;
            $serial    = 'EMS'.date("YmdHis").@$source->reg_code.$this->session->userdata('user_login_id');


             //-------------- Start here
            $emid = $this->session->userdata('user_login_id');

            //getting user or staff department section
            $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

            //for One Man
            $office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';

             $data = array();
             $data = array( 
                'serial'=>$serial,
                'paidamount'=>$price,
                'Barcode'=>strtoupper($Barcode),
                 'CustomerID'=>$last_id,
                'Customer_mobile'=>$mobile,
                'region'=>$o_region,
                'district'=>$o_branch,
                'transactionstatus'=>'POSTED',
                'office_name'=>$office_one_name,
                'created_by'=>$emid,
                'bill_status'=>'PENDING',
                'paymentFor'=>'NECTA');

            $lastTransId = $this->Box_Application_model->save_transactions($data);

            $paidamount = $price;
            $region = $o_region;
            $district = $o_branch;
            $renter   = $s_fullname;
            $serviceId = 'NECTA';
            $trackno = $bagsNo;

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
            $response = array();

            if ($lastTransId) {

                $response['status'] = 'Success';

                $serial1 = $serial;

                $transaction = $this->getBillGepgBillIdEMS($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

                if (@$transaction->controlno != '') {
                        # code...
                    $update = array('billid'=>@$transaction->controlno,'bill_status'=>'SUCCESS');
                    $this->billing_model->update_transactions($update,$serial1);

                    $first4 = substr(@$transaction->controlno, 4);
                    $trackNo = $bagsNo.$first4;

                    $data1 = array();
                    $data1 = array('track_number'=>$trackNo);

                    // $this->Loan_Board_model->update_sender_international($last_id,$data);
                    $this->billing_model->update_sender_info($last_id,$data1);

                    $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                    $location= 'Received Counter '.$info->em_region.' - '.$info->em_branch;
                    $data = array();

                    $data = array(
                        'track_no'=>$Barcode,
                        'location'=>$location,
                        'user'=>$user,'event'=>'Counter');

                    $this->Box_Application_model->save_location($data);

                     $sms ='KARIBU POSTA KIGANJANI ankara namba hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya EMS NECTA,Kiasi unachotakiwa kulipia ni TSH.'.number_format(@$price,2).' Tumia Track number '.$Barcode.' Kwa ajili ya ufuatiliaji';

                    //$this->Sms_model->send_sms_trick($s_mobile,$sms);

                    $response['message'] = $sms;

                }else{
                    $response['message'] = 'Item yako imeshasajiliwa ila control number aijatoka, wasiliana na wataalam wa ICT';
                }


            }else{
                 $response['status'] = 'Error';
                 $response['message'] = 'Item yako aijasajiliwa vizuri';
            }
            

            print_r(json_encode($response));
        } else {
            redirect(base_url());
        }    
}


public function OldSave_necta_Info()
    {
        if ($this->session->userdata('user_login_access') != false) {
           
            $Barcode = $this->input->post('Barcode');
             $r_name = $this->input->post('r_name');
            $r_region = $this->input->post('r_region');
            $r_address = $this->input->post('r_address');
            $r_zipcode = $this->input->post('r_zipcode');
            $r_phone = $this->input->post('r_phone');
            $r_email = $this->input->post('r_email');
            $s_rnumber = $this->input->post('rnumber');
            $category = $this->input->post('category');
            $emstype = 'Document';
            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');

            $addtype = $this->input->post('addtype');
            
            $rec_region = "Dar es Salaam";
            $rec_branch = "GPO";

            if ($addtype == "Physical") {
            $add = 'physical';
            $s_fullname = $this->input->post('s_fullname');
            $s_address = $this->input->post('s_address');
            $s_mobile = $mobile = $this->input->post('s_mobile');

            } else {
            
            $add = 'virtual';
            $target_url = "http://192.168.33.7/api/virtual_box/";
            $phone =  $mobile = $s_mobile =  $this->input->post('s_mobile1');
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

            $s_fullname = $answer->full_name;
            $s_address = $answer->phone;
            $s_email = '';
            $phone = $s_address = $answer->phone;

            }
            

            $month = date('m');
            $day   = date('d');

            if ($category == "ACSEE") {

                if (($month <= "09") ) {
                   $price = 8500;
                }elseif(($month >= "10")){
                    $price = 8500;
                }else{
                    $this->load->view('domestic_ems/necta_form');
                }
                
            } elseif ($category == "CSEE") {
                
                if (($month <= "09") ) {
                   $price = 8500;
                }elseif(($month >= "10")){
                    $price = 8500;
                }else{
                    $this->load->view('domestic_ems/necta_form');
                }
            }
            else {
                
                if (($month <= "09") ) {
                   $price = 8500;
                }elseif(($month >= "10")){
                    $price = 8500;
                }else{
                    $this->load->view('domestic_ems/necta_form');
                }
            }
            
            $sender = array();
            $sender = array('ems_type'=>$category,'rnumber'=>$s_rnumber,'s_fullname'=>$s_fullname,'s_address'=>$s_address,'s_mobile'=>$mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$id,'add_type'=>$add);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('from_id'=>$last_id,'fullname'=>$r_name,'address'=>$s_address,'email'=>$r_email,'mobile'=>$r_phone,'r_region'=>$r_region,'branch'=>$rec_branch);

            $db2->insert('receiver_info',$receiver);

            //$this->Loan_Board_model->Save_Receiver_Info($data);

            $source = $this->employee_model->get_code_source($o_region);
            $dest = $this->employee_model->get_code_dest($rec_region);

            $bagsNo = @$source->reg_code.$dest->reg_code;
            $serial    = 'EMS'.date("YmdHis").@$source->reg_code.$this->session->userdata('user_login_id');


             //-------------- Start here
            $emid = $this->session->userdata('user_login_id');
            //getting user or staff department section
            $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

            //for One Man
            $office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';

             $data = array();
             $data = array( 

            'serial'=>$serial,
            'paidamount'=>$price,
            'Barcode'=>strtoupper($Barcode),
             'CustomerID'=>$last_id,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'district'=>$o_branch,
            'transactionstatus'=>'POSTED',
            'office_name'=>$office_one_name,
            'created_by'=>$emid,
            'bill_status'=>'PENDING',
            'paymentFor'=>'NECTA'

            );

            $lastTransId = $this->Box_Application_model->save_transactions($data);

            $paidamount = $price;
            $region = $o_region;
            $district = $o_branch;
            $renter   = $s_fullname;
            $serviceId = 'NECTA';
            $trackno = $bagsNo;

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


            $transaction = $this->getBillGepgBillIdEMS($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

             //echo json_encode($transaction) ;
             //echo $paidamount;

            $serial1 = $serial;

            if (@$transaction->controlno != '') {
                    # code...
                $update = array('billid'=>@$transaction->controlno,'bill_status'=>'SUCCESS');
                $this->billing_model->update_transactions($update,$serial1);

                $first4 = substr(@$transaction->controlno, 4);
                $trackNo = $bagsNo.$first4;

                $data1 = array();
                $data1 = array('track_number'=>$trackNo);

                // $this->Loan_Board_model->update_sender_international($last_id,$data);
                $this->billing_model->update_sender_info($last_id,$data1);

                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= 'Received Counter '.$info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$Barcode,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                 $data['result'] ='KARIBU POSTA KIGANJANI ankara namba hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya EMS NECTA,Kiasi unachotakiwa kulipia ni TSH.'.number_format(@$price,2).' Tumia Track number '.$Barcode.' Kwa ajili ya ufuatiliaji';

                 $sms = $total ='KARIBU POSTA KIGANJANI umepatiwa ankara namba hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya EMS NECTA,Kiasi unachotakiwa kulipia ni TSH.'.number_format(@$price,2).' Tumia Track number '.$Barcode.' Kwa ajili ya ufuatiliaji';

                $this->Sms_model->send_sms_trick($s_mobile,$sms);

                $this->load->view('domestic_ems/necta_control_number',$data);

            }

            
        } else {
            redirect(base_url());
        }    
}


 public function Save_necta_delete_Info()
    {
        if ($this->session->userdata('user_login_access') != false) {
           
            $r_name = $this->input->post('r_name');
            $r_region = $this->input->post('r_region');
            $r_address = $this->input->post('r_address');
            $r_zipcode = $this->input->post('r_zipcode');
            $r_phone = $this->input->post('r_phone');
            $r_email = $this->input->post('r_email');
            $s_rnumber = $this->input->post('rnumber');
            $category = $this->input->post('category');
            $emstype = 'Document';
            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');

            $addtype = $this->input->post('addtype');
            
            $rec_region = "Dar es Salaam";
            $rec_branch = "GPO";

            if ($addtype == "Physical") {
            $add = 'physical';
            $s_fullname = $this->input->post('s_fullname');
            $s_address = $this->input->post('s_address');
            $s_mobile = $mobile = $this->input->post('s_mobile');

            } else {
            
            $add = 'virtual';
            $target_url = "http://192.168.33.7/api/virtual_box/";
            $phone =  $mobile = $s_mobile =  $this->input->post('s_mobile');
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

            $s_fullname = $answer->full_name;
            $s_address = $answer->phone;
            $s_email = '';
            $phone = $s_address = $answer->phone;

            }
            

            $month = date('m');
            $day   = date('d');

            if ($category == "ACSEE") {

                if (($month <= "09") ) {
                   $price = 4500;
                }elseif(($month >= "10")){
                    $price = 4500;
                }else{
                    $this->load->view('domestic_ems/necta_form');
                }
                
            } elseif ($category == "CSEE") {
                
                if (($month <= "09") ) {
                   $price = 4500;
                }elseif(($month >= "10")){
                    $price = 4500;
                }else{
                    $this->load->view('domestic_ems/necta_form');
                }
            }
            else {
                
                if (($month <= "09") ) {
                   $price = 4500;
                }elseif(($month >= "10")){
                    $price = 4500;
                }else{
                    $this->load->view('domestic_ems/necta_form');
                }
            }
            
            $sender = array();
            $sender = array('ems_type'=>$category,'rnumber'=>$s_rnumber,'s_fullname'=>$s_fullname,'s_address'=>$s_address,'s_mobile'=>$mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$id,'add_type'=>$add);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('from_id'=>$last_id,'fullname'=>$r_name,'address'=>$s_address,'email'=>$r_email,'mobile'=>$r_phone,'r_region'=>$r_region,'branch'=>$rec_branch);

            $db2->insert('receiver_info',$receiver);

            //$this->Loan_Board_model->Save_Receiver_Info($data);

            $source = $this->employee_model->get_code_source($o_region);
            $dest = $this->employee_model->get_code_dest($rec_region);

            $bagsNo = @$source->reg_code.$dest->reg_code;
            $serial    = 'EMS'.date("YmdHis").@$source->reg_code.$this->session->userdata('user_login_id');

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
            'paymentFor'=>'NECTA'

            );

            $this->Box_Application_model->save_transactions($data);

            $paidamount = $price;
            $region = $o_region;
            $district = $o_branch;
            $renter   = $s_fullname;
            $serviceId = 'NECTA';
            $trackno = $bagsNo;


            $transaction = $this->getBillGepgBillIdEMS($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

             //echo json_encode($transaction) ;
             //echo $paidamount;

            $serial1 = $serial;

          

            if (@$transaction->controlno != '') {
                    # code...
                $update = array('billid'=>@$transaction->controlno,'bill_status'=>'SUCCESS');
                $this->billing_model->update_transactions($update,$serial1);

                $first4 = substr(@$transaction->controlno, 4);
                $trackNo = $bagsNo.$first4;

                $data1 = array();
                $data1 = array('track_number'=>$trackNo);

                // $this->Loan_Board_model->update_sender_international($last_id,$data);
                $this->billing_model->update_sender_info($last_id,$data1);

                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                 $data['result'] ='KARIBU POSTA KIGANJANI ankara namba hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya EMS NECTA,Kiasi unachotakiwa kulipia ni TSH.'.number_format(@$price,2);

                 $sms = $total ='KARIBU POSTA KIGANJANI umepatiwa ankara namba hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya EMS NECTA,Kiasi unachotakiwa kulipia ni TSH.'.number_format(@$price,2);

                $this->Sms_model->send_sms_trick($s_mobile,$sms);

                $this->load->view('domestic_ems/necta_control_number',$data);

                

            }


            
        } else {
            redirect(base_url());
        }    
}



   public function getBillGepgBillIdEMS($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno){

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

    //create logs
       $value = array();
       $value = array('trackno'=>$trackno,'serviceid'=>$serviceId,'item'=>$renter,'serial'=>$serial);
       $log=json_encode($value);
       $lg = array(
       'response'=>$log
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


    public function necta_transactions_list()
    {
        if ($this->session->userdata('user_login_access') != false) {
           
           $this->load->view('domestic_ems/necta_application_list');
        } else {
            redirect(base_url());
        }
        
    }

    public function find_necta_transactions_list(){
        if ($this->session->userdata('user_login_access') != false) {

           //$data['inter'] = $this->Necta_model->get_necta_list();
           //$data['sum'] = $this->Necta_model->get_necta_sum();

           //$search = $this->input->post('search');
           $fromdata = $this->input->post('fromdate');
           $todate = $this->input->post('todate');
           $status = $this->input->post('status');

           $data['inter'] = $this->Necta_model->find_all_get_necta_search($fromdata,$todate,$status);
              //$data['sum'] = $this->Necta_model->get_sum_necta_search($date,$month,$status);

        
           
           $this->load->view('domestic_ems/necta_application_list',$data);
        } else {
            redirect(base_url());
        }
        
    }

     public function bulk_necta_transactions_list()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['interAll'] = $this->Necta_model->get_bulk_necta_list();
           $data['inter'] = $this->Necta_model->get_bulk_necta_Groupedlist();
           $data['sum'] = $this->Necta_model->get_bulk_necta_sum();

           $search = $this->input->post('search');
           $date = $this->input->post('date');
           $month = $this->input->post('month');
           $status = $this->input->post('status');

           if ($search == "search") {

              $data['inter'] = $this->Necta_model->get_bulk_necta_search($date,$month,$status);
              $data['sum'] = $this->Necta_model->get_bulk_sum_necta_search($date,$month,$status);

           }
           
           $this->load->view('domestic_ems/necta_bulk_application_list',$data);
        } else {
            redirect(base_url());
        }
        
    }
}