 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ems_International_Bill extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('Ems_International_model');
        $this->load->model('Box_Application_model');
        $this->load->model('organization_model');
        $this->load->model('billing_model');
        $this->load->model('Sms_model');
        $this->load->model('Bill_Customer_model');
        $this->load->model('Ems_International_bill_model');
         $this->load->model('unregistered_model');
    }


    public function International_bulk_Ems()
    {
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
           $data['country'] = $this->organization_model->countryselect();
           //$country = $countries->country_name;

      $this->load->view('ems_international/international_ems_bulk_form',$data);
           
        
    }
}


public function save_bulk_bill_document_info(){



   $id  = $this->session->userdata('user_login_id');
   $info = $this->employee_model->GetBasic($id);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
   $AskFor = $this->input->post('AskFor');
    $this->session->set_userdata('askfor',$AskFor);
   $serial = $this->input->post('serial');
   $operator = $this->input->post('operator');
    $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);
     $alltotal = 0;
     
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->paidamount;
   
                
                $data = array();
                $data = array('track_no'=>$value->track_number,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);
              }


    

    $paidamount = @$alltotal;
    $region = @$listbulk[0]->s_region;
    $district = @$listbulk[0]->s_district;
    $renter   =  @$listbulk[0]->s_fullname;
    $serviceId = 'EMS_INTERNATIONAL';
    $trackNo = $serial;
     $mobile = @$listbulk[0]->s_mobile;



 $sender_region = $this->session->userdata('user_region');
  $sender_branch = $this->session->userdata('user_branch');

  echo "Successfully Saved";
        // redirect(base_url('Bill_Customer/bill_customer_list?AskFor=EMS%20Postage'));


                // $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya EMS  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                //$this->load->view('inlandMails/posts-cargo-control-number-form',$data);   

            


}


    public function bill_customer_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            $AskFor = $this->input->get('AskFor');
            $this->session->set_userdata('askfor',$AskFor);
            $data['region'] = $this->employee_model->regselect();
            $data['check'] = $this->Ems_International_bill_model->check_credit_customer();
            $this->load->view('ems_international/bill-customer-list-Ems',@$data);

         }else{
            redirect(base_url());
         }
           
    }

    public function bill_customer_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') !=false){
           $crdtid = base64_decode($this->input->get('I'));
           $data['askfor'] = $this->input->get('AskFor');
           $this->session->set_userdata('askfor',@$askfor);
           $data['edit'] = $this->Bill_Customer_model->get_customer_bill_credit_by_id($crdtid);
            $this->load->view('ems_international/bill-customer-register-form',$data);
            
            }else{
                redirect(base_ur());
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

     
                 redirect(base_url('Ems_International_Bill/bill_customer_form?I='.base64_encode($I).'&&'.'AskFor='.$askfor),'refresh');


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
     
                 redirect(base_url('Ems_International_Bill/bill_customer_form?I='.base64_encode($I).'&&'.'AskFor='.$askfor),'refresh');

         
      // redirect(base_url('Bill_Customer/bill_customer_form?I='.base64_encode($I).'&&'.'AskFor='.$askfor),'refresh');

    }

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
            
           
            $data['check'] = $this->Ems_International_bill_model->check_credit_customer_search_employee($region,$month,$date,$custname);
            $this->load->view('ems_international/bill-customer-list-Ems_search',$data);
            
            

         }else{
            redirect(base_url());
         }
           
    }



public function Ems_price_vat_international()
{
if ($this->session->userdata('user_login_access') != false)
{

$emsCat = $this->input->post('tariffCat');
$weight = $this->input->post('weight');
$emstype = $this->input->post('emstype');

$Getzone = $this->organization_model->get_zone_country($emsCat);
$zone    = $Getzone->zone_name;

    if ($weight > 10) {
      

        $weight10    = 10;
    $getPrice    = $this->organization_model->get_zone_country_price10($zone,$weight10,$emstype);

    //$vat10       = $getPrice->vat;
    //$price10     = $getPrice->tariff_price;
    $totalprice10 = $getPrice->zone_price;
    $diff   =  $weight - $weight10;

    if ($emstype == "Document") {

    if ($diff <= 0.5) {

        if ($zone == 'ZONE1') {
            $totalPrice = $totalprice10 + 4000;
        }if ($zone == 'ZONE2') {
            $totalPrice = $totalprice10 + 6100;
        }if ($zone == 'ZONE3') {
            $totalPrice = $totalprice10 + 7300;
        }if ($zone == 'ZONE4') {
            $totalPrice = $totalprice10 + 7600;
        }if ($zone == 'ZONE5') {
            $totalPrice = $totalprice10 + 8400;
        }if ($zone == 'ZONE6') {
            $totalPrice = $totalprice10 + 9800;
        }if ($zone == 'ZONE7') {
            $totalPrice = $totalprice10 + 9400;
        }

        $dvat = $totalPrice * 0.18;
        $dprice = $totalPrice - ($totalPrice * 0.18);
        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$totalPrice' class='price1'></td></tr>
            </table>";


    } else {

            $whole   = floor($diff);
            $decimal = fmod($diff,1);
            if ($decimal == 0) {

                if ($zone == 'ZONE1') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*4000;
                }if ($zone == 'ZONE2') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*6100;
                }if ($zone == 'ZONE3') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*7300;
                }if ($zone == 'ZONE4') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*7600;
                }if ($zone == 'ZONE5') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*8400;
                }if ($zone == 'ZONE6') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*9800;
                }if ($zone == 'ZONE7') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*9400;
                }
                

            } else {

                if ($decimal <= 0.5) {

                    
                    if ($zone == 'ZONE1') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*4000 + 4000;
                    }if ($zone == 'ZONE2') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*6100 + 6100;
                    }if ($zone == 'ZONE3') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*7300 + 7300;
                    }if ($zone == 'ZONE4') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*7600 + 7600;
                    }if ($zone == 'ZONE5') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*8400 + 8400;
                    }if ($zone == 'ZONE6') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9800 + 9800;
                    }if ($zone == 'ZONE7') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9400 + 9400;
                    }

                } else {

                    
                    if ($zone == 'ZONE1') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*4000 + 4000 + 4000;
                    }if ($zone == 'ZONE2') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*6100 + 6100 + 6100;
                    }if ($zone == 'ZONE3') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*7300 + 7300 + 7300;
                    }if ($zone == 'ZONE4') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*7600 + 7600 + 7600;
                    }if ($zone == 'ZONE5') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*8400 + 8400 + 8400;
                    }if ($zone == 'ZONE6') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9800 + 9800 + 9800;
                    }if ($zone == 'ZONE7') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9400 + 9400 + 9400;
                    }
                }

            }
            $dvat = $totalPrice * 0.18;
         $dprice = $totalPrice - ($totalPrice * 0.18);
            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$totalPrice' class='price1'></td></tr>
            </table>";
    }

    } else {

    if ($diff <= 0.5) {

        if ($zone == 'ZONE1') {
            $totalPrice = $totalprice10 + 5100;
        }if ($zone == 'ZONE2') {
            $totalPrice = $totalprice10 + 6900;
        }if ($zone == 'ZONE3') {
            $totalPrice = $totalprice10 + 9000;
        }if ($zone == 'ZONE4') {
            $totalPrice = $totalprice10 + 9100;
        }if ($zone == 'ZONE5') {
            $totalPrice = $totalprice10 + 9900;
        }if ($zone == 'ZONE6') {
            $totalPrice = $totalprice10 + 11000;
        }if ($zone == 'ZONE7') {
            $totalPrice = $totalprice10 + 16200;
        }

        $dvat = $totalPrice * 0.18;
        $dprice = $totalPrice - ($totalPrice * 0.18);
        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$totalPrice' class='price1'></td></tr>
            </table>";


    } else {

            $whole   = floor($diff);
            $decimal = fmod($diff,1);
            if ($decimal == 0) {

                if ($zone == 'ZONE1') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*5100;
                }if ($zone == 'ZONE2') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*6900;
                }if ($zone == 'ZONE3') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*9000;
                }if ($zone == 'ZONE4') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*9100;
                }if ($zone == 'ZONE5') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*9900;
                }if ($zone == 'ZONE6') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*11000;
                }if ($zone == 'ZONE7') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*16200;
                }
                

            } else {

                if ($decimal <= 0.5) {

                    
                    if ($zone == 'ZONE1') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*5100 + 5100;
                    }if ($zone == 'ZONE2') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*6900 + 6900;
                    }if ($zone == 'ZONE3') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9000 + 9000;
                    }if ($zone == 'ZONE4') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9100 + 9100;
                    }if ($zone == 'ZONE5') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9900 + 9900;
                    }if ($zone == 'ZONE6') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*11000 + 11000;
                    }if ($zone == 'ZONE7') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*16200 + 16200;
                    }

                } else {

                    
                    if ($zone == 'ZONE1') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*5100 + 5100 + 5100;
                    }if ($zone == 'ZONE2') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*6900 + 6900 + 6900;
                    }if ($zone == 'ZONE3') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9000 + 9000 + 9000;
                    }if ($zone == 'ZONE4') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9100 + 9100 + 9100;
                    }if ($zone == 'ZONE5') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9900 + 9900 + 9900;
                    }if ($zone == 'ZONE6') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*11000 + 11000 + 11000;
                    }if ($zone == 'ZONE7') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*16200 + 16200 + 16200;
                    }
                }

            }

            $dvat = $totalPrice * 0.18;
            $dprice = $totalPrice - ($totalPrice * 0.18);
            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$totalPrice' class='price1'></td></tr>
            </table>";
    }
    }


    } else {
        
        $Getprice = $this->organization_model->get_zone_country_price($zone,$weight,$emstype);

        //$totatEMSPrice = $Getprice->zone_tariff + $Getprice->zone_vat;

        if (empty($Getprice)) {

            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Price:</b></td><td>0</td></tr>
            <tr><td><b>Vat:</b></td><td>0</td></tr>
            <tr><td><b>Total Price:</b></td><td>0</td></tr>
            </table>";

        }else{

            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Price:</b></td><td><input type='text' name ='price1' value='$Getprice->zone_tariff' readonly></td></tr>
            <tr><td><b>Vat:</b></td><td><input type='text' name ='vat' value='$Getprice->zone_vat' readonly></td></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$Getprice->zone_price' class='price1' readonly></td></tr>
            </table>";

        }
    }
    
   


}else{
redirect(base_url());
}
}



}