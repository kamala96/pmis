	<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Realestate extends CI_Controller
	{


		function __construct()
		{
			parent::__construct();
			$this->load->database();
			//$db2 = $this->load->database('otherdb', TRUE);
			$this->load->model('login_model');
			$this->load->model('dashboard_model');
			$this->load->model('employee_model');
			$this->load->model('notice_model');
			$this->load->model('settings_model');
			$this->load->model('leave_model');
			$this->load->model('billing_model');
			$this->load->model('organization_model');
			$this->load->model('Box_Application_model');
			$this->load->model('Stampbureau');
			$this->load->model('Estatemodel');
			$this->load->model('Control_Number_model');
			$this->load->model('Sms_model');
			$this->load->model('Posta_Cash_Model');
		}

public function realestate_post(){


   $tenantlist = $this->dashboard_model->get_tenant_informationss();

    foreach ($tenantlist as $key => $value) {
    	# code...

		$id = $value->tenant_id;
		

          $ipo = $this->dashboard_model->get_tenants_customer_details($id); 
			if(empty($ipo->tenant_id)  )
			{

				$paymentlist = $this->dashboard_model->get_tenants_payment_details($id);
		foreach ($paymentlist as $key => $pay) {
			# code...
				$Date= $pay->transactiondate;

			$year=date('Y', strtotime($Date)) + 1;
			$month=date('m', strtotime($Date));
			$day=date('d', strtotime($Date));
			$RenewDate = $year.'-'.$month.'-'.$day;

          
				$add = array();
             $add = array(

            'controlnumber'=>$pay->billid,
            'paidamount'=>$pay->paidamount,
            'tenantid'=>$pay->tenant_id,
            'tenant_mobile'=>$value->mobile_number,
            'transactionstatus'=>$pay->status,
            'receipt'=>$pay->receipt,
            //'RenewDate'=>$RenewDate,
             'realestate_type'=>$value->estate_type,
             'paymentdate'=>$pay->transactiondate

            );

          $this->dashboard_model->save_tenant_payment_details($add);

		}
		//$Outstanding= $this->Box_Application_model->get_box_outstanding_list_perperson($id);

        $regid = $value->region;
         $reg = $this->dashboard_model->getRegion_ById($regid); 

         $disid =$value->district; 
         $dis = $this->dashboard_model->getDistrict_ById($disid);

         $contract_end=date('Y-m-d',strtotime($value->end_date));

		$info = array();
		$info = array('tenant_id'=>$id,'region'=>$reg->region_name,'Branch'=>$dis->district_name,'tenant_name'=>$value->customer_name,
			'estate_name'=>$value->estate_name,'contractnumber'=>$value->contract_number,'contract_end'=>$contract_end,'status'=>$value->estate_status,'mobile'=>$value->mobile_number);

		$this->dashboard_model->save_tenant_customer_details($info);


			}
		

    }

  
     echo 'Successfully';
    
    //header('Content-Type: application/json');
    //echo json_encode($data);
    
  }

  public function realestate_tenants_update_payments(){
    

    $Realestatelist = $this->dashboard_model->get_realestate_tenants_payments_details_list();

    foreach ($Realestatelist as $key => $value) {
    	# code...

       $controlno = $value->controlnumber;
			$paystatus ='';
		 $sum = $this->dashboard_model->getsumPayments($controlno);
           $diff = $value->paidamount-$sum->sum_amount;
           if ($diff <=0) {
              $paystatus ='Paid';

               $update = array();
             $update = array(
           
            'transactionstatus'=>$paystatus,
            'receipt'=>$sum->receipt,
             'paymentdate'=>$sum->date_created

            );

          $this->dashboard_model->update_realestate_tenants_payments_details($update,$id);


               } else {
                 $paystatus ='NotPaid';
               }
                               
			
          
			





		//$id = $value->tenantid;

		//$paymentlist = $this->dashboard_model->get_tenants_updated_payment_details($id);


		// foreach ($paymentlist as $key => $pay) {
		// 	$controlno = $pay->billid;
		// 	$paystatus ='';
		//  $sum = $this->dashboard_model->getsumPayments($controlno);
  //          $diff = $pay->paidamount-$sum->sum_amount;
  //          if ($diff <=0) {
  //             $paystatus ='Paid';
  //              } else {
  //                $paystatus ='NotPaid';
  //              }
                               
			
          
		// 	 $update = array();
  //            $update = array(
           
  //           'transactionstatus'=>$paystatus,
  //           'receipt'=>$sum->receipt,
  //            'paymentdate'=>$sum->date_created

  //           );

  //         $this->dashboard_model->update_realestate_tenants_payments_details($update,$id);

		// }
	}
   echo 'Successfully';

}


		public function Propertylist()
		{
			if ($this->session->userdata('user_login_access') != false) {
                $data['region'] = $this->Posta_Cash_Model->regselect_by_restriction();
				$this->load->view('estate/Propertylist', $data);
			} else {
				redirect(base_url());
			}
		}

		public function delete_real_estate_property(){
		$id = base64_decode($this->input->get('I'));
		$this->Estatemodel->delete_real_estate_property($id);
		$this->session->set_flashdata('success','Property has been successfully Deleted');
        redirect($this->agent->referrer());
		}

		public function find_real_estate_property_list(){
        if ($this->session->userdata('user_login_access') != false) {

        	    $fromdate = $this->input->get('fromdate');
        	    $todate = $this->input->get('todate');
        	    $region = $this->input->get('region');
        	    $district = $this->input->get('district');
        	    $propertytype = $this->input->get('propertytype');
				
                $data['region'] = $this->Posta_Cash_Model->regselect_by_restriction();


				$data['list'] = $this->Estatemodel->find_real_estate_property_list($fromdate,$todate,$region,$district,$propertytype);
				if(!empty($data['list'])){
				$this->load->view('estate/Propertylist', $data);
			   } else {
               $this->session->set_flashdata('feedback','No Property Found, Please try again');
               redirect('Realestate/Propertylist');
			   }

			} else {
				redirect(base_url());
			}
		}

		public function clients_tenants_dashboard()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->load->view('estate/clients-tenants-dashboard');
			} else {
				redirect(base_url());
			}
		}
		public function Edit_Tenant_information()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->session->set_userdata('heading','Edit Tenant Information');

				$id = $this->input->get('id');
				$type = $this->input->get('type');
				$data['tenants']=$tenants = $this->Estatemodel->get_tenant_informations($id);
				//echo $tenants->region;
				$regid = $tenants->region;
				$reginal= $this->Estatemodel->getregionvalue($regid);
				$id =$tenants->district;
				$district= $this->Estatemodel->getdistrictvalue($id);
				$data['reginal'] =$reginal;
				$data['district'] =$district;
				$data['type'] =$type;
				$this->load->view('estate/edit-tenant-information',$data);
			} else {
				redirect(base_url());
			}
		}

			public function Tenant_informations()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->session->set_userdata('heading','Edit Tenant Information');

				$id = $this->input->get('id');
				$type = $this->input->get('type');
				$data['tenants']=$tenants = $this->Estatemodel->get_tenant_informations_details($id);

				$tin_number = $tenants->tin_number;
				$customer_name = $tenants->customer_name;

				//echo $tenants->region;
				$regid = $tenants->region;
				$reginal= $this->Estatemodel->getregionvalue($regid);
				$districtid =$tenants->district;
				$district= $this->Estatemodel->getdistrictvalue($districtid);
				$data['reginal'] =$reginal;
				$data['district'] =$district;
				$data['type'] =$type;
					$data['paymentlist'] = $this->Estatemodel->get_tenant_informations_payment($type,$regid,$id,$tin_number,$districtid,$customer_name);
				$this->load->view('estate/tenant_information',$data);
			} else {
				redirect(base_url());
			}
		}

		 public function checkCustomerexist(){
        if ($this->session->userdata('user_login_access') != false) {
            $custname = $this->input->post('custname');

            $checkdata = $this->Estatemodel->check_customer($custname);

            if(!empty($checkdata)) {
                $res['status'] = 'available';
                $res['message'] = 'Mteja huyu '.$checkdata['customer_name'].' Tayari yupo';
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


		public function Save_Tenant_edited_information()
		{
			if ($this->session->userdata('user_login_access') != false) {

				$type =$this->input->post('type'); 

				$Id = $this->input->post('estateid');
				$tenantid = $this->input->post('tenantid');

				$vrn = $this->input->post('vrn');
				$tin_number = $this->input->post('tin_number');

				$custname = $this->input->post('custname');
				$mobile = $this->input->post('mobile_number');
				$address = $this->input->post('address');

				$regid = $this->input->post('region');
				$disid = $this->input->post('district');
				$estate_name = $this->input->post('estate_name');


                $tenant = array();
				$tenant = array(
					'vrn' => $vrn,
					'tin_number' => $tin_number,
					'customer_name' => $custname,
					'mobile_number' => $mobile,
					'address' => $address
				);
				//echo json_encode($tenant) ;
				$this->Estatemodel->Update_tenantinf($tenant,$tenantid);

				$data = array();
				$data = array(
					'region' => $regid,
					'district' => $disid,
					'estate_name' => $estate_name
				);
				  //echo $id ;
				  //echo json_encode($data) ;
				$this->Estatemodel->Update_estateinf($data,$Id);

				$data['tenant'] = $this->dashboard_model->get_tenant_information($type);

				if($type=="Residential"){
					$this->load->view('estate/Residential-list',$data);
					 echo "Successfully Added" ;

				}
				elseif ($type == "Land") {
					# code...
					$this->load->view('estate/Land-list',$data);
					 echo "Successfully Added" ;
				}

				elseif ($type == "Offices") {
					# code...
					$this->load->view('estate/Office-list',$data);
					 echo "Successfully Added" ;
				}

				if(empty($type))
				{
					$this->load->view('estate/clients-tenants-dashboard');

				}
            
				
				

				
				
				
				// $data['tenant'] = $this->dashboard_model->get_tenant_informations($id);
				// $this->load->view('estate/edit-tenant-information');
			} else {
				redirect(base_url());
			}
		}

		public function Add_Tenant_information()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->load->view('estate/add-residential-information');
			} else {
				redirect(base_url());
			}
		}

		public function add_hall_information()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->load->view('estate/add-hall-information');
			} else {
				redirect(base_url());
			}
		}


		public function Add_Office_Information()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->load->view('estate/add-offices-information');
			} else {
				redirect(base_url());
			}
		}

		public function Add_Land_Information()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->load->view('estate/add-land-information');
			} else {
				redirect(base_url());
			}
		}

		public function Residential_list()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->session->set_userdata('heading','Residential List');

				$type = "Residential";
				$regid = trim($this->input->post('regid'));
				$disid = trim($this->input->post('disid'));
				$status = trim($this->input->post('status'));
				$estatus = trim($this->input->post('estatus'));
				$button = $this->input->post('search');

				$id = $this->session->userdata('user_login_id');
		        $info = $this->employee_model->GetBasic($id);
		        $o_region = $info->em_region;
		       

		        $getregionid= $this->dashboard_model->getregionid($o_region);
		        
		        if($this->session->userdata('user_type') != "ADMIN"){

		        	$regid = $getregionid->region_id;
		        	
		        }

				if($button == "search"){
					$data['tenant'] = $this->dashboard_model->get_tenant_information_search($type,$regid,$disid,$status,$estatus);
				}else{
					$data['tenant'] = $this->dashboard_model->get_tenant_informationsk($type,$regid);
				}

				$this->load->view('estate/Residential-list',$data);
			} else {
				redirect(base_url());
			}
		}


		public function Hall_list()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->session->set_userdata('heading','Conference List');

				$type = "Hall";
				$regid = trim($this->input->post('regid'));
				$disid = trim($this->input->post('disid'));
				$status = trim($this->input->post('status'));
				$estatus = trim($this->input->post('estatus'));
				$button = $this->input->post('search');

				$id = $this->session->userdata('user_login_id');
		        $info = $this->employee_model->GetBasic($id);
		        $o_region = $info->em_region;
		       

		        $getregionid= $this->dashboard_model->getregionid($o_region);
		        
		        if($this->session->userdata('user_type') != "ADMIN" && $this->session->userdata('user_type') != "SUPER ADMIN"){

		        	$regid = $getregionid->region_id;
		        	
		        }

				if($button == "search"){
					$data['tenant'] = $this->dashboard_model->get_tenant_information_search($type,$regid,$disid,$status,$estatus);
				}else{
					$data['tenant'] = $this->dashboard_model->get_tenant_informationsk($type,$regid);
				}

				$this->load->view('estate/Hall-list',$data);
			} else {
				redirect(base_url());
			}
		}

		public function Hall_Customer_list()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->session->set_userdata('heading','Hall List');

				$type = "Hall";
				$regid = trim($this->input->post('regid'));
				$disid = trim($this->input->post('disid'));
				$status = trim($this->input->post('status'));
				$estatus = trim($this->input->post('estatus'));
				$estate_name = $this->input->post('estate_name');
				$button = $this->input->post('search');

				// get_tenant_informations_by_estatename($type,$statename){

				$id = $this->session->userdata('user_login_id');
		        $info = $this->employee_model->GetBasic($id);
		        $o_region = $info->em_region;
		       

		        $getregionid= $this->dashboard_model->getregionid($o_region);
		        
		        if($this->session->userdata('user_type') != "ADMIN" && $this->session->userdata('user_type') != "SUPER ADMIN"){

		        	$regid = $getregionid;
		        	
		        }

		if($button == "search"){
			$data['tenant'] = $this->dashboard_model->get_tenant_information_search_tenantName($type,$regid,$disid,$status,$estatus,$estate_name);
		}else{
		// $data['tenant'] = $this->dashboard_model->get_tenant_informations_by_estatename($type,$estate_name);
			$data['tenant'] = $this->dashboard_model->get_estate_information();
			
		}



				$this->load->view('estate/Hall_Customer_list',$data);
			} else {
				redirect(base_url());
			}
		}


		public function Residential_Customer_list()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->session->set_userdata('heading','Residential List');

				$type = "Residential";
				$regid = trim($this->input->post('regid'));
				$disid = trim($this->input->post('disid'));
				$status = trim($this->input->post('status'));
				$estatus = trim($this->input->post('estatus'));
				$estate_name = $this->input->post('estate_name');
				$button = $this->input->post('search');

				// get_tenant_informations_by_estatename($type,$statename){

				$id = $this->session->userdata('user_login_id');
		        $info = $this->employee_model->GetBasic($id);
		        $o_region = $info->em_region;
		       

		        $getregionid= $this->dashboard_model->getregionid($o_region);
		        
		        if($this->session->userdata('user_type') != "ADMIN"){

		        	$regid = $getregionid;
		        	
		        }

		if($button == "search"){
			$data['tenant'] = $this->dashboard_model->get_tenant_information_search_tenantName($type,$regid,$disid,$status,$estatus,$estate_name);
		}else{
		// $data['tenant'] = $this->dashboard_model->get_tenant_informations_by_estatename($type,$estate_name);
			$data['tenant'] = $this->dashboard_model->get_estate_information();
			
		}



				$this->load->view('estate/Residential_Customer_list',$data);
			} else {
				redirect(base_url());
			}
		}

		public function Save_Tenant_Information()
		{
			if ($this->session->userdata('user_login_access') != false) {
				
				$custname = $this->input->post('custname');
				$mobile = $this->input->post('mobile_number');
				$address = $this->input->post('address');

				$vrn = $this->input->post('vrn');
				$tin_number = $this->input->post('tin_number');


				$regid = $this->input->post('region');
				$disid = $this->input->post('district');
				$estate_name = $this->input->post('estate_name');
				$status = $this->input->post('status');
				$floor = $this->input->post('floor');
				$room_number = $this->input->post('room_number');
				$square_meter = $this->input->post('square_meters');
				$estateType = $this->input->post('type');
				$type = $estateType;

				$contract_number = $this->input->post('contarct_number');
				$currency_type = $this->input->post('currency_type');
				$amount = $this->input->post('amount');
				$payment_cycle = $this->input->post('payment_cycle');
				$start_date = $this->input->post('start_date');
				$end_date= $this->input->post('end_date');
				$monthrange = $this->input->post('monthrange');

				$Totalamount = 0;

				// //check if name exist
				// if(empty($Totalamount)){

				// }else{

				if ($payment_cycle == "Monthly") {

                     $Totalamount = $amount;
					if (!empty($monthrange)) {
						$days = 30*$monthrange;
					} else {
						$days = 30;
					}
				} elseif($payment_cycle == "Quartery") {
					$Totalamount = $amount * 3;
					$days = 90;
				}elseif ($payment_cycle == "Semi Annual") {
						$Totalamount = $amount * 6;
					$days = 180;
				}elseif ($payment_cycle == "Custom" && $type == 'Hall') {
				// 	$date1 = new DateTime($start_date);
                //    $date2 = new DateTime($end_date);
                //    $interval = $date1->diff($date2);

				// 	$days = $interval->days + 1;
				// 	$Totalamount = $amount * $days;

					$Totalamount = $amount;

				}elseif ($payment_cycle == "Custom" && $type != 'Hall') {
						$date1 = new DateTime($start_date);
					   $date2 = new DateTime($end_date);
					   $interval = $date1->diff($date2);
	
						$days = $interval->days + 1;
						$Totalamount = $amount * $days;
	
					}else{
						$Totalamount = $amount * 12;
					$days = 360;
				}

				if ($payment_cycle != "Custom") {$end_date =  date('Y-m-d', strtotime($start_date. ' +'.$days.' days'));}
				
			

				$em_id = $this->session->userdata('user_login_id');

				$getr = $this->dashboard_model->getRegion_ById($regid);
				$getd = $this->dashboard_model->getDistrict_ById($disid);

				$region = $getr->region_name;
			    $district = $getd->district_name;

			   

				 $resident = array();
				 $resident = array(

					'vrn'=>$vrn,
				 	'tin_number'=>$tin_number,
				 	'customer_name'=>$custname,
				 	'mobile_number'=>$mobile,
				 	'address'=>$address,
				 	'operator'=>$em_id
				 	
				    ); 

				 $db2 = $this->load->database('otherdb', TRUE);
				 $db2->insert('estate_tenant_information',$resident);
				 $tenant_id = $db2->insert_id();

				 $estate = array();
				 $estate = array(
				 	'estate_name'=>$estate_name,
				 	'region'=>$regid,
				 	'district'=>$disid,
				 	'estate_status'=>$status,
				 	'floor'=>$floor,
				 	'room_number'=>$room_number,
				 	'estate_square_meter'=>$square_meter,
				 	'estate_type'=>$estateType
				   ); 

				 $db2->insert('estate_information',$estate);
				 $estate_id = $db2->insert_id();


				 $contract = array();
				 $contract = array(
				 	'estate_id'=>$estate_id,
				 	'tenant_id'=>$tenant_id,
				 	'contract_number'=>$contract_number,
				 	'currency_type'=>$currency_type,
				 	'amount'=>$amount,
				 	'payment_cycle'=>$payment_cycle,
				 	'start_date'=>$start_date,
				 	'end_date'=>$end_date
				 ); 

				 $db2->insert('estate_contract_information',$contract);

				 if($type=='Residential')
				 {
				 	 $serial    = 'resreal-estate'.date("YmdHis").$this->session->userdata('user_emid');

				 }elseif($type=='Hall'){
				 	$serial    = 'Hallreal-estate'.date("YmdHis").$this->session->userdata('user_emid');

				 }
				 else
				 {
				 	    $serial    = 'real-estate'.date("YmdHis").$this->session->userdata('user_emid');

				 }

				
			 


			     if($type == 'Land'){

                 	 $Vat = $Totalamount * 0.18;
			     $withholding = $Totalamount * 0.1;
			     $exclusive= $Totalamount - $withholding;
			     $Totalamount =$exclusive + $Vat;

                 }
                 if($type == 'Offices'){

                 	 $Vat = $Totalamount * 0.18;
			     $withholding = $Totalamount * 0.1;
			     $exclusive= $Totalamount - $withholding;
			     $Totalamount =$exclusive + $Vat;

                 }

                 if($type == 'Residential'){

			     $withholding = $Totalamount * 0.1;
			     $exclusive= $Totalamount - $withholding;
			     $Totalamount =$Totalamount ;
			     $custname =$custname.'-ZERORATE';

                 }

                    if($type == 'Hall'){

			     $withholding = 0;
			     $exclusive= $Totalamount;
			     $Totalamount =$Totalamount ;
			     $custname =$custname.'-ZERORATE';

                 }



			 	 $data = array();
                  $data = array(

                  'serial'=>$serial,
                  'paidamount'=>$Totalamount,
                  'tenant_id'=>$tenant_id,
                  'transactionstatus'=>'POSTED',
                  'bill_status'=>'PENDING'

	              );

	              $db2->insert('real_estate_transactions',$data);

	              $paidamount = $Totalamount;
	              $renter   = $custname;
	              $serviceId = 'RENTAL';
	              $trackno = 00;

	              $transaction = $this->Control_Number_model->get_control_number_partial_payment($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

	              if(!empty($transaction->billid)){

	              
	              @$serial1 = $transaction->billid;
                  $update = array('billid'=>@$transaction->controlno,'bill_status'=>'SUCCESS');
                  $this->dashboard_model->update_transactions_real_estate($update,$serial1);

                  	$message['sms'] = $sms='<h3>Successfull Saved'. '         '.'Umepatiwa ankara namba hii hapa'.'      '.@$transaction->controlno.'</h3>';
                  	$sms=''.'Umepatiwa ankara ya malipo '.'  '.$transaction->controlno.' kwa ajili ya huduma ya miliki za shirika';
                  	$this->Sms_model->send_sms_trick($mobile,$sms);

                  if ($estateType == "Residential") {
                       $this->load->view('estate/add-residential-information',$message);    
                   }elseif($estateType == "Land"){
                   	$this->load->view('estate/add-land-information',$message);
                   }elseif($estateType == "Hall"){
                   	$this->load->view('estate/add-hall-information',$message);
                   }else {
                  		$this->load->view('estate/add-offices-information',$message);
                  }
               }else{

               	$message['sms'] = '<h3>Failed '. 'ankara namba haijapatikana </h3>';
                  
                  
                  if ($estateType == "Residential") {
                       $this->load->view('estate/add-residential-information',$message);    
                   }elseif($estateType == "Land"){
                   	$this->load->view('estate/add-land-information',$message);
                   }elseif($estateType == "Hall"){
                   	$this->load->view('estate/add-hall-information',$message);
                   }else {
                  		$this->load->view('estate/add-offices-information',$message);
                  }



               }

            //}

				} else {
					redirect(base_url());
				}
		}



		public function Update_contract_info()
		{
			//echo 'IMEFIKA';
			if ($this->session->userdata('user_login_access') != false) {
				
				$custname = $this->input->post('custname');
				$type = $this->input->post('type');

				$contract_number = $this->input->post('contarct_number');
				$currency_type = $this->input->post('currency_type');
				$amount = $this->input->post('amount');
				$payment_cycle = $this->input->post('payment_cycle');
				$start_date = $this->input->post('start_date');
				$monthrange = $this->input->post('monthrange');



				 $tenant_id = $this->input->post('tenant_id');
                 $mobile = $this->input->post('mobile');
				 $estate_id = $this->input->post('estate_id');
				 $regid = $this->input->post('region');
				 $disid = $this->input->post('district');


				$Totalamount = 0;

				if ($payment_cycle == "Monthly") {

                     $Totalamount = $amount;
					if (!empty($monthrange)) {
						$days = 30*$monthrange;
					} else {
						$days = 30;
					}
				} elseif($payment_cycle == "Quartery") {
					$Totalamount = $amount * 3;
					$days = 90;
				}elseif ($payment_cycle == "Semi Annual") {
						$Totalamount = $amount * 6;
					$days = 180;
				}else{
						$Totalamount = $amount * 12;
					$days = 360;
				}



				
				$end_date =  date('Y-m-d', strtotime($start_date. ' +'.$days.' days'));

				$em_id = $this->session->userdata('user_login_id');

				$getr = $this->dashboard_model->getRegion_ById($regid);
				$getd = $this->dashboard_model->getDistrict_ById($disid);

				$region = $getr->region_name;
			    $district = $getd->district_name;

				

				 $db2 = $this->load->database('otherdb', TRUE);
				 
				
				 $contract = array();
				 $contract = array(
				 	'estate_id'=>$estate_id,
				 	'tenant_id'=>$tenant_id,
				 	'contract_number'=>$contract_number,
				 	'currency_type'=>$currency_type,
				 	'amount'=>$amount,
				 	'payment_cycle'=>$payment_cycle,
				 	'start_date'=>$start_date,
				 	'end_date'=>$end_date
				 ); 

				 $db2->insert('estate_contract_information',$contract);

				
				if($type='Residential')
				 {
				 	 $serial    = 'resreal-estate'.date("YmdHis").$this->session->userdata('user_emid');

				 }
				 else
				 {
				 	    $serial    = 'real-estate'.date("YmdHis").$this->session->userdata('user_emid');

				 }



                 if($type == 'Land'){

                 	 $Vat = $Totalamount * 0.18;
			     $withholding = $Totalamount * 0.1;
			     $exclusive= $Totalamount - $withholding;
			     $Totalamount =$exclusive + $Vat;

                 }
                 if($type == 'Offices'){

                 	 $Vat = $Totalamount * 0.18;
			     $withholding = $Totalamount * 0.1;
			     $exclusive= $Totalamount - $withholding;
			     $Totalamount =$exclusive + $Vat;

                 }
                  if($type == 'Residential'){

			     $withholding = $Totalamount * 0.1;
			     $exclusive= $Totalamount - $withholding;
			     $Totalamount =$Totalamount;
			     $custname =$custname.'-ZERORATE';

                 }

                 // echo json_encode($custname.'  hilo ndilo jina');

			     

			 	 $data = array();
                  $data = array(

                  'serial'=>$serial,
                  'paidamount'=>$Totalamount,
                  'tenant_id'=>$tenant_id,
                  'transactionstatus'=>'POSTED',
                  'bill_status'=>'PENDING'

	              );

	              $db2->insert('real_estate_transactions',$data);

	              $paidamount = $Totalamount;
	              $renter   =$custname;
	              $serviceId = 'RENTAL';
	              $trackno = 00;

	              $transaction = $this->Control_Number_model->get_control_number_partial_payment($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

	              @$serial1 = $transaction->billid;
                  $update = array('billid'=>@$transaction->controlno,'bill_status'=>'SUCCESS');
                  $this->dashboard_model->update_transactions_real_estate($update,$serial1);

                  	$message['sms'] = '<h3>Successfull Saved'. '         '.'Umepatiwa ankara namba hii hapa'.'      '.$transaction->controlno.'</h3>';

                  	$sms=''.'Umepatiwa ankara ya malipo '.'  '.@$transaction->controlno.' kwa ajili ya huduma ya miliki za shirika';
                  	$this->Sms_model->send_sms_trick($mobile,$sms);

                  if ($type == "Residential") {
                       $this->load->view('estate/add-residential-information',$message);    
                   }elseif($type == "Land"){
                   	$this->load->view('estate/add-land-information',$message);
                   }else {
                  		$this->load->view('estate/add-offices-information',$message);
                  }

				} else {
					redirect(base_url());
				}
		}


		
		public function billrepost()
		{
			if ($this->session->userdata('user_login_access') != false) {

				 //resreal-estate
				$serial = $this->input->post('serial');
				$tenant_id = $this->input->post('tenant_id');
				// echo  json_encode($serial.' serial id');

				// $gettransaction = $this->dashboard_model->get_payment_details($serial);
				$getTenantinfo = $this->dashboard_model->get_cust_detail_serial($tenant_id,$serial);

				// echo  json_encode($getTenantinfo);

				$customer_name = $getTenantinfo->customer_name;
				$word1 = 'resreal';

                if(strpos($getTenantinfo->serial, $word1) !== false ){
					$customer_name = $getTenantinfo->customer_name.'-ZERORATE';
				 }

				// echo  json_encode($customer_name.' name id');

				$paidamount = $getTenantinfo->paidamount;
	              $renter   =$customer_name;
	              $serviceId = 'RENTAL';
	              $trackno = 00;
	              $mobile = $getTenantinfo->mobile_number;
	              $district = $getTenantinfo->district;
	              $region = $getTenantinfo->region;
	              $serial =$getTenantinfo->serial;

	              $getr = $this->dashboard_model->getRegion_ById($region);
				  $getd = $this->dashboard_model->getDistrict_ById($district);

				$region = $getr->region_name;
			    $district = $getd->district_name;

			    $type = $getTenantinfo->estate_type;


	              $transaction = $this->Control_Number_model->get_control_number_partial_payment($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

	              // echo  json_encode($transaction);

	              @$serial1 = @$transaction->billid;
                  $update = array('billid'=>@$transaction->controlno,'bill_status'=>'SUCCESS');
                  $this->dashboard_model->update_transactions_real_estate($update,$serial1);

                  	$message['sms'] = '<h3>Successfull Reposted '.$serial. ' '.'Umepatiwa ankara namba hii hapa'.'      '.@$transaction->controlno.'</h3>';

                  	$sms=''.'Umepatiwa ankara ya malipo '.'  '.@$transaction->controlno.' kwa ajili ya huduma ya miliki za shirika';
                  	$this->Sms_model->send_sms_trick($mobile,$sms);

                  	if ($type == "Residential") {
                       $this->load->view('estate/add-residential-information',$message);    
                   }elseif($type == "Land"){
                   	$this->load->view('estate/add-land-information',$message);
                   }else {
                  		$this->load->view('estate/add-offices-information',$message);
                  }

				
			} else {
				redirect(base_url());
			}
		}




		public function Land_list()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->session->set_userdata('heading','Land List');
				$type = "Land";
				$regid = trim($this->input->post('regid'));
				$disid = trim($this->input->post('disid'));
				$status = trim($this->input->post('status'));
				$estatus = trim($this->input->post('estatus'));
				$button = $this->input->post('search');


				$id = $this->session->userdata('user_login_id');
		        $info = $this->employee_model->GetBasic($id);
		        $o_region = $info->em_region;
		       

		        $getregionid= $this->dashboard_model->getregionid($o_region);
		        
		        if($this->session->userdata('user_type') != "ADMIN"){

		        	$regid = $getregionid->region_id;
		        	
		        }


				if($button == "search"){
					$data['tenant'] = $this->dashboard_model->get_tenant_information_search($type,$regid,$disid,$status,$estatus);
				}else{
					$data['tenant'] = $this->dashboard_model->get_tenant_informationsk($type,$regid);
				}

				$this->load->view('estate/Land-list',$data);
			} else {
				redirect(base_url());
			}
		}
		public function getPaymentTrend()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->session->set_userdata('heading','Payment Trend List');

				$controlno = $this->input->get('controlno');
				$data['tenant'] = $this->dashboard_model->get_payment_information($controlno);
				$this->load->view('estate/Payment-list',$data);

			} else {
				redirect(base_url());
			}
		}

		public function getPaymentTrends()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->session->set_userdata('heading','Payment Trend List');

				$tenantid = $this->input->get('controlno');




				$listcontrol= $this->dashboard_model->get_tenant_payment_information($tenantid);
				foreach ($listcontrol as $key => $value) {
					# code...
                  $data['tenant'] = $this->dashboard_model->get_payment_information($value->billid);

				}

				
				$this->load->view('estate/Payment-lists',$data);

			} else {
				redirect(base_url());
			}
		}
		public function Office_list()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->session->set_userdata('heading','Office List');

				$type = "Offices";
				$regid = trim($this->input->post('regid'));
				$disid = trim($this->input->post('disid'));
				$status = trim($this->input->post('status'));
				$estatus = trim($this->input->post('estatus'));
				$button = $this->input->post('search');

				$id = $this->session->userdata('user_login_id');
		        $info = $this->employee_model->GetBasic($id);
		        $o_region = $info->em_region;
		       

		        $getregionid= $this->dashboard_model->getregionid($o_region);
		        
		        if($this->session->userdata('user_type') != "ADMIN"){

		        	$regid = $getregionid->region_id;
		        	
		        }


				if($button == "search"){
					$data['tenant'] = $this->dashboard_model->get_tenant_information_search($type,$regid,$disid,$status,$estatus);
				}else{
					$data['tenant'] = $this->dashboard_model->get_tenant_informationsk($type,$regid);
				}

				$this->load->view('estate/Office-list',$data);
			} else {
				redirect(base_url());
			}
		}
		public function Propertyprofile($id)
		{
			if ($this->session->userdata('user_login_access') != false) {
				$data['region'] = $this->employee_model->regselect();
				//$id = "0";propertyimages

				$data['propertyimages'] = $this->Estatemodel->propertyimages($id);
				$data['property'] = $this->Estatemodel->propertyprofile($id);
				$this->load->view('estate/Propertyprofile', $data);
			} else {
				redirect(base_url());
			}
		}


		public function editproperty($id)
		{
			if ($this->session->userdata('user_login_access') != false) {
				//$data['philatel'] = $this->Stampbureau->philatelist();
				$data['region'] = $this->employee_model->regselect();
				//$data['category'] = $this->billing_model->getAllCategory();
				//$data['listItem'] = $this->billing_model->getAllCategoryBill();

				$data['propertyimages'] = $this->Estatemodel->propertyimages($id);
				$data['property'] = $this->Estatemodel->propertyprofile($id);
				$this->load->view('estate/editproperty', $data);
			} else {
				redirect(base_url());
			}
		}
		public function AddProperty()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$data['region'] = $this->employee_model->regselect();
				$this->load->view('estate/addproperty', $data);
			} else {
				redirect(base_url());
			}
		}


		public function UploadAttachment()
		{
			if ($this->session->userdata('user_login_access') != false) {
				if (!empty($_FILES)) {

					$upload_dir = "./images/";   ////"../record-documents/";
					$fileName = $_FILES['file']['name'];
					$property_id = 0;
					$date = date("Y-m-d H:i:s");

					$uploaded_file = $upload_dir . $fileName;

					if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaded_file)) {

						//insert file information into db table
						//$mysql_insert = "INSERT INTO propertyuploads (file_name, upload_time,property_id)VALUES('".$fileName."','".date("Y-m-d H:i:s")."','".$property_id."')";
						//mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
						$data = array();
						$data = array(
							'file_name' => $fileName,
							'upload_time' => $date,

							'property_id' => $property_id,


						);

						$success = $this->Estatemodel->Addattachment($data);
					}
				}
				//$this->load->view('billing/Stock',$data);
				//$this->load->view('Estate/Propertylist',$data);
			} else {
				redirect(base_url());
			}
		}

		public function Requisition_Form() //unissued requisition
		{
			// $info = $this->Stampbureau->requestlist1($serialno);
			// $id = $info->RequestedBy;
			if ($this->session->userdata('user_login_access') != false) {
				$empid = $this->session->userdata('user_login_id');

				$basicinfo = $this->employee_model->GetBasic($empid);
				$em_sub_role = $basicinfo->em_sub_role;
				$em_region = $basicinfo->em_region;
				$em_branch = $basicinfo->em_branch;
				if ($em_sub_role == "BRANCH") {
					//aone request zote za branch yake kutoka kwa counter
					$data1 = "0";
					$takefromrole = "COUNTER";
					$data['stock'] = $this->Stampbureau->requisationbranch($data1, $em_branch, $takefromrole);
					$this->load->view('Stock/RequisitionForm', $data);
				} elseif ($em_sub_role == "STRONGROOM") {
					//aone request zote za mkoa wake kutoka kwa branch
					$data1 = "0";
					$takefromrole = "BRANCH";
					$data['stock'] = $this->Stampbureau->requisationstrong($data1, $em_region, $takefromrole);
					$this->load->view('Stock/RequisitionForm', $data);
				} elseif ($em_sub_role == "STORE") {
					//aone request zote za mikoa yote kutoka kwa strongroom
					$data1 = "0";
					$takefromrole = "STRONGROOM";
					$data['stock'] = $this->Stampbureau->requisationlistStore($data1, $takefromrole);
					$this->load->view('Stock/RequisitionForm', $data);
				}

				//redirect(base_url());
			} else {
				redirect(base_url());
			}
		}






		public function Saveproperty()
		{
			if ($this->session->userdata('user_login_access') != False) {

				//$DateofRegs = $this->input->post('DateofReg');
				//$dayissue = date('d', strtotime($DateofRegs));
				//$monthissue = date('m', strtotime($DateofRegs));
				//$yearissue = date('Y', strtotime($DateofRegs));
				//$DateofReg = ($yearissue) . '-' . $monthissue . '-' . $dayissue;

				$property_name = $this->input->post('property_name');
				$RegistrationNo = $this->input->post('RegistrationNo');
				$Status = $this->input->post('Status');
				$Plot = $this->input->post('Plot');
				$block = $this->input->post('block');
				$Region = $this->input->post('Region');
				$District = $this->input->post('district');
				$addresss = $this->input->post('address');
				$city = $Region;
				$postal_code = $this->input->post('postal_code');
				$property_size = $this->input->post('property_size');
				$price_per_sqm = $this->input->post('price_per_sqm');
				$PropertyValue = $this->input->post('PropertyValue');
				$Totalprice = $this->input->post('Totalprice');
				$size_unit = $this->input->post('size_unit');
				$monthly_paymentRent = $this->input->post('monthly_paymentRent');
				$property_type = $this->input->post('propertytype');
				$caretaker = " ";
				$payment_mode = " ";
				$additional_info = $this->input->post('additional_info');

				$property_condition = $this->input->post('property_condition');
				$isdevided = 0;
				$PropertyUsage = $this->input->post('propertytype');
				$LandValue = $this->input->post('LandValue');

				$address = 'Plot No ' . $Plot . ' Block ' . $block . ' ' . $addresss;

				$createdby = $this->session->userdata('user_login_id');


            if($_FILES['cover']['name']){
            $coverid = rand();
            $emrand1 = substr($coverid,0,3).rand(1000,2000); 
            $emrand = str_replace("'", '', $emrand1);
            $file_name = $_FILES['cover']['name'];
            $fileSize = $_FILES["cover"]["size"]/1024;
            $fileType = $_FILES["cover"]["type"];
            $new_file_name='';
            $new_file_name .= $emrand;

            $config = array(
                'upload_path' => "./assets/images",
                'allowed_types' => "gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG|docx|doc|pdf",
                'overwrite' => False,
                'max_size' => 0,
                'remove_spaces'=> TRUE,
                'encrypt_name'=> TRUE
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('cover')) {
                  $errorreceipt =  $this->upload->display_errors();
                   $this->session->set_flashdata('feedback',"Failed to submit payment, Please try again!".' '.$errorreceipt.' ');
                   redirect('Realestate/AddProperty');
            } else {
            $path = $this->upload->data();
            $image_path = $path['file_name'];
            }
            }


				$data = array();
				$data = array(
					'property_name' => $property_name,
					'RegistrationNo' => $RegistrationNo,
					'Status' => $Status,
					'Plot' => $Plot,
					'block' => $block,
					'Region' => $Region,
					'District' => $District,
					'address' => $address,
					'city' => $city,
					'postal_code' => $postal_code,
					'property_size' => $property_size,
					'price_per_sqm' => $price_per_sqm,
					'PropertyValue' => $PropertyValue,
					'Totalprice' => $Totalprice,
					'size_unit' => $size_unit,
					'monthly_paymentRent' => $monthly_paymentRent,
					'property_type' => $property_type,
					'createdby' => $createdby,
					'caretaker' => $caretaker,
					'additional_info' => $additional_info,
					'image_path' => @$image_path,
					'isdevided' => $isdevided,
					'payment_mode' => $payment_mode,
					'PropertyUsage' => $PropertyUsage,
					'LandValue' => $LandValue

				);
				$this->Estatemodel->Addproperty($data); 

				$this->session->set_flashdata('success','Property has been successfully Saved');
                redirect($this->agent->referrer());               



			} else {
				redirect(base_url(), 'refresh');
			}
		}

		public function SaveEditproperty()
		{
			echo "IMEPA4343RF";
			if ($this->session->userdata('user_login_access') != False) {
				echo "IMEPA4343RF";
				$DateofRegs = $this->input->post('DateofReg');
				$dayissue = date('d', strtotime($DateofRegs));
				$monthissue = date('m', strtotime($DateofRegs));
				$yearissue = date('Y', strtotime($DateofRegs));
				$DateofReg = ($yearissue) . '-' . $monthissue . '-' . $dayissue;

				$property_name = $this->input->post('property_name');
				$RegistrationNo = $this->input->post('RegistrationNo');
				$Status = $this->input->post('Status');
				$Plot = $this->input->post('Plot');
				$block = $this->input->post('block');
				//$lot = $this->input->post('lot');
				$Region = $this->input->post('Region');
				$District = $this->input->post('District');
				$addresss = $this->input->post('address');
				$city = $Region;
				$postal_code = $this->input->post('postal_code');
				$property_size = $this->input->post('property_size');
				$price_per_sqm = $this->input->post('price_per_sqm');
				$PropertyValue = $this->input->post('PropertyValue');
				$Totalprice = $this->input->post('Totalprice');
				$size_unit = $this->input->post('size_unit');
				$monthly_paymentRent = $this->input->post('monthly_paymentRent');
				$property_type = $this->input->post('property_type');
				$caretaker = " ";
				$payment_mode = " ";
				$additional_info = $this->input->post('additional_info');

				$property_condition = $this->input->post('property_condition');
				$image_path = "";
				$isdevided = 0;
				$PropertyUsage = $this->input->post('PropertyUsage');
				$LandValue = $this->input->post('LandValue');

				$address = 'Plot No ' . $Plot . ' Block ' . $block . ' ' . $addresss;

				echo "IMEPA4343RF";

				$upload_dir = "./images/";
				if (!empty($_FILES)) {

					if (getimagesize($_FILES['image']['tmp_name']) == FALSE) {
						$image_path = "no-image.png";
					} else {

						$myFile = $_FILES["image"];

						if ($myFile["error"] !== UPLOAD_ERR_OK) {
							echo "<p>An error occurred.</p>";
							exit;
						}

						// ensure a safe filename
						//$name = pFreg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);
						$name = $myFile["name"];

						// don't overwrite an existing file
						$i = 0;
						$parts = pathinfo($name);
						while (file_exists($upload_dir . $name)) {
							$i++;
							$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
						}


						// preserve file from temporary directory
						$success = move_uploaded_file(
							$myFile["tmp_name"],
							$upload_dir . $name
						);
						if (!$success) {
							echo "<p>Unable to save file.</p>";
							//   exit;
						}

						// set proper permissions on the new file
						chmod($upload_dir . $name, 0644);
						$image_path = $name;
					}
				} else {

					$image_path = "no-image.png";
				}


				$this->load->library('form_validation');
				// $this->form_validation->set_error_delimiters();



				$id = $this->session->userdata('user_login_id');
				$basicinfo = $this->employee_model->GetBasic($id);
				$em_id = $basicinfo->em_id;
				$date = date('Y-m-d');
				$Id= $this->input->post('id');
				$date = $date;
				$createdby = $em_id;
				echo "IMEPA";
				if($Id != "")
				{
					echo "IMEPITAAAAAAAAA";
					$data = array();
					$data = array(
						'property_name' => $property_name,
						'RegistrationNo' => $RegistrationNo,
						'DateofReg' => $DateofReg,
						'date' => $date,
						'Status' => $Status,
						'Plot' => $Plot,
						'block' => $block,
						//'lot' => $lot,
						'Region' => $Region,
						'District' => $District,
						'address' => $address,
						'city' => $city,
						'postal_code' => $postal_code,
						'property_size' => $property_size,
						'price_per_sqm' => $price_per_sqm,
						'PropertyValue' => $PropertyValue,
						'Totalprice' => $Totalprice,
						'size_unit' => $size_unit,
						'monthly_paymentRent' => $monthly_paymentRent,
						'property_type' => $property_type,
						'createdby' => $createdby,
						'caretaker' => $caretaker,
						'additional_info' => $additional_info,
						'image_path' => $image_path,
						'isdevided' => $isdevided,
						'payment_mode' => $payment_mode,
						'PropertyUsage' => $PropertyUsage,
						'LandValue' => $LandValue
	
					);
					//echo $data;Update_property($data,$Id)
					$success = $this->Estatemodel->Update_property($data,$Id);
					#$this->confirm_mail_send($email,$pass_hash);        
					echo "Successfully Added" . $success;
					#redirect('employee/Add_employee');   
					//$this->session->set_flashdata('feedback','Successfully Created');
				}

				
			} else {
				redirect(base_url(), 'refresh');
			}

			//redirect(base_url(), 'refresh');
		}




		public function Savestrongroomrequest()
		{
			if ($this->session->userdata('user_login_access') != False) {


				for ($i = 0; $i < count($this->input->post('QuantityReq')); $i++) {

					$formno = $this->input->post('formno');
					$serialno = $this->input->post('serialno');
					$issuedby = $this->input->post('issuedby');
					//$stampname = $this->input->post('stampname');
					$RequestedBy = $this->input->post('RequestedBy');
					$QuantityReq = $this->input->post('QuantityReq[' . $i . ']');
					$StockId = $this->input->post('StockId[' . $i . ']');

					//$Totalamount = $price * $QuantityReq;

					$date = date('Y-m-d H:i:s');

					$RequestedDate = $date;


					$this->load->library('form_validation');
					// $this->form_validation->set_error_delimiters();

					{
						$data = array();
						$data = array(
							'serialno' => $serialno,
							'RequestedBy' => $RequestedBy,
							'QuantityReq' => $QuantityReq,
							'StockId' => $StockId,
							'formno' => $formno,
							'RequestedDate' => $RequestedDate,
							'issuedby' => $issuedby,

						);

						$success = $this->Stampbureau->Addstockrequest($data);
					}
				}



				#$this->confirm_mail_send($email,$pass_hash);        
				echo "Successfully Added" . $success;
				#redirect('employee/Add_employee');   
				//$this->session->set_flashdata('feedback','Successfully Created');


			} else {
				redirect(base_url(), 'refresh');
			}
		}


	public function getDistrict(){

      if ($this->input->post('region_id') != '') {
          echo $this->dashboard_model->GetDistrictById($this->input->post('region_id'));
      }
  }

  	public function RealEsategetDistrict(){
  	$region = $this->input->post('region_id');
  	$info = $this->dashboard_model->get_region_info($region);
    echo $this->dashboard_model->RealEsateGetDistrictById($info->region_id);
  }

  public function getDistricts(){

      if ($this->input->post('district') != '') {
      	$districtid=$this->input->post('district');
      	$BranchName=$this->dashboard_model->getDistrict_ById($districtid);
        echo $BranchName->district_name;

      }
  }

   public function getregions(){

      if ($this->input->post('region_id') != '') {
      	$region_id=$this->input->post('region_id');
      	$RegionName=$this->dashboard_model->getRegion_ById($region_id);
        echo $RegionName->region_name;

      }
  }

  public function getHall(){

      if ($this->input->post('district') != '') {
      	$districtid=$this->input->post('district');
      	$BranchName=$this->dashboard_model->getDistrict_ById($districtid);

      	
      	 if($BranchName->district_name=='Morogoro Mjini'){
      	 	 // $output ='<option value="">--Select Hall--</option>';
      	 	$output ='<option value="Conference 01">Conference 01</option>';
      	 	$output .='<option value="Conference 02">Conference 02</option>';

      	 }else{ $output ='<option value="">--Select Hall--</option>'; }
           
             echo $output;

      }
  }

  public function getHallPrice(){

      if ($this->input->post('district') != '') {
      	$hallname=$this->input->post('hallname');
      	$facility=$this->input->post('facility');
		  $projectordays=$this->input->post('projectordays');
      	$currency=$this->input->post('currency');
      	$districtid=$this->input->post('district');
      	$BranchName=$this->dashboard_model->getDistrict_ById($districtid);

		  $start_date=$this->input->post('start_date');
      	$end_date=$this->input->post('end_date');
		  $date1 = new DateTime(@$start_date);
         $date2 = new DateTime(@$end_date);
                   $interval = $date1->diff($date2);
					$days = @$interval->days + 1;

      	
      	 if($BranchName->district_name=='Morogoro Mjini'){
      	 
      	 if($currency=='TSH'){
      	 	if($hallname=='Conference 01' && $facility=='Nill'){
      	 		$output =200000 * @$days;//200000

      	 	}elseif($hallname=='Conference 01' && $facility=='Projector'){
                 $projPrice=50000*$projectordays;
      	 		$output =(200000* @$days) + $projPrice;//250000

      	 	}elseif($hallname=='Conference 02' && $facility=='Nill'){
      	 		$output =100000 * @$days;//100000
      	 		
      	 	}elseif($hallname=='Conference 02' && $facility=='Projector'){
				$projPrice=50000*$projectordays;
				$output =(100000 * @$days) + $projPrice;
      	 		
      	 	}else{
				$projPrice=50000*$projectordays;
				$output =(100000* @$days) + $projPrice;

      	 	}



      	 }else{
      	 	if($hallname=='Conference 01' && $facility=='Nill'){
      	 		$output =200 * @$days;

      	 	}elseif($hallname=='Conference 01' && $facility=='Projector'){
				$projPrice=25*$projectordays;
				$output =(200* @$days) + $projPrice;
      	 		//$output ='225';

      	 	}elseif($hallname=='Conference 02' && $facility=='Nill'){
      	 		$output =100 * @$days;
      	 		
      	 	}elseif($hallname=='Conference 02' && $facility=='Projector'){
				$projPrice=25*$projectordays;
				$output =(100* @$days) + $projPrice;
      	 		//$output ='125';
      	 		
      	 	}else{
				$projPrice=25*$projectordays;
				$output =(200* @$days) + $projPrice;

      	 	}

      	 }

      	 }else{

      	 	if($currency=='TSH'){
      	 		$output =250000 * @$days;
      	 	}else{
      	 		$output =225 * @$days;


      	 	}
      	  }
           
             echo $output;

      }
  }

  public function getEstate(){

      if ($this->input->post('district') != '') {
          echo $this->dashboard_model->GetEstateByDistrict($this->input->post('district'));
      }
  }

  public function printInvoice(){

$acc_no = base64_decode($this->input->get('acc_no'));
//$month = $this->input->get('month');
$data['cno'] = $controlno = $this->input->get('billid');
$cuno = $this->input->get('cuno');
$data['custinfo'] = $this->dashboard_model->get_cust_details($cuno);
$data['invoice'] = $controlno;
$id = $this->session->userdata('user_login_id');
$info = $this->employee_model->GetBasic($id);
$data['preparedby']= 'PF'.' '.$info->em_code.' '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;

     $contract  = $this->dashboard_model->getamount($cuno);
     $payment_cycle=$contract->payment_cycle;
     $amount = $contract->amount;
     $Totalamount = 0;
     if ($payment_cycle == "Monthly") {

	         $Totalamount = $amount;
			
		} elseif($payment_cycle == "Quartery") {
			$Totalamount = $amount * 3;
			
		}elseif ($payment_cycle == "Semi Annual") {
				$Totalamount = $amount * 6;
			
		}else{
				$Totalamount = $amount * 12;
			
		}

		         $withholding = $Totalamount * 0.1;
			     $exclusive= $Totalamount - $withholding;

                 $taxex = $exclusive;
// $data['emslist'] = $this->Box_Application_model->get_credit_customer_list_byAccnoMonth2($acc_no,$month);
// $data['sum'] = $this->Box_Application_model->get_credit_customer_sum_byAccnoMonth2($acc_no,$month);
 
$sign = array('controlno'=>$controlno,'idtype'=>'1','custid'=>@$data['custinfo']->tin_number,'custname'=>@$data['custinfo']->customer_name,'msisdn'=>@$data['custinfo']->mobile_number,'service'=>'EFD','taxex'=>$taxex);
	    $url = "http://192.168.33.2/api/vfd/getSig.php";
		$ch = curl_init($url);
		$json = json_encode($sign);
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
		$data['signature'] = $signature = json_decode($response);


		$this->load->library('ciqrcode');

			$config['cacheable']    = true; //boolean, the default is true
			$config['cachedir']     = './assets/'; //string, the default is application/cache/
			$config['errorlog']     = './assets/'; //string, the default is application/logs/
			$config['imagedir']     = './assets/images/'; //direktori penyimpanan qr code
			$config['quality']      = true; //boolean, the default is true
			$config['size']         = '1024'; //interger, the default is 1024
			$config['black']        = array(224,255,255); // array, default is array(255,255,255)
			$config['white']        = array(70,130,180); // array, default is array(0,0,0)
			$this->ciqrcode->initialize($config);

			$image_name = $data['qrcodename'] = $controlno .'.png'; 
			
			$params['data'] = 'https://verify.tra.go.tz/'.$signature->desc; 
			$params['level'] = 'H'; 
			$params['size'] = 10;
			$params['savename'] = FCPATH.$config['imagedir'].$image_name; 
			$this->ciqrcode->generate($params);

			//$this->load->view('billing/invoice_sheet',$data);

               $this->load->library('Pdf');
               $html= $this->load->view('estate/invoice_sheet',$data,TRUE);
              $this->load->library('Pdf');
                $this->dompdf->loadHtml($html);
                $this->dompdf->setPaper('A4','potrait');
                $this->dompdf->render();
                $this->dompdf->stream($controlno, array("Attachment"=>0));

 }

  public function printResidentialInvoice(){

$acc_no = base64_decode($this->input->get('acc_no'));
//$month = $this->input->get('month');
$data['cno'] = $controlno = $this->input->get('billid');
$cuno = $this->input->get('cuno');
$data['custinfo'] = $this->dashboard_model->get_cust_details($cuno);
$data['invoice'] = $controlno;
$id = $this->session->userdata('user_login_id');
$info = $this->employee_model->GetBasic($id);
$data['preparedby']= 'PF'.' '.$info->em_code.' '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;

     $contract  = $this->dashboard_model->getamount($cuno);
     $payment_cycle=$contract->payment_cycle;
     $amount = $contract->amount;

      $start_date = $contract->start_date;
       $end_date = $contract->end_date;
     $Totalamount = 0;
     if ($payment_cycle == "Monthly") {

	         $Totalamount = $amount;
			
		} elseif($payment_cycle == "Quartery") {
			$Totalamount = $amount * 3;
			
		}elseif ($payment_cycle == "Semi Annual") {
				$Totalamount = $amount * 6;
			
		}elseif ($payment_cycle == "Custom") {
					$date1 = new DateTime($start_date);
                   $date2 = new DateTime($end_date);
                   $interval = $date1->diff($date2);

					$days = $interval->days;
					$Totalamount = $amount * $days;
				}else{
				$Totalamount = $amount * 12;
			
		}

		      //    $withholding = $Totalamount * 0.1;
			     // $exclusive= $Totalamount - $withholding;
        //          $taxex = $exclusive;

                 $customer_name = @$data['custinfo']->customer_name.'-ZERORATE';//ZANZIBAR



// $data['emslist'] = $this->Box_Application_model->get_credit_customer_list_byAccnoMonth2($acc_no,$month);
// $data['sum'] = $this->Box_Application_model->get_credit_customer_sum_byAccnoMonth2($acc_no,$month);
if(@$data['custinfo']->region =="22" ){$service="ZRB";}else{$service="EFD";}
$sign = array('controlno'=>$controlno,'idtype'=>'1','custid'=>@$data['custinfo']->tin_number,'custname'=>@$customer_name,'msisdn'=>@$data['custinfo']->mobile_number,'service'=>$service);
	    $url = "http://192.168.33.2/api/vfd/getSig.php";
		$ch = curl_init($url);
		$json = json_encode($sign);
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
		$data['signature'] = $signature = json_decode($response);


		$this->load->library('ciqrcode');

			$config['cacheable']    = true; //boolean, the default is true
			$config['cachedir']     = './assets/'; //string, the default is application/cache/
			$config['errorlog']     = './assets/'; //string, the default is application/logs/
			$config['imagedir']     = './assets/images/'; //direktori penyimpanan qr code
			$config['quality']      = true; //boolean, the default is true
			$config['size']         = '1024'; //interger, the default is 1024
			$config['black']        = array(224,255,255); // array, default is array(255,255,255)
			$config['white']        = array(70,130,180); // array, default is array(0,0,0)
			$this->ciqrcode->initialize($config);

			$image_name = $data['qrcodename'] = $controlno .'.png'; 
			
			//$params['data'] = 'https://verify.tra.go.tz/'.$signature->desc; 

			if(@$data['custinfo']->region =="22" ){
				$params['data'] = $signature->desc;
			}else{$params['data'] = 'https://verify.tra.go.tz/'.$signature->desc; }

			$params['level'] = 'H'; 
			$params['size'] = 10;
			$params['savename'] = FCPATH.$config['imagedir'].$image_name; 
			$this->ciqrcode->generate($params);

			//$this->load->view('billing/invoice_sheet',$data);

               $this->load->library('Pdf');

               $html= "";//$this->load->view('estate/invoice_sheet',$data,TRUE);
			   if(@$data['custinfo']->region =="22" ){
				$html= $this->load->view('estate/invoice_sheet_znz',$data,TRUE);
				}else{ $html= $this->load->view('estate/invoice_sheet',$data,TRUE);}


              $this->load->library('Pdf');
                $this->dompdf->loadHtml($html);
                $this->dompdf->setPaper('A4','potrait');
                $this->dompdf->render();
                $this->dompdf->stream($controlno, array("Attachment"=>0));

 }
}
