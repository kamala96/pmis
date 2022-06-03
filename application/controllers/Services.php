 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('billing_model');
        $this->load->model('organization_model');
        $this->load->model('Box_Application_model');
        $this->load->model('unregistered_model');
        $this->load->model('Stampbureau');
        $this->load->model('Stock_model');
        $this->load->model('BureauModel');
        $this->load->model('parking_model');
        $this->load->model('FleetModel');
        $this->load->model('FGN_Application_model');
        $this->load->model('OfficialuseModel');
        $this->load->model('Ems_International_model');

    }
    
	public function Ems(){
        if ($this->session->userdata('user_login_access') != false) {
            
            //$data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Ems Dashboard');
            $this->load->view('ems/ems-dashboard',@$data);
            
        } else {
           redirect(base_url());
        }
        
    }

public function Search_international()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');
             $barcode= $this->input->post('barcode');


           if (!empty($barcode) ) {
                $data['inter'] = $this->Ems_International_model->get_ems_international_Search_list_search($barcode);
               $data['sum'] = $this->Ems_International_model->get_ems_international_search_sum_sarch($barcode);
           

           }
            elseif (!empty($month) || !empty($date) ) {
                $data['inter'] = $this->Ems_International_model->get_ems_international_list_search($date,$month,$region);
               $data['sum'] = $this->Ems_International_model->get_ems_international_sum_sarch($date,$month,$region);
               

           } else {

               if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "ADMIN"  || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "BOP") {
                $data['inter'] = $this->Ems_International_model->get_ems_international_list_search($date,$month,$region);
               $data['sum'] = $this->Ems_International_model->get_ems_international_sum_sarch($date,$month,$region);
           }else{
            $data['inter'] = $this->Ems_International_model->get_ems_international_list();
               $data['sum'] = $this->Ems_International_model->get_ems_international_sum();
           }

           }
           
           $this->load->view('ems/ems_international_search_list',$data);
        } else {
            redirect(base_url());
        }
        
    }


    
    public function Receipt(){
        $this->load->view('backend/master_receipt');
        }

public function Search_Receipt()
{
    if ($this->session->userdata('user_login_access') != false){
        $type = $this->input->post('type');
        $cnumber = $this->input->post('cnumber');

        if($type=="Realestate"){
            $data  = $this->Box_Application_model->searchRealestateReceipt($cnumber);

        }else{
            $data  = $this->Box_Application_model->searchTransaction($id='',$type,$cnumber);

        }

      

        if ($data) {
            $count = 1;
            $temp = '';

            foreach ($data as $key => $value) {
                $sn = $count++;

                $temp .="<tr class='tr".$value['partial_id']."'> <td>".$sn."</td>
                    
                     <td>".$value['controlno']."</td>
                     <td>".$value['customer_name']."</td>
                     <td>".$value['mobile_number']."</td>
                     <td>".$value['amount']."</td>
                     <td>".$value['pay_channel']."</td>
                     <td>".$value['partial_receipt']."</td>
                     <td>".$value['partial_date_created']."</td>
                    
                     <td>
                     <a href='".base_url()."Services/printpartialreceipt?partial=".$value['partial_id']."' title='Print' class='btn btn-md btn-danger waves-effect waves-light'><i class='fa fa-print-o'></i> Print</a>

                     </td>
                     </tr>";
            }
            $response['status'] = "Success";
            $response['msg'] = $temp;
        }else{
            $response['status'] = "Error";
            $response['msg'] = 'No data';
        }


        print_r(json_encode($response));
    }else{
        redirect(base_url());
    }
    
}


public function printpartialreceipt(){

    $partial = $this->input->get('partial');
    $data['custinfo']  = $this->Box_Application_model->searchRealestatepartialReceipt($partial);
    $data['cno'] = $controlno = $data['custinfo']->controlno;
    $cuno = $controlno;
    $data['Receipt'] = $data['custinfo']->partial_receipt;
    $id = $this->session->userdata('user_login_id');
    $info = $this->employee_model->GetBasic($id);
    $data['preparedby']= 'PF'.' '.$info->em_code.' '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
    
             
                   $this->load->library('Pdf');
    
                   $html= "";
                    $html= $this->load->view('estate/partial_receipt',$data,TRUE);
    
                  $this->load->library('Pdf');
                    $this->dompdf->loadHtml($html);
                    $this->dompdf->setPaper('A4','potrait');
                    $this->dompdf->render();
                    $this->dompdf->stream($controlno, array("Attachment"=>0));
    
     }


    public function StrongRoom(){
    $this->load->view('bureau/strongroom_dashboard');
    }

    public function Store(){
    $this->load->view('inventory/store_dashboard');
    }

    public function fas(){
    $this->load->view('inlandMails/fas_dashboard');
    }

    public function Inventory(){
    $this->load->view('inventory/inventory_dashboard');
    }

    public function Fleet(){
        if ($this->session->userdata('user_login_access') != false) {
            $data['region'] = $this->FleetModel->get_regions();
            $this->load->view('fleet/add_vehicle',$data); 
        } else {
           redirect(base_url());
        }
        
    }

    //Foreign
public function Foreign_parcel(){
    if ($this->session->userdata('user_login_access') != false) {
        $data['region'] = $this->employee_model->regselect();
        $this->load->view('FP/add_foreign_parcel',$data);
    } else {
       redirect(base_url());
    }
}

/*public function Foreign_letter(){
    if ($this->session->userdata('user_login_access') != false) {
        $data['region'] = $this->employee_model->regselect();
        $this->load->view('FP/add_foreign_parcel',$data);
    } else {
       redirect(base_url());
    }
}*/

      public function Small_Packets(){
        if ($this->session->userdata('user_login_access') != false) {

            $data['region'] = $this->employee_model->regselect();
            //$data['outsidesmallpacket'] = $this->FGN_Application_model->outside_small_parcket();
            $emid = $this->session->userdata('user_login_id');
            $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

            if (!empty($staff_section)) {
                $data['depsection'] = $staff_section[0]['name'];
            }else{
                $data['depsection'] = '';
            }

            //echo "<pre>";
            //print_r($data['depsection']);
            //die();

            $this->load->view('FGN/add_fgn',$data);
        } else {
           redirect(base_url());
        }
        
    }

    public function Posta_mlangoni(){
    if ($this->session->userdata('user_login_access') != false){
        $emid = $this->session->userdata('user_login_id');
        $service_type = 'Posta_mlangoni';

        $staff_section = $this->employee_model->getEmpDepartmentSections($emid);


        $this->session->set_userdata('service_type',$service_type);
        $this->session->set_userdata('service_type_new','Posta_mlangoni');

        $emslist = $this->unregistered_model->get_mails_application_list($staff_section[0]['name'],$Barcode='',$emid);

        $data['ems'] = $this->unregistered_model->count_ems();
        $data['bags'] = $this->unregistered_model->count_bags();
        $data['despout'] = $this->unregistered_model->count_despatch();
        $data['despin'] = $this->unregistered_model->count_despatch_in();
        $data['current_section'] = $staff_section[0]['name'];
        $data['current_controller'] = $staff_section[0]['controller'];

       if (!empty($emslist)) {
           foreach ($emslist as $key => $list) {
                $emplyo = $this->employee_model->GetBasic($list->created_by);

                $NewList[$list->created_by]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                $NewList[$list->created_by]['em_sub_role'] = $emplyo->em_sub_role;
                $NewList[$list->created_by]['em_image'] = $emplyo->em_image;
                $NewList[$list->created_by]['pass_from'] = $list->pass_from;
                $NewList[$list->created_by]['last_name'] = $emplyo->last_name;
            }
            $data['counter_list'] = $NewList;
       }

        $this->load->view('domestic_ems/mails_mlangoni_list.php',$data);
    }else{
        redirect(base_url());
    }
}

    public function Pcum(){
        if ($this->session->userdata('user_login_access') != false) {
            
            $data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Pcum Dashboard');
            $this->load->view('pcum/pcum_dashboard',@$data);
            
        } else {
           redirect(base_url());
        }
        
    }
    

    public function Bureau(){
        if ($this->session->userdata('user_login_access') != false) {
            
            $this->load->view('bureau/dashboard',@$data);
            
        } else {
           redirect(base_url());
        }
        
    }

    public function Delivery(){
        if ($this->session->userdata('user_login_access') != false) {

            $this->load->view('delivery/delivery-dashboard');

        }else{
            redirect(base_url());
        }

        
    }

     public function Exchange(){  
        if ($this->session->userdata('user_login_access') != false) {

            $this->load->view('inlandMails/exchange_dashboard');

        }else{
            redirect(base_url());
        }

        
    }

    public function Giro(){

    if ($this->session->userdata('user_login_access') != false)
    {
    $data['region'] = $this->employee_model->regselect();
    $this->load->view('billing/companies_registration',$data);
    }
    else{
    redirect(base_url());
    }

    }
 public function Internet()
    {
   if ($this->session->userdata('user_login_access') != false) {
            
            $data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Internet Dashboard');
            $this->load->view('internet/Internet-dashboard',@$data);
            
        } else {
           redirect(base_url());
        }
    }

    public function Ebusiness()
    {
   if ($this->session->userdata('user_login_access') != false) {
            
            //$data['cash'] = @$this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Ebusiness Dashboard');
            $this->load->view('Eshoping/Ebusiness-dashboard');
            
        } else {
           redirect(base_url());
        }
    }


    public function Miscellaneous()
    {
   if ($this->session->userdata('user_login_access') != false) {
            
            $data['cash'] = "";//$this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Miscellaneous Dashboard');
            $this->load->view('Miscellaneous/Miscellaneous-dashboard',@$data);
            
        } else {
           redirect(base_url());
        }
    }



    public function PostShop()
    {
   if ($this->session->userdata('user_login_access') != false) {
            
            $data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Posta Shop Dashboard');
            $this->load->view('Post_shop/Post_shop-dashboard',@$data);
            
        } else {
           redirect(base_url());
        }
    }
    public function posta_bus()
    {
    if ($this->session->userdata('user_login_access') != false) {
            
            $data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Postabus Dashboard');
            $this->load->view('postabus/Postabus-dashboard',@$data);
            
        } else {
           redirect(base_url());
        }
    }

    public function Inland_Mail()
    {
    if ($this->session->userdata('user_login_access') != false)
                {
                    $this->load->view('inlandMails/mails-dashboard');
                }
                else{
                    redirect(base_url());
                }
    }

     /*public function Bulk_Post()
    {
    if ($this->session->userdata('user_login_access') != false)
                {
                    $this->load->view('inlandMails/mails-bulk-posting-dashboard');
                }
                else{
                    redirect(base_url());
                }
    }*/


    public function Bulk_Post(){
        if ($this->session->userdata('user_login_access') != false){
            $emid = $this->session->userdata('user_login_id');

           

            $emslist = $this->unregistered_model->get_mails_application_list('BULK Post',$Barcode='',$emid);

            $data = array();

             $data['ems'] = $this->unregistered_model->count_ems();
          $data['bags'] = $this->unregistered_model->count_bags();
          $data['despout'] = $this->unregistered_model->count_despatch();
          $data['despin'] = $this->unregistered_model->count_despatch_in();

            $data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
            $data['bags'] = $this->Box_Application_model->count_bags();

            $staff_section = $this->employee_model->getEmpDepartmentSections($emid);
            
            $data['current_section'] = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'';


            $data['current_controller'] = (!empty($staff_section[0]['controller']))? $staff_section[0]['controller']:'';


           if (!empty($emslist)) {
               foreach ($emslist as $key => $list) {
                    $emplyo = $this->employee_model->GetBasic($list->created_by);

                    $NewList[$list->created_by]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                    $NewList[$list->created_by]['em_sub_role'] = $emplyo->em_sub_role;
                    $NewList[$list->created_by]['em_image'] = $emplyo->em_image;
                    $NewList[$list->created_by]['pass_from'] = $list->pass_from;
                    $NewList[$list->created_by]['last_name'] = $emplyo->last_name;
                    //$NewList[$list['created_by']]['total'] = count($list['created_by']);
                }
                $data['counter_list'] = $NewList;
           }

            $this->load->view('inlandMails/mails-bulk-posting-dashboard',$data);
            // $this->load->view('inlandMails/mails-bulk-posting-dashboard');
        }else{
            redirect(base_url());
        }
    }


    public function Legal()
    {
    if ($this->session->userdata('user_login_access') != false)
    {

    /*$data['id'] = base64_decode($this->input->get('I'));
    $id = base64_decode($this->input->get('I'));
    $data['contItem'] = $this->Box_Application_model->get_contract_byId($id);
    $data['service']=$this->organization_model->get_contract();
    $this->load->view('legal/legal_view',$data);*/

    $data['contract'] = $this->Box_Application_model->get_contract_lists();
    $data['service']=$this->organization_model->get_contract();
    $this->load->view('legal/contract_list_view',$data);

    }
    else{
    redirect(base_url());
    }
    }

    public function Counter(){

        if ($this->session->userdata('user_login_access') != false){

            $emid = base64_decode($this->input->get('I'));
            $data['region'] = $this->employee_model->regselect();
            $data['emselect'] = $this->employee_model->emselect();
            $data['agselect'] = $this->employee_model->agselect();  

            $pf = $this->input->post('pf');
            $date = $this->input->post('date');
            $month = $this->input->post('month');

            if(!empty($pf)){
                //turn code to emid
                $emid2=$this->Box_Application_model->getemid($pf);
                $emid2=$emid2->em_id;
                if(!empty($emid2)){

                    if (!empty($date) || !empty($month)) {

                    $data['total'] = $this->Box_Application_model->get_ems_sumSearchpf($date,$month,$emid2);
                    $data['emslist'] = $this->Box_Application_model->get_ems_listSearchpf($date,$month,$emid2);
                    } else {
                        $data['total'] = $this->Box_Application_model->get_ems_sum();
                        $data['emslist'] = $this->Box_Application_model->get_ems_list();
                    }
                        
                } 

        }else{

            if (!empty($date) || !empty($month)) {
                $data['total'] = $this->Box_Application_model->get_ems_sumSearch($date,$month);
                $data['emslist'] = $this->Box_Application_model->get_ems_listSearch($date,$month);
            } else {
                $data['total'] = $this->Box_Application_model->get_ems_sum();
                $data['emslist'] = $this->Box_Application_model->get_ems_list();
            }
    }
    
    $this->load->view('domestic_ems/ems_counter_list',$data);

}else{
    redirect(base_url());
}

}

public function Distributer(){
    if ($this->session->userdata('user_login_access') != false){
        $emslist = $this->Box_Application_model->get_ems_counter_list('Distributer');

        // echo '<pre>';
        // print_r($emslist);
        // die();
       
       $data = array();

       if (!empty($emslist)) {
           foreach ($emslist as $key => $list) {
                $emplyo = $this->employee_model->GetBasic($list['created_by']);

                $NewList[$list['created_by']]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                $NewList[$list['created_by']]['em_sub_role'] = $emplyo->em_sub_role;
                $NewList[$list['created_by']]['em_image'] = $emplyo->em_image;
                $NewList[$list['created_by']]['pass_from'] = $list['pass_from'];
                $NewList[$list['created_by']]['last_name'] = $emplyo->last_name;
                //$NewList[$list['created_by']]['total'] = count($list['created_by']);
            }
            $data['counter_list'] = $NewList;
       }

        $this->load->view('domestic_ems/ems_distributer_list',$data);
    }else{
        redirect(base_url());
    }
}

public function Foreign_letter(){
    if ($this->session->userdata('user_login_access') != false){
        $emid = $this->session->userdata('user_login_id');

        $emslist = $this->unregistered_model->get_mails_application_list('Foreign letter',$Barcode='',$emid);
        $data = array();

        $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

       $data['current_section'] = @$staff_section[0]['name'];
       $data['current_controller'] = @$staff_section[0]['controller'];


       if (!empty($emslist)) {
           foreach ($emslist as $key => $list) {
                $emplyo = $this->employee_model->GetBasic($list->created_by);

                $NewList[$list->created_by]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                $NewList[$list->created_by]['em_sub_role'] = $emplyo->em_sub_role;
                $NewList[$list->created_by]['em_image'] = $emplyo->em_image;
                $NewList[$list->created_by]['pass_from'] = $list->pass_from;
                $NewList[$list->created_by]['last_name'] = $emplyo->last_name;
            }

            $data['counter_list'] = $NewList;
       }

        $this->load->view('domestic_ems/fl_passing_zone',$data);
    }else{
        redirect(base_url());
    }
}

public function InWard(){
    if ($this->session->userdata('user_login_access') != false){

        $emslist = $this->Box_Application_model->get_ems_Inward_list('InWard');
        $data = array();

        $data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
        $data['bags'] = $this->Box_Application_model->count_bags();

       if (!empty($emslist)) {
           foreach ($emslist as $key => $list) {
                $emplyo = $this->employee_model->GetBasic($list['created_by']);

                $NewList[$list['created_by']]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                $NewList[$list['created_by']]['em_sub_role'] = $emplyo->em_sub_role;
                $NewList[$list['created_by']]['em_image'] = $emplyo->em_image;
                $NewList[$list['created_by']]['pass_from'] = $list['pass_from'];
                $NewList[$list['created_by']]['last_name'] = $emplyo->last_name;
                //$NewList[$list['created_by']]['total'] = count($list['created_by']);
            }
            $data['counter_list'] = $NewList;
       }

        $this->load->view('domestic_ems/ems_inward_list',$data);
    }else{
        redirect(base_url());
    }
}

public function Pickup(){
    if ($this->session->userdata('user_login_access') != false){
        //$data['sectiondata'] = $this->employee_model->getDepartmentSections();

        $emid = $this->session->userdata('user_login_id');
        /*$data['emslist'] = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode='','InWard',$emid);*/
        $data['region'] = $this->employee_model->regselect();
        $data['emselect'] = $this->employee_model->emselect();
        $data['agselect'] = $this->employee_model->agselect();

        $pf = $this->input->post('pf');
        $date = $this->input->post('date');
        $month = $this->input->post('month');

        if (!empty($date) || !empty($month)) {
            $data['total'] = $this->Box_Application_model->get_ems_bill_sumSearch($date,$month);
            $data['emslist'] = $this->Box_Application_model->get_ems_bill_listSearch($date,$month);

            //$data['emslist'] = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode='','InWard',$emid);

        } else {
            $data['total'] = $this->Box_Application_model->get_ems_bill_sum();
            $data['emslist'] = $this->Box_Application_model->get_ems_bill_forPickup_list('Pickup',$barcode='',$emid);

             //$data['emslist'] = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode='','Pickup',$emid='');
        }
    
        $this->load->view('domestic_ems/ems_pickup_list',$data);
    }else{
        redirect(base_url());
    }
}

public function Pickup_pass(){
    if ($this->session->userdata('user_login_access') != false){
        $data['sectiondata'] = $this->employee_model->getDepartmentSections();

        $createdby = $this->session->userdata('user_login_id');

        $data['emslist'] = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode='','Pickup',$createdby,$emid='');

        $this->load->view('domestic_ems/ems_pickup_process_list.php',$data);
    }else{
        redirect(base_url());
    }
}

public function pcum_pass(){
    if ($this->session->userdata('user_login_access') != false){
        $data['sectiondata'] = $this->employee_model->getDepartmentSections();

        $createdby = $this->session->userdata('user_login_id');

        $data['emslist'] = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode='','Pickup',$createdby,$emid='');

        $this->load->view('domestic_ems/ems_pcum_process_list.php',$data);
    }else{
        redirect(base_url());
    }
}

public function pcum_passed_receive_list(){
    if ($this->session->userdata('user_login_access') != false){

        $emslist = $this->Box_Application_model->get_ems_Despatch_list('PCUM');
        $data = array();

        $data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
        $data['bags'] = $this->Box_Application_model->count_bags();

       if (!empty($emslist)) {
           foreach ($emslist as $key => $list) {
            if ($list['created_by']) {
                 $emplyo = $this->employee_model->GetBasic($list['created_by']);

                $NewList[$list['created_by']]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                $NewList[$list['created_by']]['em_sub_role'] = $emplyo->em_sub_role;
                $NewList[$list['created_by']]['em_image'] = $emplyo->em_image;
                $NewList[$list['created_by']]['pass_from'] = $list['pass_from'];
                $NewList[$list['created_by']]['last_name'] = $emplyo->last_name;
                //$NewList[$list['created_by']]['total'] = count($list['created_by']);
            }
               
            }
            
            if (!empty($NewList)) $data['counter_list'] = $NewList;
       }

        $this->load->view('domestic_ems/pcum_passed_receive_list',$data);
    }else{
        redirect(base_url());
    }
}

public function mails_zone_pass(){
    if ($this->session->userdata('user_login_access') != false){
        $data['sectiondata'] = $this->employee_model->getDepartmentSections(23);
        $data['fromzone'] = $_GET['fromzone'];

        $createdby = $this->session->userdata('user_login_id');
        $staff_section = $this->employee_model->getEmpDepartmentSections($createdby);

        //section details
        $data['current_section'] = @$staff_section[0]['name'];
        $data['current_controller'] = @$staff_section[0]['controller'];
        // print_r($data['current_section']);
        // die();

        //$data['emslist'] = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode='','Pickup',$createdby,$emid='');

        $this->load->view('domestic_ems/ems_zone_passing_process.php',$data);
    }else{
        redirect(base_url());
    }
}

public function InWard_mails_pass(){
    if ($this->session->userdata('user_login_access') != false){
        $data['sectiondata'] = $this->employee_model->getDepartmentSections(23);

        $createdby = $this->session->userdata('user_login_id');

        $data['emslist'] = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode='','Pickup',$createdby,$emid='');

        $this->load->view('domestic_ems/ems_inward_mails_process_list.php',$data);
    }else{
        redirect(base_url());
    }
}

public function InWard_pass(){
    if ($this->session->userdata('user_login_access') != false){
        $data['sectiondata'] = $this->employee_model->getDepartmentSections();

        $createdby = $this->session->userdata('user_login_id');

        $data['emslist'] = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode='','Pickup',$createdby,$emid='');

        $this->load->view('domestic_ems/ems_inward_process_list.php',$data);
    }else{
        redirect(base_url());
    }
}

public function Despatch(){
    if ($this->session->userdata('user_login_access') != false){

        $emslist = $this->Box_Application_model->get_ems_Despatch_list('Despatch');
        $data = array();

        $data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
        $data['bags'] = $this->Box_Application_model->count_bags();

       if (!empty($emslist)) {
           foreach ($emslist as $key => $list) {
                $emplyo = $this->employee_model->GetBasic($list['created_by']);

                $NewList[$list['created_by']]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                $NewList[$list['created_by']]['em_sub_role'] = $emplyo->em_sub_role;
                $NewList[$list['created_by']]['em_image'] = $emplyo->em_image;
                $NewList[$list['created_by']]['pass_from'] = $list['pass_from'];
                $NewList[$list['created_by']]['last_name'] = $emplyo->last_name;
                //$NewList[$list['created_by']]['total'] = count($list['created_by']);
            }
            //$data['counter_list'] = $NewList;
            if (!empty($NewList)) $data['counter_list'] = $NewList;
       }

        $this->load->view('domestic_ems/ems_despatch_list',$data);
    }else{
        redirect(base_url());
    }
}

public function Despatch_pass(){
    if ($this->session->userdata('user_login_access') != false){
        $data['sectiondata'] = $this->employee_model->getDepartmentSections();

        $createdby = $this->session->userdata('user_login_id');

        $data['emslist'] = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode='','Pickup',$createdby,$emid='');

        $this->load->view('domestic_ems/ems_despatch_process_list.php',$data);
    }else{
        redirect(base_url());
    }
}


public function tracing(){
    if ($this->session->userdata('user_login_access') != false){
         $this->load->view('backend/trace_edit.php');

    }else{
        redirect(base_url());
    }
}

public function deliver_report(){
    if ($this->session->userdata('user_login_access') != false){
         $this->load->view('ems/deliverer_report.php');

    }else{
        redirect(base_url());
    }
}

public function printDeliveryItems(){
    if ($this->session->userdata('user_login_access') != false){

        $fromdate = $this->input->get('fromdate');
        $todate = $this->input->get('todate');
        $status = $this->input->get('status');
        $empid = $this->input->get('empid');

        $data['fromdate'] = $fromdate;
        $data['todate'] = $todate;

        $data['delivering'] = $this->Box_Application_model->getDeliveryItemsByStatus($empid,$status,$fromdate,$todate);

        $data['info'] = $this->ContractModel->get_employee_info($empid);

        // echo "<pre>";
        // print_r($data['delivering']);
        // die();

        

        $this->load->view('domestic_ems/printdeliveryItems.php',$data);
    }else{
        redirect(base_url());
    }
}

public function tracing_master(){
    if ($this->session->userdata('user_login_access') != false){
        $barcode = $this->input->post('barcode');

        $tranDetails  = $this->Box_Application_model->searchTransaction($id='',$barcode,$cnumber='',$mobile='');

        $tranDetailsFull  = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode,"","","");

        $receiverInfo = "<h3 
        style='font-weight:bold'
        >From ".$tranDetailsFull[0]['s_district']." - To ".$tranDetailsFull[0]['branch']."</h3>";

        if ($tranDetails) {
            $count = 1;
            $temp = '';

            //$data  = $this->Box_Application_model->transTracingMaster($tranDetails[0]['id']);

            $data  = $this->Box_Application_model->transTracingMaster(
                $tranDetails[0]['id'],
                $createdby='',
                $pass_to='',
                $office_name='',
                $status='',$fromdate='',$todate='',$trans_type='',$type=1);

            

            foreach ($data as $key => $value) {
                $sn = $count++;


                $fromdata  = $this->Box_Application_model->GetBasic($value['emid']);

                $fromFullName = @$fromdata->first_name.' '.@$fromdata->middle_name.' '.@$fromdata->last_name;

                if ($value['pass_to']) {
                   $todata  = $this->Box_Application_model->GetBasic($value['pass_to']);

                   $toFullName = @$todata->first_name.' '.@$todata->middle_name.' '.@$todata->last_name;

                }else{
                    $toFullName = 'Null';
                }
            

                $temp .="<tr class='tr".$value['id']."'> 
                    <td>".$sn."</td>
                     <td>".@$tranDetails[0]['Barcode']."</td>
                     <td>".$fromFullName."</td>
                     <td>".$toFullName."</td>
                     <td>".$value['office_name']."</td>
                     <td>".$value['description']."</td>
                     <td>".$value['status']."</td>
                     <td>".@$fromdata->em_branch."</td>
                     <td>".@$value['doc']."</td>
                     </tr>";
            }

            $response['status'] = "Success";
            $response['infotab'] = @$receiverInfo;
            $response['msg'] = @$temp;
        }else{
            $response['status'] = "Error";
            $response['msg'] = 'No data';
        }

        print_r(json_encode($response));
    }else{
        redirect(base_url());
    }
}

//-MAILS
public function InWard_mails(){
    if ($this->session->userdata('user_login_access') != false){
        $emid = $this->session->userdata('user_login_id');

        $emslist = $this->unregistered_model->get_mails_application_list('InWard Open',$Barcode='',$emid);
        $data = array();

        $data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
        $data['bags'] = $this->Box_Application_model->count_bags();

        $staff_section = $this->employee_model->getEmpDepartmentSections($emid);
        
        $data['current_section'] = $staff_section[0]['name'];
        $data['current_controller'] = $staff_section[0]['controller'];


       if (!empty($emslist)) {
           foreach ($emslist as $key => $list) {
                $emplyo = $this->employee_model->GetBasic($list->created_by);

                $NewList[$list->created_by]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                $NewList[$list->created_by]['em_sub_role'] = $emplyo->em_sub_role;
                $NewList[$list->created_by]['em_image'] = $emplyo->em_image;
                $NewList[$list->created_by]['pass_from'] = $list->pass_from;
                $NewList[$list->created_by]['last_name'] = $emplyo->last_name;
                //$NewList[$list['created_by']]['total'] = count($list['created_by']);
            }
            $data['counter_list'] = $NewList;
       }

        $this->load->view('domestic_ems/ems_inward_mails_list.php',$data);
    }else{
        redirect(base_url());
    }
}

public function mail_tracing(){
    if ($this->session->userdata('user_login_access') != false){
         $this->load->view('backend/mail_trace_edit.php');

    }else{
        redirect(base_url());
    }
}


public function InLand_reg(){
    if ($this->session->userdata('user_login_access') != false){
        $emid = $this->session->userdata('user_login_id');
        $service_type = 'Register';

        $this->session->set_userdata('service_type',$service_type);
        $this->session->set_userdata('service_type_new','InLand_reg');

        $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

        //$emslist = $this->unregistered_model->get_mails_application_list('InLand registration');
        $emslist = $this->unregistered_model->get_mails_application_list('InLand registration',$Barcode='',$emid);

        $data['ems'] = $this->unregistered_model->count_ems();
        $data['bags'] = $this->unregistered_model->count_bags();
        $data['despout'] = $this->unregistered_model->count_despatch();
        $data['despin'] = $this->unregistered_model->count_despatch_in();
        $data['current_section'] = $staff_section[0]['name'];
        $data['current_controller'] = $staff_section[0]['controller'];


       if (!empty($emslist)) {
           foreach ($emslist as $key => $list) {
                $emplyo = $this->employee_model->GetBasic($list->created_by);

                $NewList[$list->created_by]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                $NewList[$list->created_by]['em_sub_role'] = $emplyo->em_sub_role;
                $NewList[$list->created_by]['em_image'] = $emplyo->em_image;
                $NewList[$list->created_by]['pass_from'] = $list->pass_from;
                $NewList[$list->created_by]['last_name'] = $emplyo->last_name;
            }
            $data['counter_list'] = $NewList;
       }

        $this->load->view('domestic_ems/ems_iland_reg_list.php',$data);
    }else{
        redirect(base_url());
    }
}

public function mails_counters(){
    if ($this->session->userdata('user_login_access') != false){
        $emid = $this->session->userdata('user_login_id');
        $service_type = 'Register';

        $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

        $this->session->set_userdata('service_type',$service_type);
        $this->session->set_userdata('service_type_new','InLand_reg');

        $emslist = $this->unregistered_model->get_mails_application_list($staff_section[0]['name'],$barcode='',$emid);

        $data['ems'] = $this->unregistered_model->count_ems();
        $data['bags'] = $this->unregistered_model->count_bags();
        //$data['despout'] = $this->unregistered_model->count_despatch();
        //$data['despin'] = $this->unregistered_model->count_despatch_in();
        $data['current_section'] = $staff_section[0]['name'];
        $data['current_controller'] = $staff_section[0]['controller'];


       if (!empty($emslist)) {
           foreach ($emslist as $key => $list) {
                $emplyo = $this->employee_model->GetBasic($list->created_by);

                $NewList[$list->created_by]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                $NewList[$list->created_by]['em_sub_role'] = $emplyo->em_sub_role;
                $NewList[$list->created_by]['em_image'] = $emplyo->em_image;
                $NewList[$list->created_by]['pass_from'] = $list->pass_from;
                $NewList[$list->created_by]['last_name'] = $emplyo->last_name;
            }
            $data['counter_list'] = $NewList;
       }

        $this->load->view('domestic_ems/mails_counters_list.php',$data);
    }else{
        redirect(base_url());
    }
}


public function InLand_parcel(){
    if ($this->session->userdata('user_login_access') != false){
        $emid = $this->session->userdata('user_login_id');

        $emslist = $this->unregistered_model->get_mails_application_list('Inland parcel',$Barcode='',$emid);

        $service_type = 'InLand_parcel';

        $this->session->set_userdata('Ask_for','Parcels-Post');
        $this->session->set_userdata('service_type',$service_type);
        $this->session->set_userdata('service_type_new','InLand_parcel');

        $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

        $data['despout'] = $this->unregistered_model->count_despatch();
        $data['despin'] = $this->unregistered_model->count_despatch_in();
        $data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
        $data['bags'] = $this->Box_Application_model->count_bags();

        $data['current_section'] = $staff_section[0]['name'];
        $data['current_controller'] = $staff_section[0]['controller'];


       if (!empty($emslist)) {
        
           foreach ($emslist as $key => $list) {
                $emplyo = $this->employee_model->GetBasic($list->created_by);

                $NewList[$list->created_by]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                $NewList[$list->created_by]['em_sub_role'] = $emplyo->em_sub_role;
                $NewList[$list->created_by]['em_image'] = $emplyo->em_image;
                $NewList[$list->created_by]['pass_from'] = $list->pass_from;
                $NewList[$list->created_by]['last_name'] = $emplyo->last_name;
                //$NewList[$list['created_by']]['total'] = count($list['created_by']);
            }
            $data['counter_list'] = $NewList;
       }

        $this->load->view('domestic_ems/ems_inland_parcel.php',$data);
    }else{
        redirect(base_url());
    }
}

//Outbond
public function OutBound(){
    if ($this->session->userdata('user_login_access') != false){
        $emid = $this->session->userdata('user_login_id');

        $emslist = $this->unregistered_model->get_mails_application_list('OutBound',$Barcode='',$emid);

        $service_type = 'OutBound';

        $this->session->set_userdata('Ask_for','Parcels-Post');
        $this->session->set_userdata('service_type',$service_type);
        $this->session->set_userdata('service_type_new','OutBound');

        $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

        $data['despout'] = $this->unregistered_model->count_despatch();
        $data['despin'] = $this->unregistered_model->count_despatch_in();
        $data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
        $data['bags'] = $this->Box_Application_model->count_bags();

        $data['current_section'] = $staff_section[0]['name'];
        $data['current_controller'] = $staff_section[0]['controller'];


       if (!empty($emslist)) {
        
           foreach ($emslist as $key => $list) {
                $emplyo = $this->employee_model->GetBasic($list->created_by);

                $NewList[$list->created_by]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                $NewList[$list->created_by]['em_sub_role'] = $emplyo->em_sub_role;
                $NewList[$list->created_by]['em_image'] = $emplyo->em_image;
                $NewList[$list->created_by]['pass_from'] = $list->pass_from;
                $NewList[$list->created_by]['last_name'] = $emplyo->last_name;
                //$NewList[$list['created_by']]['total'] = count($list['created_by']);
            }
            $data['counter_list'] = $NewList;
       }

        $this->load->view('domestic_ems/ems_outbound.php',$data);
    }else{
        redirect(base_url());
    }
}

//Return letter office
public function Return_letter_office(){
    if ($this->session->userdata('user_login_access') != false){
        $emid = $this->session->userdata('user_login_id');

        $emslist = $this->unregistered_model->get_mails_application_list('Return letter office',$Barcode='',$emid);

        $service_type = 'Return_letter_office';

        $this->session->set_userdata('Ask_for','Parcels-Post');
        $this->session->set_userdata('service_type',$service_type);
        $this->session->set_userdata('service_type_new','Return_letter_office');

        $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

        $data['despout'] = $this->unregistered_model->count_despatch();
        $data['despin'] = $this->unregistered_model->count_despatch_in();
        $data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
        $data['bags'] = $this->Box_Application_model->count_bags();

        $data['current_section'] = $staff_section[0]['name'];
        $data['current_controller'] = $staff_section[0]['controller'];


       if (!empty($emslist)) {
        
           foreach ($emslist as $key => $list) {
                $emplyo = $this->employee_model->GetBasic($list->created_by);

                $NewList[$list->created_by]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                $NewList[$list->created_by]['em_sub_role'] = $emplyo->em_sub_role;
                $NewList[$list->created_by]['em_image'] = $emplyo->em_image;
                $NewList[$list->created_by]['pass_from'] = $list->pass_from;
                $NewList[$list->created_by]['last_name'] = $emplyo->last_name;
                //$NewList[$list['created_by']]['total'] = count($list['created_by']);
            }
            $data['counter_list'] = $NewList;
       }

        $this->load->view('domestic_ems/ems_return_letter.php',$data);
    }else{
        redirect(base_url());
    }
}

public function mail_tracing_master(){
    if ($this->session->userdata('user_login_access') != false){
        $barcode = $this->input->post('barcode');


        $tranDetails  = $this->unregistered_model->mail_searchTransaction($transid='',$barcode,$mobile='');

        $tranDetailsFull  = $this->unregistered_model->get_senderperson_barcode($db='otherdb',$barcode);

        $receiverInfo = '';

        if(!empty($tranDetailsFull)){

            $toReceiver = (!empty($tranDetailsFull[0]['reciver_branch']))? $tranDetailsFull[0]['reciver_branch']:'Null';

            $receiverInfo = "<h3 
        style='font-weight:bold'
        >From ".$tranDetailsFull[0]['sender_branch']." - To - ".$toReceiver."</h3>";
        }

        if ($tranDetails) {
            $count = 1;
            $temp = '';

            $data  = $this->Box_Application_model->transTracingMaster($tranDetails[0]['t_id'],$createdby='',$pass_to='',$office_name='',$status='',$fromdate='',$todate='','mails',$type=1);

            foreach ($data as $key => $value) {

                $fromdata  = $this->Box_Application_model->GetBasic($value['emid']);

                $fromFullName = $fromdata->first_name.' '.$fromdata->middle_name.' '.$fromdata->last_name;

                if ($value['pass_to']) {
                   $todata  = $this->Box_Application_model->GetBasic($value['pass_to']);

                   $toFullName = $todata->first_name.' '.$todata->middle_name.' '.$todata->last_name;

                }else{
                    $toFullName = 'Null';
                }

                //Fomulating new index, which will remove duplicate incase
                $newArrIndex = $value['office_name'].'_'.$value['status'];
                //Trace list
                $newList[$newArrIndex]['id'] = $value['id'];
                $newList[$newArrIndex]['office_name'] = $value['office_name'];
                $newList[$newArrIndex]['barcode'] = $tranDetails[0]['Barcode'];
                $newList[$newArrIndex]['fromFullName'] = $fromFullName;
                $newList[$newArrIndex]['toFullName'] = $toFullName;
                $newList[$newArrIndex]['description'] = $value['description'];
                $newList[$newArrIndex]['status'] = $value['status'];
                $newList[$newArrIndex]['doc'] = $value['doc'];
                $newList[$newArrIndex]['branch'] = $fromdata->em_branch;

            }

            //Preparing data for viewing on client side
            foreach ($newList as $key => $value) {
                $sn = $count++;
                
                $temp .="<tr class='tr".$value['id']."'> 
                    <td>".$sn."</td>
                     <td>".$value['barcode']."</td>
                     <td>".$value['fromFullName']."</td>
                     <td>".$value['toFullName']."</td>
                     <td>".$value['office_name']."</td>
                     <td>".$value['description']."</td>
                     <td>".$value['status']."</td>
                     <td>".$value['branch']."</td>
                     <td>".$value['doc']."</td>
                     </tr>";
            }

            $response['status'] = "Success";
            $response['infotab'] = $receiverInfo;
            $response['msg'] = $temp;
        }else{
            $response['status'] = "Error";
            $response['msg'] = 'No data';
        }

        print_r(json_encode($response));
    }else{
        redirect(base_url());
    }
}

public function search_master(){
    if ($this->session->userdata('user_login_access') != false){
         $this->load->view('backend/master_search');

    }else{
        redirect(base_url());
    }
}

public function search_transaction(){
    if ($this->session->userdata('user_login_access') != false){
        $barcode = $this->input->post('barcode');
        $cnumber = $this->input->post('cnumber');
        $mobile = $this->input->post('mobile');

        $data  = $this->Box_Application_model->searchTransaction($id='',$barcode,$cnumber,$mobile);

        if ($data) {
            $count = 1;
            $temp = '';

            foreach ($data as $key => $value) {
                $sn = $count++;

                $temp .="<tr class='tr".$value['id']."'> <td>".$sn."</td>
                     <td><input 
                     onchange='editingProcess(this)'
                     class='editbarcode form-condtrol' 
                     data-transId='".$value['id']."'
                     readonly disabled type='text' value='".$value['Barcode']."'/></td>
                     <td>".$value['Customer_mobile']."</td>
                     <td>".$value['PaymentFor']."</td>
                     <td>".$value['bag_status']."</td>
                     <td>".$value['billid']."</td>
                     <td>".$value['district']."</td>
                     <td>".$value['isBagNo']."</td>
                     <td>".$value['paidamount']."</td>
                     <td>".$value['paychannel']."</td>
                     <td>".$value['paymentdate']."</td>
                     <td>".$value['receipt']."</td>
                     <td>".$value['region']."</td>
                     <td>".$value['serial']."</td>
                     <td>".$value['transactiondate']."</td>
                     <td>
                     <a onclick='return confirm('Are you sure to delete this data?')' 
                     href='".base_url()."Services/cancelTransaction/".$value['id']."' title='Cancel' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-trash-o'></i></a>

                     <a onclick='allowEdit()' href='#' title='Edit' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-pencil'></i></a>

                     </td>
                     </tr>";
            }
            $response['status'] = "Success";
            $response['msg'] = $temp;
        }else{
            $response['status'] = "Error";
            $response['msg'] = 'No data';
        }


        print_r(json_encode($response));
    }else{
        redirect(base_url());
    }
}

    public function cancelTransaction($transid){
     if ($this->session->userdata('user_login_access') != false){
        // print_r($transid);
        // die();

        if ($transid) {
             $data  = $this->Box_Application_model->searchTransaction($transid,$barcode='',$cnumber='',$mobile='');
            //delete the transaction
            $this->Box_Application_model->transactionDelete($transid);
            //process of copying data
            $this->Box_Application_model->copyTransaction($data[0]);

            redirect('Services/search_master');
        }else{
            redirect('Services/search_master');
        }

     }else{
        redirect(base_url());
     }
}

public function mail_search_master(){
    if ($this->session->userdata('user_login_access') != false){
         $this->load->view('backend/mail_master_search');
    }else{
        redirect(base_url());
    }
}

public function mail_search_transaction(){
    if ($this->session->userdata('user_login_access') != false){
        $barcode = $this->input->post('barcode');
        $cnumber = $this->input->post('cnumber');
        $mobile = $this->input->post('mobile');

        $data  = $this->unregistered_model->mail_searchTransaction($transid='',$barcode,$mobile);

        //print_r($data);die();

        if ($data) {
            $count = 1;
            $temp = '';

            foreach ($data as $key => $value) {
                $sn = $count++;

                $temp .="<tr class='tr".$value['t_id']."'> <td>".$sn."</td>
                     <td><input 
                     onchange='editingProcess(this)'
                     class='editbarcode form-condtrol' 
                     data-transId='".$value['t_id']."'
                     readonly disabled type='text' value='".$value['Barcode']."'/></td>
                     <td>".$value['sender_mobile']."</td>
                     <td>".$value['bag_status']."</td>
                     <td>".$value['billid']."</td>
                     <td>".$value['sender_branch']."</td>
                     <td>".$value['isBagNo']."</td>
                     <td>".$value['serial']."</td>
                     <td>".$value['transactiondate']."</td>
                     <td>
                     <a onclick='return confirm('Are you sure to delete this data?')' 
                     href='".base_url()."Services/cancelMailTransaction/".$value['t_id']."' title='Cancel' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-trash-o'></i></a>

                     <a onclick='allowEdit()' href='#' title='Edit' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-pencil'></i></a>

                     </td>
                     </tr>";
            }
            $response['status'] = "Success";
            $response['msg'] = $temp;
        }else{
            $response['status'] = "Error";
            $response['msg'] = 'No data';
        }


        print_r(json_encode($response));
    }else{
        redirect(base_url());
    }
}

public function cancelMailTransaction($transid){
     if ($this->session->userdata('user_login_access') != false){

        if ($transid) {
            $data  = $this->unregistered_model->mail_searchTransaction($transid,$barcode='',$mobile='');
            
            //echo "<pre>";
            //print_r($data);
            //die();

            //delete the transaction
            $this->unregistered_model->transactionDelete($transid);
            //process of copying data
           unset($data[0]['senderp_id']);
           unset($data[0]['sender_fullname']);
           unset($data[0]['sender_address']);
           unset($data[0]['sender_email']);
           unset($data[0]['sender_mobile']);
           unset($data[0]['sender_status']);
           unset($data[0]['register_type']);
           unset($data[0]['register_weght']);
           unset($data[0]['register_price']);
           unset($data[0]['sender_region']);
           unset($data[0]['sender_branch']);
           unset($data[0]['sender_date_created']);
           unset($data[0]['operator']);
           unset($data[0]['payment_type']);
           unset($data[0]['sender_bag_number']);
           unset($data[0]['sender_type']);
           unset($data[0]['sender_received_by']);
           unset($data[0]['acc_no']);
           unset($data[0]['add_type']);
           unset($data[0]['edit_reason_Message']);
           unset($data[0]['track_number']);

            $this->unregistered_model->copyTransaction($data[0]);

            redirect('Services/mail_search_master');
        }else{
            redirect('Services/mail_search_master');
        }

     }else{
        redirect(base_url());
     }
}

    public function BackOffice(){

    if ($this->session->userdata('user_login_access') != false)
    {

    $data['emslist1'] = $this->Box_Application_model->get_ems_back_list233();
    //$data['emslist1'] = $this->Box_Application_model->get_ems_back_list_international_Search($date,$month);

    $data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
    $data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
    $data['ems'] = $this->Box_Application_model->count_ems();


    $data['bags'] = $this->Box_Application_model->count_bags();
    $this->load->view('backend/dashboard_backoffice',$data);
    }
    else{
    redirect(base_url());
    }

    }
    public function Mails_Backoffice(){

    if ($this->session->userdata('user_login_access') != false)
    {
    $this->load->view('inlandMails/mails-backoffice-dashboard');
    }
    else{
    redirect(base_url());
    }

    }

    public function SmartPosta(){

        if ($this->session->userdata('user_login_access') != false){

            $id = $this->session->userdata('user_login_id');
            $getInfo = $this->employee_model->GetBasic($id);
            $email = $getInfo->em_email;
            $region = $getInfo->em_region;
            $role = $getInfo->em_role;


            $getRegId = $this->organization_model->get_region_id($region);
            $reg_id = $getRegId->region_id;

            $getBrId = $this->organization_model->selectbranch($reg_id);

            redirect('http://smartposta.posta.co.tz/app/sso_auth?email='.$email.'&officeid='.$getBrId->branch_id.'&role='.$role);
        
        }else{
            redirect(base_url());
        }
 }

 public function Delivery_Map(){

        if ($this->session->userdata('user_login_access') != false){

            $id = $this->session->userdata('user_login_id');
            $getInfo = $this->employee_model->GetBasic($id);
            $email = $getInfo->em_email;
            $region = $getInfo->em_region;
            $role = $getInfo->em_role;


            $getRegId = $this->organization_model->get_region_id($region);
            $reg_id = $getRegId->region_id;

            $getBrId = $this->organization_model->selectbranch($reg_id);


            $simple_string = $email;
            $ciphering = "AES-128-CTR";
            $iv_length = openssl_cipher_iv_length($ciphering);
            $options = 0;
            $encryption_iv = '2354235322332234';
            $encryption_key = "Postapmis";
            $encryption = openssl_encrypt($simple_string, $ciphering,
            $encryption_key, $options, $encryption_iv);

            redirect('https://delivery.posta.co.tz/index.php/Login/auth?email='.$email.'&key='.$encryption.'&role='.$role);
        
        }else{
            redirect(base_url());
        }
 }

public function Commission(){

if($this->session->userdata('user_login_access') != false)
{
$data['region'] = $this->employee_model->regselect();
$this->load->view('billing/commission_agency_registration',$data);
}
else{
redirect(base_url());
}

}

public function EMS_Billing(){

if ($this->session->userdata('user_login_access') != false)
{
$data['region'] = $this->employee_model->regselect();
$this->load->view('billing/ems_companies_registration',$data);
}
else{
redirect(base_url());
}

}
public function MAILS_Billing(){

if ($this->session->userdata('user_login_access') != false)
{
$data['region'] = $this->employee_model->regselect();
$this->load->view('billing/mails_companies_registration',$data);
}
else{
redirect(base_url());
}

}

public function Estate()
        {
            if ($this->session->userdata('user_login_access') != false)
            {
                $data['region'] = $this->employee_model->regselect();
                $data['category'] = $this->billing_model->getAllCategory();
                $data['listItem'] = $this->billing_model->getAllCategoryBill();

                $this->load->view('estate/Estate',$data);
            }
            else{
                redirect(base_url());
            }
        }

        public function Report()
        {
            if ($this->session->userdata('user_login_access') != false)
            {
              

                $this->load->view('billing/ems_report');
            }
            else{
                redirect(base_url());
            }
        }

public function Parking()
        {
            if ($this->session->userdata('user_login_access') != false)
            {
                
                $data['countIn'] = $this->parking_model->get_to_day_vehicle_In();
                $data['countOutn'] = $this->parking_model->get_to_day_vehicle_Out();
                $data['countTrans'] = $this->parking_model->get_to_day_trans();
                $data['graph'] = $this->parking_model->getVehicleDataGraph();
                $data['countWallet'] = $this->parking_model->get_wallet_custom_trans();

                $this->load->view('parking/parking-dashboard',$data);

            }
            else{
                redirect(base_url());
            }
        }
    
}