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




public function Collection_Reports(){
        if ($this->session->userdata('user_login_access') != false) {
            
            //$data['cash'] = $this->dashboard_model->get_ems_international();
            $data['region'] = $this->employee_model->regselect();
            $this->session->set_userdata('heading','Reports Dashboard');
            $this->load->view('reports/collection_report',@$data);
            
        } else {
           redirect(base_url());
        }
        
    }


    public function Collection_Search_Reports(){
        if ($this->session->userdata('user_login_access') != false) {
            
                $fromdate =$this->input->post('fromdate'); 
                $todate = $this->input->post('todate');
                $rgeion = $this->input->post('region');

               
                   
                              $type2 = 'EMS';//DomesticDocument paidamount 
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getReportDomesticDocument =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $DomesticDocumentvat=$getReportDomesticDocument->Totalamount * 0.18;
                              $DomesticDocumentvatexlusive=$getReportDomesticDocument->Totalamount -  $DomesticDocumentvat;
                               $DomesticDocumentTotal=$getReportDomesticDocument->Totalamount;

                             


                                $type2 = 'PARCEL CHARGES';//DomesticDocument paidamount 
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getPARCELCHARGESt =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $getPARCELCHARGEStVAT=$getPARCELCHARGESt->Totalamount * 0.18;
                              $getPARCELCHARGESVATEXCLUSIVE=$getPARCELCHARGESt->Totalamount -  $getPARCELCHARGEStVAT;
                               $getPARCELCHARGEStOTAL=$getPARCELCHARGESt->Totalamount;



                                $type2 = 'LOAN BOARD';//LOAN BOARD
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getLOANBOARD =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $getLOANBOARDVAT=$getLOANBOARD->Totalamount * 0.18;
                              $getLOANBOARDVATEXCLUSIVE=$getLOANBOARD->Totalamount -  $getLOANBOARDVAT;
                               $getLOANBOARDTOTAL=$getLOANBOARD->Totalamount;


                               


                             $type2 = 'NECTA';//NECTA 
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getNECTA =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $NECTAVAT=$getNECTA->Totalamount * 0.18;
                              $NECTAVATEXCLUSIVE=$getNECTA->Totalamount -  $NECTAVAT;
                               $NECTATOTAL=$getNECTA->Totalamount;

                                 

                             $type2 = 'EMS';//local bill status=bill paymentfor =ems 
                              $DB = 'transactions';
                              $status = 'Bill';
                            $getlocalbill =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $getlocalbillvat=$getlocalbill->Totalamount * 0.18;
                              $getlocalbillvatexlusive=$getlocalbill->Totalamount -  $getlocalbillvat;
                               $getlocalbillTotal=$getlocalbill->Totalamount;

                            

                             $type2 = 'EMSBILLING';//local bill payed = paymentfor =EMSBILLING   but paid
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getlocalbillpayed =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $getlocalbillpayedvat=$getlocalbillpayed->Totalamount * 0.18;
                              $getlocalbillpayedvatexlusive=$getlocalbillpayed->Totalamount -  $getlocalbillpayedvat;
                               $getlocalbillpayedTotal=$getlocalbillpayed->Totalamount;


                                 $type2 = 'EMS_INTERNATIONAL';//intenational cash paymentfor=EMS_INTERNATIONAL status !=bill
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getEMS_INTERNATIONAL =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $getgetEMS_INTERNATIONALdvat=$getEMS_INTERNATIONAL->Totalamount * 0.18;
                              $getgetEMS_INTERNATIONALvatexlusive=$getEMS_INTERNATIONAL->Totalamount -  $getgetEMS_INTERNATIONALdvat;
                               $getgetEMS_INTERNATIONALTotal=$getEMS_INTERNATIONAL->Totalamount;



                                 $type2 = 'EMS_INTERNATIONAL';//intenational bill paymentfor=EMS_INTERNATIONAL status =bill
                              $DB = 'transactions';
                              $status = 'Bill';
                            $getEMS_INTERNATIONALBILL =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $getgetEMS_INTERNATIONALBILLdvat=$getEMS_INTERNATIONALBILL->Totalamount * 0.18;
                              $getgetEMS_INTERNATIONALBILLvatexlusive=$getEMS_INTERNATIONALBILL->Totalamount -  $getgetEMS_INTERNATIONALBILLdvat;
                               $getgetEMS_INTERNATIONALBILLTotal=$getEMS_INTERNATIONALBILL->Totalamount;



                                   


                            //      $type2 = 'EMS_INTERNATIONAL';//iinternationbill paymentfor=EMS BILLINGIN TERNATIONAL   payed bill
                            //   $DB = 'transactions';
                            //   $status = 'Bill';
                            // $getEMS_INTERNATIONALBILL =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            // $getgetEMS_INTERNATIONALBILLdvat=$getEMS_INTERNATIONALBILL->Totalamount * 0.18;
                            //   $getgetEMS_INTERNATIONALBILLTotal=$getEMS_INTERNATIONALBILL->Totalamount -  $getgetEMS_INTERNATIONALBILLdvat;
                            //    $getgetEMS_INTERNATIONALBILLvatexlusive=$getEMS_INTERNATIONALBILL->Totalamount;


                               $sumitem=($getReportDomesticDocument->Itemno + $getPARCELCHARGESt->Itemno + $getLOANBOARD->Itemno + $getNECTA->Itemno + $getlocalbill->Itemno +  $getEMS_INTERNATIONAL->Itemno + $getEMS_INTERNATIONALBILL->Itemno);
                                 $sumvat=($DomesticDocumentvat + $getPARCELCHARGEStVAT +   $getLOANBOARDVAT + $NECTAVAT +  $getlocalbillvat + $getgetEMS_INTERNATIONALdvat + $getgetEMS_INTERNATIONALBILLdvat);
                                  $sumvatexclusive=($DomesticDocumentvatexlusive +  $getPARCELCHARGESVATEXCLUSIVE + $getLOANBOARDVATEXCLUSIVE + $NECTAVATEXCLUSIVE + $getlocalbillvatexlusive +$getgetEMS_INTERNATIONALvatexlusive +  $getgetEMS_INTERNATIONALBILLvatexlusive);
                                   $sumitotal=($DomesticDocumentTotal +  $getPARCELCHARGEStOTAL + $getLOANBOARDTOTAL +  $NECTATOTAL + $getlocalbillTotal + $getgetEMS_INTERNATIONALTotal +  $getgetEMS_INTERNATIONALBILLTotal);
                               


                            echo ' <table class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%" style="width: 100%;font-size: 13px; ">

                                               <tr>
                                                <th> S/N </th>
                                                 <th>SERVICE  </th>
                                                <th> DETAILS </th>
                                                <th> NO OF ITEMS </th>
                                                <th> AMOUNT VAT EXCLUSIVE </th>
                                                <th> VAT </th>
                                                <th> TOTAL </th>
                                            </tr>



                                              



                                             <tr>
                                                <td colspan="7"><b> COURIER&EXPRESS(EMS) </b></td>
                                            </tr>
                                            <tr>
                                                <td>1 </th>
                                                 <td>Ems Postage - Local Cash </th>
                                                <td> Document/Parcel</th>
                                                <td style="text-align: right;">'.$getReportDomesticDocument->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($DomesticDocumentvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($DomesticDocumentvat).'</th>
                                                <td style="text-align: right;"> '.number_format($DomesticDocumentTotal).' </th>
                                            </tr>

                                      
                                            <tr>
                                                <td> </th>
                                                 <td> </th>
                                                <td> Ems Cargo </th>
                                                <td></th>
                                                <td>  </th>
                                                <td></th>
                                                <td>  </th>
                                            </tr>

                                             <tr>
                                                <td> </th>
                                                 <td> </th>
                                                <td > Ems Parcel Charge</th>
                                                <td style="text-align: right;">'.$getPARCELCHARGESt->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($getPARCELCHARGESVATEXCLUSIVE).' </th>
                                                <td style="text-align: right;">'.number_format(0).'</th>
                                                <td style="text-align: right;"> '.number_format($getPARCELCHARGEStOTAL).' </th>
                                            </tr>


                                            <tr>
                                                <td> </th>
                                                 <td> </th>
                                                <td> Loan Board(HELSB)</th>
                                                <td style="text-align: right;">'.$getLOANBOARD->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($getLOANBOARDVATEXCLUSIVE).' </th>
                                                <td style="text-align: right;">'.number_format($getLOANBOARDVAT).'</th>
                                                <td style="text-align: right;"> '.number_format($getLOANBOARDTOTAL).' </th>
                                            </tr>



                                             <tr>
                                                <td> </th>
                                                 <td> </th>
                                                <td> NECTA</th>
                                                <td style="text-align: right;">'.$getNECTA->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($NECTAVATEXCLUSIVE).' </th>
                                                <td style="text-align: right;">'.number_format($NECTAVAT).'</th>
                                                <td style="text-align: right;"> '.number_format($NECTATOTAL).' </th>
                                            </tr>

                                              <tr>
                                                <th>  </th>
                                                 <th>  </th>
                                                <th>  </th>
                                                <th>  </th>
                                                <th>  </th>
                                                <th>  </th>
                                                <th> </th>
                                            </tr>
                                           

                                             <tr>
                                                <td>2 </th>
                                                 <td>Ems Postage - Local Bill </th>
                                                <td> Document/Parcel</th>
                                                <td style="text-align: right;">'.$getlocalbill->Itemno.'</th>
                                                <td style="text-align: right;">'.number_format($getlocalbillvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($getlocalbillvat).'</th>
                                                <td style="text-align: right;"> '.number_format($getlocalbillTotal).' </th>
                                            </tr>

                                            

                                            <tr>
                                                <td>3 </th>
                                                 <td>Ems Postage - Local Payed Bill </th>
                                                <td> Document/Parcel</th>
                                                <td style="text-align: right;">'.$getlocalbillpayed->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($getlocalbillpayedvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($getlocalbillpayedvat).'</th>
                                                <td style="text-align: right;"> '.number_format($getlocalbillpayedTotal).' </th>
                                            </tr>

                                               <tr>
                                                <th>  </th>
                                                 <th>  </th>
                                                <th>  </th>
                                                <th>  </th>
                                                <th>  </th>
                                                <th>  </th>
                                                <th> </th>
                                            </tr>



                                             <tr>
                                                <td>4 </th>
                                                 <td>Ems Postage - International cash </th>
                                                <td> Document/Parcel</th>
                                                <td style="text-align: right;">'.$getEMS_INTERNATIONAL->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($getgetEMS_INTERNATIONALvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($getgetEMS_INTERNATIONALdvat).'</th>
                                                <td style="text-align: right;"> '.number_format($getgetEMS_INTERNATIONALTotal).' </th>
                                            </tr>
                                             <tr>
                                                <th>  </th>
                                                 <th>  </th>
                                                <th>  </th>
                                                <th>  </th>
                                                <th>  </th>
                                                <th>  </th>
                                                <th> </th>
                                            </tr>


                                            <tr>
                                                <td>5 </th>
                                                 <td>Ems Postage - International  Bill </th>
                                                <td> Document/Parcel</th>
                                                <td style="text-align: right;">'.$getEMS_INTERNATIONALBILL->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($getgetEMS_INTERNATIONALBILLvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($getgetEMS_INTERNATIONALBILLdvat).'</th>
                                                <td style="text-align: right;"> '.number_format($getgetEMS_INTERNATIONALBILLTotal).' </th>
                                            </tr>
                                            <tr>
                                                <td>6 </th>
                                                 <td>Ems Postage - International Payed  Bill </th>
                                                <td> Document/Parcel</th>
                                                <td style="text-align: right;">0</th>
                                                <td style="text-align: right;"> '.number_format(0).' </th>
                                                <td style="text-align: right;">'.number_format(0).'</th>
                                                <td style="text-align: right;"> '.number_format(0).' </th>
                                            </tr>

                                             <tr>
                                                <th>  </th>
                                                 <th>  </th>
                                                <th>  </th>
                                                <th>  </th>
                                                <th>  </th>
                                                <th>  </th>
                                                <th> </th>
                                            </tr>


                                                

                                              <tr>
                                                <td> </th>
                                                 <td> </th>
                                                <td> <b>TOTAL</b></th>
                                                <td style="text-align: right;"><b>'.$sumitem.'</b></th>
                                                 <td style="text-align: right;"><b>'.number_format($sumvatexclusive).'</b></th>
                                                <td style="text-align: right;"> <b>'.number_format($sumvat).' </b></th>
                                                <td style="text-align: right;"><b> '.number_format($sumitotal).'</b> </th>
                                            </tr>


                                            
                                        </table>';





          
            
        } else {
           redirect(base_url());
        }
        
    }

    public function print_collection_report(){
$empid =  $this->session->userdata('user_emid');
$data['info'] = $this->ContractModel->get_employee_info($empid);

//Input date
$data['fromdate'] = $fromdate = $this->input->get('fromdate');
$data['todate'] = $todate = $this->input->get('todate');

//Collection Reports
////////EMS CASH AND BILL TRANSACTIONS
$data['emscashlist'] = $this->Collection_Model->get_ems_employee_report($fromdate,$todate);
$data['emsbilllist'] = $this->Collection_Model->get_ems_employee_bill_report($fromdate,$todate);

///////////MAILS CASH AND BILL TRANSACTIONS
$data['mailcashlist'] = $this->Collection_Model->get_cash_mail_employee_report($fromdate,$todate);
$data['mailbilllist'] = $this->Collection_Model->get_bill_mail_employee_report($fromdate,$todate);

////////// /Delivery Registered (RDP,FPL)
$data['deliveryintlist'] = $this->Collection_Model->emp_list_registered_international_list_search($fromdate,$todate);

////////////Small Packets Delivery (FGN)
$data['smallpacketlist'] = $this->Collection_Model->employee_smallpacket_delivery_application_list($fromdate,$todate);

 //$this->load->library('Pdf');
 $this->load->view('E_reports/collection_report',$data);
 //$this->dompdf->loadHtml($html);
 //$this->dompdf->setPaper('A4','potrait');
 //$this->dompdf->render();
 //ob_end_clean();
 //$this->dompdf->stream($reportcode, array("Attachment"=>0));
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

     public function Transaction_report(){
        if ($this->session->userdata('user_login_access') != false) {
            
            //$data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Transaction Report');
            $this->load->view('reports/Reports-transaction',@$data);
            
        } else {
           redirect(base_url());
        }
        
    }


     public function Transactions()
    {
        
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');
           $status= $this->input->post('status');
            $controlno= $this->input->post('controlno');

          
        


           if (!empty($month) || !empty($date) || !empty($region) || !empty($controlno) )
            {
                 $DB='transactions';
               $data['list'] = $transactions1 = $this->Reports_model->Checkintransactions($DB,$controlno);

              if(empty($transactions1))
              {

                $DB='register_transactions';
               $data['list'] =  $transactions2 = $this->Reports_model->Checkintransactions1($DB,$controlno);

               if(empty($transactions2))
              {
                $DB='derivery_transactions';
               $data['list'] = $transactions3 = $this->Reports_model->Checkintransactions2($DB,$controlno);


                if(empty($transactions3))
              {
                $DB='parcel_international_transactions';
                $data['list'] = $transactions4 = $this->Reports_model->Checkintransactions3($DB,$controlno);


                if(empty($transactions4))
              {
                  $DB='parking_transactions';
                $data['list'] =$transactions5 = $this->Reports_model->Checkintransactions4($DB,$controlno);

                 if(empty($transactions5))
              {
                  $DB='real_estate_transactions';
                $data['list'] = $transactions7 = $this->Reports_model->Checkintransactions6($DB,$controlno);

              }

              }

              }

              }

                //$DB='parking_wallet';
                //$data['list'] = $transactions6 = $this->Reports_model->Checkintransactions5($DB,$controlno);

               

              }
                

                
               

           } else 
           {

             $data['list'] = $this->Reports_model->Checkintransactions12();

           }


           
           $this->load->view('reports/transaction_list',@$data);
        } else {
            redirect(base_url());
        }
        
    }


    public function Service_Reports(){
        if ($this->session->userdata('user_login_access') != false) {
            
            //$data['cash'] = $this->dashboard_model->get_ems_international();
            // $this->session->set_userdata('heading','Box Sms Dashboard Notification');
            $this->load->view('reports/service_report_graph',@$data);
            
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
            $smstext = $this->input->post('smstext');
          
             if ($Service == 'Realestate' ) {
            
          
            $DB = 'estate_tenant_information';
            //$boxno ='7199';
            $customerlist =$this->Reports_model->GetRealEstateCustomerList($DB);
            //$customerlist2 =$this->Reports_model->GetCustomerListbybox($DB,$boxno);
           // echo json_encode($customerlist2);
            $yote = "";
            foreach ($customerlist as $key => $value) {
              # code...
              //send sms
               $mobile = $value->mobile_number;
               $sms =$smstext;
               $servicename='Realestate';
               $this->Sms_model->send_sms_trick2($mobile,$sms,$servicename);


               //$yote = $yote.' ,'.$mobile;
               
            }

                //              echo $yote;
           

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
                                    $servicename='CustomSms';
                                    $this->Sms_model->send_sms_trick2($mobile,$sms,$servicename);

                                   // $this->Sms_model->send_sms_trick($mobile,$sms);
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
     public function RealestateSmslist(){
        if ($this->session->userdata('user_login_access') != false) {
            
            //$data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Realestate sms List');
            $DB = 'smsresend';
           // $customerlist =$this->Reports_model->GetAllCustomerList($DB);
             $customerlist =$this->Reports_model->GetRealestateCustomerSms($DB);//
              $customerlistcount =$this->Reports_model->GetRealestateCustomerSmscount($DB);
           $data['customerlist']= $customerlist;
           $data['customerlistcount']= $customerlistcount;

            $this->load->view('reports/RealestateSmslist',@$data);


           } else {
           redirect(base_url());
        }
      }

     public function SmsCustomers(){
        if ($this->session->userdata('user_login_access') != false) {
            
            //$data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Box Customer sms List');
             $data['region'] = $this->employee_model->regselect();
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

      public function sms_Search()
{
if ($this->session->userdata('user_login_access') != False) {
$id = $this->session->userdata('user_login_id');
        $info = $this->employee_model->GetBasic($id);
        $region2 =$info->em_region;
        $branch = $info->em_branch;


         $o_region = $this->session->userdata('user_region');


         $name = $this->input->post('name');
         $box = $this->input->post('box');
           $mobile= $this->input->post('mobile');
           $region= $this->input->post('region');
            $data['region'] = $this->employee_model->regselect();


            $DB = 'smsboxnotfy';
             $customerlist =$this->Reports_model->GetAllCustomerLisWithNumbersearch($DB,$name,$mobile,$box);//
             $customerlistcount =$this->Reports_model->GetAllCustomerLisWithNumbercountsearch($DB,$name,$mobile,$box);//
           

           $data['customerlist']= $customerlist;
           $data['customerlistcount']= $customerlistcount;
         
 $this->load->view('reports/CustomerSmslist',@$data);
            
}else{
redirect(base_url(), 'refresh');
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


  public function Get_Service_Reports(){
                  if ($this->session->userdata('user_login_access') != false){
                    $date = $this->input->post('date_time');
                    $first = $this->input->post('first');
                    $second = $this->input->post('second');
                    $type = $this->input->post('type');
                    //$cate = $this->input->post('cat');
                    $season = $this->input->post('sreport');

                    $Dayfirst = $this->input->post('Dayfirst');
                    $Daysecond = $this->input->post('Daysecond');

                    //echo $Dayfirst.'  '.$Daysecond;

                      $yearday = date('Y',strtotime($date));
                      $monthday = date('m',strtotime($date));
                      $dayday = date('d',strtotime($date));


                      // $year = date('Y',strtotime($Dayfirst));
                      // $month = date('m',strtotime($Dayfirst));
                      // $day = date('d',strtotime($Dayfirst));



                      // $year1 = date('Y',strtotime($Daysecond));
                      // $month1 = date('m',strtotime($Daysecond));
                      // $day1 = date('d',strtotime($Daysecond));

                       $year = date('Y',strtotime($date));
//$year = date('Y',strtotime($first));
                        $monthf = date('m',strtotime($first));
//$months = date('m',strtotime($second));

                        $datek = explode('-', $second);
                        $months  = @$datek[0];
                        $yearMonthBtn = @$datek[1];

                        $date = explode('-', $date);
                        $dayelse  = @$date[0];
                        $yearelse = @$date[1];



                    if ($season == 'Day') {

                          if ( $type == 'DOCUMENT')
                           {

                               $type2 = 'EMS';//DomesticDocument
                              $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                           }
                            elseif ( $type == 'GLOBAL')
                           {
                             $type2 = 'EMSBILLING';//ems posta global bill
                            $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'INTERNATIONAL')
                           {
                             $type2 = 'EMS_INTERNATIONAL';//ems international
                            $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'LOAN')
                           {

                             $type2 = 'LOAN BOARD';//Loan Board(HESLB)
                             $type1 = 'EMS_HESLB';//Loan Board(HESLB)
                              $DB = 'transactions';
                            $TOTALpaidloan =$this->Reports_model->get_General_Paid_Report_graph_double_search($season,$type2,$type1,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                             
                            

                           
                            //$data['TotalPaidLoanBoard']=$TotalPaidHESLB->amount + $TOTALpaidloan->amount;
                             $getReport =$TOTALpaidloan;
                            
                           }
                             elseif ( $type == 'PCUM')
                           {

                              $type2 = 'PCUM';//Pcum
                              $DB = 'transactions';

                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'EMSCARGO')
                           {
                            $type2 = 'EMS-CARGO';//Ems Cargo
                            $DB = 'transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'DOMESTICREGISTER')
                           {
                            $type2 = 'Register';//DOMESTICREGISTER
                            $DB = 'register_transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                          
                            
                           }
                             elseif ( $type == 'INTERNATIONALREGISTER')
                           {
                             $type2 = 'MAIL';//INTERNATIONALREGISTER
                            $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                                        
                           }
                             elseif ( $type == 'REGISTEREDBILL')
                           {

                              $type2 = 'register_billing';//REGISTEREDBILL
                            $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'STAMP')
                           {

                              $type2 = 'STAMP';//SALES OF STAMP
                              $DB = 'transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                                          
                           }
                             elseif ( $type == 'NECTA')
                           {
                              $type2 = 'NECTA';//Necta
                              $DB = 'transactions';
                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'PRIVATE')
                           {
                              $type2 = 'PBOX';//PRIVATE BOX RENTAL FEES
                              $DB = 'transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                             
                            
                           }
                             elseif ( $type == 'AUTHORITY')
                           {

                            $type2 = 'AuthorityCard';
                              $DB = 'transactions';
                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'LOCK')
                           {

                             $type2 = 'KEYDEPOSITY';
                            $DB = 'transactions';
                         $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                       
                                      
                           }
                             elseif ( $type == 'POSTSCARGO')
                           {
                            $type2 = 'CARGO';//POSTSCARGO
                          $DB = 'transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'PARCELDOMESTIC')
                           {
                             $type2 = 'Parcel';//PARCEL POST DOMESTIC
                             $DB = 'register_transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           }
                             elseif ( $type == 'PARCELINTERNATIONAL')
                           {

                            $type2 = 'PInter';//PARCEL POST INTERNATIONAL
                            $DB = 'parcel_international_transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'PACKETSDOMESTIC')
                           {

                             $type2 = 'DSmallPackets';//SMALL PACKETS DOMESTIC 
                            $DB = 'register_transactions';

                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                          
                            
                           }
                             elseif ( $type == 'PACKETSINTERNATIONAL')
                           {

                             //   $type = 'DSmallPackets';//SMALL PACKETS INTEERNATIONAL -- bado
                              //   $DB = 'register_transactions';
                              // $data['TotalPaidDSmallPackets']=$TotalPaidMAIL =$this->Reports_model->get_Paid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
                              //  $data['TotalUnPaidDSmallPackets']=$TotalUnPaidMAIL =$this->Reports_model->get_UNPaid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
                            
                           }
                            elseif ( $type == 'PACKETSDELIVERY')
                           {

                              $type2 = 'Derivery';//SMALL PACKETS Derivery 
                              $DB = 'derivery_transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_derivery_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'WESTERN')
                           {
                             $type2 = 'COMM';
                              $DB = 'transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                           }
                            elseif ( $type == 'TPB')
                           {
                          //   $type2 = 'COMM';
                          //     $DB = 'transactions';
                          // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'CRDB')
                           {
                          //   $type2 = 'COMM';
                          //     $DB = 'transactions';
                          // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'NTERSTATE')
                           {
                           //  $type2 = 'COMM';
                           //    $DB = 'transactions';
                           // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'MOBILE')
                           {
                           //  $type2 = 'COMM';
                           //    $DB = 'transactions';
                           // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'RESIDENTIAL')
                           {

                             
                              $type2 = 'Residential';//residential estate_information
                              $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                              
                            
                           }
                            elseif ( $type == 'OFFICE')
                           {


                            $type2 = 'Offices';//residential Offices
                           $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'LAND')
                           {

                             $type2 = 'Land';//residential Land
                            $DB = 'real_estate_transactions';
                             $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                           }
                            elseif ( $type == 'PARKING')
                           {

                             $type2 = 'P';
                              $DB = 'parking_transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_noregion_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse); 
                            
                           }
                            elseif ( $type == 'INTERNET')
                           {

                             $type2 = 'INTERNET';
                              $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'SHOP')
                           {
                             $type2 = 'POSTASHOP';
                            $DB = 'transactions';
                       $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                           elseif ( $type == 'BUS')
                           {


                          $type2 = 'POSTABUS';
                            $DB = 'transactions';
                       $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }



                   

                    }elseif ($season == 'DayBtn') 
                    {
                      
                        if ( $type == 'DOCUMENT')
                           {

                               $type2 = 'EMS';//DomesticDocument
                              $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                           }
                            elseif ( $type == 'GLOBAL')
                           {
                             $type2 = 'EMSBILLING';//ems posta global bill
                            $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'INTERNATIONAL')
                           {
                             $type2 = 'EMS_INTERNATIONAL';//ems international
                            $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'LOAN')
                           {

                             $type2 = 'LOAN BOARD';//Loan Board(HESLB)
                             $type1 = 'EMS_HESLB';//Loan Board(HESLB)
                              $DB = 'transactions';
                            $TOTALpaidloan =$this->Reports_model->get_General_Paid_Report_graph_double_search($season,$type2,$type1,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                             
                            

                           
                            //$data['TotalPaidLoanBoard']=$TotalPaidHESLB->amount + $TOTALpaidloan->amount;
                             $getReport =$TOTALpaidloan;
                            
                           }
                             elseif ( $type == 'PCUM')
                           {

                              $type2 = 'PCUM';//Pcum
                              $DB = 'transactions';

                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'EMSCARGO')
                           {
                            $type2 = 'EMS-CARGO';//Ems Cargo
                            $DB = 'transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'DOMESTICREGISTER')
                           {
                            $type2 = 'Register';//DOMESTICREGISTER
                            $DB = 'register_transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                          
                            
                           }
                             elseif ( $type == 'INTERNATIONALREGISTER')
                           {
                             $type2 = 'MAIL';//INTERNATIONALREGISTER
                            $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                                        
                           }
                             elseif ( $type == 'REGISTEREDBILL')
                           {

                              $type2 = 'register_billing';//REGISTEREDBILL
                            $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'STAMP')
                           {

                              $type2 = 'STAMP';//SALES OF STAMP
                              $DB = 'transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                                          
                           }
                             elseif ( $type == 'NECTA')
                           {
                              $type2 = 'NECTA';//Necta
                              $DB = 'transactions';
                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'PRIVATE')
                           {
                              $type2 = 'PBOX';//PRIVATE BOX RENTAL FEES
                              $DB = 'transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                             
                            
                           }
                             elseif ( $type == 'AUTHORITY')
                           {

                            $type2 = 'AuthorityCard';
                              $DB = 'transactions';
                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'LOCK')
                           {

                             $type2 = 'KEYDEPOSITY';
                            $DB = 'transactions';
                         $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                       
                                      
                           }
                             elseif ( $type == 'POSTSCARGO')
                           {
                            $type2 = 'CARGO';//POSTSCARGO
                          $DB = 'transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'PARCELDOMESTIC')
                           {
                             $type2 = 'Parcel';//PARCEL POST DOMESTIC
                             $DB = 'register_transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           }
                             elseif ( $type == 'PARCELINTERNATIONAL')
                           {

                            $type2 = 'PInter';//PARCEL POST INTERNATIONAL
                            $DB = 'parcel_international_transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'PACKETSDOMESTIC')
                           {

                             $type2 = 'DSmallPackets';//SMALL PACKETS DOMESTIC 
                            $DB = 'register_transactions';

                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                          
                            
                           }
                             elseif ( $type == 'PACKETSINTERNATIONAL')
                           {

                             //   $type = 'DSmallPackets';//SMALL PACKETS INTEERNATIONAL -- bado
                              //   $DB = 'register_transactions';
                              // $data['TotalPaidDSmallPackets']=$TotalPaidMAIL =$this->Reports_model->get_Paid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
                              //  $data['TotalUnPaidDSmallPackets']=$TotalUnPaidMAIL =$this->Reports_model->get_UNPaid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
                            
                           }
                            elseif ( $type == 'PACKETSDELIVERY')
                           {

                              $type2 = 'Derivery';//SMALL PACKETS Derivery 
                              $DB = 'derivery_transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_derivery_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'WESTERN')
                           {
                             $type2 = 'COMM';
                              $DB = 'transactions';
                        $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                           }
                            elseif ( $type == 'TPB')
                           {
                          //   $type2 = 'COMM';
                          //     $DB = 'transactions';
                          // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'CRDB')
                           {
                          //   $type2 = 'COMM';
                          //     $DB = 'transactions';
                          // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'NTERSTATE')
                           {
                           //  $type2 = 'COMM';
                           //    $DB = 'transactions';
                           // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'MOBILE')
                           {
                           //  $type2 = 'COMM';
                           //    $DB = 'transactions';
                           // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'RESIDENTIAL')
                           {

                             
                              $type2 = 'Residential';//residential estate_information
                              $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                              
                            
                           }
                            elseif ( $type == 'OFFICE')
                           {


                            $type2 = 'Offices';//residential Offices
                           $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'LAND')
                           {

                             $type2 = 'Land';//residential Land
                            $DB = 'real_estate_transactions';
                             $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                           }
                            elseif ( $type == 'PARKING')
                           {

                             $type2 = 'P';
                              $DB = 'parking_transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_noregion_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse); 
                            
                           }
                            elseif ( $type == 'INTERNET')
                           {

                             $type2 = 'INTERNET';
                              $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'SHOP')
                           {
                             $type2 = 'POSTASHOP';
                            $DB = 'transactions';
                       $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                           elseif ( $type == 'BUS')
                           {


                          $type2 = 'POSTABUS';
                            $DB = 'transactions';
                       $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }

                    



                    }elseif ($season == 'Year') {
  //$year = $date;
                     
                      if ( $type == 'DOCUMENT')
                           {

                               $type2 = 'EMS';//DomesticDocument
                              $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                           }
                            elseif ( $type == 'GLOBAL')
                           {
                             $type2 = 'EMSBILLING';//ems posta global bill
                            $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'INTERNATIONAL')
                           {
                             $type2 = 'EMS_INTERNATIONAL';//ems international
                            $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'LOAN')
                           {

                             $type2 = 'LOAN BOARD';//Loan Board(HESLB)
                             $type1 = 'EMS_HESLB';//Loan Board(HESLB)
                              $DB = 'transactions';
                            $TOTALpaidloan =$this->Reports_model->get_General_Paid_Report_graph_double_search($season,$type2,$type1,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                             
                            

                           
                            //$data['TotalPaidLoanBoard']=$TotalPaidHESLB->amount + $TOTALpaidloan->amount;
                             $getReport =$TOTALpaidloan;
                            
                           }
                             elseif ( $type == 'PCUM')
                           {

                              $type2 = 'PCUM';//Pcum
                              $DB = 'transactions';

                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'EMSCARGO')
                           {
                            $type2 = 'EMS-CARGO';//Ems Cargo
                            $DB = 'transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'DOMESTICREGISTER')
                           {
                            $type2 = 'Register';//DOMESTICREGISTER
                            $DB = 'register_transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                          
                            
                           }
                             elseif ( $type == 'INTERNATIONALREGISTER')
                           {
                             $type2 = 'MAIL';//INTERNATIONALREGISTER
                            $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                                        
                           }
                             elseif ( $type == 'REGISTEREDBILL')
                           {

                              $type2 = 'register_billing';//REGISTEREDBILL
                            $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'STAMP')
                           {

                              $type2 = 'STAMP';//SALES OF STAMP
                              $DB = 'transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                                          
                           }
                             elseif ( $type == 'NECTA')
                           {
                              $type2 = 'NECTA';//Necta
                              $DB = 'transactions';
                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'PRIVATE')
                           {
                              $type2 = 'PBOX';//PRIVATE BOX RENTAL FEES
                              $DB = 'transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                             
                            
                           }
                             elseif ( $type == 'AUTHORITY')
                           {

                            $type2 = 'AuthorityCard';
                              $DB = 'transactions';
                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'LOCK')
                           {

                             $type2 = 'KEYDEPOSITY';
                            $DB = 'transactions';
                         $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                       
                                      
                           }
                             elseif ( $type == 'POSTSCARGO')
                           {
                            $type2 = 'CARGO';//POSTSCARGO
                          $DB = 'transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'PARCELDOMESTIC')
                           {
                             $type2 = 'Parcel';//PARCEL POST DOMESTIC
                             $DB = 'register_transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           }
                             elseif ( $type == 'PARCELINTERNATIONAL')
                           {

                            $type2 = 'PInter';//PARCEL POST INTERNATIONAL
                            $DB = 'parcel_international_transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'PACKETSDOMESTIC')
                           {

                             $type2 = 'DSmallPackets';//SMALL PACKETS DOMESTIC 
                            $DB = 'register_transactions';

                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                          
                            
                           }
                             elseif ( $type == 'PACKETSINTERNATIONAL')
                           {

                             //   $type = 'DSmallPackets';//SMALL PACKETS INTEERNATIONAL -- bado
                              //   $DB = 'register_transactions';
                              // $data['TotalPaidDSmallPackets']=$TotalPaidMAIL =$this->Reports_model->get_Paid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
                              //  $data['TotalUnPaidDSmallPackets']=$TotalUnPaidMAIL =$this->Reports_model->get_UNPaid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
                            
                           }
                            elseif ( $type == 'PACKETSDELIVERY')
                           {

                              $type2 = 'Derivery';//SMALL PACKETS Derivery 
                              $DB = 'derivery_transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_derivery_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'WESTERN')
                           {
                             $type2 = 'COMM';
                              $DB = 'transactions';
                        $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                           }
                            elseif ( $type == 'TPB')
                           {
                          //   $type2 = 'COMM';
                          //     $DB = 'transactions';
                          // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'CRDB')
                           {
                          //   $type2 = 'COMM';
                          //     $DB = 'transactions';
                          // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'NTERSTATE')
                           {
                           //  $type2 = 'COMM';
                           //    $DB = 'transactions';
                           // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'MOBILE')
                           {
                           //  $type2 = 'COMM';
                           //    $DB = 'transactions';
                           // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'RESIDENTIAL')
                           {

                             
                              $type2 = 'Residential';//residential estate_information
                              $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                              
                            
                           }
                            elseif ( $type == 'OFFICE')
                           {


                            $type2 = 'Offices';//residential Offices
                           $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'LAND')
                           {

                             $type2 = 'Land';//residential Land
                            $DB = 'real_estate_transactions';
                             $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                           }
                            elseif ( $type == 'PARKING')
                           {

                             $type2 = 'P';
                              $DB = 'parking_transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_noregion_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse); 
                            
                           }
                            elseif ( $type == 'INTERNET')
                           {

                             $type2 = 'INTERNET';
                              $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'SHOP')
                           {
                             $type2 = 'POSTASHOP';
                            $DB = 'transactions';
                       $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                           elseif ( $type == 'BUS')
                           {


                          $type2 = 'POSTABUS';
                            $DB = 'transactions';
                       $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }







                       }elseif ($season == 'MonthBtn') {



                         if ( $type == 'DOCUMENT')
                           {

                               $type2 = 'EMS';//DomesticDocument
                              $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                           }
                            elseif ( $type == 'GLOBAL')
                           {
                             $type2 = 'EMSBILLING';//ems posta global bill
                            $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'INTERNATIONAL')
                           {
                             $type2 = 'EMS_INTERNATIONAL';//ems international
                            $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'LOAN')
                           {

                             $type2 = 'LOAN BOARD';//Loan Board(HESLB)
                             $type1 = 'EMS_HESLB';//Loan Board(HESLB)
                              $DB = 'transactions';
                            $TOTALpaidloan =$this->Reports_model->get_General_Paid_Report_graph_double_search($season,$type2,$type1,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                             
                            

                           
                            //$data['TotalPaidLoanBoard']=$TotalPaidHESLB->amount + $TOTALpaidloan->amount;
                             $getReport =$TOTALpaidloan;
                            
                           }
                             elseif ( $type == 'PCUM')
                           {

                              $type2 = 'PCUM';//Pcum
                              $DB = 'transactions';

                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'EMSCARGO')
                           {
                            $type2 = 'EMS-CARGO';//Ems Cargo
                            $DB = 'transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'DOMESTICREGISTER')
                           {
                            $type2 = 'Register';//DOMESTICREGISTER
                            $DB = 'register_transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                          
                            
                           }
                             elseif ( $type == 'INTERNATIONALREGISTER')
                           {
                             $type2 = 'MAIL';//INTERNATIONALREGISTER
                            $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                                        
                           }
                             elseif ( $type == 'REGISTEREDBILL')
                           {

                              $type2 = 'register_billing';//REGISTEREDBILL
                            $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'STAMP')
                           {

                              $type2 = 'STAMP';//SALES OF STAMP
                              $DB = 'transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                                          
                           }
                             elseif ( $type == 'NECTA')
                           {
                              $type2 = 'NECTA';//Necta
                              $DB = 'transactions';
                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'PRIVATE')
                           {
                              $type2 = 'PBOX';//PRIVATE BOX RENTAL FEES
                              $DB = 'transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                             
                            
                           }
                             elseif ( $type == 'AUTHORITY')
                           {

                            $type2 = 'AuthorityCard';
                              $DB = 'transactions';
                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'LOCK')
                           {

                             $type2 = 'KEYDEPOSITY';
                            $DB = 'transactions';
                         $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                       
                                      
                           }
                             elseif ( $type == 'POSTSCARGO')
                           {
                            $type2 = 'CARGO';//POSTSCARGO
                          $DB = 'transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'PARCELDOMESTIC')
                           {
                             $type2 = 'Parcel';//PARCEL POST DOMESTIC
                             $DB = 'register_transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           }
                             elseif ( $type == 'PARCELINTERNATIONAL')
                           {

                            $type2 = 'PInter';//PARCEL POST INTERNATIONAL
                            $DB = 'parcel_international_transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'PACKETSDOMESTIC')
                           {

                             $type2 = 'DSmallPackets';//SMALL PACKETS DOMESTIC 
                            $DB = 'register_transactions';

                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                          
                            
                           }
                             elseif ( $type == 'PACKETSINTERNATIONAL')
                           {

                             //   $type = 'DSmallPackets';//SMALL PACKETS INTEERNATIONAL -- bado
                              //   $DB = 'register_transactions';
                              // $data['TotalPaidDSmallPackets']=$TotalPaidMAIL =$this->Reports_model->get_Paid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
                              //  $data['TotalUnPaidDSmallPackets']=$TotalUnPaidMAIL =$this->Reports_model->get_UNPaid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
                            
                           }
                            elseif ( $type == 'PACKETSDELIVERY')
                           {

                              $type2 = 'Derivery';//SMALL PACKETS Derivery 
                              $DB = 'derivery_transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_derivery_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'WESTERN')
                           {
                             $type2 = 'COMM';
                              $DB = 'transactions';
                         $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                           }
                            elseif ( $type == 'TPB')
                           {
                          //   $type2 = 'COMM';
                          //     $DB = 'transactions';
                          // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'CRDB')
                           {
                          //   $type2 = 'COMM';
                          //     $DB = 'transactions';
                          // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'NTERSTATE')
                           {
                           //  $type2 = 'COMM';
                           //    $DB = 'transactions';
                           // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'MOBILE')
                           {
                           //  $type2 = 'COMM';
                           //    $DB = 'transactions';
                           // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'RESIDENTIAL')
                           {

                             
                              $type2 = 'Residential';//residential estate_information
                              $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                              
                            
                           }
                            elseif ( $type == 'OFFICE')
                           {


                            $type2 = 'Offices';//residential Offices
                           $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'LAND')
                           {

                             $type2 = 'Land';//residential Land
                            $DB = 'real_estate_transactions';
                             $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                           }
                            elseif ( $type == 'PARKING')
                           {

                             $type2 = 'P';
                              $DB = 'parking_transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_noregion_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse); 
                            
                           }
                            elseif ( $type == 'INTERNET')
                           {

                             $type2 = 'INTERNET';
                              $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'SHOP')
                           {
                             $type2 = 'POSTASHOP';
                            $DB = 'transactions';
                       $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                           elseif ( $type == 'BUS')
                           {


                          $type2 = 'POSTABUS';
                            $DB = 'transactions';
                       $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }

                      }else{




                         if ( $type == 'DOCUMENT')
                           {

                               $type2 = 'EMS';//DomesticDocument
                              $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                           }
                            elseif ( $type == 'GLOBAL')
                           {
                             $type2 = 'EMSBILLING';//ems posta global bill
                            $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'INTERNATIONAL')
                           {
                             $type2 = 'EMS_INTERNATIONAL';//ems international
                            $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'LOAN')
                           {

                             $type2 = 'LOAN BOARD';//Loan Board(HESLB)
                             $type1 = 'EMS_HESLB';//Loan Board(HESLB)
                              $DB = 'transactions';
                            $TOTALpaidloan =$this->Reports_model->get_General_Paid_Report_graph_double_search($season,$type2,$type1,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                             
                            

                           
                            //$data['TotalPaidLoanBoard']=$TotalPaidHESLB->amount + $TOTALpaidloan->amount;
                             $getReport =$TOTALpaidloan;
                            
                           }
                             elseif ( $type == 'PCUM')
                           {

                              $type2 = 'PCUM';//Pcum
                              $DB = 'transactions';

                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'EMSCARGO')
                           {
                            $type2 = 'EMS-CARGO';//Ems Cargo
                            $DB = 'transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'DOMESTICREGISTER')
                           {
                            $type2 = 'Register';//DOMESTICREGISTER
                            $DB = 'register_transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                          
                            
                           }
                             elseif ( $type == 'INTERNATIONALREGISTER')
                           {
                             $type2 = 'MAIL';//INTERNATIONALREGISTER
                            $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                                        
                           }
                             elseif ( $type == 'REGISTEREDBILL')
                           {

                              $type2 = 'register_billing';//REGISTEREDBILL
                            $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'STAMP')
                           {

                              $type2 = 'STAMP';//SALES OF STAMP
                              $DB = 'transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                                          
                           }
                             elseif ( $type == 'NECTA')
                           {
                              $type2 = 'NECTA';//Necta
                              $DB = 'transactions';
                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                             elseif ( $type == 'PRIVATE')
                           {
                              $type2 = 'PBOX';//PRIVATE BOX RENTAL FEES
                              $DB = 'transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                             
                            
                           }
                             elseif ( $type == 'AUTHORITY')
                           {

                            $type2 = 'AuthorityCard';
                              $DB = 'transactions';
                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'LOCK')
                           {

                             $type2 = 'KEYDEPOSITY';
                            $DB = 'transactions';
                         $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                       
                                      
                           }
                             elseif ( $type == 'POSTSCARGO')
                           {
                            $type2 = 'CARGO';//POSTSCARGO
                          $DB = 'transactions';
                           $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'PARCELDOMESTIC')
                           {
                             $type2 = 'Parcel';//PARCEL POST DOMESTIC
                             $DB = 'register_transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           }
                             elseif ( $type == 'PARCELINTERNATIONAL')
                           {

                            $type2 = 'PInter';//PARCEL POST INTERNATIONAL
                            $DB = 'parcel_international_transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                            
                           }
                             elseif ( $type == 'PACKETSDOMESTIC')
                           {

                             $type2 = 'DSmallPackets';//SMALL PACKETS DOMESTIC 
                            $DB = 'register_transactions';

                            $getReport  =$this->Reports_model->get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                          
                            
                           }
                             elseif ( $type == 'PACKETSINTERNATIONAL')
                           {

                             //   $type = 'DSmallPackets';//SMALL PACKETS INTEERNATIONAL -- bado
                              //   $DB = 'register_transactions';
                              // $data['TotalPaidDSmallPackets']=$TotalPaidMAIL =$this->Reports_model->get_Paid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
                              //  $data['TotalUnPaidDSmallPackets']=$TotalUnPaidMAIL =$this->Reports_model->get_UNPaid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
                            
                           }
                            elseif ( $type == 'PACKETSDELIVERY')
                           {

                              $type2 = 'Derivery';//SMALL PACKETS Derivery 
                              $DB = 'derivery_transactions';
                             $getReport  =$this->Reports_model->get_General_Paid_Report_graph_derivery_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'WESTERN')
                           {
                             $type2 = 'COMM';
                              $DB = 'transactions';
                         $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                           
                           }
                            elseif ( $type == 'TPB')
                           {
                          //   $type2 = 'COMM';
                          //     $DB = 'transactions';
                          // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'CRDB')
                           {
                          //   $type2 = 'COMM';
                          //     $DB = 'transactions';
                          // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'NTERSTATE')
                           {
                           //  $type2 = 'COMM';
                           //    $DB = 'transactions';
                           // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'MOBILE')
                           {
                           //  $type2 = 'COMM';
                           //    $DB = 'transactions';
                           // $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'RESIDENTIAL')
                           {

                             
                              $type2 = 'Residential';//residential estate_information
                              $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                              
                            
                           }
                            elseif ( $type == 'OFFICE')
                           {


                            $type2 = 'Offices';//residential Offices
                           $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'LAND')
                           {

                             $type2 = 'Land';//residential Land
                            $DB = 'real_estate_transactions';
                             $DB = 'real_estate_transactions';
                              $getReport =$this->Reports_model->get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                           }
                            elseif ( $type == 'PARKING')
                           {

                             $type2 = 'P';
                              $DB = 'parking_transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_noregion_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse); 
                            
                           }
                            elseif ( $type == 'INTERNET')
                           {

                             $type2 = 'INTERNET';
                              $DB = 'transactions';
                          $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                            elseif ( $type == 'SHOP')
                           {
                             $type2 = 'POSTASHOP';
                            $DB = 'transactions';
                       $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                           elseif ( $type == 'BUS')
                           {


                          $type2 = 'POSTABUS';
                            $DB = 'transactions';
                       $getReport  =$this->Reports_model->get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                      }


                      if ( $type == 'PARKING')
                           {

                                  $arr[] = array();
                                  foreach ($getReport as $value) {
                                    $arr[] = array(
                                      'label' => 'Dar es salaam',
                                      'value' => $value->value
                                    );
                                  }
                                  $data = json_encode($arr);
                                  echo $data;

                           }
                           else
                           {

                                      $arr[] = array();
                                foreach ($getReport as $value) {
                                  $arr[] = array(
                                    'label' => $value->year,
                                    'value' => $value->value
                                  );
                                }
                                $data = json_encode($arr);
                                echo $data;
                           }

                      

                    }
                    else{
                      redirect(base_url());
                    }
                  }

    

     public function Get_Service_Reports_daily(){
                  if ($this->session->userdata('user_login_access') != false){
                    $date = $this->input->post('date_time');
                    $first = $this->input->post('first');
                    $second = $this->input->post('second');
                    $type = $this->input->post('type');
                    //$cate = $this->input->post('cat');
                    $season = $this->input->post('sreport');

                    $Dayfirst = $this->input->post('Dayfirst');
                    $Daysecond = $this->input->post('Daysecond');

                    //echo $Dayfirst.'  '.$Daysecond;

                      $yearday = date('Y',strtotime($date));
                      $monthday = date('m',strtotime($date));
                      $dayday = date('d',strtotime($date));

                       $year = date('Y',strtotime($date));
                        $monthf = date('m',strtotime($first));

                        $datek = explode('-', $second);
                        $months  = @$datek[0];
                        $yearMonthBtn = @$datek[1];

                        $date = explode('-', $date);
                        $dayelse  = @$date[0];
                        $yearelse = @$date[1];



                   

                          if ( $type == '1')
                           {

                               $type2 = 'EMS';//DomesticDocument
                              $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Daily_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                          //   $type2 = 'Register';//DOMESTICREGISTER
                          //   $DB = 'register_transactions';
                          //  $getReport  =$this->Reports_model->get_General_Paid_Daily_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                          //    $type2 = 'PInter';//PARCEL POST INTERNATIONAL
                          //   $DB = 'parcel_international_transactions';
                          // $getReport  =$this->Reports_model->get_General_Paid_Daily_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                          //   $type2 = 'Derivery';//SMALL PACKETS Derivery 
                          //     $DB = 'derivery_transactions';
                          //    $getReport  =$this->Reports_model->get_General_Daily_Paid_Report_graph_derivery_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                          //    $type2 = 'Residential';//residential estate_information
                          //     $DB = 'real_estate_transactions';
                          //     $getReport =$this->Reports_model->get_Daily_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);

                          //        $type2 = 'P';
                          //     $DB = 'parking_transactions';
                          // $getReport  =$this->Reports_model->get_General_Daily_Paid_Report_graph_noregion_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse); 

                           }  else{

                          
                           $type2 = 'EMS';//DomesticDocument
                              $DB = 'transactions';
                            $getReport =$this->Reports_model->get_General_Paid_Daily_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse);
                            
                           }
                           


                                      $arr[] = array();
                                foreach ($getReport as $value) {
                                  $arr[] = array(
                                    'label' => $value->year,
                                    'value' => $value->value
                                  );
                                }
                                $data = json_encode($arr);
                                echo $data;
                           

                    
                    }
                    else{
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
            
              $region11 = '';
              //$data['regionname']=$region;

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
                
              
               
           
           $this->load->view('reports/Regional_report',@$data);
        } else {
            redirect(base_url());
        }
        
    }

   
   public function Service_report()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $from = $this->input->post('from');
            $to = $this->input->post('to');
           $month= $this->input->post('month');
           $year= $this->input->post('year');
          // $region= $this->input->post('region');

            $id2 = $this->session->userdata('user_login_id');
                        $info = $this->employee_model->GetBasic($id2);
                        $o_region = $info->em_region;
                        $o_branch = $info->em_branch;
                         $id = $info->em_code;
                         //$data['region2']=$o_region;
           //echo $region;

           if(empty($region))
            {
              //$region=$o_region;
            }
              //$data['regionname']=$region;
           if ( $this->session->userdata('user_type') == 'RM') {
            // $data['regionname']=$region=$o_region;
           }
            
              $region11 = '';
              //$data['regionname']=$region;

                //EMS
              $type = 'EMS';//DomesticDocument
                $DB = 'transactions';
              $data['TotalPaidDomesticDocument']=$TotalPaidStamp =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidDomesticDocument']=$TotalUnPaidStamp =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $type = 'EMSBILLING';//ems posta global bill
                $DB = 'transactions';
              $data['TotalPaidemspostaglobal']=$TotalPaidStamp =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidemspostaglobal']=$TotalUnPaidStamp =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $type = 'EMS_INTERNATIONAL';//ems international
                $DB = 'transactions';
              $data['TotalPaidemsinternational']=$TotalPaidStamp =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidemsinternational']=$TotalUnPaidStamp =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $type = 'LOAN BOARD';//Loan Board(HESLB)
                $DB = 'transactions';
              $TOTALpaidloan =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
              $TOTALUnpaidloan=$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $type = 'EMS_HESLB';//Loan Board(HESLB)
                $DB = 'transactions';
              $TotalPaidHESLB =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
              $data['TotalPaidLoanBoard']=$TotalPaidHESLB->amount + $TOTALpaidloan->amount;
               $TotalUnPaidHESLB =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidLoanBoard']=$TotalUnPaidHESLB->amount + $TOTALUnpaidloan->amount;

                $type = 'NECTA';//Necta
                $DB = 'transactions';
              $data['TotalPaidNECTA']=$TotalPaidStamp =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidNECTA']=$TotalUnPaidStamp =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);



              //   $type = 'Pcum';//Pcum
              //   $DB = 'transactions';
              // $data['TotalPaidPcum']=$TotalPaidStamp =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
              //  $data['TotalUnPaidPcum']=$TotalUnPaidStamp =$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region,$DB);

                $type = 'PCUM';//Pcum
                  $DB = 'transactions';
              // $data['TotalPaidPCUM']=$TotalPaidRegister =$this->Reports_model->get_General_Paid_Report_list_Sender_person_search($type,$date,$month,$DB);
              //  $data['TotalUnPaidPCUM']=$TotalUnPaidRegister =$this->Reports_model->get_General_UNPaid_Report_list_Sender_person_search($type,$date,$month,$DB);

               $data['TotalPaidPCUM']=$TotalPaidRegister =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidPCUM']=$TotalUnPaidRegister =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);


                $type = 'EMS-CARGO';//Ems Cargo
                $DB = 'transactions';
              $data['TotalPaidEmsCargo']=$TotalPaidStamp =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidEmsCargo']=$TotalUnPaidStamp =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);



                 //MAIL
              $type = 'Register';//DOMESTICREGISTER
                $DB = 'register_transactions';
              // $data['TotalPaidDOMESTICREGISTER']=$TotalPaidStamp =$this->Reports_model->get_General_Paid_Report_list_Sender_person_search($type,$date,$month,$DB);
              //  $data['TotalUnPaidDOMESTICREGISTER']=$TotalUnPaidStamp =$this->Reports_model->get_General_UNPaid_Report_list_Sender_person_search($type,$date,$month,$DB);
               $data['TotalPaidDOMESTICREGISTER']=$TotalPaidStamp =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidDOMESTICREGISTER']=$TotalUnPaidStamp =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);

               $type = 'MAIL';//INTERNATIONALREGISTER
                $DB = 'transactions';
              $data['TotalPaidINTERNATIONALREGISTER']=$TotalPaidStamp =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidINTERNATIONALREGISTER']=$TotalUnPaidStamp =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);

               $type = 'register_billing';//REGISTEREDBILL
                $DB = 'transactions';
              $data['TotalPaidREGISTEREDBILL']=$TotalPaidStamp =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidREGISTEREDBILL']=$TotalUnPaidStamp =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);

               $type = 'STAMP';//SALES OF STAMP
                $DB = 'transactions';
              $data['TotalPaidSTAMP'] =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
             $data['TotalUnPaidSTAMP']=$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);

               $type = 'PBOX';//PRIVATE BOX RENTAL FEES
                $DB = 'transactions';
              $TotalPaidPBOX =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
              $data['TotalPaidPBOX']=$TotalPaidPBOX;
               $TotalUnPaidPBOX =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidPBOX']=$TotalUnPaidPBOX;

                 $type = 'AuthorityCard';
                  $DB = 'transactions';
              $data['TotalPaidAuthorityCard']=$TotalPaidRegister =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidAuthorityCard']=$TotalUnPaidRegister =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);

                $type = 'KEYDEPOSITY';
                  $DB = 'transactions';
              $data['TotalPaidKEYDEPOSITY']=$TotalPaidRegister =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidKEYDEPOSITY']=$TotalUnPaidRegister =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);
               

                

                $type = 'CARGO';//POSTSCARGO
                $DB = 'transactions';
              $data['TotalPaidCARGO']=$TotalPaidStamp =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidCARGO']=$TotalUnPaidStamp =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);

                $type = 'Parcel';//PARCEL POST DOMESTIC
                 $DB = 'register_transactions';
              // $data['TotalPaidPARCELDOMESTIC']=$TotalPaidStamp =$this->Reports_model->get_General_Paid_Report_list_Sender_person_search($type,$date,$month,$DB);
              //  $data['TotalUnPaidPARCELDOMESTIC']=$TotalUnPaidStamp =$this->Reports_model->get_General_UNPaid_Report_list_Sender_person_search($type,$date,$month,$DB);

                $data['TotalPaidPARCELDOMESTIC']=$TotalPaidStamp =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidPARCELDOMESTIC']=$TotalUnPaidStamp =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);

               
               $type = 'PInter';//PARCEL POST INTERNATIONAL
                $DB = 'parcel_international_transactions';
              // $data['TotalPaidparcel_international']=$TotalPaidStamp =$this->Reports_model->get_General_Paid_Report_list_Sender_person_search($type,$date,$month,$DB);
              //  $data['TotalUnPaidparcel_international']=$TotalUnPaidStamp =$this->Reports_model->get_General_UNPaid_Report_list_Sender_person_search($type,$date,$month,$DB);

               $data['TotalPaidparcel_international']=$TotalPaidStamp =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidparcel_international']=$TotalUnPaidStamp =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);

               $type = 'DSmallPackets';//SMALL PACKETS DOMESTIC 
                $DB = 'register_transactions';
              // $data['TotalPaidDSmallPackets']=$TotalPaidMAIL =$this->Reports_model->get_General_Paid_Report_list_Sender_person_search($type,$date,$month,$DB);
              //  $data['TotalUnPaidDSmallPackets']=$TotalUnPaidMAIL =$this->Reports_model->get_General_UNPaid_Report_list_Sender_person_search($type,$date,$month,$DB);

               $data['TotalPaidDSmallPackets']=$TotalPaidMAIL =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidDSmallPackets']=$TotalUnPaidMAIL =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year);

                $type = 'Derivery';//SMALL PACKETS Derivery 
                $DB = 'derivery_transactions';
              $data['TotalPaidDerivery']=$TotalPaidMAIL =$this->Reports_model->get_General_Paid_Report_list_derivery_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidDerivery']=$TotalUnPaidMAIL =$this->Reports_model->get_General_UNPaid_Report_list_derivery_search($type,$from,$to,$month,$DB,$year);



              //   $type = 'DSmallPackets';//SMALL PACKETS INTEERNATIONAL -- bado
              //   $DB = 'register_transactions';
              // $data['TotalPaidDSmallPackets']=$TotalPaidMAIL =$this->Reports_model->get_Paid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
              //  $data['TotalUnPaidDSmallPackets']=$TotalUnPaidMAIL =$this->Reports_model->get_UNPaid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);


                $type = 'COMM';
                  $DB = 'transactions';
              $data['TotalPaidCOMM']=$TotalPaidRegister =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidCOMM']=$TotalUnPaidRegister =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year); 
                 
                


              //  $type = 'Register';
              //  $DB = 'register_transactions';//'register_transactions';
              // $data['TotalPaidRegister']=$TotalPaidRegister =$this->Reports_model->get_Paid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);
              //  $data['TotalUnPaidRegister']=$TotalUnPaidRegister =$this->Reports_model->get_UNPaid_Report_list_Sender_person_search($type,$date,$month,$region,$DB);

               
                $DB = 'real_estate_transactions';
                $totalinf =$this->Reports_model->get_General_Paid_Report_list_Estate_search($from,$to,$month,$DB,$year);
                $totalpaid = 0;
                foreach ($totalinf as $key => $value) {
                  # code...
                  $totalpaid = $totalpaid + $value->amount;
                }
               $data['TotalPaidRealEstate']=$totalpaid;
                $totalunpaids=$this->Reports_model->get_General_UNPaid_Report_list_Estate_search($from,$to,$month,$DB,$year);
               $totalunpaid = 0;
                foreach ($totalunpaids as $key => $value) {
                  # code...
                  $diff =  $value->paidamount - $value->amount;
                  $totalunpaid = $totalunpaid +$diff;
                }
                $data['TotalUnPaidRealEstate']=$totalunpaid;


              
                
               // $data['TotalPaidOffices']=$TotalPaidRegister =$this->Reports_model->get_Paid_Report_list_Estate_search($type,$date,$month,$regioncode->region_id,$DB);
               // $data['TotalUnPaidOffices']=$TotalUnPaidRegister =$this->Reports_model->get_UNPaid_Report_list_Estate_search($type,$date,$month,$regioncode->region_id,$DB);


                $type = 'P';
                  $DB = 'parking_transactions';
              $data['TotalPaidparking']=$TotalPaidRegister =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidparking']=$TotalUnPaidRegister =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year); 

               $type = 'INTERNET';
                  $DB = 'transactions';
              $data['TotalPaidINTERNET']=$TotalPaidRegister =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidINTERNET']=$TotalUnPaidRegister =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year); 

               $type = 'POSTASHOP';
                  $DB = 'transactions';
              $data['TotalPaidPOSTASHOP']=$TotalPaidRegister =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidPOSTASHOP']=$TotalUnPaidRegister =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year); 

                $type = 'POSTABUS';
                  $DB = 'transactions';
              $data['TotalPaidPOSTABUS']=$TotalPaidRegister =$this->Reports_model->get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year);
               $data['TotalUnPaidPOSTABUS']=$TotalUnPaidRegister =$this->Reports_model->get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year); 
              
               



              //   $type = 'BOX POSTA GIRO';
              //     $DB = 'transactions';
              // $data['TotalPaidBOX']=$TotalPaidRegister =$this->Reports_model->get_Paid_Report_list_search($type,$date,$month,$region,$DB);
              //  $data['TotalUnPaidBOX']=$TotalUnPaidRegister =$this->Reports_model->get_UNPaid_Report_list_search($type,$date,$month,$region,$DB);
                
              
               
           
           $this->load->view('reports/Service_report',@$data);
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