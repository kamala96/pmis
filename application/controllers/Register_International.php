 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_International extends CI_Controller {


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
        $this->load->model('Unregistered_model');
        $this->load->model('job_assign_model');
        $this->load->model('Sms_model');
        $this->load->model('Box_Application_model');
        $this->load->model('Control_Number_model');
        $this->load->model('Register_International_Model');
    }
    
    public function bill_customer_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') !=false){
           $crdtid = base64_decode($this->input->get('I'));
           $data['askfor'] = $this->input->get('AskFor');
           $this->session->set_userdata('askfor',@$askfor);
           $data['edit'] = $this->Bill_Customer_model->get_customer_bill_credit_by_id($crdtid);
            $this->load->view('register_international/bill-customer-register-form',$data);
            
            }else{
                redirect(base_ur());
            }
    }


    public function bill_customer_list(){
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            $AskFor = $this->input->get('AskFor');
            $this->session->set_userdata('askfor',$AskFor);
            $billtype = $this->input->post('billtype'); 
            $data['billtype'] = "Register";
            $data['region'] = $this->employee_model->regselect();
            $data['check'] = $this->Register_International_Model->check_credit_customer();
            $this->load->view('register_international/bill-customer-list',@$data);

         }else{
            redirect(base_url());
         }
           
    }

     public function bill_customer_list_Search()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

           // $data['bill'] = $this->Bill_Customer_model->get_all_bill_customer_saved_to();
            $AskFor = $this->input->post('AskFor');
            $this->session->set_userdata('askfor',$AskFor);

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
            
                $Asked = $AskFor;
                $data['check'] = $this->Bill_Customer_model->check_credit_customer_search_employee($Asked,$region,$month,$date,$custname);
                if(empty($billtype)){
                    $data['billtype']= "Register";

                }else{$data['billtype']=$billtype;}

                $this->load->view('register_international/bill-customer-list',$data);

       
            

         }else{
            redirect(base_url());
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

          //$this->Box_Application_model->delete_entries($accno);

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

     
                 redirect(base_url('Register_International/bill_customer_form?I='.base64_encode($I).'&&'.'AskFor='.$askfor),'refresh');


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
     
                 redirect(base_url('Register_International/bill_customer_form?I='.base64_encode($I).'&&'.'AskFor='.$askfor),'refresh');

         
      // redirect(base_url('Bill_Customer/bill_customer_form?I='.base64_encode($I).'&&'.'AskFor='.$askfor),'refresh');

    }

    }else{
        redirect(base_url());
        }
    }

/////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////

public function International_bulk_register(){
        if ($this->session->userdata('user_login_access') != false) {

           $id = base64_decode($this->input->get('I'));
           $data['custinfo'] = $this->Bill_Customer_model->get_bill_cust_details_info($id);
           $data['AskFor'] = $AskFor = $this->input->get('AskFor');
           $data['I'] = base64_decode($this->input->get('I'));
           $this->session->set_userdata('askfor',$AskFor);

           $data['region'] = $this->employee_model->regselect();
           //$date = $this->input->post('date');
           //$month= $this->input->post('month');
           //$region= $this->input->post('region');

          //$country = $this->organization_model->countryselect();
           $data['country'] = $this->Unregistered_model->International_register_country_name();
           //$country = $countries->country_name;

      $this->load->view('register_international/register-post-international-bulk-form',$data);
           
        
    }
}



}