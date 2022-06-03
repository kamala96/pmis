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
     

    public function notify_rm_dispatch_zilizopokelewa(){
      
      $infos = $this->Reports_model->GetRM();
      //$result = json_encode($infos);
     // echo '<li>result: ' . print_r($result, true);
      
      //$infos = null;
      if(!empty($infos)){
      foreach ($infos as $key => $info) {
      $o_region = @$info->em_region;
      $operator = @$info->first_name.'  '.@$info->middle_name. '  '.@$info->last_name;
      $mobile='0677028823';//ict
      $mobile1=$info->em_phone;//RM
      $mobile2='0713702203';//bop 
      $mobile3='0758498544';//pmg
      $mobile4='0763717991';//psi
      $mobile5='0754380832';//mail manager
      $mobile6='0756701070';//ems manager
      
      $title='';
      if($info->em_gender == 'Male'){ $title='MR.';}else{$title='MISS.';}
      $role='RM';
      // $emsdespatchInCount = $this->Reports_model->count_yesterdayemsdespatch_in($o_region,$role);
      // $maildespatchInCount = $this->Reports_model->count_yesterdaymaildespatch_in($o_region,$role);
      //'despatch_status'=>'Received'
      $emsdespatchInReceivedCount = $this->Reports_model->count_todayemsdespatch_in_received($o_region,$role);
      $maildespatchInReceivedCount = $this->Reports_model->count_todaymaildespatch_in_received($o_region,$role);
        
      $tz = 'Africa/Nairobi';
      $tz_obj = new DateTimeZone($tz);
      $today = new DateTime("now", $tz_obj);
      $date = $today->format('Y-m-d');
    $sms ='Rm '.@$o_region.'  '.@$title.' '.@$operator.', Dispatch za EMS zilizopokelewa '.@$emsdespatchInReceivedCount.', MAIL Dispatch zilizopokelewa '.@$maildespatchInReceivedCount.' leo tarehe '.$date;
    $this->Sms_model->send_sms_trick($mobile,$sms);
    $this->Sms_model->send_sms_trick($mobile1,$sms);
    $this->Sms_model->send_sms_trick($mobile2,$sms);
    $this->Sms_model->send_sms_trick($mobile3,$sms);
    $this->Sms_model->send_sms_trick($mobile4,$sms);
    $this->Sms_model->send_sms_trick($mobile5,$sms);
    $this->Sms_model->send_sms_trick($mobile6,$sms);
    }
  }


    }


    
    public function notify_rm_dispatch_zilizotumwa(){
      
      $infos = $this->Reports_model->GetRM();
      //$result = json_encode($infos);
      //echo '<li>result: ' . print_r($result, true);
      
      //$infos = null;
      if(!empty($infos)){
      foreach ($infos as $key => $info) {
      $o_region = @$info->em_region;
      $operator = @$info->first_name.'  '.@$info->middle_name. '  '.@$info->last_name;
      $mobile='0677028823';//ict
      $mobile1=$info->em_phone;//RM
      $mobile2='0713702203';//bop 
      $mobile3='0758498544';//pmg
      $mobile4='0763717991';//psi
      $mobile5='0754380832';//mail manager
      $mobile6='0756701070';//ems manager
      
      $title='';
      if($info->em_gender == 'Male'){ $title='MR.';}else{$title='MISS.';}
      $role='RM';
      $emsdespatchInCount = $this->Reports_model->count_yesterdayemsdespatch_in($o_region,$role);
      $maildespatchInCount = $this->Reports_model->count_yesterdaymaildespatch_in($o_region,$role);
      $tz = 'Africa/Nairobi';
      $tz_obj = new DateTimeZone($tz);
      $today = new DateTime("now", $tz_obj);
      $date = $today->format('Y-m-d');

    $sms ='Rm '.@$o_region.'  '.@$title.' '.@$operator.', Dispatch za EMS zilitumwa '.@$emsdespatchInCount.', MAIL Dispatch zilizotumwa '.@$maildespatchInCount.' leo tarehe '.$date;
    $this->Sms_model->send_sms_trick($mobile,$sms);
    $this->Sms_model->send_sms_trick($mobile1,$sms);
    $this->Sms_model->send_sms_trick($mobile2,$sms);
    $this->Sms_model->send_sms_trick($mobile3,$sms);
    $this->Sms_model->send_sms_trick($mobile4,$sms);
    $this->Sms_model->send_sms_trick($mobile5,$sms);
    $this->Sms_model->send_sms_trick($mobile6,$sms);
    }
  }


    }


    public function notify_rm(){
      
      $infos = $this->Reports_model->GetRM();
      //$result = json_encode($infos);
     // echo '<li>result: ' . print_r($result, true);
      
      //$infos = null;
      if(!empty($infos)){
      foreach ($infos as $key => $info) {
      $o_region = @$info->em_region;
      $operator = @$info->first_name.'  '.@$info->middle_name. '  '.@$info->last_name;
      $mobile='0677028823';//ict
      $mobile1=$info->em_phone;//RM
      $mobile2='0713702203';//bop 
      $mobile3='0758498544';//pmg
      $mobile4='0763717991';//psi
      $mobile5='0754380832';//mail manager
      $mobile6='0756701070';//ems manager
      
      $title='';
      if($info->em_gender == 'Male'){ $title='MR.';}else{$title='MISS.';}
      $role='RM';
      $emsdespatchInCount = $this->Reports_model->count_emsdespatch_in($o_region,$role);
      $maildespatchInCount = $this->Reports_model->count_maildespatch_in($o_region,$role);
      //'despatch_status'=>'Received'
      $emsdespatchInReceivedCount = $this->Reports_model->count_emsdespatch_in_received($o_region,$role);
      $maildespatchInReceivedCount = $this->Reports_model->count_maildespatch_in_received($o_region,$role);
        $sumin= $emsdespatchInCount +  $maildespatchInCount;
        $sumreceived= $emsdespatchInReceivedCount +  $maildespatchInReceivedCount;
        $diff=$sumin - $sumreceived;

        $sumems=$emsdespatchInCount + $emsdespatchInReceivedCount;
        $summail=$maildespatchInCount + $maildespatchInReceivedCount;

    $sms ='Ndugu Rm '.@$o_region.'  '.@$title.' '.@$operator.', Una EMS Dispatch '.@$sumems.', zilizofunguliwa '.@$emsdespatchInReceivedCount.' na '.@$emsdespatchInCount.' hazijafunguliwa, Una MAIL Dispatch '.@$summail.', zilizofunguliwa '.@$maildespatchInReceivedCount.', na '.@$maildespatchInCount.' hazijafunguliwa ';
    $this->Sms_model->send_sms_trick($mobile,$sms);
    $this->Sms_model->send_sms_trick($mobile1,$sms);
    $this->Sms_model->send_sms_trick($mobile2,$sms);
    $this->Sms_model->send_sms_trick($mobile3,$sms);
    $this->Sms_model->send_sms_trick($mobile4,$sms);
    $this->Sms_model->send_sms_trick($mobile5,$sms);
    $this->Sms_model->send_sms_trick($mobile6,$sms);
    }
  }


    }

    public function notify_rm2(){
      
      $infos = $this->Reports_model->GetRM();
      foreach ($infos as $key => $info) {
      $o_region = $info->em_region;
      $operator = $info->first_name.'  '.$info->middle_name. '  '.$info->last_name;
      $mobile='0677028823';//$info->em_phone;//0787070508
      $title='';
      if($info->em_gender == 'Male'){ $title='MR.';}else{$title='MISS.';}
      $role='RM';
      $emsdespatchInCount = $this->Reports_model->count_emsdespatch_in($o_region,$role);
      $maildespatchInCount = $this->Reports_model->count_maildespatch_in($o_region,$role);
      //'despatch_status'=>'Received'
      $emsdespatchInReceivedCount = $this->Reports_model->count_emsdespatch_in_received($o_region,$role);
      $maildespatchInReceivedCount = $this->Reports_model->count_maildespatch_in_received($o_region,$role);
        $sumin= $emsdespatchInCount +  $maildespatchInCount;
        $sumreceived= $emsdespatchInReceivedCount +  $maildespatchInReceivedCount;
        $diff=$sumin - $sumreceived;

    $sms ='Ndugu Rm '.$o_region.'  '.$title.' '.$operator.',kulikuwa na dispatch '.$emsdespatchInCount.' za Ems na dispatch '.$maildespatchInCount.' mails, '.$emsdespatchInReceivedCount.' za ems zimefunguliwa, '.$maildespatchInReceivedCount.' za mail zimefunguliwa na '.$diff.' hazijafunguliwa';
    $this->Sms_model->send_sms_trick($mobile,$sms);
    }


    }

    
public function proff_deliver_report()
{
    if ($this->session->userdata('user_login_access') != false) {
            
        //$data['cash'] = $this->dashboard_model->get_ems_international();
        $data['region'] = $this->employee_model->regselect();
        $this->session->set_userdata('heading','Reports Dashboard');
        $this->load->view('reports/proff_delivery_report',@$data);
        
    } else {
       redirect(base_url());
    }
}


public function search_proff_deliver_report()
{
    if ($this->session->userdata('user_login_access') != false) {

      $Barcode =$this->input->post('Barcode'); 
      $hovyo = $this->Box_Application_model->get_delivery_info_by_barcode($Barcode);
      if(!empty($hovyo)){
        $imgs=@$hovyo->image;
      $image= preg_replace('#^data:image/[^;]+;base64,#', '',$imgs);
      //$img = str_replace('data:image/png;base64,', '', $imgs);
      //$imageContent = file_get_contents(@$hovyo->image);
      echo '
      <div class="panel-footer text-center">
<h3> <strong> Barcode Number: '.@$Barcode.'  &nbsp; &nbsp; &nbsp;   </strong> </h3>
</div>
<div style="overflow-x: auto;">
                             <table id="example4" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                
                                 <tr>
                                    <td>Received By</td><td>'.@$hovyo->deliverer_name.'</td>
                                </tr><tr>
                                    <td>Phone Number</td><td>'.@$hovyo->phone.'</td>
                                </tr><tr>
                                    <td>Identity</td><td>'.@$hovyo->identity.'</td>
                                </tr><tr>
                                    <td>Identity No</td><td>'.@$hovyo->identityno.'</td>
                                </tr>
                                <tr>
                                    <td>Derivery Date</td><td>'.@$hovyo->datetime.'</td>
                                </tr><tr>
                                    <td>Signature</td><td>
                                        <img src="data:image/png;base64,'.@$image.'" alt="" width="80" height="80" />
                                        </td>
                                </tr>
                                    
                                </tr>

</table>
</div>
';
  }else{
       
    echo '
    <div class="panel-footer text-center" >
<h3> <strong> For Barcode Number:'.@$Barcode.'  &nbsp; &nbsp; &nbsp;   </strong> </h3>
</div>
<div style="overflow-x: auto;">
                           <table id="example4" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                             <tr>
                                  <td style="color:red;text-align:center;">Not delivered,For more Info, Please Review and trace this Item</td>
                              </tr>

</table>
</div>
';
      }
  
        
    } else {
       redirect(base_url());
    }
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


                $id = $this->session->userdata('user_login_id');
                        $basicinfo = $this->employee_model->GetBasic($id);
                        $basicinfos = $this->employee_model->GetBasic($id);
                        $dep_id = $basicinfos->dep_id;
                         $dep = $this->employee_model->getdepartment1($dep_id);
                         $dep_name='';
                        if (!empty($dep)) {
                            $dep_name = $dep->dep_name;
                        }
                       


        $userType = $this->session->userdata('user_type');

        if($userType != 'ADMIN' && $userType != 'SUPER ADMIN' && $userType != 'ACCOUNTANT-HQ' && $userType != 'CRM' && $userType != 'BOP' && $userType != 'PMG' && $dep_name != 'EMS HQ'){
             $o_region = $this->session->userdata('user_region');
             $rgeion = $o_region;
        }

               
                   
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
                              $getPARCELCHARGESVATEXCLUSIVE=$getPARCELCHARGESt->Totalamount ;
                               $getPARCELCHARGEStOTAL=$getPARCELCHARGESt->Totalamount;



                                $type2 = 'LOAN BOARD';//LOAN BOARD
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getLOANBOARD =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $getLOANBOARDVAT=$getLOANBOARD->Totalamount * 0.18;
                              $getLOANBOARDVATEXCLUSIVE=$getLOANBOARD->Totalamount -  $getLOANBOARDVAT;
                               $getLOANBOARDTOTAL=$getLOANBOARD->Totalamount;


                               $type2 = 'PCUM';//PCUM 
                               $DB = 'transactions';
                               $status = 'Paid';
                             $getPCUM =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                             $PCUMVAT=$getPCUM->Totalamount * 0.18;
                               $PCUMVATEXCLUSIVE=$getPCUM->Totalamount -  $PCUMVAT;
                                $PCUMTOTAL=$getPCUM->Totalamount;


                             
                                 

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


                               $sumitem=($getReportDomesticDocument->Itemno + @$getPCUM->Itemno + $getPARCELCHARGESt->Itemno + $getLOANBOARD->Itemno  + $getlocalbill->Itemno +  $getEMS_INTERNATIONAL->Itemno + $getEMS_INTERNATIONALBILL->Itemno);
                                 $sumvat=($DomesticDocumentvat + $getPARCELCHARGEStVAT + @$PCUMVAT +   $getLOANBOARDVAT +  $getlocalbillvat + $getgetEMS_INTERNATIONALdvat + $getgetEMS_INTERNATIONALBILLdvat);
                                  $sumvatexclusive=($DomesticDocumentvatexlusive +  @$PCUMVATEXCLUSIVE +  $getPARCELCHARGESVATEXCLUSIVE + $getLOANBOARDVATEXCLUSIVE  + $getlocalbillvatexlusive +$getgetEMS_INTERNATIONALvatexlusive +  $getgetEMS_INTERNATIONALBILLvatexlusive);
                                   $sumitotal=($DomesticDocumentTotal +  @$PCUMTOTAL +  $getPARCELCHARGEStOTAL + $getLOANBOARDTOTAL  + $getlocalbillTotal + $getgetEMS_INTERNATIONALTotal +  $getgetEMS_INTERNATIONALBILLTotal);



                                       $sumcashitem=($getReportDomesticDocument->Itemno  + @$getPCUM->Itemno + $getPARCELCHARGESt->Itemno + $getLOANBOARD->Itemno  +  $getEMS_INTERNATIONAL->Itemno );
                                 $sumcashvat=($DomesticDocumentvat + $getPARCELCHARGEStVAT + @$PCUMVAT +   $getLOANBOARDVAT   + $getgetEMS_INTERNATIONALdvat );
                                  $sumcashvatexclusive=($DomesticDocumentvatexlusive +  $PCUMVATEXCLUSIVE +  $getPARCELCHARGESVATEXCLUSIVE + $getLOANBOARDVATEXCLUSIVE   +$getgetEMS_INTERNATIONALvatexlusive );
                                   $sumcashtotal=($DomesticDocumentTotal +  @$PCUMTOTAL + $getPARCELCHARGEStOTAL + $getLOANBOARDTOTAL  + $getgetEMS_INTERNATIONALTotal );



                                   //MAILS

                              $type2 = 'STAMP';//STAMP paidamount 
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getReportSTAMP =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $STAMPvat=0;
                              $DSTAMPvatexlusive=$getReportSTAMP->Totalamount ;
                               $STAMPTotal=$getReportSTAMP->Totalamount;

                                 




                              $type2 = 'register';//register cash = serail like register na billid!=''  na billstatus = SUCCESS  na status paid
                              $DB = 'register_transactions';
                              $status = 'Paid';
                            $getReportregistercash =$this->Reports_model->get_General_mail_cash_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            if($getReportregistercash !== false)
                              {
                                $getReportregistercashItemno= $getReportregistercash->Itemno ;
                                $registercashvat=@$getReportregistercash->Totalamount * 0.18;
                                $registercashvatexlusive=@$getReportregistercash->Totalamount -  $registercashvat;
                                 $registercashTotal=@$getReportregistercash->Totalamount;
                              }
                              else
                              {
                                $getReportregistercashItemno=0;
                                $registercashvat=0;
                                $registercashvatexlusive=0;
                                 $registercashTotal=0;
                              }
                          

                              

                                $type2 = 'register';//register bill = serail like register  na billstatus = BILLING  
                              $DB = 'register_transactions';
                              $status = 'Paid';
                            $getReportregisterbill =$this->Reports_model->get_General_mail_bill_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            if($getReportregisterbill !== false)
                            {
                              $getReportregisterbillItemno= $getReportregisterbill->Itemno ;
                              $registerbillvat=$getReportregisterbill->Totalamount * 0.18;
                              $registerbillvatexlusive=$getReportregisterbill->Totalamount -  $registerbillvat;
                               $registerbillTotal=$getReportregisterbill->Totalamount;
                            }
                            else
                            {
                              $getReportregisterbillItemno=0;
                              $registerbillvat=0;
                              $registerbillvatexlusive=0;
                               $registerbillTotal=0;
                            }
                            
                            
                          



                                


                                $type2 = 'MAILSBILLING';//PAID BILL paidamount 
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getMAILSBILLING =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $getMAILSBILLINGvat=$getMAILSBILLING->Totalamount * 0.18;
                              $getMAILSBILLINGvatexlusive=$getMAILSBILLING->Totalamount -  $getMAILSBILLINGvat;
                               $getMAILSBILLINGTotal=$getMAILSBILLING->Totalamount;



                               //Parcel cash = serail like Parcel na billid!=''  na billstatus = SUCCESS  na status paid
                                 $type2 = 'Parcel';//register cash = serail like register na billid!=''  na billstatus = SUCCESS  na status paid
                              $DB = 'register_transactions';
                              $status = 'Paid';
                            $getReportParcelcash =$this->Reports_model->get_General_mail_cash_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            if($getReportParcelcash !== false)
                            {
                              $getReportParcelcashItemno= $getReportParcelcash->Itemno ;
                              $Parcelrcashvat=$getReportParcelcash->Totalamount * 0.18;
                              $Parcelcashvatexlusive=$getReportParcelcash->Totalamount -  $Parcelrcashvat;
                               $ParcelcashTotal=$getReportParcelcash->Totalamount;
                            }
                            else
                            {
                              $getReportParcelcashItemno=0;
                              $Parcelrcashvat=0;
                              $Parcelcashvatexlusive=0;
                               $ParcelcashTotal=0;
                            }
                           
                           
                            

                           

                                   //parcel unpaid bill = sereail like parcel  na billid=''  na billstatus = BILLING  na status paid
                                      $type2 = 'parcel';//register bill = serail like register  na billstatus = BILLING  
                              $DB = 'register_transactions';
                              $status = 'Paid';
                            $getReportparcelbill =$this->Reports_model->get_General_mail_bill_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            if($getReportparcelbill !== false)
                            {
                              $getReportparcelbillItemno= $getReportparcelbill->Itemno ;
                              $parcelbillvat=$getReportparcelbill->Totalamount * 0.18;
                              $parcelbillvatexlusive=$getReportparcelbill->Totalamount -  $parcelbillvat;
                               $parcelbillTotal=$getReportparcelbill->Totalamount;
                            }
                            else
                            {
                              $getReportparcelbillItemno=0;
                              $parcelbillvat=0;
                              $parcelbillvatexlusive=0;
                               $parcelbillTotal=0;
                            }
                           
                          
                                  

                             // registerinternational = barcode like %RR% billid!=''  na billstatus = SUCCESS  na status paid
                                   $type2 = 'RR';//register cash = serail like register na billid!=''  na billstatus = SUCCESS  na status paid
                              $DB = 'register_transactions';
                              $status = 'Paid';
                            $getReportregisterinternationalash =$this->Reports_model->get_General_mail_cash_BARCODE_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            if($getReportregisterinternationalash !== false)
                            {
                              $getReportregisterinternationalashItemno= $getReportregisterinternationalash->Itemno ;
                              $registerinternationalrcashvat=$getReportregisterinternationalash->Totalamount * 0.18;
                              $registerinternationalcashvatexlusive=$getReportregisterinternationalash->Totalamount -  $registerinternationalrcashvat;
                               $registerinternationalcashTotal=$getReportregisterinternationalash->Totalamount;

                            }
                            else
                            {
                              $getReportregisterinternationalashItemno=0;
                              $registerinternationalrcashvat=0;
                              $registerinternationalcashvatexlusive=0;
                               $registerinternationalcashTotal=0;
                            }
                            
                           
                             


                                   //Parcel intern  cash = serail like PInter na billid!=''  na billstatus = SUCCESS  na status paid
                                     $type2 = 'PInter';
                              $DB = 'register_transactions';
                              $status = 'Paid';
                            $getReportPIntercash =$this->Reports_model->get_General_mail_cash_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            if($getReportPIntercash !== false)
                            {
                              $getReportPIntercashItemno= $getReportPIntercash->Itemno ;
                              $PInterrcashvat=$getReportPIntercash->Totalamount * 0.18;
                              $PIntercashvatexlusive=$getReportPIntercash->Totalamount -  $PInterrcashvat;
                               $PIntercashTotal=$getReportPIntercash->Totalamount;


                            }
                            else
                            {
                              $getReportPIntercashItemno=0;
                              $PInterrcashvat=0;
                              $PIntercashvatexlusive=0;
                               $PIntercashTotal=0;
                            }
                           
                            

                                   //small packets derivery_transactions 5900,2350
                                    $type2 = 'derivery';
                              $DB = 'derivery_transactions';
                              $status = 'Paid';
                            $getReportderiverycash =$this->Reports_model->get_General_mail_cash_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            if($getReportderiverycash !== false)
                            {
                              $getReportderiverycashItemno= $getReportderiverycash->Itemno ;
                              $deriverycashvat=$getReportderiverycash->Totalamount * 0.18;
                              $deriverycashvatexlusive=$getReportderiverycash->Totalamount -  $deriverycashvat;
                               $deriverycashTotal=$getReportderiverycash->Totalamount;
                            }
                            else
                            {
                              $getReportderiverycashItemno=0;
                              $deriverycashvat=0;
                              $deriverycashvatexlusive=0;
                               $deriverycashTotal=0;
                            }
                            
                            

                            //     $type = 'foreig parcel';
                            //    $getReportderiverycash =$this->Reports_model->get_General_mail_delivery_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status,$type);
                            // $deriverycashvat=$getReportderiverycash->Totalamount * 0.18;
                            //   $deriverycashvatexlusive=$getReportderiverycash->Totalamount -  $deriverycashvat;
                            //    $deriverycashTotal=$getReportderiverycash->Totalamount;

                            //     $type = 'rdp';
                            //    $getReportderiverycash =$this->Reports_model->get_General_mail_delivery_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status,$type);
                            // $deriverycashvat=$getReportderiverycash->Totalamount * 0.18;
                            //   $deriverycashvatexlusive=$getReportderiverycash->Totalamount -  $deriverycashvat;
                            //    $deriverycashTotal=$getReportderiverycash->Totalamount;


                                            //  <tr>
                                            //     <td> </th>
                                            //      <td> </th>
                                            //     <td > RDP & DP</th>
                                            //     <td style="text-align: right;">'.$getReportderiverycash->Itemno.'</th>
                                            //     <td style="text-align: right;"> '.number_format($deriverycashvatexlusive).' </th>
                                            //     <td style="text-align: right;">'.number_format($deriverycashvat).'</th>
                                            //     <td style="text-align: right;"> '.number_format($deriverycashTotal).' </th>
                                            // </tr>



                               //POSTBOX
                                $type2 = 'POSTSBOX';
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getReportPOSTSBOXcash =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $POSTSBOXvat=$getReportPOSTSBOXcash->Totalamount * 0.18;
                              $POSTSBOXvatexlusive=$getReportPOSTSBOXcash->Totalamount -  $POSTSBOXvat;
                               $POSTSBOXTotal=$getReportPOSTSBOXcash->Totalamount;

                                //Keydeposity
                                $type2 = 'Keydeposity';
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getReportKeydeposity =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $Keydeposityvat=$getReportKeydeposity->Totalamount * 0.18;
                              $Keydeposityvatexlusive=$getReportKeydeposity->Totalamount -  $Keydeposityvat;
                               $KeydeposityXTotal=$getReportKeydeposity->Totalamount;

                               //AuthorityCard
                                $type2 = 'AuthorityCard';
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getReportAuthorityCard =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $AuthorityCardvat=$getReportAuthorityCard->Totalamount * 0.18;
                              $AuthorityCardvatexlusive=$getReportAuthorityCard->Totalamount -  $AuthorityCardvat;
                               $AuthorityCardTotal=$getReportAuthorityCard->Totalamount;

                               

                               //PostCargo
                                $type2 = 'Post Cargo';
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getReportPostCargo =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $PostCargovat=$getReportPostCargo->Totalamount * 0.18;
                              $PostCargovatexlusive=$getReportPostCargo->Totalamount -  $PostCargovat;
                               $PostCargoTotal=$getReportPostCargo->Totalamount;

                               //Posta mlangoni  unpaid bill = sereail like     Postamlangoni  na billid=''  na billstatus = BILLING  na status paid
                                $type2 = 'Postamlangoni';//register bill = serail like register  na billstatus = BILLING  
                              $DB = 'register_transactions';
                              $status = 'Paid';
                            $getReportPostamlangonibill =$this->Reports_model->get_General_mail_bill_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            if($getReportPostamlangonibill !== false)
                            {
                              $getReportPostamlangonibillItemno= $getReportPostamlangonibill->Itemno ;
                              $Postamlangonibillvat=$getReportPostamlangonibill->Totalamount * 0.18;
                              $Postamlangonibillvatexlusive=$getReportPostamlangonibill->Totalamount -  $Postamlangonibillvat;
                               $PostamlangonibillTotal=$getReportPostamlangonibill->Totalamount;

                            }
                            else
                            {
                              $getReportPostamlangonibillItemno=0;
                              $Postamlangonibillvat=0;
                              $Postamlangonibillvatexlusive=0;
                               $PostamlangonibillTotal=0;
                            }



                                     $sumMAILitem=($getReportSTAMP->Itemno + $getReportregistercashItemno + $getReportparcelbillItemno
                                 + $getReportregisterbillItemno  + $getReportParcelcashItemno  + $getReportAuthorityCard->Itemno  + $getReportregisterinternationalashItemno + $getReportPIntercashItemno + $getReportderiverycashItemno + + $getReportPOSTSBOXcash->Itemno + $getReportKeydeposity->Itemno + $getReportAuthorityCard->Itemno
                             + $getReportPostCargo->Itemno );
                                 $sumMAILvat=($STAMPvat + $registercashvat + $registerbillvat + $Parcelrcashvat + $parcelbillvat + $registerinternationalrcashvat + $PInterrcashvat  + $deriverycashvat  + $POSTSBOXvat + $Keydeposityvat  + $AuthorityCardvat  + $PostCargovat  );
                                  $sumMAILvatexclusive=($DSTAMPvatexlusive + $registercashvatexlusive + $registerbillvatexlusive + $Parcelcashvatexlusive + $parcelbillvatexlusive + $registerinternationalcashvatexlusive +   $PIntercashvatexlusive +   $deriverycashvatexlusive  +   $POSTSBOXvatexlusive +   $Keydeposityvatexlusive
                                  +   $AuthorityCardvatexlusive  +   $PostCargovatexlusive );
                                   $sumMAILitotal=($STAMPTotal +  $registercashTotal +  $registerbillTotal +  $ParcelcashTotal +  $parcelbillTotal +  $registerinternationalcashTotal +  $PIntercashTotal +  $deriverycashTotal  +  $POSTSBOXTotal +  $KeydeposityXTotal  +  $AuthorityCardTotal  +  $PostCargoTotal );



                                     $sumMAILitemcash=($getReportSTAMP->Itemno + $getReportregistercashItemno + $getReportParcelcashItemno  + $getReportAuthorityCard->Itemno  + $getReportregisterinternationalashItemno + $getReportPIntercashItemno + $getReportderiverycashItemno + + $getReportPOSTSBOXcash->Itemno + $getReportKeydeposity->Itemno + $getReportAuthorityCard->Itemno
                             + $getReportPostCargo->Itemno );
                                 $sumMAILcashvat=($STAMPvat + $registercashvat  + $Parcelrcashvat  + $registerinternationalrcashvat + $PInterrcashvat  + $deriverycashvat  + $POSTSBOXvat + $Keydeposityvat  + $AuthorityCardvat  + $PostCargovat  );
                                  $sumMAILcashvatexclusive=($DSTAMPvatexlusive + $registercashvatexlusive  + $Parcelcashvatexlusive  + $registerinternationalcashvatexlusive +   $PIntercashvatexlusive +   $deriverycashvatexlusive  +   $POSTSBOXvatexlusive +   $Keydeposityvatexlusive
                                  +   $AuthorityCardvatexlusive  +   $PostCargovatexlusive );
                                   $sumMAILcashtotal=($STAMPTotal +  $registercashTotal +  $ParcelcashTotal  +  $registerinternationalcashTotal +  $PIntercashTotal +  $deriverycashTotal  +  $POSTSBOXTotal +  $KeydeposityXTotal  +  $AuthorityCardTotal  +  $PostCargoTotal );


                                     //INTERNET  Miscellaneous
                             $type2 = 'INTERNET';
                            $DB = 'transactions';
                            $status = 'Paid';
                          $getINTERNET =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                          $INTERNETVAT=@$getINTERNET->Totalamount * 0.18;
                            $INTERNETVATEXCLUSIVE=@$getINTERNET->Totalamount ;
                             $INTERNETTOTAL=@$getINTERNET->Totalamount;


                              // Miscellaneous
                              $type2 = 'Miscellaneous';
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getMiscellaneous =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $MiscellaneousVAT=@$getMiscellaneous->Totalamount * 0.18;
                              $MiscellaneousVATEXCLUSIVE=@$getMiscellaneous->Totalamount ;
                               $MiscellaneousTOTAL=@$getMiscellaneous->Totalamount;


                           



                                   $type2 = 'Residential';//residential estate_information
                                   $DB = 'real_estate_transactions';
                                   $status = 'Paid';
                                   $getResidential =$this->Reports_model->get_Paid_Report_list_Estate_collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                                   if($getResidential !== false)
                                   {
                                    $ResidentialItemno=@$getResidential->Itemno;
                                    $ResidentialVAT=0;
                                   $ResidentialVATEXCLUSIVE=@$getResidential->Totalamount - $ResidentialVAT;
                                   $ResidentialTOTAL=@$getResidential->Totalamount;
                                   }
                                   else
                                   {
                                     $ResidentialItemno=0;
                                     $ResidentialVAT=0;
                                     $ResidentialVATEXCLUSIVE=0;
                                      $ResidentialTOTAL=0;
                                   }


                                   
                                  

                                   //$type2 = 'Land';//residential Land Offices

                                   $type2 = 'Land';//residential estate_information
                                   $DB = 'real_estate_transactions';
                                   $status = 'Paid';
                                   $getLand =$this->Reports_model->get_Paid_Report_list_Estate_collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                                   if($getLand !== false)
                                   {
                                    $LandItemno=@$getLand->Itemno;
                                    $LandVAT=@$getLand->Totalamount * 0.18;
                                    $LandVATEXCLUSIVE=@$getLand->Totalamount - $LandVAT;
                                    $LandTOTAL=@$getLand->Totalamount;
                                   }
                                   else
                                   {
                                     $LandItemno=0;
                                     $LandVAT=0;
                                     $LandVATEXCLUSIVE=0;
                                      $LandTOTAL=0;
                                   }
                                   
                                   

                                   $type2 = 'Offices';//residential estate_information
                                   $DB = 'real_estate_transactions';
                                   $status = 'Paid';
                                   $getOffices =$this->Reports_model->get_Paid_Report_list_Estate_collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                                   if($getOffices !== false)
                                   {
                                    $OfficesItemno=@$getOffices->Itemno;
                                    $OfficesVAT=@$getOffices->Totalamount * 0.18;
                                   $OfficesVATEXCLUSIVE=@$getOffices->Totalamount - $OfficesVAT;
                                   $OfficesTOTAL=@$getOffices->Totalamount;
                                   }
                                   else
                                   {
                                     $OfficesItemno=0;
                                     $OfficesVAT=0;
                                     $OfficesVATEXCLUSIVE=0;
                                      $OfficesTOTAL=0;
                                   }


                                   //
                                   
                                   $type2 = 'Hall';//residential estate_information
                                   $DB = 'real_estate_transactions';
                                   $status = 'Paid';
                                   $getHall =$this->Reports_model->get_Paid_Report_list_Estate_collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                                   if($getHall !== false)
                                   {
                                    $HallItemno=@$getHall->Itemno;
                                    $HallVAT=0;
                                   $HallVATEXCLUSIVE=@$getHall->Totalamount;
                                   $HallTOTAL=@$getHall->Totalamount;
                                   }
                                   else
                                   {
                                     $HallItemno=0;
                                     $HallVAT=0;
                                     $HallVATEXCLUSIVE=0;
                                      $HallTOTAL=0;
                                   }


                                   $type2 = 'Parking';//Parking
                                   $DB = 'parking_transactions';
                                   $status = 'Paid';
                                   $getParking =$this->Reports_model->get_General_Parking_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                                   if($getParking !== false)
                                   {
                                    $ParkingItemno=@$getParking->Itemno;
                                    $ParkingVAT=0;
                                   $ParkingVATEXCLUSIVE=@$getParking->Totalamount;
                                   $ParkingTOTAL=@$getParking->Totalamount;
                                   }
                                   else
                                   {
                                     $ParkingItemno=0;
                                     $ParkingVAT=0;
                                     $ParkingVATEXCLUSIVE=0;
                                      $ParkingTOTAL=0;
                                   }

                                   

                                   $sumEstate=(@$ResidentialItemno + @$LandItemno + @$OfficesItemno + @$HallItemno + @$ParkingItemno );
                                       $sumEstatevat=(@$ResidentialVAT + @$LandVAT + @$OfficesVAT + @$HallVAT + @$ParkingVAT  );
                                        $sumEstatevatexclusive=(@$ResidentialVATEXCLUSIVE + @$ParkingVATEXCLUSIVE + @$LandVATEXCLUSIVE  + @$OfficesVATEXCLUSIVE  + @$HallVATEXCLUSIVE  );
                                         $sumEstatetotal=(@$ResidentialTOTAL +  @$LandTOTAL +  @$ParkingTOTAL +  @$OfficesTOTAL +  @$HallTOTAL  );

                                    //FAS
                                    $type2 = 'NECTA';//NECTA 
                              $DB = 'transactions';
                              $status = 'Paid';
                            $getNECTA =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                            $NECTAVAT=$getNECTA->Totalamount * 0.18;
                              $NECTAVATEXCLUSIVE=$getNECTA->Totalamount -  $NECTAVAT;
                               $NECTATOTAL=$getNECTA->Totalamount;

                               $type2 = 'COMMISSION';//COMMISSION 
                               $DB = 'transactions';
                               $status = 'Paid';
                             $getCOMMISSION =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                             $COMMISSIONVAT=$getCOMMISSION->Totalamount * 0.18;
                               $COMMISSIONVATEXCLUSIVE=$getCOMMISSION->Totalamount -  $COMMISSIONVAT;
                                $COMMISSIONTOTAL=$getCOMMISSION->Totalamount;

                                $type2 = 'POSTA SHOP';//SHOP 
                               $DB = 'transactions';
                               $status = 'Paid';
                             $getSHOP =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                             $SHOPVAT=$getSHOP->Totalamount * 0.18;
                               $SHOPVATEXCLUSIVE=$getSHOP->Totalamount -  $SHOPVAT;
                                $SHOPTOTAL=$getSHOP->Totalamount;


                                $type2 = 'photocopy';//photocopy
                                $DB = 'transactions';
                                $status = 'Paid';
                              $getphotocopy =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                              $photocopyVAT=0;
                                $photocopyVATEXCLUSIVE=@$getphotocopy->Totalamount ;
                                 $photocopyTOTAL=@$getphotocopy->Totalamount;



                                 //Bureau
                                 $type2 = 'Bureau';
                                 $DB = 'transactions';
                                 $status = 'Paid';
                               $getBureau =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                               $BureauVAT=0;
                                 $BureauVATEXCLUSIVE=@$getBureau->Totalamount ;
                                  $BureauTOTAL=@$getBureau->Totalamount;

                                  //Moneygram
                                 $type2 = 'Moneygram';
                                 $DB = 'transactions';
                                 $status = 'Paid';
                               $getMoneygram =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                               $MoneygramVAT=0;
                                 $MoneygramVATEXCLUSIVE=@$getMoneygram->Totalamount ;
                                  $MoneygramTOTAL=@$getMoneygram->Totalamount;

                                    //Moneygram
                                 $type2 = 'Insurance_commision';
                                 $DB = 'transactions';
                                 $status = 'Paid';
                               $getInsurance_commision =$this->Reports_model->get_General_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status);
                               $Insurance_commisionVAT=0;
                                 $Insurance_commisionVATEXCLUSIVE=@$getInsurance_commision->Totalamount ;
                                  $Insurance_commisionTOTAL=@$getInsurance_commision->Totalamount;

                                $sumFAS=(@$getSHOP->Itemno + @$getCOMMISSION->Itemno + @$getNECTA->Itemno + @$getphotocopy->Itemno + @$getBureau->Itemno + @$getMoneygram->Itemno + @$getInsurance_commision->Itemno );
                                $sumFASvat=(@$SHOPVAT + @$COMMISSIONVAT + @$NECTAVAT +@$photocopyVAT +@$BureauVAT  +@$MoneygramVAT  +@$Insurance_commisionVAT  );
                                 $sumFASvatexclusive=(@$SHOPVATEXCLUSIVE + @$COMMISSIONVATEXCLUSIVE  + @$NECTAVATEXCLUSIVE + @$photocopyVATEXCLUSIVE + @$BureauVATEXCLUSIVE + @$MoneygramVATEXCLUSIVE + @$Insurance_commisionVATEXCLUSIVE  );
                                  $sumFAStotal=(@$SHOPTOTAL +  @$COMMISSIONTOTAL +  @$NECTATOTAL +  @$photocopyTOTAL  +  @$BureauTOTAL +  @$MoneygramTOTAL +  @$Insurance_commisionTOTAL  );



                                   


                            echo '

                            <div class="panel-footer text-center">
<h3> <strong> From:'.@$fromdate.'  &nbsp; &nbsp; &nbsp;  <b>To:</b> </b>'.@$todate.'  </strong> </h3>
</div>

                              





                             <table class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%" style="width: 100%;font-size: 25px; " id="exceldownload">

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
                                                <td> PCUM</th>
                                                <td style="text-align: right;">'.@$getPCUM->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format(@$PCUMVATEXCLUSIVE).' </th>
                                                <td style="text-align: right;">'.number_format(@$PCUMVAT).'</th>
                                                <td style="text-align: right;"> '.number_format(@$PCUMTOTAL).' </th>
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
                                                <td>4 </th>
                                                 <td>Ems Postage - International  Bill </th>
                                                <td> Document/Parcel</th>
                                                <td style="text-align: right;">'.$getEMS_INTERNATIONALBILL->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($getgetEMS_INTERNATIONALBILLvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($getgetEMS_INTERNATIONALBILLdvat).'</th>
                                                <td style="text-align: right;"> '.number_format($getgetEMS_INTERNATIONALBILLTotal).' </th>
                                            </tr>
                                           
                                            
                                              <tr>
                                                <td colspan="7"><b> MAILS & LOGISTIC </b></td>
                                            </tr>


                                              <tr>
                                                <td>5 </th>
                                                 <td>Sales of Stamp </th>
                                                <td> </th>
                                                <td style="text-align: right;">'.$getReportSTAMP->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($DSTAMPvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($STAMPvat).'</th>
                                                <td style="text-align: right;"> '.number_format($STAMPTotal).' </th>
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
                                                <td>6</th>
                                                 <td>Registered - Cash </th>
                                                <td> Domestic</th>
                                                <td style="text-align: right;">'.$getReportregistercashItemno.'</th>
                                                <td style="text-align: right;"> '.number_format($registercashvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($registercashvat).'</th>
                                                <td style="text-align: right;"> '.number_format($registercashTotal).' </th>
                                            </tr>

                                      
                                        

                                             <tr>
                                                <td> </th>
                                                 <td> </th>
                                                <td > Intenational</th>
                                                <td style="text-align: right;">'.$getReportregisterinternationalashItemno.'</th>
                                                <td style="text-align: right;"> '.number_format($registerinternationalcashvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($registerinternationalrcashvat).'</th>
                                                <td style="text-align: right;"> '.number_format($registerinternationalcashTotal).' </th>
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
                                                <td>7</th>
                                                 <td>Registered - Bill </th>
                                                <td> Domestic</th>
                                                <td style="text-align: right;">'.$getReportregisterbillItemno.'</th>
                                                <td style="text-align: right;"> '.number_format($registerbillvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($registerbillvat).'</th>
                                                <td style="text-align: right;"> '.number_format($registerbillTotal).' </th>
                                            </tr>

                                      



                                             <tr>
                                                <td> </th>
                                                 <td> </th>
                                                <td > Intenational</th>
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
                                                <td>8</th>
                                                 <td>Parcel - Cash </th>
                                                <td> Domestic</th>
                                                <td style="text-align: right;">'.$getReportParcelcashItemno.'</th>
                                                <td style="text-align: right;"> '.number_format($Parcelcashvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($Parcelrcashvat).'</th>
                                                <td style="text-align: right;"> '.number_format($ParcelcashTotal).' </th>
                                            </tr>

                                                                 
                                        

                                             <tr>
                                                <td> </th>
                                                 <td> </th>
                                                <td > Intenational</th>
                                                <td style="text-align: right;">'.$getReportPIntercashItemno.'</th>
                                                <td style="text-align: right;"> '.number_format($PIntercashvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($PInterrcashvat).'</th>
                                                <td style="text-align: right;"> '.number_format($PIntercashTotal).' </th>
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
                                                <td>9</th>
                                                 <td>Parcel - Bill </th>
                                                <td> Domestic</th>
                                                <td style="text-align: right;">'.$getReportparcelbillItemno.'</th>
                                                <td style="text-align: right;"> '.number_format($parcelbillvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($parcelbillvat).'</th>
                                                <td style="text-align: right;"> '.number_format($parcelbillTotal).' </th>
                                            </tr>

                                      
                                        

                                             <tr>
                                                <td> </th>
                                                 <td> </th>
                                                <td > Intenational</th>
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
                                                <td>10</th>
                                                 <td> Small Packets</th>
                                                <td> </th>
                                                <td style="text-align: right;">'.$getReportderiverycashItemno.'</th>
                                                <td style="text-align: right;"> '.number_format($deriverycashvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($deriverycashvat).'</th>
                                                <td style="text-align: right;"> '.number_format($deriverycashTotal).' </th>
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
                                                <td>11 </th>
                                                 <td>Box Rental</th>
                                                <td> Post Box</th>
                                                <td style="text-align: right;">'.$getReportPOSTSBOXcash->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($POSTSBOXvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($POSTSBOXvat).'</th>
                                                <td style="text-align: right;"> '.number_format($POSTSBOXTotal).' </th>
                                            </tr>


                                               <tr>
                                                <td> </th>
                                                 <td> </th>
                                                <td > Authority Card </th>
                                                <td style="text-align: right;">'.$getReportAuthorityCard->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($AuthorityCardvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($AuthorityCardvat).'</th>
                                                <td style="text-align: right;"> '.number_format($AuthorityCardTotal).' </th>
                                            </tr>

                                               


                                              <tr>
                                                <td> </th>
                                                 <td> </th>
                                                <td > Key deposity </th>
                                                <td style="text-align: right;">'.$getReportKeydeposity->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($Keydeposityvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($Keydeposityvat).'</th>
                                                <td style="text-align: right;"> '.number_format($KeydeposityXTotal).' </th>
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
                                                <td>12</th>
                                                 <td>Post Cargo</td>
                                                <td> </th>
                                                <td style="text-align: right;">'.$getReportPostCargo->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($PostCargovatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($PostCargovat).'</th>
                                                <td style="text-align: right;"> '.number_format($PostCargoTotal).' </th>
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
                                                <td>13 </th>
                                                 <td>Posta Mlangoni</td>
                                                <td> </th>
                                                <td style="text-align: right;">'.$getReportPostamlangonibillItemno.'</th>
                                                <td style="text-align: right;"> '.number_format($Postamlangonibillvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($Postamlangonibillvat).'</th>
                                                <td style="text-align: right;"> '.number_format($PostamlangonibillTotal).' </th>
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
                                                <td> </td> 
                                                 <td> </td>
                                                <td> <b>TOTAL</b></th>
                                                <td style="text-align: right;"><b>'.($sumitem + $sumMAILitem).'</b></th>
                                                 <td style="text-align: right;"><b>'.number_format($sumvatexclusive + $sumMAILvatexclusive).'</b></th>
                                                <td style="text-align: right;"> <b>'.number_format($sumvat + $sumMAILvat).' </b></th>
                                                <td style="text-align: right;"><b> '.number_format($sumitotal + $sumMAILitotal).'</b> </th>
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
                                                <td colspan="7"><b> DEBTS COLLECTION </b></td>
                                            </tr>

                                        
                                              <tr>
                                                <td>14 </th>
                                                 <td>Ems Billing</th>
                                                <td> </th>
                                                <td style="text-align: right;">'.$getlocalbillpayed->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($getlocalbillpayedvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($getlocalbillpayedvat).'</th>
                                                <td style="text-align: right;"> '.number_format($getlocalbillpayedTotal).' </th>
                                            </tr>

                                             <tr>
                                                <td>15</th>
                                                 <td>Mail Billing</th>
                                                <td> </th>
                                                <td style="text-align: right;">'.$getMAILSBILLING->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format($getMAILSBILLINGvatexlusive).' </th>
                                                <td style="text-align: right;">'.number_format($getMAILSBILLINGvat).'</th>
                                                <td style="text-align: right;"> '.number_format($getMAILSBILLINGTotal).' </th>
                                            </tr>
                                              <tr>
                                                <td>16</th>
                                                 <td>Mail International Billing</th>
                                                <td> </th>
                                                <td style="text-align: right;">0</th>
                                                <td style="text-align: right;"> 0</th>
                                                <td style="text-align: right;">0</th>
                                                <td style="text-align: right;"> 0 </th>
                                            </tr>

                                             <tr>
                                                <td> </td> 
                                                 <td> </td>
                                                <td> <b>TOTAL</b></th>
                                                <td style="text-align: right;"><b>'.($getlocalbillpayed->Itemno + $getMAILSBILLING->Itemno).'</b></th>
                                                 <td style="text-align: right;"><b>'.number_format($getlocalbillpayedvatexlusive + $getMAILSBILLINGvatexlusive).'</b></th>
                                                <td style="text-align: right;"> <b>'.number_format($getlocalbillpayedvat + $getMAILSBILLINGvat).' </b></th>
                                                <td style="text-align: right;"><b> '.number_format($getlocalbillpayedTotal + $getMAILSBILLINGTotal).'</b> </th>
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
                                            <td colspan="7"><b> E-BUSSNESS </b></td>
                                        </tr>


                                    
                                          <tr>
                                            <td>17</th>
                                             <td>Internet</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.(@$getINTERNET->Itemno).'</th>
                                            <td style="text-align: right;"> '.number_format(@$INTERNETVATEXCLUSIVE).' </th>
                                            <td style="text-align: right;">'.number_format(0).'</th>
                                            <td style="text-align: right;"> '.number_format(@$INTERNETTOTAL).' </th>
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
                                            <td colspan="7"><b> ESTATE </b></td>
                                        </tr>

                                    
                                          <tr>
                                            <td>18</th>
                                             <td>Resident</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.(@$getResidential->Itemno).'</th>
                                            <td style="text-align: right;"> '.number_format(@$ResidentialVATEXCLUSIVE).' </th>
                                            <td style="text-align: right;">'.number_format(0).'</th>
                                            <td style="text-align: right;"> '.number_format(@$ResidentialTOTAL).' </th>
                                            </tr>
                                            <tr>
                                            <td></th>
                                             <td>Land</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.(@$getLand->Itemno).'</th>
                                            <td style="text-align: right;"> '.number_format(@$LandVATEXCLUSIVE).' </th>
                                            <td style="text-align: right;">'.number_format(@$LandVAT).'</th>
                                            <td style="text-align: right;"> '.number_format(@$LandTOTAL).' </th>
                                            </tr>
                                            <tr>
                                            <td></th>
                                             <td>Office</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.(@$getOffices->Itemno).'</th>
                                            <td style="text-align: right;"> '.number_format(@$OfficesVATEXCLUSIVE).' </th>
                                            <td style="text-align: right;">'.number_format(@$OfficesVAT).'</th>
                                            <td style="text-align: right;"> '.number_format(@$OfficesTOTAL).' </th>
                                            </tr>
                                            <tr>
                                            <td></th>
                                             <td>Hall</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.(@$getHall->Itemno).'</th>
                                            <td style="text-align: right;"> '.number_format(@$HallVATEXCLUSIVE).' </th>
                                            <td style="text-align: right;">'.number_format(@$HallVAT).'</th>
                                            <td style="text-align: right;"> '.number_format(@$HallTOTAL).' </th>
                                            </tr>

                                            <tr>
                                            <td></th>
                                             <td>Parking</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.(@$getParking->Itemno).'</th>
                                            <td style="text-align: right;"> '.number_format(@$ParkingVATEXCLUSIVE).' </th>
                                            <td style="text-align: right;">'.number_format(@$ParkingVAT).'</th>
                                            <td style="text-align: right;"> '.number_format(@$ParkingTOTAL).' </th>
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
                                            <td colspan="7"><b>FINANCIAL AGENCY AND SERVICE (FAS) </b></td>
                                        </tr>


                                    
                                          <tr>
                                            <td>19</th>
                                             <td>Western union commission</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.@$getCOMMISSION->Itemno.'</th>
                                            <td style="text-align: right;"> '.number_format(@$COMMISSIONVATEXCLUSIVE).' </th>
                                            <td style="text-align: right;">'.number_format(@$COMMISSIONVAT).'</th>
                                            <td style="text-align: right;"> '.number_format(@$COMMISSIONTOTAL).' </th>
                                            </tr>
                                            <tr>
                                            <td></th>
                                             <td>Posta shop</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.@$getSHOP->Itemno.'</th>
                                            <td style="text-align: right;"> '.number_format(@$SHOPVATEXCLUSIVE).' </th>
                                            <td style="text-align: right;">'.number_format(@$SHOPVAT).'</th>
                                            <td style="text-align: right;"> '.number_format(@$SHOPTOTAL).' </th>
                                            </tr>
                                            <tr>
                                            <td></th>
                                             <td>Posta cash</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.(0).'</th>
                                            <td style="text-align: right;"> '.number_format(0).' </th>
                                            <td style="text-align: right;">'.number_format(0).'</th>
                                            <td style="text-align: right;"> '.number_format(0).' </th>
                                            </tr>
                                            <tr>
                                            <td></th>
                                             <td>Photocopy</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.@$getphotocopy->Itemno.'</th>
                                            <td style="text-align: right;"> '.number_format(@$photocopyVATEXCLUSIVE).' </th>
                                            <td style="text-align: right;">'.number_format(@$photocopyVAT).'</th>
                                            <td style="text-align: right;"> '.number_format(@$photocopyTOTAL).' </th>
                                            </tr>
                                            <tr>
                                            <td></th>
                                             <td>Bureau commission</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.@$getBureau->Itemno.'</th>
                                            <td style="text-align: right;"> '.number_format(@$BureauVATEXCLUSIVE).' </th>
                                            <td style="text-align: right;">'.number_format(@$BureauVAT).'</th>
                                            <td style="text-align: right;"> '.number_format(@$BureauTOTAL).' </th>
                                            </tr>


                                            <tr>
                                            <td></th>
                                             <td>Moneygram commission</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.@$getMoneygram->Itemno.'</th>
                                            <td style="text-align: right;"> '.number_format(@$MoneygramVATEXCLUSIVE).' </th>
                                            <td style="text-align: right;">'.number_format(@$MoneygramVAT).'</th>
                                            <td style="text-align: right;"> '.number_format(@$MoneygramTOTAL).' </th>
                                            </tr>
                                            <tr>
                                            <td></th>
                                             <td>Necta commission</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.@$getNECTA->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format(@$NECTAVATEXCLUSIVE).' </th>
                                                <td style="text-align: right;">'.number_format(@$NECTAVAT).'</th>
                                                <td style="text-align: right;"> '.number_format(@$NECTATOTAL).' </th>
                                            </tr>

                                            <tr>
                                            <td></th>
                                             <td>Insurance commission</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.@$getInsurance_commision->Itemno.'</th>
                                                <td style="text-align: right;"> '.number_format(@$Insurance_commisionVATEXCLUSIVE).' </th>
                                                <td style="text-align: right;">'.number_format(@$Insurance_commisionVAT).'</th>
                                                <td style="text-align: right;"> '.number_format(@$Insurance_commisionTOTAL).' </th>
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
                                            <td colspan="7"><b> Miscellaneous </b></td>
                                        </tr>


                                    
                                          <tr>
                                            <td>20</th>
                                             <td>Miscellaneous</th>
                                            <td> </th>
                                            <td style="text-align: right;">'.(@$getMiscellaneous->Itemno).'</th>
                                            <td style="text-align: right;"> '.number_format(@$MiscellaneousVATEXCLUSIVE).' </th>
                                            <td style="text-align: right;">'.number_format(0).'</th>
                                            <td style="text-align: right;"> '.number_format(@$MiscellaneousTOTAL).' </th>
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
                                                <td colspan="7"><b> DAY COLLECTION </b></td>
                                            </tr>



                                              <tr>
                                                <td>21</th>
                                                 <td>cash collection</th>
                                                <td> </th>
                                                <td style="text-align: right;">'.((int)$sumMAILitemcash + (int)$sumcashitem + @$getINTERNET->Itemno + @$getMiscellaneous->Itemno + @$sumEstate + $sumFAS).'</th>
                                                <td style="text-align: right;"> '.number_format($sumcashvatexclusive +$sumMAILcashvatexclusive + @$INTERNETTOTAL  + @$MiscellaneousTOTAL + $sumEstatevatexclusive + $sumFASvatexclusive).' </th>
                                                <td style="text-align: right;">'.number_format($sumMAILcashvat +$sumcashvat +$sumEstatevat + $sumFASvat).'</th>
                                                <td style="text-align: right;"> '.number_format($sumcashtotal + $sumMAILcashtotal + @$INTERNETTOTAL + @$MiscellaneousTOTAL +  $sumEstatetotal + $sumFAStotal).' </th>
                                            </tr>

                                             <tr>
                                                <td>21</th>
                                                 <td>Bill Collection</th>
                                                <td> </th>
                                              <td style="text-align: right;">'.($getlocalbillpayed->Itemno + $getMAILSBILLING->Itemno).'</th>
                                                 <td style="text-align: right;">'.number_format($getlocalbillpayedvatexlusive + $getMAILSBILLINGvatexlusive).'</th>
                                                <td style="text-align: right;"> '.number_format($getlocalbillpayedvat + $getMAILSBILLINGvat).'</th>
                                                <td style="text-align: right;"> '.number_format($getlocalbillpayedTotal + $getMAILSBILLINGTotal).'</th>
                                            </tr>

                                           
                                             <tr>
                                                <td> </td> 
                                                 <td> </td>
                                                <td> <b>TOTAL</b></th>
                                                <td style="text-align: right;"><b>'.($getlocalbillpayed->Itemno + $getMAILSBILLING->Itemno + (int)$sumMAILitemcash + (int)$sumcashitem + @$getINTERNET->Itemno+ @$sumEstate + $sumFAS).'</b></th>
                                                 <td style="text-align: right;"><b>'.number_format($getlocalbillpayedvatexlusive + $getMAILSBILLINGvatexlusive + $sumcashvatexclusive +$sumMAILcashvatexclusive + @$INTERNETTOTAL+ $sumEstatevatexclusive + $sumFASvatexclusive).'</b></th>
                                                <td style="text-align: right;"> <b>'.number_format($getlocalbillpayedvat + $getMAILSBILLINGvat + $sumMAILcashvat +$sumcashvat+$sumEstatevat + $sumFASvat).' </b></th>
                                                <td style="text-align: right;"><b> '.number_format($getlocalbillpayedTotal + $getMAILSBILLINGTotal + $sumcashtotal + $sumMAILcashtotal + @$INTERNETTOTAL+  $sumEstatetotal + $sumFAStotal).'</b> </th>
                                            </tr>





                                            
                                        </table>';





          
            
        } else {
           redirect(base_url());
        }
        
    }


    
public function Consolidated_Reports(){
  if ($this->session->userdata('user_login_access') != false) {
      
      //$data['cash'] = $this->dashboard_model->get_ems_international();
      $data['region'] = $this->employee_model->regselect();
      $this->session->set_userdata('heading','Consolidated Reports Dashboard');
      $this->load->view('reports/consolidated_report',@$data);
      
  } else {
     redirect(base_url());
  }
  
}

public function EMS_Consolidated(){
  if ($this->session->userdata('user_login_access') != false) {
      
      $id = $this->session->userdata('user_login_id');
      $basicinfo = $this->employee_model->GetBasic($id);

      $userType = $this->session->userdata('user_type');

      if ($userType == 'RM') {
        $data['region'] = $basicinfo->em_region;
      }else{
        $data['region'] = $this->employee_model->regselect();
      }

      // echo "<pre>";
      // print_r($data['region']);
      // die();

      $this->session->set_userdata('heading','Consolidated Reports Dashboard');
      $this->load->view('reports/ems_consolidated_report',@$data);
      
  } else {
     redirect(base_url());
  }
  
}


public function ems_Consolidated_Search_Reports(){
  if ($this->session->userdata('user_login_access') != false) {
      
      $fromdate =$this->input->post('fromdate'); 
      $todate = $this->input->post('todate');
      $rgeion = $this->input->post('region');

      //print_r($rgeion);
      //die();
      $id = $this->session->userdata('user_login_id');
      $basicinfo = $this->employee_model->GetBasic($id);
      if( $this->session->userdata('user_type') != "ADMIN" || $this->session->userdata('user_type') != 'SUPPORTER' ){
        $rgeion = $basicinfo->em_region;
      }


     
      //$basicinfos = $this->employee_model->GetBasic($id);
      $dep_id = $basicinfo->dep_id;

      //Get department
      $dep = $this->employee_model->getdepartment1($dep_id);


      //get list of branch by region name
      $branchs = $this->employee_model->Get_Branch($rgeion);

      // echo "<pre>";


      //foreach ($branchs as $key => $value) {
        if($this->session->userdata('user_type') == "SUPERVISOR" || $this->session->userdata('user_type') == 'EMPLOYEE'){
         // $branch = $basicinfo->em_branch;
          //$reportData = $this->Reports_model->get_EMS_General_Paid_Consolidated_branch_report($branch,$type2='',$fromdate,$todate,$status='Paid');
          $reportData = $this->Reports_model->get_EMS_General_Paid_Consolidated_report($rgeion,$type2='',$fromdate,$todate,$status='Paid');
        
        }else{
          $reportData = $this->Reports_model->get_EMS_General_Paid_Consolidated_report($rgeion,$type2='',$fromdate,$todate,$status='Paid');
        
        }

            //$html = '';
            // print_r($reportData);
            $newArray  = array();
            $response  = array();

            if(!empty($reportData)){

                  foreach ($reportData as $key => $list) {

                  $newArray[$list['district']]['office'] = $list['district'];

                  //For EMS
                  if($list['PaymentFor'] == 'EMS'){

                    if ($list['status'] == 'Paid') {
                      $newArray[$list['district']]['EMSCashNo'] = $list['Itemno'];
                      $newArray[$list['district']]['EMSCashAmount'] = $list['Totalamount'];
                    }else if($list['status'] == 'Bill'){
                      $newArray[$list['district']]['EMSBillhNo'] = $list['Itemno'];
                      $newArray[$list['district']]['EMSBillAmount'] = $list['Totalamount'];
                  }
                  
                }


                //For EMS_INTERNATIONAL
                if($list['PaymentFor'] == 'EMS_INTERNATIONAL'){

                    if ($list['status'] == 'Paid') {
                      $newArray[$list['district']]['EMSintCashNo'] = $list['Itemno'];
                      $newArray[$list['district']]['EMSintCashAmount'] = $list['Totalamount'];
                    }else if($list['status'] == 'Bill'){
                      $newArray[$list['district']]['EMSintBillhNo'] = $list['Itemno'];
                      $newArray[$list['district']]['EMSintBillAmount'] = $list['Totalamount'];
                  }
                  
                } 

                //For PARCEL CHARGES
                if($list['PaymentFor'] == 'PARCEL CHARGES'){

                    if ($list['status'] == 'Paid') {
                      $newArray[$list['district']]['ParcelCashNo'] = $list['Itemno'];
                      $newArray[$list['district']]['ParcelCashAmount'] = $list['Totalamount'];
                    }else if($list['status'] == 'Bill'){
                      $newArray[$list['district']]['ParcelBillhNo'] = $list['Itemno'];
                      $newArray[$list['district']]['ParcelBillAmount'] = $list['Totalamount'];
                  }
                  
                }

                //For LOAN BOARD
                  if($list['PaymentFor'] == 'LOAN BOARD'){

                    if ($list['status'] == 'Paid') {
                      $newArray[$list['district']]['LoanBoardCashNo'] = $list['Itemno'];
                      $newArray[$list['district']]['LoanBoardCashAmount'] = $list['Totalamount'];
                    }else if($list['status'] == 'Bill'){
                      $newArray[$list['district']]['LoanBoardBillhNo'] = $list['Itemno'];
                      $newArray[$list['district']]['LoanBoardBillAmount'] = $list['Totalamount'];
                  }
                  
                }


                 //For PCUM
                  if($list['PaymentFor'] == 'PCUM'){

                    if ($list['status'] == 'Paid') {
                      $newArray[$list['district']]['PCUMCashNo'] = $list['Itemno'];
                      $newArray[$list['district']]['PCUMCashAmount'] = $list['Totalamount'];
                    }else if($list['status'] == 'Bill'){
                      $newArray[$list['district']]['PCUMBillhNo'] = $list['Itemno'];
                      $newArray[$list['district']]['PCUMBillAmount'] = $list['Totalamount'];
                  }
                  
                }

              }

              $response['status'] = 'found';
              $response['data'] = $newArray;

            }else{
              $response['status'] = 'No data';
              $response['data'] = 'No data to display';
            }
            
            

            // print_r($newArray);

        //echo '<br>';

      //}

      
      // die();


      print_r(json_encode($response));
      
  } else {
     redirect(base_url());
  }
  
}




public function Consolidated_Search_Reports(){
  if ($this->session->userdata('user_login_access') != false) {
      
          $fromdate =$this->input->post('fromdate'); 
          $todate = $this->input->post('todate');
          $rgeion = $this->input->post('region');


          $id = $this->session->userdata('user_login_id');
                  $basicinfo = $this->employee_model->GetBasic($id);
                  $basicinfos = $this->employee_model->GetBasic($id);
                  $dep_id = $basicinfos->dep_id;
                   $dep = $this->employee_model->getdepartment1($dep_id);
                   $dep_name='';
                  if (!empty($dep)) {
                      $dep_name = $dep->dep_name;
                  }
                 


  $userType = $this->session->userdata('user_type');

  if($userType != 'ADMIN' && $userType != 'SUPER ADMIN' && $userType != 'ACCOUNTANT-HQ' && $userType != 'CRM' && $userType != 'BOP' && $userType != 'PMG' && $dep_name != 'EMS HQ'){
       $o_region = $this->session->userdata('user_region');
       $rgeion = $o_region;
  }

  //get list of branch by region name
  $branchs=$this->employee_model->Get_Branch($rgeion);
  echo '
  <div class="panel-footer text-center">
 
<h3> <strong> SHIRIKA LA POSTA TANZANIA </strong> </h3>
<h3 style="text-transform: uppercase;"> <strong> '.@$rgeion.' EMS BUSINESS PERFORMANCE </strong> </h3>
<h3> <strong> From:'.@$fromdate.'  &nbsp; &nbsp; &nbsp;  <b>To:</b> </b>'.@$todate.'  </strong> </h3>
</div>';

// <th colspan="2" > 	cash collection </th>
//   <th colspan="2" > 	Bill collection </th>
//<th colspan="2" style="text-align: center;"> TOTAL </th>

echo' <table class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%" style="width: 100%;font-size: 25px; " id="exceldownload">

<tr style="font-size: 18px;">
  <th colspan="16" > </th>
 
</tr>
<tr>
<tr style="text-align: center;font-size: 18px;">
 <th>  </th>
  <th colspan="2" > Document/Parcel </th>
 <th colspan="2" >  Ems Cargo </th>
 <th colspan="2" > Parcel Charge </th>
 <th colspan="2" > Loan Board (HELSB) </th>
 <th colspan="2" > PCUM </th>
 <th colspan="2" > Local Bill </th>
 <th colspan="2" > International cash </th>
 <th colspan="2" > International Bill </th>


</tr>
<tr style="text-align: right;font-size: 16px;">
 <th> OFFICE </th>
  <th>NO </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>


</tr>';
echo '
<tr style="font-size: 17px;">
 <td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
 <td></td><td> </td><td> </td><td> </td><td> </td><td> </td>
 <td> </td><td> </td>
</tr>';
$total1=0;$total2=0;$total3=0;$total4=0;$total5=0;$total6=0;$total7=0;$total8=0;$total9=0;
$total10=0;$total11=0;$total12=0;$total13=0;$total14=0;$total15=0;$total16=0;$total17=0;
$total18=0;$total19=0;$total20=0;$total21=0;
$total22=0;
  foreach ($branchs as $value)
         {
          $branch=$value->branch_name;
           {
             
                        $type2 = 'EMS';//DomesticDocument paidamount 
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getReportDomesticDocument =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $DomesticDocumentvat=$getReportDomesticDocument->Totalamount * 0.18;
                        $DomesticDocumentvatexlusive=$getReportDomesticDocument->Totalamount -  $DomesticDocumentvat;
                         $DomesticDocumentTotal=$getReportDomesticDocument->Totalamount;


                          $type2 = 'PARCEL CHARGES';//DomesticDocument paidamount 
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getPARCELCHARGESt =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $getPARCELCHARGEStVAT=$getPARCELCHARGESt->Totalamount * 0.18;
                        $getPARCELCHARGESVATEXCLUSIVE=$getPARCELCHARGESt->Totalamount ;
                         $getPARCELCHARGEStOTAL=$getPARCELCHARGESt->Totalamount;



                          $type2 = 'LOAN BOARD';//LOAN BOARD
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getLOANBOARD =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $getLOANBOARDVAT=$getLOANBOARD->Totalamount * 0.18;
                        $getLOANBOARDVATEXCLUSIVE=$getLOANBOARD->Totalamount -  $getLOANBOARDVAT;
                         $getLOANBOARDTOTAL=$getLOANBOARD->Totalamount;


                         $type2 = 'PCUM';//PCUM 
                         $DB = 'transactions';
                         $status = 'Paid';
                       $getPCUM =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                       $PCUMVAT=$getPCUM->Totalamount * 0.18;
                         $PCUMVATEXCLUSIVE=$getPCUM->Totalamount -  $PCUMVAT;
                          $PCUMTOTAL=$getPCUM->Totalamount;


                       
                           

                       $type2 = 'EMS';//local bill status=bill paymentfor =ems 
                        $DB = 'transactions';
                        $status = 'Bill';
                      $getlocalbill =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $getlocalbillvat=$getlocalbill->Totalamount * 0.18;
                        $getlocalbillvatexlusive=$getlocalbill->Totalamount -  $getlocalbillvat;
                         $getlocalbillTotal=$getlocalbill->Totalamount;

                      

                       $type2 = 'EMSBILLING';//local bill payed = paymentfor =EMSBILLING   but paid
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getlocalbillpayed =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $getlocalbillpayedvat=$getlocalbillpayed->Totalamount * 0.18;
                        $getlocalbillpayedvatexlusive=$getlocalbillpayed->Totalamount -  $getlocalbillpayedvat;
                         $getlocalbillpayedTotal=$getlocalbillpayed->Totalamount;


                           $type2 = 'EMS_INTERNATIONAL';//intenational cash paymentfor=EMS_INTERNATIONAL status !=bill
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getEMS_INTERNATIONAL =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $getgetEMS_INTERNATIONALdvat=$getEMS_INTERNATIONAL->Totalamount * 0.18;
                        $getgetEMS_INTERNATIONALvatexlusive=$getEMS_INTERNATIONAL->Totalamount -  $getgetEMS_INTERNATIONALdvat;
                         $getgetEMS_INTERNATIONALTotal=$getEMS_INTERNATIONAL->Totalamount;



                           $type2 = 'EMS_INTERNATIONAL';//intenational bill paymentfor=EMS_INTERNATIONAL status =bill
                        $DB = 'transactions';
                        $status = 'Bill';
                      $getEMS_INTERNATIONALBILL =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
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


                         $sumitem=($getReportDomesticDocument->Itemno + @$getPCUM->Itemno + $getPARCELCHARGESt->Itemno + $getLOANBOARD->Itemno  + $getlocalbill->Itemno +  $getEMS_INTERNATIONAL->Itemno + $getEMS_INTERNATIONALBILL->Itemno);
                           $sumvat=($DomesticDocumentvat + $getPARCELCHARGEStVAT + @$PCUMVAT +   $getLOANBOARDVAT +  $getlocalbillvat + $getgetEMS_INTERNATIONALdvat + $getgetEMS_INTERNATIONALBILLdvat);
                            $sumvatexclusive=($DomesticDocumentvatexlusive +  @$PCUMVATEXCLUSIVE +  $getPARCELCHARGESVATEXCLUSIVE + $getLOANBOARDVATEXCLUSIVE  + $getlocalbillvatexlusive +$getgetEMS_INTERNATIONALvatexlusive +  $getgetEMS_INTERNATIONALBILLvatexlusive);
                             $sumitotal=($DomesticDocumentTotal +  @$PCUMTOTAL +  $getPARCELCHARGEStOTAL + $getLOANBOARDTOTAL  + $getlocalbillTotal + $getgetEMS_INTERNATIONALTotal +  $getgetEMS_INTERNATIONALBILLTotal);



                                 $sumcashitem=($getReportDomesticDocument->Itemno  + @$getPCUM->Itemno + $getPARCELCHARGESt->Itemno + $getLOANBOARD->Itemno  +  $getEMS_INTERNATIONAL->Itemno );
                           $sumcashvat=($DomesticDocumentvat + $getPARCELCHARGEStVAT + @$PCUMVAT +   $getLOANBOARDVAT   + $getgetEMS_INTERNATIONALdvat );
                            $sumcashvatexclusive=($DomesticDocumentvatexlusive +  $PCUMVATEXCLUSIVE +  $getPARCELCHARGESVATEXCLUSIVE + $getLOANBOARDVATEXCLUSIVE   +$getgetEMS_INTERNATIONALvatexlusive );
                             $sumcashtotal=($DomesticDocumentTotal +  @$PCUMTOTAL + $getPARCELCHARGEStOTAL + $getLOANBOARDTOTAL  + $getgetEMS_INTERNATIONALTotal );

                             
                            }

                            {

                              {
                                $total1=$total1 + $getReportDomesticDocument->Itemno;
                                $total2=$total2 + $DomesticDocumentTotal;
                                $total3=$total3 + 0;
                                $total4=$total4 + 0;
                                $total5=$total5 + $getPARCELCHARGESt->Itemno;
                                $total6=$total6 + $getPARCELCHARGEStOTAL;
                                $total7=$total7 + $getLOANBOARD->Itemno;
                                $total8=$total8 + $getLOANBOARDTOTAL;
                                $total9=$total9 + @$getPCUM->Itemno;
                                $total10=$total10 + @$PCUMTOTAL;
                                $total11=$total11 + $getlocalbill->Itemno;
                                $total12=$total12 + $getlocalbillTotal;
                                $total13=$total13 + $getEMS_INTERNATIONAL->Itemno;
                                $total14=$total14 + $getgetEMS_INTERNATIONALTotal;
                                $total15=$total15 + $getEMS_INTERNATIONALBILL->Itemno;
                                $total16=$total16 + $getgetEMS_INTERNATIONALBILLTotal;
                                $total17=$total17 + $sumcashitem;
                                $total18=$total18 + $sumcashtotal;
                                $total19=$total19 + $getlocalbillpayed->Itemno;
                                $total20=$total20 + $getlocalbillTotal;
                                $total21=$total21 + ($getlocalbillpayed->Itemno + (int)$sumcashitem );
                                // <td style="text-align: right;">'.((int)$sumcashitem ).'</td> <td style="text-align: right;"> '.number_format($sumcashtotal ).' </td>
                                // <td style="text-align: right;">'.($getlocalbillpayed->Itemno ).'</td> <td style="text-align: right;"> '.number_format($getlocalbillpayedTotal ).'</td>
                                // <td>'.number_format($total18).' </td><td>'.$total19.' </td>
                                // <td>'.number_format($total20).' </td><td>'.number_format($total21).' </td>
                               
                               
                                $total22=$total22 + ($getlocalbillpayedTotal +  $sumcashtotal);


                              }

                      echo' 
                      <tr style="font-size: 17px;">
                      <td>'.$branch.' </td>
                      <td style="text-align: right;">'.$getReportDomesticDocument->Itemno.' </td><td style="text-align: right;">'.number_format($DomesticDocumentTotal).' </td>
                      <td style="text-align: right;">0 </td><td style="text-align: right;">'.number_format(0).' </td>
                      <td style="text-align: right;">'.$getPARCELCHARGESt->Itemno.'</td>  <td style="text-align: right;"> '.number_format($getPARCELCHARGEStOTAL).' </td>
                      <td style="text-align: right;">'.$getLOANBOARD->Itemno.'</td><td style="text-align: right;"> '.number_format($getLOANBOARDTOTAL).' </td>
                      <td style="text-align: right;">'.@$getPCUM->Itemno.'</td><td style="text-align: right;"> '.number_format(@$PCUMTOTAL).' </td>
                      <td style="text-align: right;">'.$getlocalbill->Itemno.'</td> <td style="text-align: right;"> '.number_format($getlocalbillTotal).' </td>
                      <td style="text-align: right;">'.$getEMS_INTERNATIONAL->Itemno.'</td>  <td style="text-align: right;"> '.number_format($getgetEMS_INTERNATIONALTotal).' </td>              
                      <td style="text-align: right;">'.$getEMS_INTERNATIONALBILL->Itemno.'</td> <td style="text-align: right;"> '.number_format($getgetEMS_INTERNATIONALBILLTotal).' </td>
                       
                        
                     </tr>       
                                  ';
                            }

                          }
                          //<td style="text-align: right;"><b>'.($getlocalbillpayed->Itemno + (int)$sumcashitem ).'</b></td><td style="text-align: right;"><b> '.number_format($getlocalbillpayedTotal +  $sumcashtotal ).'</b> </td>
                          //<td> '.$total17.'</td><td>'.number_format($total22).' </td>
                          echo '<tr style="font-size: 17px;"><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
                       <td> </td><td> </td><td></td><td> </td><td> </td><td> </td><td> </td><td> </td><td> 
                       </td><td> </td></tr>

                        <tr style="font-size: 17px;font-weight: bold;text-align: left;"><td> TOTAL </td><td>'.$total1.' </td><td>'.number_format($total2).' </td><td>'.$total3.' </td><td>'.number_format($total4).' </td>
                        <td> '.$total5.'</td><td> '.number_format($total6).'</td><td>'.$total7.'</td><td> '.number_format($total8).'</td><td>'.$total9.'</td>
                        <td>'.number_format($total10).' </td><td>'.$total11.' </td><td>'.number_format($total12).' </td><td> '.$total13.'</td><td>'.number_format($total14).' </td>
                        <td>'.$total15.'</td><td>'.number_format($total16).' </td></tr>';

                        echo '<tr style="font-size: 17px;"><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
                        <td> </td><td> </td><td></td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
                        </tr>

                        <tr style="font-size: 17px;"><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
                        <td> </td><td> </td><td></td><td> </td><td> </td><td> </td>
                        <td> </td><td> NO </td><td>AMOUNT </td><td> </td></tr>

                        <tr style="font-size: 17px;"><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
                        <td> </td><td> </td><td></td><td> </td><td> </td>
                        <td colspan="2">TOTAL CASH </td><td>'.($total17).' </td><td> '.number_format($total18).'</td><td> </td></tr>

                       <tr style="font-size: 17px;"><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
                       <td> </td><td> </td><td></td><td> </td><td> </td>
                       <td colspan="2"> TOTAL BILL </td><td>'.($total11).' </td><td>'.number_format($total20).' </td><td> </td></tr>

                       <tr style="font-size: 17px;font-weight: bold;"><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td>
                       <td> </td><td> </td><td></td><td> </td><td> </td>
                       <td colspan="2"> TOTAL</td><td> '.($total21).'</td><td>'.number_format($total22).' </td><td> </td></tr>
                       
                       ';

                          echo '</table>';
      
  } else {
     redirect(base_url());
  }
  
}


public function Consolidated1_Search_Reports(){
  if ($this->session->userdata('user_login_access') != false) {
      
          $fromdate =$this->input->post('fromdate'); 
          $todate = $this->input->post('todate');
          $rgeion = $this->input->post('region');


          $id = $this->session->userdata('user_login_id');
                  $basicinfo = $this->employee_model->GetBasic($id);
                  $basicinfos = $this->employee_model->GetBasic($id);
                  $dep_id = $basicinfos->dep_id;
                   $dep = $this->employee_model->getdepartment1($dep_id);
                   $dep_name='';
                  if (!empty($dep)) {
                      $dep_name = $dep->dep_name;
                  }
                 


  $userType = $this->session->userdata('user_type');

  if($userType != 'ADMIN' && $userType != 'SUPER ADMIN' && $userType != 'ACCOUNTANT-HQ' && $userType != 'CRM' && $userType != 'BOP' && $userType != 'PMG' && $dep_name != 'EMS HQ'){
       $o_region = $this->session->userdata('user_region');
       $rgeion = $o_region;
  }

  //get list of branch by region name
  $branchs=$this->employee_model->Get_Branch($rgeion);
  echo '
  <div class="panel-footer text-center">
 
<h3> <strong> CONSOLIDATED TRANSACTION SUMMARY </strong> </h3>
<h3> <strong> EMS BUSINESS PERFORMANCE </strong> </h3>
<h3> <strong> From:'.@$fromdate.'  &nbsp; &nbsp; &nbsp;  <b>To:</b> </b>'.@$todate.'  </strong> </h3>
</div>';

echo' <table class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%" style="width: 100%;font-size: 25px; " id="exceldownload">

<tr>
 <th>  </th>
  <th colspan="16" > COURIER&EXPRESS(EMS) </th>

 <th colspan="4"> DAY COLLECTION </th>
 <th colspan="2"> TOTAL </th>
 
</tr>
<tr>
<tr>
 <th>  </th>
  <th colspan="2" > Document/Parcel </th>
 <th colspan="2" > Ems Cargo </th>
 <th colspan="2" >Ems Parcel Charge </th>
 <th colspan="2" > Loan Board(HELSB) </th>
 <th colspan="2" > PCUM </th>
 <th colspan="2" > Local Bill </th>
 <th colspan="2" > International cash </th>
 <th colspan="2" > International Bill </th>

 <th colspan="2" > 	cash collection </th>
 <th colspan="2" > 	Bill collection </th>

 <th colspan="2" > Total </th>


</tr>
<tr>
 <th> OFFICE </th>
  <th>NO </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>

 <th>NO  </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>
 <th>NO  </th>
 <th> AMOUNT </th>
</tr>';
echo '
<tr>
 <td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td>
  </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> 
  </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> 
  </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td><td> 
  </td><td> </td><td> </td><td> </td>
</tr>';
  foreach ($branchs as $value)
         {
          $branch=$value->branch_name;
           {
             
                        $type2 = 'EMS';//DomesticDocument paidamount 
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getReportDomesticDocument =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $DomesticDocumentvat=$getReportDomesticDocument->Totalamount * 0.18;
                        $DomesticDocumentvatexlusive=$getReportDomesticDocument->Totalamount -  $DomesticDocumentvat;
                         $DomesticDocumentTotal=$getReportDomesticDocument->Totalamount;

                       


                          $type2 = 'PARCEL CHARGES';//DomesticDocument paidamount 
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getPARCELCHARGESt =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $getPARCELCHARGEStVAT=$getPARCELCHARGESt->Totalamount * 0.18;
                        $getPARCELCHARGESVATEXCLUSIVE=$getPARCELCHARGESt->Totalamount ;
                         $getPARCELCHARGEStOTAL=$getPARCELCHARGESt->Totalamount;



                          $type2 = 'LOAN BOARD';//LOAN BOARD
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getLOANBOARD =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $getLOANBOARDVAT=$getLOANBOARD->Totalamount * 0.18;
                        $getLOANBOARDVATEXCLUSIVE=$getLOANBOARD->Totalamount -  $getLOANBOARDVAT;
                         $getLOANBOARDTOTAL=$getLOANBOARD->Totalamount;


                         $type2 = 'PCUM';//PCUM 
                         $DB = 'transactions';
                         $status = 'Paid';
                       $getPCUM =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                       $PCUMVAT=$getPCUM->Totalamount * 0.18;
                         $PCUMVATEXCLUSIVE=$getPCUM->Totalamount -  $PCUMVAT;
                          $PCUMTOTAL=$getPCUM->Totalamount;


                       
                           

                       $type2 = 'EMS';//local bill status=bill paymentfor =ems 
                        $DB = 'transactions';
                        $status = 'Bill';
                      $getlocalbill =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $getlocalbillvat=$getlocalbill->Totalamount * 0.18;
                        $getlocalbillvatexlusive=$getlocalbill->Totalamount -  $getlocalbillvat;
                         $getlocalbillTotal=$getlocalbill->Totalamount;

                      

                       $type2 = 'EMSBILLING';//local bill payed = paymentfor =EMSBILLING   but paid
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getlocalbillpayed =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $getlocalbillpayedvat=$getlocalbillpayed->Totalamount * 0.18;
                        $getlocalbillpayedvatexlusive=$getlocalbillpayed->Totalamount -  $getlocalbillpayedvat;
                         $getlocalbillpayedTotal=$getlocalbillpayed->Totalamount;


                           $type2 = 'EMS_INTERNATIONAL';//intenational cash paymentfor=EMS_INTERNATIONAL status !=bill
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getEMS_INTERNATIONAL =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $getgetEMS_INTERNATIONALdvat=$getEMS_INTERNATIONAL->Totalamount * 0.18;
                        $getgetEMS_INTERNATIONALvatexlusive=$getEMS_INTERNATIONAL->Totalamount -  $getgetEMS_INTERNATIONALdvat;
                         $getgetEMS_INTERNATIONALTotal=$getEMS_INTERNATIONAL->Totalamount;



                           $type2 = 'EMS_INTERNATIONAL';//intenational bill paymentfor=EMS_INTERNATIONAL status =bill
                        $DB = 'transactions';
                        $status = 'Bill';
                      $getEMS_INTERNATIONALBILL =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
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


                         $sumitem=($getReportDomesticDocument->Itemno + @$getPCUM->Itemno + $getPARCELCHARGESt->Itemno + $getLOANBOARD->Itemno  + $getlocalbill->Itemno +  $getEMS_INTERNATIONAL->Itemno + $getEMS_INTERNATIONALBILL->Itemno);
                           $sumvat=($DomesticDocumentvat + $getPARCELCHARGEStVAT + @$PCUMVAT +   $getLOANBOARDVAT +  $getlocalbillvat + $getgetEMS_INTERNATIONALdvat + $getgetEMS_INTERNATIONALBILLdvat);
                            $sumvatexclusive=($DomesticDocumentvatexlusive +  @$PCUMVATEXCLUSIVE +  $getPARCELCHARGESVATEXCLUSIVE + $getLOANBOARDVATEXCLUSIVE  + $getlocalbillvatexlusive +$getgetEMS_INTERNATIONALvatexlusive +  $getgetEMS_INTERNATIONALBILLvatexlusive);
                             $sumitotal=($DomesticDocumentTotal +  @$PCUMTOTAL +  $getPARCELCHARGEStOTAL + $getLOANBOARDTOTAL  + $getlocalbillTotal + $getgetEMS_INTERNATIONALTotal +  $getgetEMS_INTERNATIONALBILLTotal);



                                 $sumcashitem=($getReportDomesticDocument->Itemno  + @$getPCUM->Itemno + $getPARCELCHARGESt->Itemno + $getLOANBOARD->Itemno  +  $getEMS_INTERNATIONAL->Itemno );
                           $sumcashvat=($DomesticDocumentvat + $getPARCELCHARGEStVAT + @$PCUMVAT +   $getLOANBOARDVAT   + $getgetEMS_INTERNATIONALdvat );
                            $sumcashvatexclusive=($DomesticDocumentvatexlusive +  $PCUMVATEXCLUSIVE +  $getPARCELCHARGESVATEXCLUSIVE + $getLOANBOARDVATEXCLUSIVE   +$getgetEMS_INTERNATIONALvatexlusive );
                             $sumcashtotal=($DomesticDocumentTotal +  @$PCUMTOTAL + $getPARCELCHARGEStOTAL + $getLOANBOARDTOTAL  + $getgetEMS_INTERNATIONALTotal );



                             //MAILS

                        $type2 = 'STAMP';//STAMP paidamount 
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getReportSTAMP =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $STAMPvat=0;
                        $DSTAMPvatexlusive=$getReportSTAMP->Totalamount ;
                         $STAMPTotal=$getReportSTAMP->Totalamount;

                           




                        $type2 = 'register';//register cash = serail like register na billid!=''  na billstatus = SUCCESS  na status paid
                        $DB = 'register_transactions';
                        $status = 'Paid';
                      $getReportregistercash =$this->Reports_model->get_General_mail_cash_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      if($getReportregistercash !== false)
                        {
                          $getReportregistercashItemno= $getReportregistercash->Itemno ;
                          $registercashvat=@$getReportregistercash->Totalamount * 0.18;
                          $registercashvatexlusive=@$getReportregistercash->Totalamount -  $registercashvat;
                           $registercashTotal=@$getReportregistercash->Totalamount;
                        }
                        else
                        {
                          $getReportregistercashItemno=0;
                          $registercashvat=0;
                          $registercashvatexlusive=0;
                           $registercashTotal=0;
                        }
                    

                        

                          $type2 = 'register';//register bill = serail like register  na billstatus = BILLING  
                        $DB = 'register_transactions';
                        $status = 'Paid';
                      $getReportregisterbill =$this->Reports_model->get_General_mail_bill_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      if($getReportregisterbill !== false)
                      {
                        $getReportregisterbillItemno= $getReportregisterbill->Itemno ;
                        $registerbillvat=$getReportregisterbill->Totalamount * 0.18;
                        $registerbillvatexlusive=$getReportregisterbill->Totalamount -  $registerbillvat;
                         $registerbillTotal=$getReportregisterbill->Totalamount;
                      }
                      else
                      {
                        $getReportregisterbillItemno=0;
                        $registerbillvat=0;
                        $registerbillvatexlusive=0;
                         $registerbillTotal=0;
                      }
                      
                      
                    



                          


                          $type2 = 'MAILSBILLING';//PAID BILL paidamount 
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getMAILSBILLING =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $getMAILSBILLINGvat=$getMAILSBILLING->Totalamount * 0.18;
                        $getMAILSBILLINGvatexlusive=$getMAILSBILLING->Totalamount -  $getMAILSBILLINGvat;
                         $getMAILSBILLINGTotal=$getMAILSBILLING->Totalamount;



                         //Parcel cash = serail like Parcel na billid!=''  na billstatus = SUCCESS  na status paid
                           $type2 = 'Parcel';//register cash = serail like register na billid!=''  na billstatus = SUCCESS  na status paid
                        $DB = 'register_transactions';
                        $status = 'Paid';
                      $getReportParcelcash =$this->Reports_model->get_General_mail_cash_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      if($getReportParcelcash !== false)
                      {
                        $getReportParcelcashItemno= $getReportParcelcash->Itemno ;
                        $Parcelrcashvat=$getReportParcelcash->Totalamount * 0.18;
                        $Parcelcashvatexlusive=$getReportParcelcash->Totalamount -  $Parcelrcashvat;
                         $ParcelcashTotal=$getReportParcelcash->Totalamount;
                      }
                      else
                      {
                        $getReportParcelcashItemno=0;
                        $Parcelrcashvat=0;
                        $Parcelcashvatexlusive=0;
                         $ParcelcashTotal=0;
                      }
                     
                     
                      

                     

                             //parcel unpaid bill = sereail like parcel  na billid=''  na billstatus = BILLING  na status paid
                                $type2 = 'parcel';//register bill = serail like register  na billstatus = BILLING  
                        $DB = 'register_transactions';
                        $status = 'Paid';
                      $getReportparcelbill =$this->Reports_model->get_General_mail_bill_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      if($getReportparcelbill !== false)
                      {
                        $getReportparcelbillItemno= $getReportparcelbill->Itemno ;
                        $parcelbillvat=$getReportparcelbill->Totalamount * 0.18;
                        $parcelbillvatexlusive=$getReportparcelbill->Totalamount -  $parcelbillvat;
                         $parcelbillTotal=$getReportparcelbill->Totalamount;
                      }
                      else
                      {
                        $getReportparcelbillItemno=0;
                        $parcelbillvat=0;
                        $parcelbillvatexlusive=0;
                         $parcelbillTotal=0;
                      }
                     
                    
                            

                       // registerinternational = barcode like %RR% billid!=''  na billstatus = SUCCESS  na status paid
                             $type2 = 'RR';//register cash = serail like register na billid!=''  na billstatus = SUCCESS  na status paid
                        $DB = 'register_transactions';
                        $status = 'Paid';
                      $getReportregisterinternationalash =$this->Reports_model->get_General_mail_cash_BARCODE_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      if($getReportregisterinternationalash !== false)
                      {
                        $getReportregisterinternationalashItemno= $getReportregisterinternationalash->Itemno ;
                        $registerinternationalrcashvat=$getReportregisterinternationalash->Totalamount * 0.18;
                        $registerinternationalcashvatexlusive=$getReportregisterinternationalash->Totalamount -  $registerinternationalrcashvat;
                         $registerinternationalcashTotal=$getReportregisterinternationalash->Totalamount;

                      }
                      else
                      {
                        $getReportregisterinternationalashItemno=0;
                        $registerinternationalrcashvat=0;
                        $registerinternationalcashvatexlusive=0;
                         $registerinternationalcashTotal=0;
                      }
                      
                     
                       


                             //Parcel intern  cash = serail like PInter na billid!=''  na billstatus = SUCCESS  na status paid
                               $type2 = 'PInter';
                        $DB = 'register_transactions';
                        $status = 'Paid';
                      $getReportPIntercash =$this->Reports_model->get_General_mail_cash_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      if($getReportPIntercash !== false)
                      {
                        $getReportPIntercashItemno= $getReportPIntercash->Itemno ;
                        $PInterrcashvat=$getReportPIntercash->Totalamount * 0.18;
                        $PIntercashvatexlusive=$getReportPIntercash->Totalamount -  $PInterrcashvat;
                         $PIntercashTotal=$getReportPIntercash->Totalamount;


                      }
                      else
                      {
                        $getReportPIntercashItemno=0;
                        $PInterrcashvat=0;
                        $PIntercashvatexlusive=0;
                         $PIntercashTotal=0;
                      }
                     
                      

                             //small packets derivery_transactions 5900,2350
                              $type2 = 'derivery';
                        $DB = 'derivery_transactions';
                        $status = 'Paid';
                      $getReportderiverycash =$this->Reports_model->get_General_mail_cash_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      if($getReportderiverycash !== false)
                      {
                        $getReportderiverycashItemno= $getReportderiverycash->Itemno ;
                        $deriverycashvat=$getReportderiverycash->Totalamount * 0.18;
                        $deriverycashvatexlusive=$getReportderiverycash->Totalamount -  $deriverycashvat;
                         $deriverycashTotal=$getReportderiverycash->Totalamount;
                      }
                      else
                      {
                        $getReportderiverycashItemno=0;
                        $deriverycashvat=0;
                        $deriverycashvatexlusive=0;
                         $deriverycashTotal=0;
                      }
                      
                      

                      //     $type = 'foreig parcel';
                      //    $getReportderiverycash =$this->Reports_model->get_General_mail_delivery_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status,$type);
                      // $deriverycashvat=$getReportderiverycash->Totalamount * 0.18;
                      //   $deriverycashvatexlusive=$getReportderiverycash->Totalamount -  $deriverycashvat;
                      //    $deriverycashTotal=$getReportderiverycash->Totalamount;

                      //     $type = 'rdp';
                      //    $getReportderiverycash =$this->Reports_model->get_General_mail_delivery_Paid_Report_Collection_search($rgeion,$type2,$DB,$fromdate,$todate,$status,$type);
                      // $deriverycashvat=$getReportderiverycash->Totalamount * 0.18;
                      //   $deriverycashvatexlusive=$getReportderiverycash->Totalamount -  $deriverycashvat;
                      //    $deriverycashTotal=$getReportderiverycash->Totalamount;


                                      //  <tr>
                                      //     <td> </th>
                                      //      <td> </th>
                                      //     <td > RDP & DP</th>
                                      //     <td style="text-align: right;">'.$getReportderiverycash->Itemno.'</th>
                                      //     <td style="text-align: right;"> '.number_format($deriverycashvatexlusive).' </th>
                                      //     <td style="text-align: right;">'.number_format($deriverycashvat).'</th>
                                      //     <td style="text-align: right;"> '.number_format($deriverycashTotal).' </th>
                                      // </tr>



                         //POSTBOX
                          $type2 = 'POSTSBOX';
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getReportPOSTSBOXcash =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $POSTSBOXvat=$getReportPOSTSBOXcash->Totalamount * 0.18;
                        $POSTSBOXvatexlusive=$getReportPOSTSBOXcash->Totalamount -  $POSTSBOXvat;
                         $POSTSBOXTotal=$getReportPOSTSBOXcash->Totalamount;

                          //Keydeposity
                          $type2 = 'Keydeposity';
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getReportKeydeposity =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $Keydeposityvat=$getReportKeydeposity->Totalamount * 0.18;
                        $Keydeposityvatexlusive=$getReportKeydeposity->Totalamount -  $Keydeposityvat;
                         $KeydeposityXTotal=$getReportKeydeposity->Totalamount;

                         //AuthorityCard
                          $type2 = 'AuthorityCard';
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getReportAuthorityCard =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $AuthorityCardvat=$getReportAuthorityCard->Totalamount * 0.18;
                        $AuthorityCardvatexlusive=$getReportAuthorityCard->Totalamount -  $AuthorityCardvat;
                         $AuthorityCardTotal=$getReportAuthorityCard->Totalamount;

                         

                         //PostCargo
                          $type2 = 'Post Cargo';
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getReportPostCargo =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $PostCargovat=$getReportPostCargo->Totalamount * 0.18;
                        $PostCargovatexlusive=$getReportPostCargo->Totalamount -  $PostCargovat;
                         $PostCargoTotal=$getReportPostCargo->Totalamount;

                         //Posta mlangoni  unpaid bill = sereail like     Postamlangoni  na billid=''  na billstatus = BILLING  na status paid
                          $type2 = 'Postamlangoni';//register bill = serail like register  na billstatus = BILLING  
                        $DB = 'register_transactions';
                        $status = 'Paid';
                      $getReportPostamlangonibill =$this->Reports_model->get_General_mail_bill_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      if($getReportPostamlangonibill !== false)
                      {
                        $getReportPostamlangonibillItemno= $getReportPostamlangonibill->Itemno ;
                        $Postamlangonibillvat=$getReportPostamlangonibill->Totalamount * 0.18;
                        $Postamlangonibillvatexlusive=$getReportPostamlangonibill->Totalamount -  $Postamlangonibillvat;
                         $PostamlangonibillTotal=$getReportPostamlangonibill->Totalamount;

                      }
                      else
                      {
                        $getReportPostamlangonibillItemno=0;
                        $Postamlangonibillvat=0;
                        $Postamlangonibillvatexlusive=0;
                         $PostamlangonibillTotal=0;
                      }



                               $sumMAILitem=($getReportSTAMP->Itemno + $getReportregistercashItemno + $getReportparcelbillItemno
                           + $getReportregisterbillItemno  + $getReportParcelcashItemno  + $getReportAuthorityCard->Itemno  + $getReportregisterinternationalashItemno + $getReportPIntercashItemno + $getReportderiverycashItemno + + $getReportPOSTSBOXcash->Itemno + $getReportKeydeposity->Itemno + $getReportAuthorityCard->Itemno
                       + $getReportPostCargo->Itemno );
                           $sumMAILvat=($STAMPvat + $registercashvat + $registerbillvat + $Parcelrcashvat + $parcelbillvat + $registerinternationalrcashvat + $PInterrcashvat  + $deriverycashvat  + $POSTSBOXvat + $Keydeposityvat  + $AuthorityCardvat  + $PostCargovat  );
                            $sumMAILvatexclusive=($DSTAMPvatexlusive + $registercashvatexlusive + $registerbillvatexlusive + $Parcelcashvatexlusive + $parcelbillvatexlusive + $registerinternationalcashvatexlusive +   $PIntercashvatexlusive +   $deriverycashvatexlusive  +   $POSTSBOXvatexlusive +   $Keydeposityvatexlusive
                            +   $AuthorityCardvatexlusive  +   $PostCargovatexlusive );
                             $sumMAILitotal=($STAMPTotal +  $registercashTotal +  $registerbillTotal +  $ParcelcashTotal +  $parcelbillTotal +  $registerinternationalcashTotal +  $PIntercashTotal +  $deriverycashTotal  +  $POSTSBOXTotal +  $KeydeposityXTotal  +  $AuthorityCardTotal  +  $PostCargoTotal );



                               $sumMAILitemcash=($getReportSTAMP->Itemno + $getReportregistercashItemno + $getReportParcelcashItemno  + $getReportAuthorityCard->Itemno  + $getReportregisterinternationalashItemno + $getReportPIntercashItemno + $getReportderiverycashItemno + + $getReportPOSTSBOXcash->Itemno + $getReportKeydeposity->Itemno + $getReportAuthorityCard->Itemno
                       + $getReportPostCargo->Itemno );
                           $sumMAILcashvat=($STAMPvat + $registercashvat  + $Parcelrcashvat  + $registerinternationalrcashvat + $PInterrcashvat  + $deriverycashvat  + $POSTSBOXvat + $Keydeposityvat  + $AuthorityCardvat  + $PostCargovat  );
                            $sumMAILcashvatexclusive=($DSTAMPvatexlusive + $registercashvatexlusive  + $Parcelcashvatexlusive  + $registerinternationalcashvatexlusive +   $PIntercashvatexlusive +   $deriverycashvatexlusive  +   $POSTSBOXvatexlusive +   $Keydeposityvatexlusive
                            +   $AuthorityCardvatexlusive  +   $PostCargovatexlusive );
                             $sumMAILcashtotal=($STAMPTotal +  $registercashTotal +  $ParcelcashTotal  +  $registerinternationalcashTotal +  $PIntercashTotal +  $deriverycashTotal  +  $POSTSBOXTotal +  $KeydeposityXTotal  +  $AuthorityCardTotal  +  $PostCargoTotal );


                               //INTERNET  Miscellaneous
                       $type2 = 'INTERNET';
                      $DB = 'transactions';
                      $status = 'Paid';
                    $getINTERNET =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                    $INTERNETVAT=@$getINTERNET->Totalamount * 0.18;
                      $INTERNETVATEXCLUSIVE=@$getINTERNET->Totalamount ;
                       $INTERNETTOTAL=@$getINTERNET->Totalamount;


                        // Miscellaneous
                        $type2 = 'Miscellaneous';
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getMiscellaneous =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $MiscellaneousVAT=@$getMiscellaneous->Totalamount * 0.18;
                        $MiscellaneousVATEXCLUSIVE=@$getMiscellaneous->Totalamount ;
                         $MiscellaneousTOTAL=@$getMiscellaneous->Totalamount;


                     



                             $type2 = 'Residential';//residential estate_information
                             $DB = 'real_estate_transactions';
                             $status = 'Paid';
                             $getResidential =$this->Reports_model->get_Paid_Report_list_Estate_consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                             if($getResidential !== false)
                             {
                              $ResidentialItemno=@$getResidential->Itemno;
                              $ResidentialVAT=0;
                             $ResidentialVATEXCLUSIVE=@$getResidential->Totalamount - $ResidentialVAT;
                             $ResidentialTOTAL=@$getResidential->Totalamount;
                             }
                             else
                             {
                               $ResidentialItemno=0;
                               $ResidentialVAT=0;
                               $ResidentialVATEXCLUSIVE=0;
                                $ResidentialTOTAL=0;
                             }


                             
                            

                             //$type2 = 'Land';//residential Land Offices

                             $type2 = 'Land';//residential estate_information
                             $DB = 'real_estate_transactions';
                             $status = 'Paid';
                             $getLand =$this->Reports_model->get_Paid_Report_list_Estate_consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                             if($getLand !== false)
                             {
                              $LandItemno=@$getLand->Itemno;
                              $LandVAT=@$getLand->Totalamount * 0.18;
                              $LandVATEXCLUSIVE=@$getLand->Totalamount - $LandVAT;
                              $LandTOTAL=@$getLand->Totalamount;
                             }
                             else
                             {
                               $LandItemno=0;
                               $LandVAT=0;
                               $LandVATEXCLUSIVE=0;
                                $LandTOTAL=0;
                             }
                             
                             

                             $type2 = 'Offices';//residential estate_information
                             $DB = 'real_estate_transactions';
                             $status = 'Paid';
                             $getOffices =$this->Reports_model->get_Paid_Report_list_Estate_consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                             if($getOffices !== false)
                             {
                              $OfficesItemno=@$getOffices->Itemno;
                              $OfficesVAT=@$getOffices->Totalamount * 0.18;
                             $OfficesVATEXCLUSIVE=@$getOffices->Totalamount - $OfficesVAT;
                             $OfficesTOTAL=@$getOffices->Totalamount;
                             }
                             else
                             {
                               $OfficesItemno=0;
                               $OfficesVAT=0;
                               $OfficesVATEXCLUSIVE=0;
                                $OfficesTOTAL=0;
                             }


                             //
                             
                             $type2 = 'Hall';//residential estate_information
                             $DB = 'real_estate_transactions';
                             $status = 'Paid';
                             $getHall =$this->Reports_model->get_Paid_Report_list_Estate_consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                             if($getHall !== false)
                             {
                              $HallItemno=@$getHall->Itemno;
                              $HallVAT=0;
                             $HallVATEXCLUSIVE=@$getHall->Totalamount;
                             $HallTOTAL=@$getHall->Totalamount;
                             }
                             else
                             {
                               $HallItemno=0;
                               $HallVAT=0;
                               $HallVATEXCLUSIVE=0;
                                $HallTOTAL=0;
                             }


                             $type2 = 'Parking';//Parking
                             $DB = 'parking_transactions';
                             $status = 'Paid';
                             $getParking =$this->Reports_model->get_General_Parking_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                             if($getParking !== false)
                             {
                              $ParkingItemno=@$getParking->Itemno;
                              $ParkingVAT=0;
                             $ParkingVATEXCLUSIVE=@$getParking->Totalamount;
                             $ParkingTOTAL=@$getParking->Totalamount;
                             }
                             else
                             {
                               $ParkingItemno=0;
                               $ParkingVAT=0;
                               $ParkingVATEXCLUSIVE=0;
                                $ParkingTOTAL=0;
                             }

                             

                             $sumEstate=(@$ResidentialItemno + @$LandItemno + @$OfficesItemno + @$HallItemno + @$ParkingItemno );
                                 $sumEstatevat=(@$ResidentialVAT + @$LandVAT + @$OfficesVAT + @$HallVAT + @$ParkingVAT  );
                                  $sumEstatevatexclusive=(@$ResidentialVATEXCLUSIVE + @$ParkingVATEXCLUSIVE + @$LandVATEXCLUSIVE  + @$OfficesVATEXCLUSIVE  + @$HallVATEXCLUSIVE  );
                                   $sumEstatetotal=(@$ResidentialTOTAL +  @$LandTOTAL +  @$ParkingTOTAL +  @$OfficesTOTAL +  @$HallTOTAL  );

                              //FAS
                              $type2 = 'NECTA';//NECTA 
                        $DB = 'transactions';
                        $status = 'Paid';
                      $getNECTA =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                      $NECTAVAT=$getNECTA->Totalamount * 0.18;
                        $NECTAVATEXCLUSIVE=$getNECTA->Totalamount -  $NECTAVAT;
                         $NECTATOTAL=$getNECTA->Totalamount;

                         $type2 = 'COMMISSION';//COMMISSION 
                         $DB = 'transactions';
                         $status = 'Paid';
                       $getCOMMISSION =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                       $COMMISSIONVAT=$getCOMMISSION->Totalamount * 0.18;
                         $COMMISSIONVATEXCLUSIVE=$getCOMMISSION->Totalamount -  $COMMISSIONVAT;
                          $COMMISSIONTOTAL=$getCOMMISSION->Totalamount;

                          $type2 = 'POSTA SHOP';//SHOP 
                         $DB = 'transactions';
                         $status = 'Paid';
                       $getSHOP =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                       $SHOPVAT=$getSHOP->Totalamount * 0.18;
                         $SHOPVATEXCLUSIVE=$getSHOP->Totalamount -  $SHOPVAT;
                          $SHOPTOTAL=$getSHOP->Totalamount;


                          $type2 = 'photocopy';//photocopy
                          $DB = 'transactions';
                          $status = 'Paid';
                        $getphotocopy =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                        $photocopyVAT=0;
                          $photocopyVATEXCLUSIVE=@$getphotocopy->Totalamount ;
                           $photocopyTOTAL=@$getphotocopy->Totalamount;



                           //Bureau
                           $type2 = 'Bureau';
                           $DB = 'transactions';
                           $status = 'Paid';
                         $getBureau =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                         $BureauVAT=0;
                           $BureauVATEXCLUSIVE=@$getBureau->Totalamount ;
                            $BureauTOTAL=@$getBureau->Totalamount;

                            //Moneygram
                           $type2 = 'Moneygram';
                           $DB = 'transactions';
                           $status = 'Paid';
                         $getMoneygram =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                         $MoneygramVAT=0;
                           $MoneygramVATEXCLUSIVE=@$getMoneygram->Totalamount ;
                            $MoneygramTOTAL=@$getMoneygram->Totalamount;

                              //Moneygram
                           $type2 = 'Insurance_commision';
                           $DB = 'transactions';
                           $status = 'Paid';
                         $getInsurance_commision =$this->Reports_model->get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$fromdate,$todate,$status);
                         $Insurance_commisionVAT=0;
                           $Insurance_commisionVATEXCLUSIVE=@$getInsurance_commision->Totalamount ;
                            $Insurance_commisionTOTAL=@$getInsurance_commision->Totalamount;

                          $sumFAS=(@$getSHOP->Itemno + @$getCOMMISSION->Itemno + @$getNECTA->Itemno + @$getphotocopy->Itemno + @$getBureau->Itemno + @$getMoneygram->Itemno + @$getInsurance_commision->Itemno );
                          $sumFASvat=(@$SHOPVAT + @$COMMISSIONVAT + @$NECTAVAT +@$photocopyVAT +@$BureauVAT  +@$MoneygramVAT  +@$Insurance_commisionVAT  );
                           $sumFASvatexclusive=(@$SHOPVATEXCLUSIVE + @$COMMISSIONVATEXCLUSIVE  + @$NECTAVATEXCLUSIVE + @$photocopyVATEXCLUSIVE + @$BureauVATEXCLUSIVE + @$MoneygramVATEXCLUSIVE + @$Insurance_commisionVATEXCLUSIVE  );
                            $sumFAStotal=(@$SHOPTOTAL +  @$COMMISSIONTOTAL +  @$NECTATOTAL +  @$photocopyTOTAL  +  @$BureauTOTAL +  @$MoneygramTOTAL +  @$Insurance_commisionTOTAL  );



                             
                            }

                            {

                     

                      echo' <table class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%" style="width: 100%;font-size: 25px; " id="exceldownload">

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
                                          <td> PCUM</th>
                                          <td style="text-align: right;">'.@$getPCUM->Itemno.'</th>
                                          <td style="text-align: right;"> '.number_format(@$PCUMVATEXCLUSIVE).' </th>
                                          <td style="text-align: right;">'.number_format(@$PCUMVAT).'</th>
                                          <td style="text-align: right;"> '.number_format(@$PCUMTOTAL).' </th>
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
                                          <td>4 </th>
                                           <td>Ems Postage - International  Bill </th>
                                          <td> Document/Parcel</th>
                                          <td style="text-align: right;">'.$getEMS_INTERNATIONALBILL->Itemno.'</th>
                                          <td style="text-align: right;"> '.number_format($getgetEMS_INTERNATIONALBILLvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($getgetEMS_INTERNATIONALBILLdvat).'</th>
                                          <td style="text-align: right;"> '.number_format($getgetEMS_INTERNATIONALBILLTotal).' </th>
                                      </tr>
                                     
                                      
                                        <tr>
                                          <td colspan="7"><b> MAILS & LOGISTIC </b></td>
                                      </tr>


                                        <tr>
                                          <td>5 </th>
                                           <td>Sales of Stamp </th>
                                          <td> </th>
                                          <td style="text-align: right;">'.$getReportSTAMP->Itemno.'</th>
                                          <td style="text-align: right;"> '.number_format($DSTAMPvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($STAMPvat).'</th>
                                          <td style="text-align: right;"> '.number_format($STAMPTotal).' </th>
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
                                          <td>6</th>
                                           <td>Registered - Cash </th>
                                          <td> Domestic</th>
                                          <td style="text-align: right;">'.$getReportregistercashItemno.'</th>
                                          <td style="text-align: right;"> '.number_format($registercashvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($registercashvat).'</th>
                                          <td style="text-align: right;"> '.number_format($registercashTotal).' </th>
                                      </tr>

                                
                                  

                                       <tr>
                                          <td> </th>
                                           <td> </th>
                                          <td > Intenational</th>
                                          <td style="text-align: right;">'.$getReportregisterinternationalashItemno.'</th>
                                          <td style="text-align: right;"> '.number_format($registerinternationalcashvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($registerinternationalrcashvat).'</th>
                                          <td style="text-align: right;"> '.number_format($registerinternationalcashTotal).' </th>
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
                                          <td>7</th>
                                           <td>Registered - Bill </th>
                                          <td> Domestic</th>
                                          <td style="text-align: right;">'.$getReportregisterbillItemno.'</th>
                                          <td style="text-align: right;"> '.number_format($registerbillvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($registerbillvat).'</th>
                                          <td style="text-align: right;"> '.number_format($registerbillTotal).' </th>
                                      </tr>

                                



                                       <tr>
                                          <td> </th>
                                           <td> </th>
                                          <td > Intenational</th>
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
                                          <td>8</th>
                                           <td>Parcel - Cash </th>
                                          <td> Domestic</th>
                                          <td style="text-align: right;">'.$getReportParcelcashItemno.'</th>
                                          <td style="text-align: right;"> '.number_format($Parcelcashvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($Parcelrcashvat).'</th>
                                          <td style="text-align: right;"> '.number_format($ParcelcashTotal).' </th>
                                      </tr>

                                                           
                                  

                                       <tr>
                                          <td> </th>
                                           <td> </th>
                                          <td > Intenational</th>
                                          <td style="text-align: right;">'.$getReportPIntercashItemno.'</th>
                                          <td style="text-align: right;"> '.number_format($PIntercashvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($PInterrcashvat).'</th>
                                          <td style="text-align: right;"> '.number_format($PIntercashTotal).' </th>
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
                                          <td>9</th>
                                           <td>Parcel - Bill </th>
                                          <td> Domestic</th>
                                          <td style="text-align: right;">'.$getReportparcelbillItemno.'</th>
                                          <td style="text-align: right;"> '.number_format($parcelbillvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($parcelbillvat).'</th>
                                          <td style="text-align: right;"> '.number_format($parcelbillTotal).' </th>
                                      </tr>

                                
                                  

                                       <tr>
                                          <td> </th>
                                           <td> </th>
                                          <td > Intenational</th>
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
                                          <td>10</th>
                                           <td> Small Packets</th>
                                          <td> </th>
                                          <td style="text-align: right;">'.$getReportderiverycashItemno.'</th>
                                          <td style="text-align: right;"> '.number_format($deriverycashvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($deriverycashvat).'</th>
                                          <td style="text-align: right;"> '.number_format($deriverycashTotal).' </th>
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
                                          <td>11 </th>
                                           <td>Box Rental</th>
                                          <td> Post Box</th>
                                          <td style="text-align: right;">'.$getReportPOSTSBOXcash->Itemno.'</th>
                                          <td style="text-align: right;"> '.number_format($POSTSBOXvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($POSTSBOXvat).'</th>
                                          <td style="text-align: right;"> '.number_format($POSTSBOXTotal).' </th>
                                      </tr>


                                         <tr>
                                          <td> </th>
                                           <td> </th>
                                          <td > Authority Card </th>
                                          <td style="text-align: right;">'.$getReportAuthorityCard->Itemno.'</th>
                                          <td style="text-align: right;"> '.number_format($AuthorityCardvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($AuthorityCardvat).'</th>
                                          <td style="text-align: right;"> '.number_format($AuthorityCardTotal).' </th>
                                      </tr>

                                         


                                        <tr>
                                          <td> </th>
                                           <td> </th>
                                          <td > Key deposity </th>
                                          <td style="text-align: right;">'.$getReportKeydeposity->Itemno.'</th>
                                          <td style="text-align: right;"> '.number_format($Keydeposityvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($Keydeposityvat).'</th>
                                          <td style="text-align: right;"> '.number_format($KeydeposityXTotal).' </th>
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
                                          <td>12</th>
                                           <td>Post Cargo</td>
                                          <td> </th>
                                          <td style="text-align: right;">'.$getReportPostCargo->Itemno.'</th>
                                          <td style="text-align: right;"> '.number_format($PostCargovatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($PostCargovat).'</th>
                                          <td style="text-align: right;"> '.number_format($PostCargoTotal).' </th>
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
                                          <td>13 </th>
                                           <td>Posta Mlangoni</td>
                                          <td> </th>
                                          <td style="text-align: right;">'.$getReportPostamlangonibillItemno.'</th>
                                          <td style="text-align: right;"> '.number_format($Postamlangonibillvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($Postamlangonibillvat).'</th>
                                          <td style="text-align: right;"> '.number_format($PostamlangonibillTotal).' </th>
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
                                          <td> </td> 
                                           <td> </td>
                                          <td> <b>TOTAL</b></th>
                                          <td style="text-align: right;"><b>'.($sumitem + $sumMAILitem).'</b></th>
                                           <td style="text-align: right;"><b>'.number_format($sumvatexclusive + $sumMAILvatexclusive).'</b></th>
                                          <td style="text-align: right;"> <b>'.number_format($sumvat + $sumMAILvat).' </b></th>
                                          <td style="text-align: right;"><b> '.number_format($sumitotal + $sumMAILitotal).'</b> </th>
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
                                          <td colspan="7"><b> DEBTS COLLECTION </b></td>
                                      </tr>

                                  
                                        <tr>
                                          <td>14 </th>
                                           <td>Ems Billing</th>
                                          <td> </th>
                                          <td style="text-align: right;">'.$getlocalbillpayed->Itemno.'</th>
                                          <td style="text-align: right;"> '.number_format($getlocalbillpayedvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($getlocalbillpayedvat).'</th>
                                          <td style="text-align: right;"> '.number_format($getlocalbillpayedTotal).' </th>
                                      </tr>

                                       <tr>
                                          <td>15</th>
                                           <td>Mail Billing</th>
                                          <td> </th>
                                          <td style="text-align: right;">'.$getMAILSBILLING->Itemno.'</th>
                                          <td style="text-align: right;"> '.number_format($getMAILSBILLINGvatexlusive).' </th>
                                          <td style="text-align: right;">'.number_format($getMAILSBILLINGvat).'</th>
                                          <td style="text-align: right;"> '.number_format($getMAILSBILLINGTotal).' </th>
                                      </tr>
                                        <tr>
                                          <td>16</th>
                                           <td>Mail International Billing</th>
                                          <td> </th>
                                          <td style="text-align: right;">0</th>
                                          <td style="text-align: right;"> 0</th>
                                          <td style="text-align: right;">0</th>
                                          <td style="text-align: right;"> 0 </th>
                                      </tr>

                                       <tr>
                                          <td> </td> 
                                           <td> </td>
                                          <td> <b>TOTAL</b></th>
                                          <td style="text-align: right;"><b>'.($getlocalbillpayed->Itemno + $getMAILSBILLING->Itemno).'</b></th>
                                           <td style="text-align: right;"><b>'.number_format($getlocalbillpayedvatexlusive + $getMAILSBILLINGvatexlusive).'</b></th>
                                          <td style="text-align: right;"> <b>'.number_format($getlocalbillpayedvat + $getMAILSBILLINGvat).' </b></th>
                                          <td style="text-align: right;"><b> '.number_format($getlocalbillpayedTotal + $getMAILSBILLINGTotal).'</b> </th>
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
                                      <td colspan="7"><b> E-BUSSNESS </b></td>
                                  </tr>


                              
                                    <tr>
                                      <td>17</th>
                                       <td>Internet</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.(@$getINTERNET->Itemno).'</th>
                                      <td style="text-align: right;"> '.number_format(@$INTERNETVATEXCLUSIVE).' </th>
                                      <td style="text-align: right;">'.number_format(0).'</th>
                                      <td style="text-align: right;"> '.number_format(@$INTERNETTOTAL).' </th>
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
                                      <td colspan="7"><b> ESTATE </b></td>
                                  </tr>

                              
                                    <tr>
                                      <td>18</th>
                                       <td>Resident</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.(@$getResidential->Itemno).'</th>
                                      <td style="text-align: right;"> '.number_format(@$ResidentialVATEXCLUSIVE).' </th>
                                      <td style="text-align: right;">'.number_format(0).'</th>
                                      <td style="text-align: right;"> '.number_format(@$ResidentialTOTAL).' </th>
                                      </tr>
                                      <tr>
                                      <td></th>
                                       <td>Land</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.(@$getLand->Itemno).'</th>
                                      <td style="text-align: right;"> '.number_format(@$LandVATEXCLUSIVE).' </th>
                                      <td style="text-align: right;">'.number_format(@$LandVAT).'</th>
                                      <td style="text-align: right;"> '.number_format(@$LandTOTAL).' </th>
                                      </tr>
                                      <tr>
                                      <td></th>
                                       <td>Office</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.(@$getOffices->Itemno).'</th>
                                      <td style="text-align: right;"> '.number_format(@$OfficesVATEXCLUSIVE).' </th>
                                      <td style="text-align: right;">'.number_format(@$OfficesVAT).'</th>
                                      <td style="text-align: right;"> '.number_format(@$OfficesTOTAL).' </th>
                                      </tr>
                                      <tr>
                                      <td></th>
                                       <td>Hall</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.(@$getHall->Itemno).'</th>
                                      <td style="text-align: right;"> '.number_format(@$HallVATEXCLUSIVE).' </th>
                                      <td style="text-align: right;">'.number_format(@$HallVAT).'</th>
                                      <td style="text-align: right;"> '.number_format(@$HallTOTAL).' </th>
                                      </tr>

                                      <tr>
                                      <td></th>
                                       <td>Parking</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.(@$getParking->Itemno).'</th>
                                      <td style="text-align: right;"> '.number_format(@$ParkingVATEXCLUSIVE).' </th>
                                      <td style="text-align: right;">'.number_format(@$ParkingVAT).'</th>
                                      <td style="text-align: right;"> '.number_format(@$ParkingTOTAL).' </th>
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
                                      <td colspan="7"><b>FINANCIAL AGENCY AND SERVICE (FAS) </b></td>
                                  </tr>


                              
                                    <tr>
                                      <td>19</th>
                                       <td>Western union commission</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.@$getCOMMISSION->Itemno.'</th>
                                      <td style="text-align: right;"> '.number_format(@$COMMISSIONVATEXCLUSIVE).' </th>
                                      <td style="text-align: right;">'.number_format(@$COMMISSIONVAT).'</th>
                                      <td style="text-align: right;"> '.number_format(@$COMMISSIONTOTAL).' </th>
                                      </tr>
                                      <tr>
                                      <td></th>
                                       <td>Posta shop</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.@$getSHOP->Itemno.'</th>
                                      <td style="text-align: right;"> '.number_format(@$SHOPVATEXCLUSIVE).' </th>
                                      <td style="text-align: right;">'.number_format(@$SHOPVAT).'</th>
                                      <td style="text-align: right;"> '.number_format(@$SHOPTOTAL).' </th>
                                      </tr>
                                      <tr>
                                      <td></th>
                                       <td>Posta cash</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.(0).'</th>
                                      <td style="text-align: right;"> '.number_format(0).' </th>
                                      <td style="text-align: right;">'.number_format(0).'</th>
                                      <td style="text-align: right;"> '.number_format(0).' </th>
                                      </tr>
                                      <tr>
                                      <td></th>
                                       <td>Photocopy</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.@$getphotocopy->Itemno.'</th>
                                      <td style="text-align: right;"> '.number_format(@$photocopyVATEXCLUSIVE).' </th>
                                      <td style="text-align: right;">'.number_format(@$photocopyVAT).'</th>
                                      <td style="text-align: right;"> '.number_format(@$photocopyTOTAL).' </th>
                                      </tr>
                                      <tr>
                                      <td></th>
                                       <td>Bureau commission</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.@$getBureau->Itemno.'</th>
                                      <td style="text-align: right;"> '.number_format(@$BureauVATEXCLUSIVE).' </th>
                                      <td style="text-align: right;">'.number_format(@$BureauVAT).'</th>
                                      <td style="text-align: right;"> '.number_format(@$BureauTOTAL).' </th>
                                      </tr>


                                      <tr>
                                      <td></th>
                                       <td>Moneygram commission</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.@$getMoneygram->Itemno.'</th>
                                      <td style="text-align: right;"> '.number_format(@$MoneygramVATEXCLUSIVE).' </th>
                                      <td style="text-align: right;">'.number_format(@$MoneygramVAT).'</th>
                                      <td style="text-align: right;"> '.number_format(@$MoneygramTOTAL).' </th>
                                      </tr>
                                      <tr>
                                      <td></th>
                                       <td>Necta commission</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.@$getNECTA->Itemno.'</th>
                                          <td style="text-align: right;"> '.number_format(@$NECTAVATEXCLUSIVE).' </th>
                                          <td style="text-align: right;">'.number_format(@$NECTAVAT).'</th>
                                          <td style="text-align: right;"> '.number_format(@$NECTATOTAL).' </th>
                                      </tr>

                                      <tr>
                                      <td></th>
                                       <td>Insurance commission</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.@$getInsurance_commision->Itemno.'</th>
                                          <td style="text-align: right;"> '.number_format(@$Insurance_commisionVATEXCLUSIVE).' </th>
                                          <td style="text-align: right;">'.number_format(@$Insurance_commisionVAT).'</th>
                                          <td style="text-align: right;"> '.number_format(@$Insurance_commisionTOTAL).' </th>
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
                                      <td colspan="7"><b> Miscellaneous </b></td>
                                  </tr>


                              
                                    <tr>
                                      <td>20</th>
                                       <td>Miscellaneous</th>
                                      <td> </th>
                                      <td style="text-align: right;">'.(@$getMiscellaneous->Itemno).'</th>
                                      <td style="text-align: right;"> '.number_format(@$MiscellaneousVATEXCLUSIVE).' </th>
                                      <td style="text-align: right;">'.number_format(0).'</th>
                                      <td style="text-align: right;"> '.number_format(@$MiscellaneousTOTAL).' </th>
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
                                          <td colspan="7"><b> DAY COLLECTION </b></td>
                                      </tr>



                                        <tr>
                                          <td>21</th>
                                           <td>cash collection</th>
                                          <td> </th>
                                          <td style="text-align: right;">'.((int)$sumMAILitemcash + (int)$sumcashitem + @$getINTERNET->Itemno + @$getMiscellaneous->Itemno + @$sumEstate + $sumFAS).'</th>
                                          <td style="text-align: right;"> '.number_format($sumcashvatexclusive +$sumMAILcashvatexclusive + @$INTERNETTOTAL  + @$MiscellaneousTOTAL + $sumEstatevatexclusive + $sumFASvatexclusive).' </th>
                                          <td style="text-align: right;">'.number_format($sumMAILcashvat +$sumcashvat +$sumEstatevat + $sumFASvat).'</th>
                                          <td style="text-align: right;"> '.number_format($sumcashtotal + $sumMAILcashtotal + @$INTERNETTOTAL + @$MiscellaneousTOTAL +  $sumEstatetotal + $sumFAStotal).' </th>
                                      </tr>

                                       <tr>
                                          <td>21</th>
                                           <td>Bill Collection</th>
                                          <td> </th>
                                        <td style="text-align: right;">'.($getlocalbillpayed->Itemno + $getMAILSBILLING->Itemno).'</th>
                                           <td style="text-align: right;">'.number_format($getlocalbillpayedvatexlusive + $getMAILSBILLINGvatexlusive).'</th>
                                          <td style="text-align: right;"> '.number_format($getlocalbillpayedvat + $getMAILSBILLINGvat).'</th>
                                          <td style="text-align: right;"> '.number_format($getlocalbillpayedTotal + $getMAILSBILLINGTotal).'</th>
                                      </tr>

                                     
                                       <tr>
                                          <td> </td> 
                                           <td> </td>
                                          <td> <b>TOTAL</b></th>
                                          <td style="text-align: right;"><b>'.($getlocalbillpayed->Itemno + $getMAILSBILLING->Itemno + (int)$sumMAILitemcash + (int)$sumcashitem + @$getINTERNET->Itemno+ @$sumEstate + $sumFAS).'</b></th>
                                           <td style="text-align: right;"><b>'.number_format($getlocalbillpayedvatexlusive + $getMAILSBILLINGvatexlusive + $sumcashvatexclusive +$sumMAILcashvatexclusive + @$INTERNETTOTAL+ $sumEstatevatexclusive + $sumFASvatexclusive).'</b></th>
                                          <td style="text-align: right;"> <b>'.number_format($getlocalbillpayedvat + $getMAILSBILLINGvat + $sumMAILcashvat +$sumcashvat+$sumEstatevat + $sumFASvat).' </b></th>
                                          <td style="text-align: right;"><b> '.number_format($getlocalbillpayedTotal + $getMAILSBILLINGTotal + $sumcashtotal + $sumMAILcashtotal + @$INTERNETTOTAL+  $sumEstatetotal + $sumFAStotal).'</b> </th>
                                      </tr>





                                      
                                  </table>';
                            }

                          }




    
      
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
          }

            
            if ($Service == 'Box' ) {
              $DB = 'smsboxnotfy';
             $customerlist =$this->Reports_model->GetAllCustomerLisWithNumber2($DB);
              foreach ($customerlist as $key => $value) {
                 $mobile = $value->MobileNumber;
                 $sms =$smstext;
                 $servicename='Box';
                 $this->Sms_model->send_sms_trick2($mobile,$sms,$servicename);
  
              }
            }

            if ($Service == 'Ems' ) {
             $customerlist =$this->Reports_model->GetAllCustomeremsSender();
              foreach ($customerlist as $key => $value) {
                 $mobile = $value->s_mobile;
                 $sms =$smstext;
                 $servicename='Ems';
                 $this->Sms_model->send_sms_trick2($mobile,$sms,$servicename);
  
              }
            }

            //echo 'Successfully sent';
            
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

                             $type2 = 'Land';//residential Land Offices
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