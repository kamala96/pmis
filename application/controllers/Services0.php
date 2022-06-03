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
        $this->load->model('parking_model');
    }
    
	public function Ems(){
        if ($this->session->userdata('user_login_access') != false) {
            
            $data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Ems Dashboard');
            $this->load->view('ems/ems-dashboard',$data);
            
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
            $this->load->view('internet/Internet-dashboard',$data);
            
        } else {
           redirect(base_url());
        }
    }

    public function PostShop()
    {
   if ($this->session->userdata('user_login_access') != false) {
            
            $data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Posta Shop Dashboard');
            $this->load->view('Post_shop/Post_shop-dashboard',$data);
            
        } else {
           redirect(base_url());
        }
    }
    public function posta_bus()
    {
    if ($this->session->userdata('user_login_access') != false) {
            
            $data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Postabus Dashboard');
            $this->load->view('postabus/Postabus-dashboard',$data);
            
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

    public function Legal()
    {
    if ($this->session->userdata('user_login_access') != false)
    {

    $data['id'] = base64_decode($this->input->get('I'));
    $id = base64_decode($this->input->get('I'));
    $data['contItem'] = $this->Box_Application_model->get_contract_byId($id);
    $data['service']=$this->organization_model->get_contract();
    $this->load->view('legal/legal_view',$data);

    }
    else{
    redirect(base_url());
    }
    }

    public function BackOffice(){

    if ($this->session->userdata('user_login_access') != false)
    {

    $data['emslist1'] = $this->Box_Application_model->get_ems_back_list();
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