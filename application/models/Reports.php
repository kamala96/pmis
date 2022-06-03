 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('Reports_model');
        $this->load->model('Box_Application_model');
        $this->load->model('organization_model');
        $this->load->model('billing_model');
         $this->load->model('unregistered_model');
        $this->load->model('parcel_model');
        $this->load->model('Sms_model');
        $this->load->helper('url');
    }





public function Reports(){
        if ($this->session->userdata('user_login_access') != false) {
            
            //$data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Reports Dashboard');
            $this->load->view('reports/Reports-dashboard',@$data);
            
        } else {
           redirect(base_url());
        }
        
    }

    public function oldboxnotfy(){
        if ($this->session->userdata('user_login_access') != false) {
            
            //$data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Box Sms Dashboard Notification');
            $this->load->view('reports/oldboxnotfy-dashboard',@$data);
            
        } else {
           redirect(base_url());
        }
        
    }


  public function Service_sms(){
        if ($this->session->userdata('user_login_access') != false) {
            
            //$data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Service Sms Notification');
            $this->load->view('reports/Service_sms',@$data);
            
        } else {
           redirect(base_url());
        }
        
    }

  public function Save_Service_sms(){
        if ($this->session->userdata('user_login_access') != false) {

           $Service = $this->input->post('Service');
            $text = $this->input->post('text');
          
             if ($Service == 'Realestate' ) {
            
          
            $DB = 'estate_tenant_information';
            //$boxno ='7199';
            $customerlist =$this->Reports_model->GetRealEstateCustomerList($DB);
            //$customerlist2 =$this->Reports_model->GetCustomerListbybox($DB,$boxno);
           // echo json_encode($customerlist2);
            foreach ($customerlist as $key => $value) {
              # code...
              //send sms
              $mobile = $value->mobile_number;

               $sms =$text;

                $this->Sms_model->send_sms_trick($mobile,$sms);
                //update sms  table
                // $id =$value->id;
                // $this->Reports_model->updatesms($id);
            }

            //echo 'Successfully sent';

               
           }





            
            //$data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Box Sms Dashboard Notification');
            $this->load->view('reports/Service_sms',@$data);
            
        } else {
           redirect(base_url());
        }
        
    }

  public function Custom_sms(){
        if ($this->session->userdata('user_login_access') != false) {
            
            //$data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Custom Sms Notification');
            $this->load->view('reports/Custom_sms',@$data);
            
        } else {
           redirect(base_url());
        }
        
    }

  public function Save_Custom_sms(){
        if ($this->session->userdata('user_login_access') != false) {
            

             $phonenumber = $this->input->post('phonenumber');
            $text = $this->input->post('text');
          
             if (!empty($text) ) {
            
               // convert string to array         
                  $numbers = explode(',', $phonenumber);
                  // remove empty items from array
                  $numbers = array_filter($numbers);
                  // trim all the items in array 
                  $numbers =array_map('trim', $numbers);
                  
                  // default error count
                  $error = 0;
                  // array to store invalid numbers
                  $inValidNumbers = array();
               
                  // loop through all the numbers in array  
                  foreach($numbers as $number) {
                    // number validation we allow only 0 to 9 , min 5 max 14 number only
                    if(!preg_match("/^[0-9,]{5,14}$/", $number)) {
                            $error++; // increment error count
                            // push the invalid numbers into array
                            array_push($inValidNumbers,$number); 
               
                    }
                  }
               
                  if($error != 0) { 
                     'invalid numbers : '. implode(", ", $inValidNumbers);
                  } else {

                    foreach ($numbers as $key => $value) {
                                  # code...
                                  //send sms
                                  $mobile = $value;

                                   $sms =$text;

                                    $this->Sms_model->send_sms_trick($mobile,$sms);
                                    //update sms  table
                                    // $id =$value->id;
                                    // $this->Reports_model->updatesms($id);
                                }

                               // echo 'Successfully sent';
               



            //$data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Custom Sms Notification');
            $this->load->view('reports/Custom_sms',@$data);
            }
          }

        } else {
           redirect(base_url());
        }
        
    }






     public function Notfysms(){
        if ($this->session->userdata('user_login_access') != false) {
            
            //resend
           $resend= $this->input->post('resend');

           if (!empty($resend) ) {
            //update status
             $this->Reports_model->updateNotSentsms();

               
           }


            $this->session->set_userdata('heading','Box Sms Dashboard Notification');
            $DB = 'smsboxnotfy';
            //$boxno ='7199';
            $customerlist =$this->Reports_model->GetCustomerList($DB);
            //$customerlist2 =$this->Reports_model->GetCustomerListbybox($DB,$boxno);
           // echo json_encode($customerlist2);
            foreach ($customerlist as $key => $value) {
              # code...
              //send sms
              $mobile = $value->MobileNumber;
              $boxno =  $value->PostBoxNumber;

               $sms ='Ndugu mteja,Tafadhali lipia sanduku lako namba '.$boxno. ' ili uendelee kutumia na kufurahia huduma za Posta. '.'KARIBU POSTA KIGANJANI';

                $this->Sms_model->send_sms_trick($mobile,$sms);
                //update sms  table
                $id =$value->id;
                $this->Reports_model->updatesms($id);
            }

           // echo 'Successfully sent';

             
             //redirect('reports/oldboxnotfy');

           $this->session->set_userdata('heading','Box Sms Dashboard Notification');
            $this->load->view('reports/oldboxnotfy-dashboard',@$data);
            
        } else {
           redirect(base_url());
        }
        
    }

     public function SmsCustomers(){
        if ($this->session->userdata('user_login_access') != false) {
            
            //$data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Box Customer sms List');
            $DB = 'smsboxnotfy';
           // $customerlist =$this->Reports_model->GetAllCustomerList($DB);
             $customerlist =$this->Reports_model->GetAllCustomerLisWithNumber($DB);//
              $customerlistcount =$this->Reports_model->GetAllCustomerLisWithNumbercount($DB);
           $data['customerlist']= $customerlist;
           $data['customerlistcount']= $customerlistcount;

            $this->load->view('reports/CustomerSmslist',@$data);


           } else {
           redirect(base_url());
        }
      }

       public function SmsCustomersWithoutNUmber(){
        if ($this->session->userdata('user_login_access') != false) {
            
            //$data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Box Customer sms List');
            $DB = 'smsboxnotfy';
           // $customerlist =$this->Reports_model->GetAllCustomerList($DB);
             $customerlist =$this->Reports_model->GetAllCustomerListNONumber($DB);
              $customerlistcount =$this->Reports_model->GetAllCustomerListNONumbercount($DB);
           $data['customerlist']= $customerlist;
             $data['customerlistcount']= $customerlistcount;

            $this->load->view('reports/CustomerSmslistNoNumber',@$data);


           } else {
           redirect(base_url());
        }
      }
public function Edit_SmsCustomersWithoutNUmber()
    {
      if ($this->session->userdata('user_login_access') != false) {
        $this->session->set_userdata('heading','Box Customer sms List');

        $id = $this->input->get('id');
        $DB = 'smsboxnotfy';
        $data['customer']=$customer = $this->Reports_model->getcustomer($id);
         $customerlistcount =$this->Reports_model->GetAllCustomerListNONumbercount($DB);
          $data['customerlistcount']= $customerlistcount;
       

        $this->load->view('reports/editCustomerSmslistNoNumber',@$data);
      } else {
        redirect(base_url());
      }
    }
    


  public function Save_Edit_SmsCustomersWithoutNUmber(){
        if ($this->session->userdata('user_login_access') != false) {

           $id = $this->input->post('id');
           $PostBoxNumber = $this->input->post('PostBoxNumber');
            $MobileNumber = $this->input->post('MobileNumber');
          
            
              $custom = array();
        $custom = array(
          'MobileNumber' => $MobileNumber,
          'PostBoxNumber' => $PostBoxNumber
        );
        //echo json_encode($tenant) ;
           $this->Reports_model->Update_boxcustomer($custom,$id);

            //echo 'Successfully sent';

         

            $DB = 'smsboxnotfy';
        $data['customer']=$customer = $this->Reports_model->getcustomer($id);
         $customerlistcount =$this->Reports_model->GetAllCustomerListNONumbercount($DB);
          $data['customerlistcount']= $customerlistcount;
       

        $this->load->view('reports/editCustomerSmslistNoNumber',@$data);
            
        } else {
           redirect(base_url());
        }
        
    }



     public function General_Report()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

           if (!empty($month) || !empty($date) ) {
               // $data['list'] = $this->Internet_model->get_Internet_list_search($date,$month,$region);
               
           } else 
           {
            //$data['list'] = $this->Internet_model->get_Internet_list();

           }
       //         $controlno = '995120880910';

       //       @$check = $this->billing_model->checkValue($controlno);
       //       @$check2 = $this->unregistered_model->checkValueRegister($controlno);
       //       @$check3 = $this->unregistered_model->checkValueDerivery($controlno);
       //       @$check4 = $this->parcel_model->checkValueParcInter($controlno);


            

       //       $pattern='%EMS%';
       //       $loanbord='%LOAN BOARD%'; 
       //       $NECTA='%NECTA%';
       //       $PCUM='%PCUM%';
       //       $CARGO='%CARGO%';
       //       $MAIL='%MAIL%';
       //       if($this->Reports_model->like_match($pattern, @$check->PaymentFor) OR $this->Reports_model->like_match($MAIL, @$check->serial)  OR $this->Reports_model->like_match($loanbord, @$check->PaymentFor) OR $this->Reports_model->like_match($NECTA, @$check->serial) OR $this->Reports_model->like_match($PCUM, @$check->serial) OR $this->Reports_model->like_match($CARGO, @$check->serial)  )
       //       {
       //        //gett track number
              
       //        if(!empty(@$check->serial))
       //        {
       //          $id = $check->CustomerID;

       //        }
       //        if(!empty(@$check2->serial) OR !empty(@$check3->serial) OR !empty(@$check4->serial))
       //        {
       //          $id = $check2->register_id;

       //        }
              
       //          $db='sender_info';
       //         $sender = $this->Reports_model->get_senderINFObyID($db,$id);
       //  $smobile =$sender->s_mobile;
       //  $trackno = $sender->track_number ;

       //   // echo 'trackno '.$trackno;
       // // echo 'smobile '.$smobile;

       //  $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako  umepokelewa Counter,umepatiwa Track number '.$trackno. ' yenye controlnumber '.$controlno;



       //       $db2 ='receiver_info';
       //       $sender_id =  $sender->sender_id;
       //  $receiver = $this->Reports_model->get_receiverINFO($db2,$sender_id);
       //   $rmobile =$receiver->mobile;


       //    echo 'trackno '.$trackno;
       //   echo 'rmobile '.$rmobile;

       //  $rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako  umepokelewa Counter,umepatiwa Track number '.$trackno. ' yenye controlnumber '.$controlno;

       //          $this->Sms_model->send_sms_trick($smobile,$stotal);
       //          $this->Sms_model->send_sms_trick($rmobile,$rtotal);

       //       }
       //       //mails
       //       $Register='%Register%';
       //       $register_billing='%register_billing%';
       //        $Parcel='%Parcel%';
       //       $PInter='%PInter%'; 
       //       $DSmallPackets='%DSmallPackets%';
       //       if($this->Reports_model->like_match($Register, @$check2->serial) OR $this->Reports_model->like_match($register_billing, @$check->serial) OR
       //       $this->Reports_model->like_match($Parcel, @$check2->serial) OR $this->Reports_model->like_match($PInter, @$check4->serial) OR $this->Reports_model->like_match($DSmallPackets, @$check2->serial)  )
       //       {
       //         //gett track number
              
       //        if(!empty(@$check->serial))
       //        {
       //          $id = $check->CustomerID;

       //        }
       //        if(!empty(@$check2->serial) OR !empty(@$check3->serial) OR !empty(@$check4->serial))
       //        {
       //          $id = $check2->register_id;

       //        }

       //          $db='sender_person_info';
       //        $sender = $this->Reports_model->get_senderbyID($db,$id);
       //        $smobile =$sender->sender_mobile;
       //        $trackno = $sender->track_number ;
       //        $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako  umepokelewa Counter,umepatiwa Track number '.$trackno. ' yenye controlnumber '.$controlno;


       //       $db2 ='receiver_register_info';
       //       $sender_id = $sender->senderp_id;
       //        $receiver = $this->Reports_model->get_receiver($db2,$sender_id);
       //         $rmobile = $receiver->receiver_mobile;
       //     echo ''.$rmobile.' rmoble2';


       //       $rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako  umepokelewa Counter,umepatiwa Track number '.$trackno. ' yenye controlnumber '.$controlno;

       //          $this->Sms_model->send_sms_trick($smobile,$stotal);
       //          $this->Sms_model->send_sms_trick($rmobile,$rtotal);

       //       }
 

           $this->load->view('reports/General_report',@$data);
        } else {
            redirect(base_url());
        }
        
    }

    


public function Regional_report()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

            $id2 = $this->session->userdata('user_login_id');
                        $info = $this->employee_model->GetBasic($id2);
                        $o_region = $info->em_region;
                        $o_branch = $info->em_branch;
                         $id = $info->em_code;
                         $data['region2']=$o_region;
           //echo $region;

           if(empty($region))
            {
              $region=$o_region;
            }
              $data['regionname']=$region;
           if ( $this->session->userdata('user_type') == 'RM') {
             $data['regionname']=$region=$o_region;
           }

           if ($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ADMIN') {
              $region11 = '';
              $data['regionname']=$region;

                //EMS
              $type = 'EMS';//DomesticDocument
                $DB = 'transactions';
              $data['TotalPaidDomesticDocument']=$TotalPaidStamp =$this->Reports_model->get_Paid_Report_list_for_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidDomesticDocument']=$TotalUnPaidStamp =$this->Reports_model->get_UNPaid_Report_list_for_search($type,$date,$month,$region,$DB);
               $type = 'EMSBILLING';//ems posta global bill
                $DB = 'transactions';
              $data['TotalPaidemspostaglobal']=$TotalPaidStamp =$this->Reports_model->get_Paid_Report_list_for_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidemspostaglobal']=$TotalUnPaidStamp =$this->Reports_model->get_UNPaid_Report_list_for_search($type,$date,$month,$region,$DB);
               $type = 'EMS_INTERNATIONAL';//ems international
                $DB = 'transactions';
              $data['TotalPaidemsinternational']=$TotalPaidStamp =$this->Reports_model->get_Paid_Report_list_for_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidemsinternational']=$TotalUnPaidStamp =$this->Reports_model->get_UNPaid_Report_list_for_search($type,$date,$month,$region,$DB);
               $type = 'LOAN BOARD';//Loan Board(HESLB)
                $DB = 'transactions';
              $TOTALpaidloan =$this->Reports_model->get_Paid_Report_list_for_search($type,$date,$month,$region,$DB);
              $TOTALUnpaidloan=$this->Reports_model->get_UNPaid_Report_list_for_search($type,$date,$month,$region,$DB);
               $type = 'EMS_HESLB';//Loan Board(HESLB)
                $DB = 'transactions';
              $TotalPaidHESLB =$this->Reports_model->get_Paid_Report_list_for_search($type,$date,$month,$region,$DB);
              $data['TotalPaidLoanBoard']=$TotalPaidHESLB->amount + $TOTALpaidloan->amount;
               $TotalUnPaidHESLB =$this->Reports_model->get_UNPaid_Report_list_for_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidLoanBoard']=$TotalUnPaidHESLB->amount + $TOTALUnpaidloan->amount;

                $type = 'NECTA';//Necta
                $DB = 'transactions';
              $data['TotalPaidNECTA']=$TotalPaidStamp =$this->Reports_model->get_Paid_Report_list_for_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidNECTA']=$TotalUnPaidStamp =$this->Reports_model->get_UNPaid_Report_list_for_search($type,$date,$month,$region,$DB);



              //   $type = 'Pcum';//Pcum
              //   $DB = 'transactions';
              // $data['TotalPaidPcum']=$TotalPaidStamp =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
              //  $data['TotalUnPaidPcum']=$TotalUnPaidStamp =$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region,$DB);

                $type = 'PCUM';//Pcum
                  $DB = 'transactions';
              $data['TotalPaidPCUM']=$TotalPaidRegister =$this->Reports_model->get_Paid_Report_list_Sender_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidPCUM']=$TotalUnPaidRegister =$this->Reports_model->get_UNPaid_Report_list_Sender_search($type,$date,$month,$region,$DB);


                $type = 'EMS-CARGO';//Ems Cargo
                $DB = 'transactions';
              $data['TotalPaidEmsCargo']=$TotalPaidStamp =$this->Reports_model->get_Paid_Report_list_for_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidEmsCargo']=$TotalUnPaidStamp =$this->Reports_model->get_UNPaid_Report_list_for_search($type,$date,$month,$region,$DB);



                 //MAIL
              $type = 'Register';//DOMESTICREGISTER
                $DB = 'register_transactions';
              $data['TotalPaidDOMESTICREGISTER']=$TotalPaidStamp =$this->Reports_model->get_Paid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidDOMESTICREGISTER']=$TotalUnPaidStamp =$this->Reports_model->get_UNPaid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);

               $type = 'MAIL';//INTERNATIONALREGISTER
                $DB = 'transactions';
              $data['TotalPaidINTERNATIONALREGISTER']=$TotalPaidStamp =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidINTERNATIONALREGISTER']=$TotalUnPaidStamp =$this->Reports_model->get_UNPaid_Report_list_for_search($type,$date,$month,$region,$DB);

               $type = 'register_billing';//REGISTEREDBILL
                $DB = 'transactions';
              $data['TotalPaidREGISTEREDBILL']=$TotalPaidStamp =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidREGISTEREDBILL']=$TotalUnPaidStamp =$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region,$DB);

               $type = 'STAMP';//SALES OF STAMP
                $DB = 'transactions';
              $data['TotalPaidSTAMP'] =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
             $data['TotalUnPaidSTAMP']=$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region,$DB);

               $type = 'PBOX';//PRIVATE BOX RENTAL FEES
                $DB = 'transactions';
              $TotalPaidPBOX =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
              $data['TotalPaidPBOX']=$TotalPaidPBOX;
               $TotalUnPaidPBOX =$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidPBOX']=$TotalUnPaidPBOX;

                 $type = 'AuthorityCard';
                  $DB = 'transactions';
              $data['TotalPaidAuthorityCard']=$TotalPaidRegister =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidAuthorityCard']=$TotalUnPaidRegister =$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region,$DB);

                $type = 'KEYDEPOSITY';
                  $DB = 'transactions';
              $data['TotalPaidKEYDEPOSITY']=$TotalPaidRegister =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidKEYDEPOSITY']=$TotalUnPaidRegister =$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region,$DB);
               

                

                $type = 'CARGO';//POSTSCARGO
                $DB = 'transactions';
              $data['TotalPaidCARGO']=$TotalPaidStamp =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidCARGO']=$TotalUnPaidStamp =$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region,$DB);

                $type = 'Parcel';//PARCEL POST DOMESTIC
                 $DB = 'register_transactions';
              $data['TotalPaidPARCELDOMESTIC']=$TotalPaidStamp =$this->Reports_model->get_Paid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidPARCELDOMESTIC']=$TotalUnPaidStamp =$this->Reports_model->get_UNPaid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
               
               $type = 'PInter';//PARCEL POST INTERNATIONAL
                $DB = 'parcel_international_transactions';
              $data['TotalPaidparcel_international']=$TotalPaidStamp =$this->Reports_model->get_Paid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidparcel_international']=$TotalUnPaidStamp =$this->Reports_model->get_UNPaid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);

               $type = 'DSmallPackets';//SMALL PACKETS DOMESTIC 
                $DB = 'register_transactions';
              $data['TotalPaidDSmallPackets']=$TotalPaidMAIL =$this->Reports_model->get_Paid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidDSmallPackets']=$TotalUnPaidMAIL =$this->Reports_model->get_UNPaid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);

                $type = 'Derivery';//SMALL PACKETS Derivery 
                $DB = 'derivery_transactions';
              $data['TotalPaidDerivery']=$TotalPaidMAIL =$this->Reports_model->get_Paid_Report_list_derivery_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidDerivery']=$TotalUnPaidMAIL =$this->Reports_model->get_UNPaid_Report_list_derivery_search($type,$date,$month,$region,$DB);

              //   $type = 'DSmallPackets';//SMALL PACKETS INTEERNATIONAL -- bado
              //   $DB = 'register_transactions';
              // $data['TotalPaidDSmallPackets']=$TotalPaidMAIL =$this->Reports_model->get_Paid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
              //  $data['TotalUnPaidDSmallPackets']=$TotalUnPaidMAIL =$this->Reports_model->get_UNPaid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);


                $type = 'COMM';
                  $DB = 'transactions';
              $data['TotalPaidCOMM']=$TotalPaidRegister =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidCOMM']=$TotalUnPaidRegister =$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region,$DB); 
                 
                


              //  $type = 'Register';
              //  $DB = 'register_transactions';//'register_transactions';
              // $data['TotalPaidRegister']=$TotalPaidRegister =$this->Reports_model->get_Paid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
              //  $data['TotalUnPaidRegister']=$TotalUnPaidRegister =$this->Reports_model->get_UNPaid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);

               $regioncode =$this->Reports_model->getRegionbyname($region);
                $type = 'Residential';//residential estate_information
                $DB = 'real_estate_transactions';
                $totalinf =$this->Reports_model->get_Paid_Report_list_Estate_search($type,$date,$month,$regioncode->region_id,$DB);
                $totalpaid = 0;
                foreach ($totalinf as $key => $value) {
                  # code...
                  $totalpaid = $totalpaid + $value->amount;
                }
               $data['TotalPaidResidential']=$totalpaid;
                $totalunpaids=$this->Reports_model->get_UNPaid_Report_list_Estate_search($type,$date,$month,$regioncode->region_id,$DB);
               $totalunpaid = 0;
                foreach ($totalunpaids as $key => $value) {
                  # code...
                  $diff =  $value->paidamount - $value->amount;
                  $totalunpaid = $totalunpaid +$diff;
                }
                $data['TotalUnPaidResidential']=$totalunpaid;

               $type = 'Land';//residential Land
                $DB = 'real_estate_transactions';
                 $totalinf =$this->Reports_model->get_Paid_Report_list_Estate_search($type,$date,$month,$regioncode->region_id,$DB);
                $totalpaid = 0;
                foreach ($totalinf as $key => $value) {
                  # code...
                  $totalpaid = $totalpaid + $value->amount;
                }
               $data['TotalPaidLand']=$totalpaid;
                $totalunpaids=$this->Reports_model->get_UNPaid_Report_list_Estate_search($type,$date,$month,$regioncode->region_id,$DB);
               $totalunpaid = 0;
                foreach ($totalunpaids as $key => $value) {
                  # code...
                  $diff =  $value->paidamount - $value->amount;
                  $totalunpaid = $totalunpaid +$diff;
                }
                $data['TotalUnPaidLand']=$totalunpaid;
             

                $type = 'Offices';//residential Offices
                $DB = 'real_estate_transactions';
                 $totalinf =$this->Reports_model->get_Paid_Report_list_Estate_search($type,$date,$month,$regioncode->region_id,$DB);
                $totalpaid = 0;
                foreach ($totalinf as $key => $value) {
                  # code...
                  $totalpaid = $totalpaid + $value->amount;
                }
               $data['TotalPaidOffices']=$totalpaid;
                $totalunpaids=$this->Reports_model->get_UNPaid_Report_list_Estate_search($type,$date,$month,$regioncode->region_id,$DB);
               $totalunpaid = 0;
                foreach ($totalunpaids as $key => $value) {
                  # code...
                  $diff =  $value->paidamount - $value->amount;
                  $totalunpaid = $totalunpaid +$diff;
                }
                $data['TotalUnPaidOffices']=$totalunpaid;
                
               // $data['TotalPaidOffices']=$TotalPaidRegister =$this->Reports_model->get_Paid_Report_list_Estate_search($type,$date,$month,$regioncode->region_id,$DB);
               // $data['TotalUnPaidOffices']=$TotalUnPaidRegister =$this->Reports_model->get_UNPaid_Report_list_Estate_search($type,$date,$month,$regioncode->region_id,$DB);


                $type = 'P';
                  $DB = 'parking_transactions';
              $data['TotalPaidparking']=$TotalPaidRegister =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region11,$DB);
               $data['TotalUnPaidparking']=$TotalUnPaidRegister =$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region11,$DB); 

               $type = 'INTERNET';
                  $DB = 'transactions';
              $data['TotalPaidINTERNET']=$TotalPaidRegister =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidINTERNET']=$TotalUnPaidRegister =$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region,$DB); 

               $type = 'POSTASHOP';
                  $DB = 'transactions';
              $data['TotalPaidPOSTASHOP']=$TotalPaidRegister =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidPOSTASHOP']=$TotalUnPaidRegister =$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region,$DB); 

                $type = 'POSTABUS';
                  $DB = 'transactions';
              $data['TotalPaidPOSTABUS']=$TotalPaidRegister =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
               $data['TotalUnPaidPOSTABUS']=$TotalUnPaidRegister =$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region,$DB); 
              
               



              //   $type = 'BOX POSTA GIRO';
              //     $DB = 'transactions';
              // $data['TotalPaidBOX']=$TotalPaidRegister =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
              //  $data['TotalUnPaidBOX']=$TotalUnPaidRegister =$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region,$DB);
                
              
               


              
               
           } 
           $this->load->view('reports/Regional_report',@$data);
        } else {
            redirect(base_url());
        }
        
    }

   

    
	public function Internet_form()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

          //$country = $this->organization_model->countryselect();
           $data['country'] = $this->organization_model->countryselect();
           //$country = $countries->country_name;

      $this->load->view('internet/Internet_form',$data);
           
        
    }






}
    public function Save_Internet()
    {
        if ($this->session->userdata('user_login_access') != false) {
           
            $InternetDetails = $this->input->post('InternetDetails');
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
            $serial    = 'INTERNET'.date("YmdHis").$source->reg_code;


             $data = array();
             $data = array(

            'serial'=>$serial,
            'item'=>$InternetDetails,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'branch'=>$o_branch,
            'date_created'=>date("YmdHis"),
            'Operator'=> $user,
            'Created_byId'=>$info->em_code

            );

            $this->Internet_model->save_Internets($data);

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
            'paymentFor'=>'Internet'

            );

            $this->Internet_model->save_transactions($data1);



            $paidamount = $Amount;
            $region = $o_region;
            $district = $o_branch;
            $renter   = 'Internet';
            $serviceId = 'Internet';
            $trackno = '90'.$bagsNo;
            $transaction = $this->getBillGepgBillIdInternet($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
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

                 $data['result'] ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Internet,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                 $total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Internet,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                $this->Sms_model->send_sms_trick($mobile,$total);

                $this->load->view('internet/Internet_control_number',$data);
            }else{
                redirect('Internet/Internet_List');
            }


        } else {
            redirect(base_url());
        }    
}

  
public function getBillGepgBillIdInternet($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno){

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