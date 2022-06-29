<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$current_date = null;
$current_time = null;
$current_datetime = null;
$time = '';

class Box_Application extends CI_Controller {


	function __construct() {
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
		$this->load->model('Sms_model');
		$this->load->model('unregistered_model');
		$this->load->model('Control_Number_model');
		$this->load->model('Supervisor_ViewModel');
		$this->load->model('ReceivedBranch_ViewModel');
		$this->load->model('Pcum_model');
		$this->load->model('Bill_Customer_model');

		$this->load->helper(array("security"));

		date_default_timezone_set('Africa/Nairobi');
		$datetime = new DateTime();
		$this->current_date  = $datetime->format('Y-m-d');
		$this->current_time  = $datetime->format('H:i:s');
		$this->current_datetime  = $datetime->format('Y-m-d H:i:s');

	}
	public function Inventory()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$data['region'] = $this->employee_model->regselect();
			$data['category'] = $this->billing_model->getAllCategory();
			$data['listItem'] = $this->billing_model->getAllCategoryBill();

			$this->load->view('Stock/StampBureauandStock',$data);
		}
		else{
			redirect(base_url());
		}
	}


	public function box_post(){
     // $url = 'http://192.168.33.3/Posta_Api/box_post';

    ///$getValue = json_decode( file_get_contents( 'php://input' ), true );

    //$mobile      = $getValue['mobile'];

		$Boxlist = $this->Box_Application_model->get_box_listWeb();

		foreach ($Boxlist as $key => $value) {
    	# code...

			$id = $value->details_cust_id;
			$inforperson = $this->Box_Application_model->get_box_list_perperson($id);

			$ipo = $this->Box_Application_model->get_box_customer_details($id); 
			if(empty($ipo->customer_id)  )
			{

				$paymentlist = $this->Box_Application_model->get_box_payment_list_perperson($id);
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
						'CustomerID'=>$id,
						'Customer_mobile'=>$pay->Customer_mobile,
						'transactionstatus'=>$pay->status,
						'receipt'=>$pay->receipt,
						'RenewDate'=>$RenewDate,
						'paymentdate'=>$pay->transactiondate

					);

					$this->Box_Application_model->save_box_payment_details($add);

				}
		//$Outstanding= $this->Box_Application_model->get_box_outstanding_list_perperson($id);

				$repname=$value->first_name.' '.$value->middle_name.' '.$value->last_name;
				$info = array();
				$info = array('customer_id'=>$id,'region'=>$value->region,'Branch'=>$value->district,'cust_boxtype'=>$value->cust_boxtype,
					'cust_name'=>$value->cust_name,'repesentative_name'=>$repname,'authority_card'=>$value->authority_card,'boxnumber'=>$inforperson->box_number,'mobile'=>$value->Customer_mobile);

				$this->Box_Application_model->save_box_cust_details($info);


			}


		}


		echo 'Successfully';

    //header('Content-Type: application/json');
    //echo json_encode($data);

	}



	public function box_update_number(){
     // $url = 'http://192.168.33.3/Posta_Api/box_post';

    ///$getValue = json_decode( file_get_contents( 'php://input' ), true );

    //$mobile      = $getValue['mobile'];

		$Boxlist = $this->Box_Application_model->get_box_customer_details_list();

		foreach ($Boxlist as $key => $value) {
    	# code...
			$id = $value->customer_id;
			$inforperson = $this->Box_Application_model->get_box_list_perperson($id);

			$boxupdate = array();
			$boxupdate = array('boxnumber'=>$inforperson->box_number);
			$this->Box_Application_model->update_box_number_details00($boxupdate,$id);

		}
		

		echo 'Successfully';

    //header('Content-Type: application/json');
    //echo json_encode($data);

	}



	public function box_update_payments(){
     // $url = 'http://192.168.33.3/Posta_Api/box_post';

    ///$getValue = json_decode( file_get_contents( 'php://input' ), true );

    //$mobile      = $getValue['mobile'];

		$Boxlist = $this->Box_Application_model->get_box_customer_payments_details_list();

		foreach ($Boxlist as $key => $value) {
    	# code...
			$id = $value->customer_id;



			$paymentlist = $this->Box_Application_model->get_box_payment_paid_list_perperson($id);
			foreach ($paymentlist as $key => $pay) {
			# code...
				$Date= $pay->transactiondate;

				$year=date('Y', strtotime($Date)) + 1;
				$month=date('m', strtotime($Date));
				$day=date('d', strtotime($Date));
				$RenewDate = $year.'-'.$month.'-'.$day;


				$boxupdate = array();
				$boxupdate = array(
					'transactionstatus'=>$pay->status,
					'receipt'=>$pay->receipt,
					'paymentdate'=>$pay->transactiondate

				);

				$this->Box_Application_model->update_box_payments_details($boxupdate,$id);



			}

		}
		echo 'Successfully';

	}






	public function BoxRental()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->session->userdata('user_login_id');
			$info = $this->Box_Application_model->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;



			if($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER')
			{
				$data['regionlist'] = $this->employee_model->regselect();
			}else
			{
				$data['regionlist'] = $this->employee_model->regselect();
			//$data['regionlist'] = $this->Box_Application_model->regselect1($o_region);
			}

			$data['box_renters'] = $this->Box_Application_model->get_box_renters();
			$this->load->view('box/box_application_form',$data);
		}else{
			redirect(base_url(), 'refresh');
		}

	}
	public function Bulkboxes()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->session->userdata('user_login_id');
			$info = $this->Box_Application_model->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;


			if($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER')
			{
				$data['regionlist'] = $this->employee_model->regselect();
			}else
			{
				$data['regionlist'] = $this->Box_Application_model->regselect1($o_region);
			}

			$data['box_renters'] = $this->Box_Application_model->get_box_renters();
			$this->load->view('box/Bulk_form',@$data);
		}else{
			redirect(base_url(), 'refresh');
		}

	}

	public function Bulk_Boxes()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$id = $this->session->userdata('user_login_id');
			$info = $this->Box_Application_model->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;
			$id2 = base64_decode($this->input->get('code'));

			if($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER')
			{
				$data['regionlist'] = $this->employee_model->regselect();
			}else
			{
				$data['regionlist'] = $this->Box_Application_model->regselect1($o_region);
			}
			$dec = $this->Box_Application_model->get_bulk_customers($id2);
			if(empty($dec)){
				echo 'Select Customer First';


			}else{
				$data['customer']=$dec ;

			//echo json_encode($dec);
				$this->load->view('box/boxes_form',$data);

			}

		}else{
			redirect(base_url(), 'refresh');
		}

	}


	public function Mail()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$data['region'] = $this->employee_model->regselect();
			$data['category'] = $this->billing_model->getAllCategory();
			$data['listItem'] = $this->billing_model->getAllCategoryBill();

			$this->load->view('billing/inland_mails',$data);
		}
		else{
			redirect(base_url());
		}
	}
	public function Inland_Mails_List()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$data['mails'] = $this->billing_model->get_mails_list();
			$this->load->view('billing/inland_mails_list',$data);
		}
		else{
			redirect(base_url());
		}
	}


	public function Register_Box_Number()
	{
		if ($this->session->userdata('user_login_access') != False) {

			$this->load->view('box/box_register_number_form');
		}else{
			redirect(base_url(), 'refresh');
		}

	}
	public function Edit_Box_Number()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$editId = base64_decode($this->input->get('I'));
			$data['edit'] = $this->Box_Application_model->getValueForEdit($editId);
			$this->load->view('box/box_register_number_form',$data);
		}else{
			redirect(base_url(), 'refresh');
		}

	}
	public function Register_Box_Number_Action()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$box_number1 = $this->input->post('box_number');
			$box_id = $this->input->post('box_id');
			if (!empty($box_id)) {
				$boxupdate = array();
				$boxupdate = array('box_number'=>$box_number1);
				$this->Box_Application_model->update_box_number($boxupdate,$box_id);

				echo "Successfully Updated";
			}else{
				$boxs = array();
				$boxs = array('box_number'=>$box_number1,'box_status'=>'Vacance');
				$this->Box_Application_model->save_box_number($boxs);

				echo "Successfully Added";
			}


		}else{
			redirect(base_url(), 'refresh');
		}

	}






	public function Register_Box_Action()
	{

		if ($this->session->userdata('user_login_access') != False) {

			$id = $this->session->userdata('user_login_id');
			$info = $this->employee_model->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;
			$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;


			$TotalAccesoryamounts = $this->input->post('TotalAccesoryamounts');
			$TotalAccesoryvalues = $this->input->post('TotalAccesoryvalues');
//$OutstandingArray = $this->input->post('OutstandingArray');
//$myArray2 = $_REQUEST['OutstandingArray'];
			if(!empty($_POST['AccesoryArray']))
			{
				$myArray2 = $_POST['AccesoryArray'];
				$AccesoryArray    = json_decode($myArray2);

			}

			$accesoryDesc = $this->input->post('accesoryDesc');


			$TotalOutstandingamounts = $this->input->post('TotalOutstandingamounts');
			$TotalOutstandingvalues = $this->input->post('TotalOutstandingvalues');
//$OutstandingArray = $this->input->post('OutstandingArray');
//$myArray2 = $_REQUEST['OutstandingArray'];
			if(!empty($_POST['OutstandingArray']))
			{
				$myArray = $_POST['OutstandingArray'];
				$OutstandingArray    = json_decode($myArray);

			}

			$OutstandingDesc = $this->input->post('OutstandingDesc');

			$Totalpaymentsamounts = $this->input->post('Totalpaymentsamounts');
			$Totalpaymentsvalues = $this->input->post('Totalpaymentsvalues');
//$OutstandingArray = $this->input->post('OutstandingArray');
//$myArray2 = $_REQUEST['OutstandingArray'];
			if(!empty($_POST['paymentsArray']))
			{
				$myArray3 = $_POST['paymentsArray'];
				$paymentsArray    = json_decode($myArray3);

			}

			$paymentsDesc = $this->input->post('paymentsDesc');

			$boxtype = $this->input->post('boxtype');
			$tariffcat = $this->input->post('tariffCat');
			$custname = $this->input->post('name');
			$fname = $this->input->post('fname');
			$mname = $this->input->post('mname');
			$lname = $this->input->post('lname');
			$iddescription = $this->input->post('iddescription');
			$idnumber = $this->input->post('idnumber');
			$box = $this->input->post('box');
			$boxn = $this->input->post('boxn');
			$region = $this->input->post('region');
			$district = $this->input->post('district');
			$email = $this->input->post('email');
			$phone = $this->input->post('phone');
			$mobile = $this->input->post('mobile');
			$residence = $this->input->post('residence');
			$authcard = $this->input->post('authcard');




			$data['boxid'] = $this->Box_Application_model->get_box_price($tariffcat);
			$source = $this->employee_model->get_code_source($o_region);

			$transactionstatus   = 'POSTED';
			$bill_status  = 'PENDING';
			$PaymentFor = 'POSTSBOX';
			$transactiondate = date("Y-m-d");
			$source = $this->employee_model->get_code_source($o_region);
			$serial    = 'PBOX'.date("YmdHis").$source->reg_code;
			$price = $data['boxid']->price ;
			$renter = $data['boxid']->box_tariff_category;
			$vat = floor($price * 0.18);


			$priceVat=round(round(($vat + $price),1));
			$total1 = round(round(($vat + $price),1))+ $TotalOutstandingamounts+ $TotalAccesoryamounts+ $Totalpaymentsamounts;
			$paidamount = doubleval(round(round(($vat + $price),1))) + $TotalOutstandingamounts+ $TotalAccesoryamounts+ $Totalpaymentsamounts;

			if($box =="Renewal Box"){
				$priceVat=round(round((0),1));
				$total1 =  $TotalOutstandingamounts+ $TotalAccesoryamounts+ $Totalpaymentsamounts;
				$paidamount =  $TotalOutstandingamounts+ $TotalAccesoryamounts+ $Totalpaymentsamounts;
			}
			$cust = array();
			$cust = array('cust_boxtype'=>$tariffcat,'boxnumber'=>$box,'cust_name'=>$custname,'iddescription'=>$iddescription,'idnumber'=>$idnumber,'first_name'=>$fname,'middle_name'=>$mname,'last_name'=>$lname,'authority_card'=>$authcard);

//$this->box_application_model->save_customer_details($cust);
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('customer_details',$cust);
			$last_id = $db2->insert_id();

			$add = array();
			$add = array('add_cust_id'=>$last_id,'region'=>$region,'district'=>$district,'residence'=>$residence,'email'=>$email,'phone'=>$phone,'mobile'=>$mobile);

			$this->Box_Application_model->save_address_details($add);

			if($box !="Renewal Box"){


				$Outstanding1 = array();
				$Outstanding1 = array('amount'=>$priceVat,'year'=>date("Y"),'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);

				$this->Box_Application_model->save_Outstanding($Outstanding1);

			}





			if($Totalpaymentsamounts > 0 ) 
			{
				if($Totalpaymentsvalues == 0){

	//echo json_encode($OutstandingArray);
					$year = $paymentsArray[0]->Year;
					$amount =$paymentsArray[0]->Amount;

					$payments3 = array();
					$payments3 = array('amount'=>$amount,'year'=>$year,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);
					$this->Box_Application_model->save_Outstanding($payments3);

				}
				else
				{

					foreach ($paymentsArray as $key => $variable) {

 //    $year = $variable['year'];
	// $amount =$variable['amount'];

						$year = $variable->year;
						$amount =$variable->amount;

						$payments = array();
						$payments = array('amount'=>$amount,'year'=>$year,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);
						$this->Box_Application_model->save_Outstanding($payments);

					}

				}

			}



			if($TotalOutstandingamounts > 0 ) 
			{
				if($TotalOutstandingvalues == 0){

	//echo json_encode($OutstandingArray);
					$year = $OutstandingArray[0]->Year;
					$amount =$OutstandingArray[0]->Amount;

					$Outstanding3 = array();
					$Outstanding3 = array('amount'=>$amount,'year'=>$year,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);
					$this->Box_Application_model->save_Outstanding($Outstanding3);

				}
				else
				{

					foreach ($OutstandingArray as $key => $variable) {

 //    $year = $variable['year'];
	// $amount =$variable['amount'];

						$year = $variable->year;
						$amount =$variable->amount;

						$Outstanding = array();
						$Outstanding = array('amount'=>$amount,'year'=>$year,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);
						$this->Box_Application_model->save_Outstanding($Outstanding);

					}

				}

			}


			if($TotalAccesoryamounts > 0 ) 
			{
				if($TotalAccesoryvalues == 0){

	//echo json_encode($OutstandingArray);
					$year = $AccesoryArray[0]->accesory;
					$amount =$AccesoryArray[0]->Amount;

					$Outstanding3 = array();
					$Outstanding3 = array('amount'=>$amount,'year'=>$year,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);
					$this->Box_Application_model->save_Outstanding($Outstanding3);

				}
				else
				{

					foreach ($AccesoryArray as $key => $variable) {

 //    $year = $variable['year'];
	// $amount =$variable['amount'];

						$year = $variable->accesory;
						$amount =$variable->amount;

						$Outstanding = array();
						$Outstanding = array('amount'=>$amount,'year'=>$year,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);
						$this->Box_Application_model->save_Outstanding($Outstanding);

					}

				}

			}

//taking last id and select tariff type
			$data = array(

				'transactiondate'=>$transactiondate,
				'serial'=>$serial,
				'paidamount'=>$paidamount,
				'CustomerID'=>$last_id,
				'Customer_mobile'=>$mobile,
				'region'=>$region,
				'district'=>$district,
				'transactionstatus'=>$transactionstatus,
				'bill_status'=>$bill_status,
				'paymentFor'=>$PaymentFor

			);

			if (empty( $boxn)) {

			}else{
				$boxs = array();
				$boxs = array('box_number'=>$boxn,'box_status'=>'Occupied','reff_cust_id'=>$last_id,'region'=>$region,'branch'=>$district);
				$this->Box_Application_model->save_box_number($boxs);
			}

			$serviceId = 'POSTBOX';
			$renter = $custname;

	//$trackno = $bagsNo;
			$this->Box_Application_model->save_transactions($data);

			$transaction = $this->getBillGepgBillId($serial, $paidamount,$district,$region,$mobile,$renter,$serviceId);

			$serial1 = $transaction->billid;
			$update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
			$this->Box_Application_model->update_transactions($update,$serial1);

			$total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya RENTER BOX,Kiasi unachotakiwa kulipia ni TSH.'.number_format($total1,2);

			$total2 ='The amount to be paid for RENTER BOX is '. ' '.number_format($price,2).'  and VAT to be paid is'.' '. number_format($vat,2).'  The TOTAL amount is '.' '.number_format($total1,2).
			'Pay through this control number'.' '.$transaction->controlno;
			$this->Sms_model->send_sms_trick($mobile,$total);

			echo json_encode($total2);

		}else{
			redirect(base_url(), 'refresh');
		}

	}



	public function Register_Bulk_Action()
	{

		if ($this->session->userdata('user_login_access') != False) {

			$id = $this->session->userdata('user_login_id');
			$info = $this->employee_model->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;
			$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;



			$Totalpaymentsamounts = $this->input->post('Totalpaymentsamounts');
			$Totalpaymentsvalues = $this->input->post('Totalpaymentsvalues');
//$OutstandingArray = $this->input->post('OutstandingArray');
//$myArray2 = $_REQUEST['OutstandingArray'];
			if(!empty($_POST['paymentsArray']))
			{
				$myArray3 = $_POST['paymentsArray'];
				$paymentsArray    = json_decode($myArray3);

			}

			$Customerserial = $this->input->post('Customerserial');
			$serial    = $Customerserial;
			$bulkcustomer = $this->Box_Application_model->get_bulk_customers($serial);
			if($bulkcustomer->amount >= $Totalpaymentsamounts) {
				if( $Totalpaymentsamounts > 0 ) 

				{
	//update  amount
					$remain = $bulkcustomer->amount - $Totalpaymentsamounts;
					$amountavailable = array('amount'=>$remain);
					$this->Box_Application_model->update_bulk_numbers($amountavailable,$serial);

					if($Totalpaymentsvalues == 0){

	//echo json_encode($OutstandingArray);
						$Boxnumber = $paymentsArray[0]->Boxnumber;
						$Boxname = $paymentsArray[0]->Boxname;
						$amount =$paymentsArray[0]->Amount;

						$payments3 = array('amount'=>$amount,'Box_name'=>$Boxname,'serial'=>$serial,'Box_number'=>$Boxnumber, 'Operator'=> $user,'Created_byId'=>$info->em_code);
						$this->Box_Application_model->save_bulk_boxes($payments3);

					}
					else
					{

						foreach ($paymentsArray as $key => $variable) {

							$Boxnumber = $variable->Boxnumber;
							$Boxname = $variable->Boxname;
							$amount =$variable->amount;

							$payments = array();
							$payments = array('amount'=>$amount,'Box_name'=>$Boxname,'serial'=>$serial,'Box_number'=>$Boxnumber, 'Operator'=> $user,'Created_byId'=>$info->em_code);
							$this->Box_Application_model->save_bulk_boxes($payments);

						}}
           //  $data['list'] = $this->Box_Application_model->get_Bulk_list();
           // $this->load->view('box/Bulk_List',$data);
						$data['statuss']="Saved Successfully";
  //echo 'Saved Successfully';

						echo $data['statuss'];

 //redirect('/Box_Application/Bulk_List');

					}
				}else{
					$data['statuss']="Kiwango chako kimefikia kikomo";
					echo $data['statuss'];
				}



			}else{
				redirect(base_url(), 'refresh');
			}

		}


		public function sendsms($mobile,$total)
		{
			$url = 'http://192.168.33.2/modules/otsms/process.php?msisdn='.$mobile.'&message='.urlencode($total);
			$urloutput=file_get_contents($url);
			return $urloutput;
		}
		public function GetTariffCategory(){

			$bt_id = $this->input->post('bt_id',TRUE);
//run the query for the cities we specified earlier
			echo $this->Box_Application_model->geTariffCategoryById($bt_id);
		}


		public function Receive_scanned(){

			$emid=   $this->session->userdata('user_login_id');
			$trackno = $this->input->post('identifier',TRUE);


			$emid=$emid;


     // $arr = array(array('emid'=>$emid,'identifier'=>$trackno));
     //                  $list["data"]=$arr; 

				 //    header('Content-Type: application/json');
				 //    echo json_encode($list);


			if(empty($emid)){

				$value = array();
				$value = array('message'=>'Empty emid','status'=>'404');
				$list["data"] = $value; 

				header('Content-Type: application/json');
				echo 'Empty emid';


			}else{

    	// $emid=   $this->session->userdata('user_login_id');
				$getInfo = $this->employee_model->GetBasic($emid);
				$users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
				$loc = $getInfo->em_region.' - '.$getInfo->em_branch;

				$word = 'DS';
				if(strpos($trackno, $word) !== false ){

                         $updes = array(); //receive despatch
                         $updes = array('despatch_status'=>'Received','received_by'=>$emid);
                         $this->unregistered_model->update_despatch_info($updes,$trackno);

                         $listbags = $this->unregistered_model->get_Mail_bags_desp_list_BYNO($trackno);

                         foreach ($listbags as $key => $value) {
                           # code...
                         	$id =$value->bag_id;

                         	$update1 = array();
                         	$update1 = array('bags_status'=>'isReceived','bag_received_by'=>$emid);
                         	$this->unregistered_model->update_bags_info($update1,$id);


                            //update content za bags
                         	$listitems = $this->unregistered_model->get_list_of_all_bags($id);
                         	foreach ($listitems as $value) {

                         		$last_id = $value->senderp_id;
                         		$update2 = array();
                         		$update2 = array('sender_status'=>'Back',);
                         		$this->unregistered_model->update_sender_info($last_id,$update2);




                         		$track_number=$value->track_number;

                         		$event = "Received Despatch";
                         		$location ='Received Sorting Facility '.$loc;
                         		$data = array();
                         		$data = array('track_no'=>@$trackno,'location'=>$location,'user'=>@$users,'event'=>$event);

                         		$this->Box_Application_model->save_location($data);

                         		$smobile =@$value->sender_mobile;
                         		$rmobile =@$value->receiver_mobile;
                         		$stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' umefika '.'Sorting '.$getInfo->em_region.' - '.$getInfo->em_branch;
                         		$this->Sms_model->send_sms_trick($smobile,$stotal);
                         		$this->Sms_model->send_sms_trick($rmobile,$stotal);



                         	}


                         }


                            // $data = array();//update to backoffice
                            // $data = array('sender_status'=>'BackReceive');//
                            // $this->unregistered_model->update_acceptance_sender_person_info($trackno,$data); //from counter



                         $arr = array(array('message'=>'Successful Received','status'=>'200'));
                         $list["data"]=$arr; 


                         header('Content-Type: application/json');
						    // echo json_encode($list);
                         echo 'Successful Received';



                     }
                     else{




                     	$info = $this->employee_model->GetBasic($emid);
                     	$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                     	$location= $info->em_region.' - '.$info->em_branch;




                     	$db='sender_info';
                     	$senderinfo = $this->unregistered_model->get_senderinfo($db,$trackno);

          if(!empty($senderinfo))//which table
          {
          	//check payment
          	$sender_id=@$senderinfo->sender_id;
          	$serial=@$senderinfo->serial;
          	$DB='transactions';
          	$transactions1 = $this->unregistered_model->Checkintransactions($DB,$sender_id);



          	if(!empty($transactions1) ){

          	if($senderinfo->item_status != 'Received'){ //haijawa received?
                    $love = array();//from counter or region - receive item
                    $love = array(
                    	'track_no'=>$trackno,
                    	'event'=>$info->em_role,
                    	'region'=>$info->em_region,
                    	'branch'=>$info->em_branch,
                    	'user'=>$emid,
                    	'name'=>'Received',
                    	'status'=>'Received',
                    	'type'=>'qrscan'
                    );

                    $this->unregistered_model->save_event($love);


                    $data = array();//update sender status
                    $data = array('s_status'=>'Received','item_status'=>'Received');
                    $this->unregistered_model->update_acceptance_sender_info($trackno,$data); 

                    $sender_id=@$senderinfo->sender_id;
                    $data2 = array();//update transaction status
                    $data2 = array('item_received_by'=>$emid,'office_name'=>'Received');
                    $this->unregistered_model->update_transactionsbyinfosender_id($sender_id,$data2); 



                    $track_number=$senderinfo->track_number;

                    $event = "Sorting Facility";
                    $location ='Received Sorting Facility '.$loc;
                    $data = array();
                    $data = array('track_no'=>@$trackno,'location'=>$location,'user'=>@$users,'event'=>$event);

                    $this->Box_Application_model->save_location($data);

                    $smobile =@$senderinfo->s_mobile;
                    $rmobile =@$senderinfo->mobile;
                    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'Sorting '.$getInfo->em_region.' - '.$getInfo->em_branch;
                    $this->Sms_model->send_sms_trick($smobile,$stotal);
                    $this->Sms_model->send_sms_trick($rmobile,$stotal);








                    $arr = array(array('message'=>'Successful Received','status'=>'200'));
                    $list["data"]=$arr; 

                    header('Content-Type: application/json');
				    // echo json_encode($list);
                    echo 'Successful Received';


                }else{



                	$arr = array(array('message'=>'Already Scanned','status'=>'404'));
                	$list["data"]=$arr; 

                	header('Content-Type: application/json');
				    // echo json_encode($list);
                	echo 'Already Scanned';

                }
            }else{



            	$arr = array(array('message'=>'Payment not Received','status'=>'404'));
            	$list["data"]=$arr; 

            	header('Content-Type: application/json');
				    // echo json_encode($list);
            	echo 'Payment not Received';
            }


        }else{

        	$db='sender_person_info';
        	$senderperson = $this->unregistered_model->get_senderperson($db,$trackno);

        if(!empty($senderperson))//which table
        {
          	 //check payment
        	$senderp_id=@$senderperson->senderp_id;
          	//$serial=@$senderperson->serial;

        	$DB='register_transactions';
        	$transactions2 = $this->unregistered_model->CheckintransactionsBYSENDERPRS($DB,$senderp_id);
        	$DB='parcel_international_transactions';
        	$transactions4 = $this->unregistered_model->Checkintransactions3($DB,$senderp_id);

        	if( !empty($transactions2) || !empty($transactions4)){

        		if(!empty($senderperson)){


		    if($senderperson->sender_status != 'BackReceive'){ //haijawa received?


                    $love = array();//from counter or region - receive item
                    $love = array(
                    	'track_no'=>$trackno,
                    	'event'=>$info->em_role,
                    	'region'=>$info->em_region,
                    	'branch'=>$info->em_branch,
                    	'user'=>$emid,
                    	'name'=>'BackReceive',
                    	'status'=>'Received',
                    	'type'=>'qrscan'
                    );

                    $this->unregistered_model->save_event($love);

                    $track_number=@$senderperson->track_number;
                    $data = array();//update sender status
                    $data = array('sender_status'=>'BackReceive');
                    $this->unregistered_model->update_acceptance_sender_person_info($track_number,$data);

                    $track_number=$senderperson->track_number;

                    $event = "Sorting Facility";
                    $location ='Received Sorting Facility '.$loc;
                    $data = array();
                    $data = array('track_no'=>@$trackno,'location'=>$location,'user'=>@$users,'event'=>$event);

                    $this->Box_Application_model->save_location($data);

                    $smobile =@$senderperson->sender_mobile;
                    $rmobile =@$senderperson->receiver_mobile;
                    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'Sorting '.$getInfo->em_region.' - '.$getInfo->em_branch;
                    $this->Sms_model->send_sms_trick($smobile,$stotal);
                    $this->Sms_model->send_sms_trick($rmobile,$stotal); 

                    $arr = array(array('message'=>'Successful Received','status'=>'200'));
                    $list["data"]=$arr; 

                    header('Content-Type: application/json');
				    // echo json_encode($list);

                    echo 'Successful Received';




                }else{


                	$arr = array(array('message'=>'Already Scanned','status'=>'404'));
                	$list["data"]=$arr; 

                	header('Content-Type: application/json');
				    // echo json_encode($list);
                	echo 'Already Scanned';

                }}
            }else{


            	$arr = array(array('message'=>'Payment not Received','status'=>'404'));
            	$list["data"]=$arr; 

            	header('Content-Type: application/json');
				    // echo json_encode($list);
            	echo 'Payment not Received';
            }




        }else{


        	$db='sender_info';
        	$senderinfo = $this->unregistered_model->get_senderinfo_barcode($db,$trackno);

          if(!empty($senderinfo))//which table
          {
          	//check payment
          	$sender_id=@$senderinfo->sender_id;
          	$serial=@$senderinfo->serial;
          	$trackno=@$senderinfo->track_number;
          	$DB='transactions';
          	$transactions1 = $this->unregistered_model->Checkintransactions($DB,$sender_id);



          	if(!empty($transactions1) ){

          	if($senderinfo->item_status != 'Received'){ //haijawa received?
                    $love = array();//from counter or region - receive item
                    $love = array(
                    	'track_no'=>$trackno,
                    	'event'=>$info->em_role,
                    	'region'=>$info->em_region,
                    	'branch'=>$info->em_branch,
                    	'user'=>$emid,
                    	'name'=>'Received',
                    	'status'=>'Received',
                    	'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);

                    $trackno=@$senderinfo->track_number;
                    $data = array();//update sender status
                    $data = array('s_status'=>'Received','item_status'=>'Received');
                    $this->unregistered_model->update_acceptance_sender_info_barcode($trackno,$data); 

                    $sender_id=@$senderinfo->sender_id;
                    $data2 = array();//update transaction status
                    $data2 = array('item_received_by'=>$emid,'office_name'=>'Received');
                    $this->unregistered_model->update_transactionsbyinfosender_id($sender_id,$data2); 



                    $track_number=$senderinfo->track_number;

                    $event = "Sorting Facility";
                    $location ='Received Sorting Facility '.$loc;
                    $data = array();
                    $data = array('track_no'=>@$trackno,'location'=>$location,'user'=>@$users,'event'=>$event);

                    $this->Box_Application_model->save_location($data);

                    $smobile =@$senderinfo->s_mobile;
                    $rmobile =@$senderinfo->mobile;
                    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'Sorting '.$getInfo->em_region.' - '.$getInfo->em_branch;
                    $this->Sms_model->send_sms_trick($smobile,$stotal);
                    $this->Sms_model->send_sms_trick($rmobile,$stotal);





                    $arr = array(array('message'=>'Successful Received','status'=>'200'));
                    $list["data"]=$arr; 

                    header('Content-Type: application/json');
				    // echo json_encode($list);
                    echo 'Successful Received';


                }else{



                	$arr = array(array('message'=>'Already Scanned','status'=>'404'));
                	$list["data"]=$arr; 

                	header('Content-Type: application/json');
				    // echo json_encode($list);
                	echo 'Already Scanned';

                }
            }else{



            	$arr = array(array('message'=>'Payment not Received','status'=>'404'));
            	$list["data"]=$arr; 

            	header('Content-Type: application/json');
				    // echo json_encode($list);
            	echo 'Payment not Received';
            }


        }else{

        	$db='sender_person_info';
        	$senderperson = $this->unregistered_model->get_senderperson_barcode($db,$trackno);

        if(!empty($senderperson))//which table
        {
          	 //check payment
        	$senderp_id=@$senderperson->senderp_id;
        	$trackno=@$senderperson->track_number;
          	//$serial=@$senderperson->serial;

        	$DB='register_transactions';
        	$transactions2 = $this->unregistered_model->CheckintransactionsBYSENDERPRS($DB,$senderp_id);
        	$DB='parcel_international_transactions';
        	$transactions4 = $this->unregistered_model->Checkintransactions3($DB,$senderp_id);

        	if( !empty($transactions2) || !empty($transactions4)){

        		if(!empty($senderperson)){


		    if($senderperson->sender_status != 'BackReceive'){ //haijawa received?


                    $love = array();//from counter or region - receive item
                    $love = array(
                    	'track_no'=>$trackno,
                    	'event'=>$info->em_role,
                    	'region'=>$info->em_region,
                    	'branch'=>$info->em_branch,
                    	'user'=>$emid,
                    	'name'=>'BackReceive',
                    	'status'=>'Received',
                    	'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);


                    $data = array();//update sender status
                    $data = array('sender_status'=>'BackReceive');
                    $this->unregistered_model->update_acceptance_sender_person_info_barcode($senderp_id,$data); 


                    $track_number=$senderperson->track_number;

                    $event = "Sorting Facility";
                    $location ='Received Sorting Facility '.$loc;
                    $data = array();
                    $data = array('track_no'=>@$trackno,'location'=>$location,'user'=>@$users,'event'=>$event);

                    $this->Box_Application_model->save_location($data);

                    $smobile =@$senderperson->sender_mobile;
                    $rmobile =@$senderperson->receiver_mobile;
                    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'Sorting '.$getInfo->em_region.' - '.$getInfo->em_branch;
                    $this->Sms_model->send_sms_trick($smobile,$stotal);
                    $this->Sms_model->send_sms_trick($rmobile,$stotal); 



                    $arr = array(array('message'=>'Successful Received','status'=>'200'));
                    $list["data"]=$arr; 

                    header('Content-Type: application/json');
				    // echo json_encode($list);
                    echo 'Successful Received';




                }else{


                	$arr = array(array('message'=>'Already Scanned','status'=>'404'));
                	$list["data"]=$arr; 

                	header('Content-Type: application/json');
				    // echo json_encode($list);
                	echo 'Already Scanned';

                }}
            }else{


            	$arr = array(array('message'=>'Payment not Received','status'=>'404'));
            	$list["data"]=$arr; 

            	header('Content-Type: application/json');
				    // echo json_encode($list);
            	echo 'Payment not Received';
            }




        }
    }
}
}






}
}




}



public function deliver_bulk_scanned_item()
{
	if ($this->session->userdata('user_login_access') != false){

		$emid=   $this->session->userdata('user_login_id');
		$trackno = $this->input->post('identifier');
		$operator = $this->input->post('operator');
		$serial = $this->input->post('serial');
		$serial    = 'serial'.date("YmdHis");

		$emid=$emid;

		$info = $this->employee_model->GetBasic($emid);
		$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
		$location= $info->em_region.' - '.$info->em_branch;



		$db='sender_info';
		$senderinfo = $this->unregistered_model->get_senderinfo_barcode($db,$trackno);


          if(!empty(@$senderinfo))//which table
          {
          	
          	//check payment
          	$sender_id=@$senderinfo->sender_id;
          	//$serial=@$senderinfo->serial;
          	
          	$DB='transactions';
          	$transactions1 = $this->unregistered_model->Checkintransactionsbarcode($DB,$trackno);



          	if(!empty($transactions1)  ){



          	if($senderinfo->item_status != 'Received'){ //haijawa received?
          		//echo 'Please check6 operator '.$trackno.' '.$operator;


          		$serial = $this->input->post('serial');
          		if($serial =='not'){
          			$check=$this->unregistered_model->check_event($trackno);
          			if(empty(@$check)){
          				$serial    = 'derivery'.date("YmdHis");


          			}else{ 
            	//$serial = @$check->name;
          				$serial    = 'derivery'.date("YmdHis");
            	//delete and update barcode

          				$this->unregistered_model->delete_event($trackno);
          			}


          		}else{$check=$this->unregistered_model->check_event($trackno); $this->unregistered_model->delete_event($trackno);}


                    $love = array();//from counter or region - receive item
                    $love = array(
                    	'track_no'=>$trackno,
                    	'event'=>$info->em_role,
                    	'region'=>$info->em_region,
                    	'branch'=>$info->em_branch,
                    	'user'=>$emid,
                    	'name'=>$serial,
                    	'status'=>'Delivery',
                    	'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);

                    $service_type= 'EMS';
                    $sender_id=@$senderinfo->sender_id;

                    $listbulk= @$this->unregistered_model->GetListbulkTrans_delivey($emid,$serial);




                    echo "
                    <table id='' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."</td></tr></table>
                    <table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
                    <tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                    $alltotal = 0;
                    $sn=1;
                    foreach ($listbulk as $key => $value) { 

                    	$alltotal =$alltotal + $value->paidamount;
                    	echo "<tr style='width:100%;color:#343434;'>
                    	<td>".$sn."</td><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branchs."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                    	<td>


                    	<button  class='btn btn-info Delete' onclick=Deletevalue('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>

                    	</td></tr>";
                    	$sn++;
                    }


                    echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                    </table>
                    <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                    <input type='hidden' name ='serial' value=".$serial." class='serial'  id='serial'>
                    <input type='hidden' name ='operator' value=".$operator." class='operator'>

                    ";






                }
            }    



        }else{



         // echo '  <span class ="price" style="color: red;font-weight: 60px;font-size: 22px;align-content:center ;"> Huduma Haijalipiwa</span>';

        	$serial = $this->input->post('serial');
        	if(empty($serial)){
        		$check=$this->unregistered_model->check_event($trackno);
        		if(empty(@$check)){
        			$serial    = 'derivery'.date("YmdHis");


        		}else{ 
            	//$serial = @$check->name;
        			$serial    = 'derivery'.date("YmdHis");
            	//delete and update barcode

        			$this->unregistered_model->delete_event($trackno);
        		}


        	}


        	$service_type= 'EMS';
        	$sender_id=@$senderinfo->sender_id;

        	$listbulk= @$this->unregistered_model->GetListbulkTrans_delivey($emid,$serial);



        	echo "
        	<table id='' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."<span class ='price' style='color: red;font-weight: 60px;font-size: 22px;align-content:center ;'> Huduma Haijalipiwa</span></td></tr></table>
        	<table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
        	<tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
        	$alltotal = 0;
        	$sn=1;
        	foreach ($listbulk as $key => $value) { 

        		$alltotal =$alltotal + $value->paidamount;
        		echo "<tr style='width:100%;color:#343434;'>
        		<td>".$sn."</td><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branchs."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
        		<td>


        		<button  class='btn btn-info Delete' onclick=Deletevalue('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>

        		</td></tr>";
        		$sn++;
        	}


        	echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
        	</table>
        	<input type='hidden' name ='senders' value=".$sender_id." class='senders'>
        	<input type='hidden' name ='serial' value=".$serial." class='serial'  id='serial'>
        	<input type='hidden' name ='operator' value=".$operator." class='operator'>

        	";

        }





    }
    else{
    	redirect(base_url());
    }

}


public function deliver_bulk_scanned_items()
{
	if ($this->session->userdata('user_login_access') != false){

		$emid=   $this->session->userdata('user_login_id');
		$trackno = $this->input->post('identifier');
		$operator = $this->input->post('operator');
		$serial = $this->input->post('serial');
		$serial    = 'serial'.date("YmdHis");

		$emid=$emid;

		$info = $this->employee_model->GetBasic($emid);
		$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
		$location= $info->em_region.' - '.$info->em_branch;
		$location2= $info->em_region.' - '.$info->em_branch;



		$db='sender_info';
		$senderinfo = $this->unregistered_model->get_senderinfo_barcode($db,$trackno);


          if(!empty(@$senderinfo))//which table
          {
          	
          	//check payment
          	$sender_id=@$senderinfo->sender_id;
          	//$serial=@$senderinfo->serial;
          	
          	$DB='transactions';
          	$transactions1 = $this->unregistered_model->Checkintransactionsbarcode($DB,$trackno);



          	if(!empty($transactions1)  ){



          	if($senderinfo->item_status != 'Received'){ //haijawa received?
          		//echo 'Please check6 operator '.$trackno.' '.$operator;


          		$serial = $this->input->post('serial');
          		if($serial =='not'){
          			$check=$this->unregistered_model->check_event($trackno);
          			if(empty(@$check)){
          				$serial    = 'derivery'.date("YmdHis");


          			}else{ 
            	//$serial = @$check->name;
          				$serial    = 'derivery'.date("YmdHis");
            	//delete and update barcode

          				$this->unregistered_model->delete_event($trackno);
          			}


          		}else{$check=$this->unregistered_model->check_event($trackno); $this->unregistered_model->delete_event($trackno);}


                    $love = array();//from counter or region - receive item
                    $love = array(
                    	'track_no'=>$trackno,
                    	'event'=>$info->em_role,
                    	'region'=>$info->em_region,
                    	'branch'=>$info->em_branch,
                    	'user'=>$emid,
                    	'name'=>$serial,
                    	'status'=>'Delivery',
                    	'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);

                    $service_type= 'EMS';
                    $sender_id=@$senderinfo->sender_id;

                    $getbarcode =  $this->unregistered_model->check_events_serial($serial);

          if(!empty(@$trackno))//which table
          {
          	

          	//check payment
          	$sender_id=@$senderinfo->sender_id;
          	$service_type= 'EMS';

          	$checkReassigned = $this->Box_Application_model->check_reassign($sender_id,$operator);

          	if(!empty($checkReassigned)){

          		$data = array();
          		$data = array(
          			'em_id'=>$operator,
          			'item_id'=>$sender_id,
          			'serial'=>$serial,
          			'service_type'=>$service_type
          		);
          		$this->Box_Application_model->update_delivery_info($data,$sender_id);

          	}else{

          		$data = array();
          		$data = array(
          			'em_id'=>$operator,
          			'item_id'=>$sender_id,
          			'serial'=>$serial,
          			'service_type'=>$service_type
          		);

          		$this->Box_Application_model->save_delivery_info($data);

          		$track_number=@$senderinfo->track_number;


                    $data = array();//update sender status
                    $data = array('s_status'=>'Received','item_status'=>'Assigned');
                    $this->unregistered_model->update_acceptance_sender_info_barcode($track_number,$data); 


                    $event = "Delivery Facility";
                    $location ='Ready for derivery';
                    $data21 = array();
                    $data21 = array('track_no'=>@$track_number,'location'=>$location,'user'=>@$user,'event'=>$event);

                    $this->Box_Application_model->save_location($data21);



						     //  $smobile =@$senderinfo->s_mobile;
						     //  $rmobile =@$senderinfo->mobile;
						     // $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umesafirishwa '.'kutoka '.$getInfo->em_region.' - '.$getInfo->em_branch;
						     // $this->Sms_model->send_sms_trick($smobile,$stotal);
           //                         $this->Sms_model->send_sms_trick($rmobile,$stotal);




                }


            }


            $listbulk= @$this->unregistered_model->GetListbulkTrans_delivey($emid,$serial);



            echo "
            <table id='' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."</td></tr></table>
            <table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
            <tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
            $alltotal = 0;
            $sn=1;
            foreach ($listbulk as $key => $value) { 

            	$alltotal =$alltotal + $value->paidamount;
            	echo "<tr style='width:100%;color:#343434;'>
            	<td>".$sn."</td><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branchs."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
            	<td>


            	<button  class='btn btn-info Delete' onclick=Deletevalue1('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>

            	</td></tr>";
            	$sn++;
            }


            echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
            </table>
            <input type='hidden' name ='senders1' value=".$sender_id." class='senders1'>
            <input type='hidden' name ='serial1' value=".$serial." class='serial1'  id='serial1'>
            <input type='hidden' name ='operator1' value=".$operator." class='operator1'>

            ";



        }
    }    



}else{



         // echo '  <span class ="price" style="color: red;font-weight: 60px;font-size: 22px;align-content:center ;"> Huduma Haijalipiwa</span>';

	$serial = $this->input->post('serial');
	if(empty($serial)){
		$check=$this->unregistered_model->check_event($trackno);
		if(empty(@$check)){
			$serial    = 'derivery'.date("YmdHis");


		}else{ 
            	//$serial = @$check->name;
			$serial    = 'derivery'.date("YmdHis");
            	//delete and update barcode

			$this->unregistered_model->delete_event($trackno);
		}


	}


	$service_type= 'EMS';
	$sender_id=@$senderinfo->sender_id;

	$listbulk= @$this->unregistered_model->GetListbulkTrans_delivey($emid,$serial);



	echo "
	<table id='' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)." <span class ='price' style='color: red;font-weight: 60px;font-size: 22px;align-content:center ;'> Huduma Haijalipiwa</span></td></tr></table>
	<table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
	<tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
	$alltotal = 0;
	$sn=1;
	foreach ($listbulk as $key => $value) { 

		$alltotal =$alltotal + $value->paidamount;
		echo "<tr style='width:100%;color:#343434;'>
		<td>".$sn."</td><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branchs."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
		<td>


		<button  class='btn btn-info Delete' onclick=Deletevalue1('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>

		</td></tr>";
		$sn++;
	}


	echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
	</table>
	<input type='hidden' name ='senders1' value=".$sender_id." class='senders1'>
	<input type='hidden' name ='serial1' value=".$serial." class='serial1'  id='serial1'>
	<input type='hidden' name ='operator1' value=".$operator." class='operator1'>

	";

}





}
else{
	redirect(base_url());
}

}


public function close_bag_bulk_scanned_item()
{
	if ($this->session->userdata('user_login_access') != false){

		$emid=   $this->session->userdata('user_login_id');
		$trackno = $this->input->post('identifier');
		$weight = $this->input->post('weight');
		$region = $this->input->post('region');
		$branch = $this->input->post('branch');
		$serial    = 'serial'.date("YmdHis");

		$emid=$emid;

		$info = $this->employee_model->GetBasic($emid);
		$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
		$location= $info->em_region.' - '.$info->em_branch;



		$db='sender_info';
		$senderinfo = $this->unregistered_model->get_senderinfo_barcode($db,$trackno);


          if(!empty(@$senderinfo))//which table
          {
          	
          	//check payment
          	$sender_id=@$senderinfo->sender_id;
          	//$serial=@$senderinfo->serial;
          	
          	$DB='transactions';
          	$transactions1 = $this->unregistered_model->Checkintransactionsbarcode($DB,$trackno);



          	if(!empty($transactions1)  ){



          	if($senderinfo->item_status != 'Received0'){ //haijawa received?
          		//echo 'Please check6 operator '.$trackno.' '.$operator;


          		$serial = $this->input->post('serial');

          		if($serial =='not'){

          			$check=$this->unregistered_model->check_event($trackno);
          			if(empty(@$check)){
          				$serial    = 'closebag'.date("YmdHis");


          			}else{ 
            	// $serial = @$check->name;
          				$serial    = 'closebag'.date("YmdHis");
            	//delete and update barcode

          				$this->unregistered_model->delete_event($trackno);
          			}


          		}else{$check=$this->unregistered_model->check_event($trackno); $this->unregistered_model->delete_event($trackno);}

            // echo 'event '.$serial;



                    $love = array();//from counter or region - receive item
                    $love = array(
                    	'track_no'=>$trackno,
                    	'event'=>$info->em_role,
                    	'region'=>$info->em_region,
                    	'branch'=>$info->em_branch,
                    	'user'=>$emid,
                    	'name'=>$serial,
                    	'status'=>'closebag',
                    	'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);

                    $service_type= 'EMS';
                    $sender_id=@$senderinfo->sender_id;

                    $listbulk= @$this->unregistered_model->GetListbulkTrans_delivey($emid,$serial);



                    echo "
                    <table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."</td></tr></table>
                    <table style='width:100%;' class='table table-bordered'>
                    <tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                    $alltotal = 0;
                    $sn=1;
                    foreach ($listbulk as $key => $value) { 

                    	$alltotal =$alltotal + $value->paidamount;
                    	echo "<tr style='width:100%;color:#343434;'>
                    	<td>".$sn."</td><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branchs."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                    	<td>


                    	<button  class='btn btn-info Delete' onclick=Deletevalue('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>

                    	</td></tr>";
                    	$sn++;
                    }

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>




                    echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                    </table>
                    <input type='hidden' name ='senders' value=".$sender_id." class='senders' >
                    <input type='hidden' name ='serial' value=".$serial." class='serial'  id='serial'>

                    ";










                }
            }    



        }else{

        	$serial = $this->input->post('serial');
        	if(empty($serial)){
        		$check=$this->unregistered_model->check_event($trackno);
        		if(empty(@$check)){
        			$serial    = 'closebag'.date("YmdHis");


        		}else{ 
            	// $serial = @$check->name;
        			$serial    = 'closebag'.date("YmdHis");
            	//delete and update barcode

        			$this->unregistered_model->delete_event($trackno);
        		}


        	}

			// echo '  <span class ="price" style="color: red;font-weight: 60px;font-size: 22px;align-content:center ;"> Huduma Haijalipiwa</span>';


        	$listbulk= @$this->unregistered_model->GetListbulkTrans_delivey($emid,$serial);



        	echo "
        	<table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."  <span class ='price' style='color: red;font-weight: 60px;font-size: 22px;align-content:center ;'> Huduma Haijalipiwa</span></td></tr></table>
        	<table style='width:100%;' class='table table-bordered'>
        	<tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
        	$alltotal = 0;
        	$sn=1;
        	foreach ($listbulk as $key => $value) { 

        		$alltotal =$alltotal + $value->paidamount;
        		echo "<tr style='width:100%;color:#343434;'>
        		<td>".$sn."</td><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branchs."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
        		<td>


        		<button  class='btn btn-info Delete' onclick=Deletevalue('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>

        		</td></tr>";
        		$sn++;
        	}

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>




        	echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
        	</table>

        	<input type='hidden' name ='serial' value=".$serial." class='serial'  id='serial'>

        	";
                         // <input type='hidden' name ='senders' value=".$sender_id." class='senders'>

        }





    }
    else{
    	redirect(base_url());
    }

}


public function delete_deliver_bulk_scanned_item()
{
	if ($this->session->userdata('user_login_access') != false){

		$emid=   $this->session->userdata('user_login_id');
		$trackno = $this->input->post('identifier');
		$operator = $this->input->post('operator');
		$serial = $this->input->post('serial');




		$emid=$emid;

		$info = $this->employee_model->GetBasic($emid);
		$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
		$location= $info->em_region.' - '.$info->em_branch;



		$db='sender_info';
		$senderinfo = $this->unregistered_model->get_senderinfo_barcode($db,$trackno);


          if(!empty(@$senderinfo))//which table
          {
          	$this->unregistered_model->delete_bulk_by_event($trackno);

          	$listbulk= $this->unregistered_model->GetListbulkTrans_delivey($emid,$serial);
          	$sender_id=@$senderinfo->sender_id;



          	echo "
          	<table id='' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."</td></tr></table>
          	<table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
          	<tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
          	$alltotal = 0;
          	$sn=1;
          	foreach ($listbulk as $key => $value) { 

          		$alltotal =$alltotal + $value->paidamount;
          		echo "<tr style='width:100%;color:#343434;'>
          		<td>".$sn."</td><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branchs."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
          		<td>


          		<button  class='btn btn-info Delete' onclick=Deletevalue('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>

          		</td></tr>";
          		$sn++;
          	}


          	echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
          	</table>
          	<input type='hidden' name ='senders' value=".$sender_id." class='senders'>
          	<input type='hidden' name ='serial' value=".$serial." class='serial'  id='serial'>
          	<input type='hidden' name ='operator' value=".$operator." class='operator'>

          	";


          	




          }else{

          	$db='sender_person_info';
          	$senderperson = $this->unregistered_model->get_senderperson_barcode($db,$trackno);

        if(!empty($senderperson))//which table
        {
          	 //check payment
        	$senderp_id=@$senderperson->senderp_id;
        	$trackno=@$senderperson->Barcode;
          	//$serial=@$senderperson->serial;

        	$DB='register_transactions';
        	$transactions2 = $this->unregistered_model->CheckintransactionsBYSENDERPRS($DB,$senderp_id);
        	$DB='parcel_international_transactions';
        	$transactions4 = $this->unregistered_model->Checkintransactions3($DB,$senderp_id);

        	if( !empty($transactions2) || !empty($transactions4)){

        		if(!empty($senderperson)){


		    if($senderperson->sender_status == 'BackReceive'){ //haijawa received?


                    $love = array();//from counter or region - receive item
                    $love = array(
                    	'track_no'=>$trackno,
                    	'event'=>$info->em_role,
                    	'region'=>$info->em_region,
                    	'branch'=>$info->em_branch,
                    	'user'=>$emid,
                    	'name'=>'Delivery',
                    	'status'=>'Delivery',
                    	'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);

                    $service_type= 'MAIL';
                    $sender_id=@$senderperson->senderp_id;

                    $checkReassigned = $this->Box_Application_model->check_reassign($sender_id,$operator);

                    if(!empty($checkReassigned)){

                    	$data = array();
                    	$data = array(
                    		'em_id'=>$operator,
                    		'item_id'=>$sender_id,
                    		'serial'=>$serial,
                    		'service_type'=>$service_type
                    	);
                    	$this->Box_Application_model->update_delivery_info($data,$sender_id);

                    }else{

                    	$data = array();
                    	$data = array(
                    		'em_id'=>$operator,
                    		'item_id'=>$sender_id,
                    		'serial'=>$serial,
                    		'service_type'=>$service_type
                    	);

                    	$this->Box_Application_model->save_delivery_info($data);

                    	$trackno=@$senderperson->track_number;


                    $data = array();//update sender status
                    $data = array('sender_status'=>'Assigned');
                    $this->unregistered_model->update_acceptance_sender_person_info($trackno,$data); 


                    echo "<table style='width:100%;' class='table table-bordered'>
                    <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                    $alltotal = 0;
                // foreach ($listbulk as $key => $value) { 

                //   $alltotal =$alltotal + $value->paidamount;
                //   echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->paidamount,2)."</td>
                //   <td>


                //    <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>

                //  </td></tr>";
                // }

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>


                    $sender_id = 0;
                    $serial = 0;
                    $operator = 0;

                    echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                    </table>
                    <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                    <input type='hidden' name ='serial' value=".$serial." class='serial'  id='serial'>
                    <input type='hidden' name ='operator' value=".$operator." class='operator'>

                    ";

                }          	
            }}
        }}}





    }
    else{
    	redirect(base_url());
    }

}


public function delete_deliver_bulk_scanned_itemS()
{
	if ($this->session->userdata('user_login_access') != false){

		$emid=   $this->session->userdata('user_login_id');
		$trackno = $this->input->post('identifier');
		$operator = $this->input->post('operator');
		$serial = $this->input->post('serial');




		$emid=$emid;

		$info = $this->employee_model->GetBasic($emid);
		$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
		$location= $info->em_region.' - '.$info->em_branch;



		$db='sender_info';
		$senderinfo = $this->unregistered_model->get_senderinfo_barcode($db,$trackno);


          if(!empty(@$senderinfo))//which table
          {
          	$this->unregistered_model->delete_bulk_by_event($trackno);

          	 if(!empty(@$trackno))//which table
          	 {


          	//check payment
          	 	$sender_id=@$senderinfo->sender_id;

          	 	$this->Box_Application_model->delete_delivery_info($sender_id);

          	 	$track_number=@$senderinfo->track_number;


                    $data = array();//update sender status
                    $data = array('s_status'=>'Received','item_status'=>'Received');
                    $this->unregistered_model->update_acceptance_sender_info_barcode($track_number,$data); 



                }

                $listbulk= $this->unregistered_model->GetListbulkTrans_delivey($emid,$serial);
                $sender_id=@$senderinfo->sender_id;

                echo "
                <table id='' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."</td></tr></table>
                <table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
                <tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                $sn=1;
                foreach ($listbulk as $key => $value) { 

                	$alltotal =$alltotal + $value->paidamount;
                	echo "<tr style='width:100%;color:#343434;'>
                	<td>".$sn."</td><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branchs."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                	<td>


                	<button  class='btn btn-info Delete' onclick=Deletevalue('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>

                	</td></tr>";
                	$sn++;
                }


                echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                <input type='hidden' name ='serial1' value=".$serial." class='serial1'  id='serial1'>
                <input type='hidden' name ='operator1' value=".$operator." class='operator1'>

                ";






            }else{

            	$db='sender_person_info';
            	$senderperson = $this->unregistered_model->get_senderperson_barcode($db,$trackno);

        if(!empty($senderperson))//which table
        {
          	 //check payment
        	$senderp_id=@$senderperson->senderp_id;
        	$trackno=@$senderperson->Barcode;
          	//$serial=@$senderperson->serial;

        	$DB='register_transactions';
        	$transactions2 = $this->unregistered_model->CheckintransactionsBYSENDERPRS($DB,$senderp_id);
        	$DB='parcel_international_transactions';
        	$transactions4 = $this->unregistered_model->Checkintransactions3($DB,$senderp_id);

        	if( !empty($transactions2) || !empty($transactions4)){

        		if(!empty($senderperson)){


		    if($senderperson->sender_status == 'BackReceive'){ //haijawa received?


                    $love = array();//from counter or region - receive item
                    $love = array(
                    	'track_no'=>$trackno,
                    	'event'=>$info->em_role,
                    	'region'=>$info->em_region,
                    	'branch'=>$info->em_branch,
                    	'user'=>$emid,
                    	'name'=>'Delivery',
                    	'status'=>'Delivery',
                    	'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);

                    $service_type= 'MAIL';
                    $sender_id=@$senderperson->senderp_id;

                    $checkReassigned = $this->Box_Application_model->check_reassign($sender_id,$operator);

                    if(!empty($checkReassigned)){

                    	$data = array();
                    	$data = array(
                    		'em_id'=>$operator,
                    		'item_id'=>$sender_id,
                    		'serial'=>$serial,
                    		'service_type'=>$service_type
                    	);
                    	$this->Box_Application_model->update_delivery_info($data,$sender_id);

                    }else{

                    	$data = array();
                    	$data = array(
                    		'em_id'=>$operator,
                    		'item_id'=>$sender_id,
                    		'serial'=>$serial,
                    		'service_type'=>$service_type
                    	);

                    	$this->Box_Application_model->save_delivery_info($data);

                    	$trackno=@$senderperson->track_number;


                    $data = array();//update sender status
                    $data = array('sender_status'=>'Assigned');
                    $this->unregistered_model->update_acceptance_sender_person_info($trackno,$data); 


                    echo "<table style='width:100%;' class='table table-bordered'>
                    <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                    $alltotal = 0;
                // foreach ($listbulk as $key => $value) { 

                //   $alltotal =$alltotal + $value->paidamount;
                //   echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->paidamount,2)."</td>
                //   <td>


                //    <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>

                //  </td></tr>";
                // }

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>


                    $sender_id = 0;
                    $serial = 0;
                    $operator = 0;

                    echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                    </table>
                    <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                    <input type='hidden' name ='serial1' value=".$serial." class='serial1'  id='serial1'>
                    <input type='hidden' name ='operator1' value=".$operator." class='operator1'>

                    ";

                }          	
            }}
        }}}





    }
    else{
    	redirect(base_url());
    }

}

public function delete_bag_item_scanned(){
	if ($this->session->userdata('user_login_access') != false){
		$emid=   $this->session->userdata('user_login_id');
		$transid = $this->input->post('transactionid');
		$response = array();
		if ($transid) {
			$data = array(
				'isBagNo'=>'', 
				'bag_status'=>'isNotBag');
			$this->Box_Application_model->update_office_name($transid,$data);

			$response['status'] = 'Success';
			$response['msg'] = 'Item is removed from bag';

		}else{
			$response['status'] = 'Error';
			$response['msg'] = 'No transaction id';
		}
		//produce result to the server
		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}

public function delete_bag_close_bulk_scanned_item()
{
	if ($this->session->userdata('user_login_access') != false){

		$emid=   $this->session->userdata('user_login_id');
		$trackno = $this->input->post('identifier');
		$operator = $this->input->post('operator');
		$serial = $this->input->post('serial');




		$emid=$emid;

		$info = $this->employee_model->GetBasic($emid);
		$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
		$location= $info->em_region.' - '.$info->em_branch;



		$db='sender_info';
		$senderinfo = $this->unregistered_model->get_senderinfo_barcode($db,$trackno);


          if(!empty(@$senderinfo))//which table
          {
          	$this->unregistered_model->delete_bulk_by_event($trackno);

          	$listbulk= $this->unregistered_model->GetListbulkTrans_delivey($emid,$serial);
          	$sender_id=@$senderinfo->sender_id;



          	echo "
          	<table id='' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'> <tr style='font-size:22px ;'><td>Total Items: ".count($listbulk)."</td></tr></table>
          	<table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
          	<tr style='width:100%;color:#3895D3;'><th> S/No. </th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
          	$alltotal = 0;
          	$sn=1;
          	foreach ($listbulk as $key => $value) { 

          		$alltotal =$alltotal + $value->paidamount;
          		echo "<tr style='width:100%;color:#343434;'>
          		<td>".$sn."</td><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branchs."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
          		<td>


          		<button  class='btn btn-info Delete' onclick=Deletevalue('".$value->Barcode."'); type='button'   id='Delete'>Delete </button>

          		</td></tr>";
          		$sn++;
          	}

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>




          	echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
          	</table>
          	<input type='hidden' name ='senders' value=".$sender_id." class='senders'>
          	<input type='hidden' name ='serial' value=".$serial." class='serial' id='serial' >

          	";






          	




          }else{

          	$db='sender_person_info';
          	$senderperson = $this->unregistered_model->get_senderperson_barcode($db,$trackno);

        if(!empty($senderperson))//which table
        {
          	 //check payment
        	$senderp_id=@$senderperson->senderp_id;
        	$trackno=@$senderperson->Barcode;
          	//$serial=@$senderperson->serial;

        	$DB='register_transactions';
        	$transactions2 = $this->unregistered_model->CheckintransactionsBYSENDERPRS($DB,$senderp_id);
        	$DB='parcel_international_transactions';
        	$transactions4 = $this->unregistered_model->Checkintransactions3($DB,$senderp_id);

        	if( !empty($transactions2) || !empty($transactions4)){

        		if(!empty($senderperson)){


		    if($senderperson->sender_status == 'BackReceive'){ //haijawa received?


                    $love = array();//from counter or region - receive item
                    $love = array(
                    	'track_no'=>$trackno,
                    	'event'=>$info->em_role,
                    	'region'=>$info->em_region,
                    	'branch'=>$info->em_branch,
                    	'user'=>$emid,
                    	'name'=>'Delivery',
                    	'status'=>'Delivery',
                    	'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);

                    $service_type= 'MAIL';
                    $sender_id=@$senderperson->senderp_id;

                    $checkReassigned = $this->Box_Application_model->check_reassign($sender_id,$operator);

                    if(!empty($checkReassigned)){

                    	$data = array();
                    	$data = array(
                    		'em_id'=>$operator,
                    		'item_id'=>$sender_id,
                    		'serial'=>$serial,
                    		'service_type'=>$service_type
                    	);
                    	$this->Box_Application_model->update_delivery_info($data,$sender_id);

                    }else{

                    	$data = array();
                    	$data = array(
                    		'em_id'=>$operator,
                    		'item_id'=>$sender_id,
                    		'serial'=>$serial,
                    		'service_type'=>$service_type
                    	);

                    	$this->Box_Application_model->save_delivery_info($data);

                    	$trackno=@$senderperson->track_number;


                    $data = array();//update sender status
                    $data = array('sender_status'=>'Assigned');
                    $this->unregistered_model->update_acceptance_sender_person_info($trackno,$data); 


                    echo " <table id='example5' class='display nowrap table table-hover  table-bordered' cellspacing='0' width='100%'>
                    <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                    $alltotal = 0;
                // foreach ($listbulk as $key => $value) { 

                //   $alltotal =$alltotal + $value->paidamount;
                //   echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->paidamount,2)."</td>
                //   <td>


                //    <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>

                //  </td></tr>";
                // }

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>


                    $sender_id = 0;
                    $serial = 0;
                    $operator = 0;

                    echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                    </table>
                    <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                    <input type='hidden' name ='serial' value=".$serial." class='serial' id='serial'>
                    <input type='hidden' name ='operator' value=".$operator." class='operator'>

                    ";

                }          	
            }}
        }}}





    }
    else{
    	redirect(base_url());
    }

}


public function Delivery_scanned(){

	$emid=   $this->session->userdata('user_login_id');
	$trackno = $this->input->post('identifier');
	$operator = $this->input->post('operator');
	$serial = $this->input->post('serial');
	$serial    = 'serial'.date("YmdHis");

	$emid=$emid;

     // $arr = array(array('emid'=>$emid,'identifier'=>$trackno));
     //                  $list["data"]=$arr; 

				 //    header('Content-Type: application/json');
				 //    echo json_encode($list);


	if(empty($operator)){

		echo 'Please Select operator ';

	}else{
		$word = 'DS';
		if(strpos($trackno, $word) === false ){

			$info = $this->employee_model->GetBasic($emid);
			$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
			$location= $info->em_region.' - '.$info->em_branch;


			$db='sender_info';
			$senderinfo = $this->unregistered_model->get_senderinfo_barcode($db,$trackno);


          if(!empty(@$senderinfo))//which table
          {
          	
          	//check payment
          	$sender_id=@$senderinfo->sender_id;
          	$serial=@$senderinfo->serial;
          	
          	$DB='transactions';
          	$transactions1 = $this->unregistered_model->Checkintransactionsbarcode($DB,$trackno);



          	if(!empty($transactions1)  ){



          	if($senderinfo->item_status != 'Received0'){ //haijawa received?
          		//echo 'Please check6 operator '.$trackno.' '.$operator;

                    $love = array();//from counter or region - receive item
                    $love = array(
                    	'track_no'=>$trackno,
                    	'event'=>$info->em_role,
                    	'region'=>$info->em_region,
                    	'branch'=>$info->em_branch,
                    	'user'=>$emid,
                    	'name'=>'Delivery',
                    	'status'=>'Delivery',
                    	'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);

                    $service_type= 'EMS';
                    $sender_id=@$senderinfo->sender_id;

                    $checkReassigned = $this->Box_Application_model->check_reassign($sender_id,$operator);

                    if(!empty(@$checkReassigned)){
                     	//echo 'Please check8 operator '.$trackno.' '.$operator;

                    	$data = array();
                    	$data = array(
                    		'em_id'=>$operator,
                    		'item_id'=>$sender_id,
                    		'serial'=>$serial,
                    		'service_type'=>$service_type
                    	);
                    	$this->Box_Application_model->update_delivery_info($data,$sender_id);

                    	echo 'Successful Reassigned';

                    }else{
                     	//echo 'Please check7 operator '.$trackno.' '.$operator;

                    	$data = array();
                    	$data = array(
                    		'em_id'=>$operator,
                    		'item_id'=>$sender_id,
                    		'serial'=>$serial,
                    		'service_type'=>$service_type
                    	);

                    	$this->Box_Application_model->save_delivery_info($data);


                 if($senderinfo->item_status != 'Received'){ //haijawa received?
                    $love = array();//from counter or region - receive item sss
                    $love = array(
                    	'track_no'=>$trackno,
                    	'event'=>$info->em_role,
                    	'region'=>$info->em_region,
                    	'branch'=>$info->em_branch,
                    	'user'=>$emid,
                    	'name'=>'Received',
                    	'status'=>'Received',
                    	'type'=>'Barcodescan'
                    );

                    $this->unregistered_model->save_event($love);

                    $trackno=@$senderinfo->track_number;
                    $data = array();//update sender status
                    $data = array('s_status'=>'Received','item_status'=>'Received');
                    $this->unregistered_model->update_acceptance_sender_info($trackno,$data); 

                    $sender_id=@$senderinfo->sender_id;
                    $data2 = array();//update transaction status
                    $data2 = array('item_received_by'=>$emid,'office_name'=>'Received');
                    $this->unregistered_model->update_transactionsbyinfosender_id($sender_id,$data2);


                }


                $trackno=@$senderinfo->track_number;

                    $data = array();//update sender status
                    $data = array('s_status'=>'Received','item_status'=>'Assigned');
                    $this->unregistered_model->update_acceptance_sender_info_barcode($trackno,$data); 

                    // $sender_id=@$senderinfo->sender_id;
                    // $data2 = array();//update transaction status
                    // $data2 = array('item_received_by'=>$emid,'office_name'=>'Received');
                    // $this->unregistered_model->update_transactionsbyinfosender_id($sender_id,$data2); 


                    echo 'Successful Assigned';
                }

                echo 'Successful Assigned';



            }
            echo 'Successful Assigned';
        }    



    }else{

    	echo '  <span class ="" style="color: red;font-weight: 60px;font-size: 22px;align-content:center ;"> Huduma Haijalipiwa</span>';

    	$db='sender_person_info';
    	$senderperson = $this->unregistered_model->get_senderperson_barcode($db,$trackno);

        if(!empty($senderperson))//which table
        {
          	 //check payment
        	$senderp_id=@$senderperson->senderp_id;
        	$trackno=@$senderperson->Barcode;
          	//$serial=@$senderperson->serial;

        	$DB='register_transactions';
        	$transactions2 = $this->unregistered_model->CheckintransactionsBYSENDERPRS($DB,$senderp_id);
        	$DB='parcel_international_transactions';
        	$transactions4 = $this->unregistered_model->Checkintransactions3($DB,$senderp_id);

        	if( !empty($transactions2) || !empty($transactions4)){

        		if(!empty($senderperson)){


		    if($senderperson->sender_status == 'BackReceive'){ //haijawa received?


                    $love = array();//from counter or region - receive item
                    $love = array(
                    	'track_no'=>$trackno,
                    	'event'=>$info->em_role,
                    	'region'=>$info->em_region,
                    	'branch'=>$info->em_branch,
                    	'user'=>$emid,
                    	'name'=>'Delivery',
                    	'status'=>'Delivery',
                    	'type'=>'barcodescan'
                    );

                    $this->unregistered_model->save_event($love);

                    $service_type= 'MAIL';
                    $sender_id=@$senderperson->senderp_id;

                    $checkReassigned = $this->Box_Application_model->check_reassign($sender_id,$operator);

                    if(!empty($checkReassigned)){

                    	$data = array();
                    	$data = array(
                    		'em_id'=>$operator,
                    		'item_id'=>$sender_id,
                    		'serial'=>$serial,
                    		'service_type'=>$service_type
                    	);
                    	$this->Box_Application_model->update_delivery_info($data,$sender_id);

                    }else{

                    	$data = array();
                    	$data = array(
                    		'em_id'=>$operator,
                    		'item_id'=>$sender_id,
                    		'serial'=>$serial,
                    		'service_type'=>$service_type
                    	);

                    	$this->Box_Application_model->save_delivery_info($data);

                    	$trackno=@$senderperson->track_number;


                    $data = array();//update sender status
                    $data = array('sender_status'=>'Assigned');
                    $this->unregistered_model->update_acceptance_sender_person_info($trackno,$data); 


                    echo 'Successful Assigned';

                }          	
            }}
        }
    }else{

    	echo ' Huduma Haijalipiwa ';
    }
    echo ' Huduma Haijalipiwa ';


}







}
}
}





public function Save_bulk_Delivery_scanned(){

	$emid=   $this->session->userdata('user_login_id');
	$tracknos = $this->input->post('identifier');
	$operator = $this->input->post('operator');





	$emid=$emid;
	$serial    = 'serial'.date("YmdHis");

     // $arr = array(array('emid'=>$emid,'identifier'=>$trackno));
     //                  $list["data"]=$arr; 

				 //    header('Content-Type: application/json');
				 //    echo json_encode($list);


	if(empty($operator)){


		echo 'Please Select operator ';


	}else{
		$word = 'DS';
		if(strpos($tracknos, $word) === false ){

			$info = $this->employee_model->GetBasic($emid);
			$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
			$location= $info->em_region.' - '.$info->em_branch;


			$serial = $this->input->post('serial');
			if(!empty($serial)){


				$getbarcode =  $this->unregistered_model->check_events_serial($serial);
				if(!empty(@$getbarcode)){


					foreach ($getbarcode as $key => $value) {

						$trackno = $value->track_no;

						$db='sender_info';
						$senderinfo = $this->unregistered_model->get_senderinfo_barcode($db,$trackno);

          if(!empty(@$senderinfo))//which table
          {
          	

          	//check payment
          	$sender_id=@$senderinfo->sender_id;
          	$service_type= 'EMS';

          	$checkReassigned = $this->Box_Application_model->check_reassign($sender_id,$operator);

          	if(!empty($checkReassigned)){

          		$data = array();
          		$data = array(
          			'em_id'=>$operator,
          			'item_id'=>$sender_id,
          			'serial'=>$serial,
          			'service_type'=>$service_type
          		);
          		$this->Box_Application_model->update_delivery_info($data,$sender_id);

          	}else{

          		$data = array();
          		$data = array(
          			'em_id'=>$operator,
          			'item_id'=>$sender_id,
          			'serial'=>$serial,
          			'service_type'=>$service_type
          		);

          		$this->Box_Application_model->save_delivery_info($data);

          		$track_number=@$senderinfo->track_number;


                    $data = array();//update sender status
                    $data = array('s_status'=>'Received','item_status'=>'Assigned');
                    $this->unregistered_model->update_acceptance_sender_info_barcode($track_number,$data); 


                    $event = "Delivery Facility";
                    $location ='Ready for derivery';
                    $data21 = array();
                    $data21 = array('track_no'=>@$track_number,'location'=>$location,'user'=>@$user,'event'=>$event);

                    $this->Box_Application_model->save_location($data21);




                }


            }

          		// code...
        }

        echo 'Successful Saved';

    }
       else{//register

       	$db='sender_person_info';
       	$senderperson = $this->unregistered_model->get_senderperson($db,$trackno);
          	  if(!empty(@$senderperson))//which table
          	  {

          	  	$service_type= 'MAIL';
          	  	$sender_id=@$senderperson->senderp_id;

          	  	$checkReassigned = $this->Box_Application_model->check_reassign($sender_id,$operator);

          	  	if(!empty($checkReassigned)){

          	  		$data = array();
          	  		$data = array(
          	  			'em_id'=>$operator,
          	  			'item_id'=>$sender_id,
          	  			'serial'=>$serial,
          	  			'service_type'=>$service_type
          	  		);
          	  		$this->Box_Application_model->update_delivery_info($data,$sender_id);

          	  	}else{

          	  		$data = array();
          	  		$data = array(
          	  			'em_id'=>$operator,
          	  			'item_id'=>$sender_id,
          	  			'serial'=>$serial,
          	  			'service_type'=>$service_type
          	  		);

          	  		$this->Box_Application_model->save_delivery_info($data);


                    $data = array();//update sender status
                    $data = array('sender_status'=>'Assigned');
                    $this->unregistered_model->update_acceptance_sender_person_info($trackno,$data); 

                    $event = "Delivery Facility";
                    $location ='Ready for derivery';
                    $data21 = array();
                    $data21 = array('track_no'=>@$trackno,'location'=>$location,'user'=>@$user,'event'=>$event);

                    $this->Box_Application_model->save_location($data21);


                    echo 'Successful Saved';

                }

            }
        }
    }else{
    	echo 'Please Scan Barcode';
    }
}
}
}


public function Save_bulk_closebag_scanned(){

	$emid=   $this->session->userdata('user_login_id');
	$tracknos = $this->input->post('identifier');
    // $operator = $this->input->post('operator');


	$weight = $this->input->post('weight');
	$region = $this->input->post('region');
	$branch = $this->input->post('branch');
	$bagss = $this->input->post('bagss');


	$emid=$emid;
	$serial    = 'serial'.date("YmdHis");

     // $arr = array(array('emid'=>$emid,'identifier'=>$trackno));
     //                  $list["data"]=$arr; 

				 //    header('Content-Type: application/json');
				 //    echo json_encode($list);


	if(empty($emid)){    

		echo 'Please Input weight ';       

	}else{

		$getInfo = $this->employee_model->GetBasic($emid);
		$users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
		$loc = $getInfo->em_region.' - '.$getInfo->em_branch;

		$word = 'DS';
		if(strpos($tracknos, $word) === false ){
			$weight = $this->input->post('weight');

			$info = $this->employee_model->GetBasic($emid);
			$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
			$location= ' - '.$info->em_branch;
			$location2= ' - '.$info->em_branch;


			$serial = $this->input->post('serial');
			if(!empty($serial)){


				$getbarcode =  $this->unregistered_model->check_events_serial($serial);
				if(!empty(@$getbarcode)){

					$o_region = $info->em_region;
					$o_branch = $info->em_branch;

					$source = $this->employee_model->get_code_source($o_region);
					$dest = $this->employee_model->get_code_dest($region);

       	   $year = date("y");//getbagnumber
                //$number = $this->getbagnumber(); 
       	   $number = $this->getbagnumber_branch($o_branch);

       	   $bagsNo = 'EMS-BAG'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ';

       	   if($bagss == 'New Bag'){



       	   	$bag = array();
       	   	$bag = array('bag_number'=>$bagsNo,'bag_weight'=>$weight,
       	   		'service_type'=>'EMS','bag_region_from'=>$o_region,'bag_branch_from'=>$o_branch,'bag_created_by'=>$emid);
       	   	$this->Box_Application_model->save_bag($bag);

       	   	$bag = array();
       	   	$bag = array('bag_region'=>$region,'bag_branch'=>$branch);
       	   	$this->Box_Application_model->update_bag($bag,$bagsNo);







       	   	foreach ($getbarcode as $key => $value) {

       	   		$Barcode = $value->track_no;
       		 //update transaction
       	   		$data = array();
       	   		$data = array('isBagNo'=>$bagsNo,'bag_status'=>'isBag');
       	   		$this->Box_Application_model->update_back_office_Barcode($Barcode,$data);



       	   		$db='sender_info';
       	   		$senderinfo = $this->unregistered_model->get_senderinfo_barcode($db,$Barcode);

       	   		$track_number=$senderinfo->track_number;

       	   		$event = "Sorting Facility";
       	   		$location ='Received Sorting Facility '.$location2;
       	   		$data21 = array();
       	   		$data21 = array('track_no'=>@$track_number,'location'=>$location,'user'=>@$users,'event'=>$event);

       	   		$this->Box_Application_model->save_location($data21);

       	   		$event = "Sorting Facility";
       	   		$location ='Ready for Transit '.$location2;
       	   		$data2 = array();
       	   		$data2 = array('track_no'=>@$track_number,'location'=>$location,'user'=>@$users,'event'=>$event);

       	   		$this->Box_Application_model->save_location($data2);


       	   		$smobile =@$senderinfo->s_mobile;
       	   		$rmobile =@$senderinfo->mobile;
       	   		$stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umesafirishwa '.'kutoka '.$getInfo->em_region.' - '.$getInfo->em_branch;
       	   		$this->Sms_model->send_sms_trick($smobile,$stotal);
       	   		$this->Sms_model->send_sms_trick($rmobile,$stotal);




          		// code...
       	   	}

       	   	echo 'Successful Bag Closed ';

       	   }else{
       		//

       		//get Bag by bag id
       	   	$getbaginfo = $this->Box_Application_model->get_bag_by_id($bagss);

       	   	$bagsNo = @$getbaginfo->bag_number;

       	   	$bag = array();
       	   	$bag = array('bag_weight'=>$weight);
       	   	$this->Box_Application_model->update_bag($bag,$bagsNo);

       	   	foreach ($getbarcode as $key => $value) {

       	   		$Barcode = $value->track_no;
       		 //update transaction
       	   		$data = array();
       	   		$data = array('isBagNo'=>$bagsNo,'bag_status'=>'isBag');
       	   		$this->Box_Application_model->update_back_office_Barcode($Barcode,$data);


       	   		$db='sender_info';
       	   		$senderinfo = $this->unregistered_model->get_senderinfo_barcode($db,$Barcode);

       	   		$track_number=$senderinfo->track_number;

       	   		$location ='Ready for Transit '.$location2;
       	   		$checkrepeate=$this->unregistered_model->repeate_tracknumber_location($Barcode,$track_number,$location);
       	   		if(empty($checkrepeate)){

       	   			$event = "Sorting Facility";
       	   			$location ='Received Sorting Facility '.$location2;
       	   			$data21 = array();
       	   			$data21 = array('track_no'=>@$track_number,'location'=>$location,'user'=>@$users,'event'=>$event);

       	   			$this->Box_Application_model->save_location($data21);

       	   			$event = "Sorting Facility";
       	   			$location ='Ready for Transit '.$location2;
       	   			$data2 = array();
       	   			$data2 = array('track_no'=>@$track_number,'location'=>$location,'user'=>@$users,'event'=>$event);

       	   			$this->Box_Application_model->save_location($data2);

       	   			$smobile =@$senderinfo->s_mobile;
       	   			$rmobile =@$senderinfo->mobile;
       	   			$stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umesafirishwa '.'kutoka '.$getInfo->em_region.' - '.$getInfo->em_branch;
       	   			$this->Sms_model->send_sms_trick($smobile,$stotal);
       	   			$this->Sms_model->send_sms_trick($rmobile,$stotal);



       	   		}




          		// code...
       	   	}

       	   	echo 'Successful Bag Closed ';



       	   }

       	}
       else{//register

       	$db='sender_person_info';
       	$senderperson = $this->unregistered_model->get_senderperson($db,$trackno);
          	  if(!empty(@$senderperson))//which table
          	  {

          	  	$service_type= 'MAIL';
          	  	$sender_id=@$senderperson->senderp_id;

          	  	$checkReassigned = $this->Box_Application_model->check_reassign($sender_id,$operator);

          	  	if(!empty($checkReassigned)){

          	  		$data = array();
          	  		$data = array(
          	  			'em_id'=>$operator,
          	  			'item_id'=>$sender_id,
          	  			'serial'=>$serial,
          	  			'service_type'=>$service_type
          	  		);
          	  		$this->Box_Application_model->update_delivery_info($data,$sender_id);

          	  	}else{

          	  		$data = array();
          	  		$data = array(
          	  			'em_id'=>$operator,
          	  			'item_id'=>$sender_id,
          	  			'serial'=>$serial,
          	  			'service_type'=>$service_type
          	  		);

          	  		$this->Box_Application_model->save_delivery_info($data);


                    $data = array();//update sender status
                    $data = array('sender_status'=>'Assigned');
                    $this->unregistered_model->update_acceptance_sender_person_info($trackno,$data); 


                    echo 'Successful Saved';

                }

            }
        }
    }else{
    	echo 'Failed';
    }
}
}
}

public function updateoutstanding()
{
	if ($this->session->userdata('user_login_access') != False) {
		$year = $this->input->post('yearss');
		$serial = $this->input->post('serial');
		$id = $this->input->post('id');

		$update = array(); 
		$update = array(
			'year'=>$year
		);
		$status= $this->Box_Application_model->update_outstanding($update,$id);
	  //$status= $this->Box_Application_model->update_outstandings($year,$serial);
	  //echo $status.' hii';

		redirect($this->agent->referrer());
	}else{
		redirect(base_url(), 'refresh');
	}

}	    




public function Box_Application_List()
{
	if ($this->session->userdata('user_login_access') != False) {

		$id = $this->session->userdata('user_login_id');
		$info = $this->employee_model->GetBasic($id);
		$region =$info->em_region;
		$branch = $info->em_branch;
		$o_region = $this->session->userdata('user_region');

		if($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER')
		{
			$data2['region'] = $this->employee_model->regselect();

			$data2['box_renters'] =$list = $this->Box_Application_model->get_box_listAdmins($region);


         /*  foreach ($list as $value)
           {
            $box =  $this->Box_Application_model->box_status($value->details_cust_id);
            $data2['boxlist'] = $box;

        }*/



        $this->load->view('box/box_application_admin',@$data2);
    }
    else
    {
    	$data2['box_renters'] = $this->Box_Application_model->get_box_listt();
			//$this->load->view('box/box_application_list',$data2);
    	$this->load->view('box/box_application_admin',@$data2);


    }
//$data['regionlist'] = $this->employee_model->regselect();

//$data['box_numbers'] = $this->Box_Application_model->get_box_numbers();

}else{
	redirect(base_url(), 'refresh');
}

}



public function Virtual_Box_Application_List()
{
	if ($this->session->userdata('user_login_access') != False) {

		$id = $this->session->userdata('user_login_id');
		$info = $this->employee_model->GetBasic($id);
		$region =$info->em_region;
		$branch = $info->em_branch;
		$o_region = $this->session->userdata('user_region');

		if($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER')
		{
			$data2['region'] = $this->employee_model->regselect();
			$data2['box_renters'] =$list = $this->Box_Application_model->get_virtual_box_listAdmins($region);
			$this->load->view('box/box_application_virtual',@$data2);
		}
		else
		{
			$data2['box_renters'] = $this->Box_Application_model->virtual_get_box_listt();
			$this->load->view('box/box_application_virtual',@$data2);

		}

	}else{
		redirect(base_url(), 'refresh');
	}

}

public function Box_Application_Search()
{
	if ($this->session->userdata('user_login_access') != False) {
		$id = $this->session->userdata('user_login_id');
		$info = $this->employee_model->GetBasic($id);
		$region2 =$info->em_region;
		$branch = $info->em_branch;


		$o_region = $this->session->userdata('user_region');


		$date = $this->input->post('date');
		$month= $this->input->post('month');
		$region= $this->input->post('region');
		$data2['region'] = $this->employee_model->regselect();

		if (!empty($region) ) {
			$data2['box_renters'] = $this->Box_Application_model->get_box_listsAdmin($region,$month,$date);
		} else 
		{
			$data2['box_renters'] = $this->Box_Application_model->get_box_listsAdmin($region2,$month,$date);

		}
		$data2['region'] = $this->employee_model->regselect();

//$data['box_numbers'] = $this->Box_Application_model->get_box_numbers();
		$this->load->view('box/box_application_admin',$data2);
	}else{
		redirect(base_url(), 'refresh');
	}

}

public function Virtual_Box_Application_Search()
{
	if ($this->session->userdata('user_login_access') != False) {
		$id = $this->session->userdata('user_login_id');
		$info = $this->employee_model->GetBasic($id);
		$region2 =$info->em_region;
		$branch = $info->em_branch;


		$o_region = $this->session->userdata('user_region');


		$date = $this->input->post('date');
		$month= $this->input->post('month');
		$region= $this->input->post('region');
		$data2['region'] = $this->employee_model->regselect();

		if (!empty($region) ) {
			$data2['box_renters'] = $this->Box_Application_model->virtual_get_box_listsAdmin($region,$month,$date);
		} else 
		{
			$data2['box_renters'] = $this->Box_Application_model->virtual_get_box_listsAdmin($region2,$month,$date);

		}
		$data2['region'] = $this->employee_model->regselect();

//$data['box_numbers'] = $this->Box_Application_model->get_box_numbers();
		$this->load->view('box/box_application_virtual',$data2);
	}else{
		redirect(base_url(), 'refresh');
	}

}


public function Box_Application_Invoice()
{
	if ($this->session->userdata('user_login_access') != False) {
		$id = $this->session->userdata('user_login_id');
		$info = $this->employee_model->GetBasic($id);
		$region2 =$info->em_region;
		$branch = $info->em_branch;


		$o_region = $this->session->userdata('user_region');


		$date = $this->input->post('date');
		$month= $this->input->post('month');
		$region= $this->input->post('region');
		$data2['region'] = $this->employee_model->regselect();

		if (!empty($region) ) {
			$data2['box_renters'] = $this->Box_Application_model->get_box_lists_invoice($region,$month,$date);
		} else 
		{
			if($this->session->userdata('user_type') == "ADMIN" ){
				$region2="PHQ";
			}


			$data2['box_renters'] = $this->Box_Application_model->get_box_lists_invoice($region2,$month,$date);



		}
		$data2['region'] = $this->employee_model->regselect();

//$data['box_numbers'] = $this->Box_Application_model->get_box_numbers();
		$this->load->view('box/box_application_invoice',$data2);
	}else{
		redirect(base_url(), 'refresh');
	}

}//

public function invoice_box()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$id = base64_decode($this->input->get('I'));

		$data['inforperson'] =$inforperson= $this->Box_Application_model->get_box_list_perperson2($id);
		$data['payment'] = $this->Box_Application_model->get_box_invoice($id);

		$data['invoice'] = rand(10000,20000);

		$sender_branch = $this->session->userdata('user_branch');
		$sender_region = $this->session->userdata('user_region');

//$this->load->view('box/box_invoice',$data)


		$this->load->library('Pdf');
		$html= $this->load->view('box/box_invoice',$data,TRUE);
 //$this->load->library('Pdf');
		$this->dompdf->loadHtml($html);
		$this->dompdf->setPaper('A4','potrait');
		$this->dompdf->render();
		ob_end_clean();
		$this->dompdf->stream($inforperson->cust_name, array("Attachment"=>0));

	}
	else{
		redirect(base_url());
	}
}

public function Get_Box_Invoice()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$cust_name = $this->input->post('cust_name');
		$box_tariff_category = $this->input->post('box_tariff_category');
		$box_number = $this->input->post('box_number');
		$box_type = $this->input->post('box_type');
		$CurrentValidity = $this->input->post('CurrentValidity');
		$RenewPeriod = $this->input->post('RenewPeriod');
		$tillPeriod = $this->input->post('tillPeriod');

		$price = $this->input->post('price');
	  //$data['vat'] =$vat = $this->input->post('vat');
	  //$vat = $price * 0.18;
		$data['sender_region'] = $this->session->userdata('user_region');


		$data123 = [];
		if(!empty($cust_name)){
			foreach(@$cust_name as $key => $value) {

				$custname=$value;
				$box_tariff_categorys =$box_tariff_category[$key];
				$box_numbers =$box_number[$key];
				$box_types =$box_type[$key];
				$CurrentValiditys =$CurrentValidity[$key];
				$RenewPeriods =$RenewPeriod[$key];
				$tillPeriods =$tillPeriod[$key];
				$prices =$price[$key];
				$vats =$prices * 0.18;

				$data123[] = array (
					'cust_name' => $custname,
					'box_tariff_category' => $box_tariff_categorys,
					'box_number' => $box_numbers,
					'box_type' => $box_types,
					'CurrentValidity' => $CurrentValiditys,
					'RenewPeriod' => $RenewPeriods,
					'tillPeriod' => $tillPeriods,
					'price' => $prices,
					'vat' => $vats	);
			}
		}
				//echo json_encode($data123);

		$data['details'] = $data123;

		if(empty($cust_name)){
			$this->load->view('box/Get_box_invoice',$data);

		}else{
	 	//$this->load->view('box/Print_box_invoice',$data);

			$this->load->library('Pdf');
			$html= $this->load->view('box/Print_box_invoice',$data,TRUE);
		 //$this->load->library('Pdf');
			$this->dompdf->loadHtml($html);
			$this->dompdf->setPaper('A4','potrait');
			$this->dompdf->render();
			ob_end_clean();
			$this->dompdf->stream('Boxinvoice.pdf', array("Attachment"=>0));

		}





	}
	else{
		redirect(base_url());
	}
}

public function box_rental_app_report(){
	if ($this->session->userdata('user_login_access') != false){
		$data['design'] = $this->employee_model->getdesignation();
		$this->load->view('box/box_rental_app_report',$data);
	}
	else{
		redirect(base_url());
	}
}

public function box_rental_app_report_results(){
	if ($this->session->userdata('user_login_access') != false){
		$fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
		$todate =  date("Y-m-d",strtotime($this->input->post('todate')));
		$status =  $this->input->post('status');

		if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
			redirect('Box_Application/box_rental_app_report');
		}

		$data['design'] = $this->employee_model->getdesignation();
		$data['fromdate'] = $fromdate;
		$data['todate'] = $todate;
		$data['status'] = $status;

		$results = $this->Box_Application_model->get_box_rental_box_application($fromdate,$todate,$status);
		if($results){
			$data['list'] = $this->Box_Application_model->get_box_rental_box_application($fromdate,$todate,$status);
			$this->load->view('box/box_rental_app_report',$data);
		}
		else{
			$this->session->set_flashdata('message','Transcation not found, Please try again!');
			redirect("Box_Application/box_rental_app_report");
		}

	}
	else{
		redirect(base_url());
	}
}

public function Get_ems_bags_list_In_ByDate(){
	if ($this->session->userdata('user_login_access') != false){
		$data['ems'] = $this->Box_Application_model->count_ems();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['bags'] = $this->Box_Application_model->count_bags();

		$bagdate = date('Y-m-d',strtotime($this->input->get('bagdate')));
		$regionfrom = $this->session->userdata('user_region');

		$userid = $this->session->userdata('user_login_id');

		if ($this->session->userdata('user_type') == 'ADMIN') {
			$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list_in_per_date($bagdate);
		}else{
			$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list_in_per_date_byuser($bagdate,$userid);

			//$data['emsbags'] = $this->Box_Application_model->get_ems_bags_listByUser($userid);
		}

		$this->load->view('ems/ems_bags_list_search',$data);	
	}
}

public function Get_ems_despatch_bags_list_In_ByDate(){

	if ($this->session->userdata('user_login_access') != false){
		$data['ems'] = $this->Box_Application_model->count_ems();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['bags'] = $this->Box_Application_model->count_bags();

		$bagdate = date('Y-m-d',strtotime($this->input->get('bagdate')));
		$regionfrom = $this->session->userdata('user_region');
		$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list_in_per_date($bagdate);
		$this->load->view('ems/ems_despatch_bag_list',$data);


	}
}


public function Get_ems_transfered_items_In_ByDate()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$data['ems'] = $this->Box_Application_model->count_ems();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['bags'] = $this->Box_Application_model->count_bags();

		$tdate = date('Y-m-d',strtotime($this->input->get('tdate')));
	//$year = date('Y',strtotime($date));
	//$month = date('m',strtotime($date));
	//$day = date('Y-m-d',strtotime($date));
		$regionfrom = $this->session->userdata('user_region');
		$data['emslist1'] = $this->Box_Application_model->get_ems_transfered_items_in_per_date($tdate);
		$this->load->view('ems/items_transfered_search',$data);


	}
}


public function Box_Information()
{
	if ($this->session->userdata('user_login_access') != False) {

		$id = base64_decode($this->input->get('I'));

		$data['inforperson'] = $this->Box_Application_model->get_box_list_perperson($id);
		$data['paymentlist'] = $this->Box_Application_model->get_box_payment_list_perperson($id);
		$data['Outstanding'] = $this->Box_Application_model->get_box_outstanding_list_perperson($id);
		$this->load->view('box/box_information',$data);
	}else{
		redirect(base_url(), 'refresh');
	}

}


public function Box_Informationprint()
{
	if ($this->session->userdata('user_login_access') != False) {

		$id = base64_decode($this->input->get('I'));

		$data['inforperson']=$inforperson = $this->Box_Application_model->get_box_list_perperson($id);
		$data['paymentlist'] = $this->Box_Application_model->get_box_payment_list_perperson($id);
		$data['Outstanding'] = $this->Box_Application_model->get_box_outstanding_list_perperson($id);
//$this->load->view('box/box_information',$data);

		$this->load->library('Pdf');
		$html= $this->load->view('box/Box_Informationprint',$data,TRUE);
		$this->dompdf->loadHtml($html);
		$this->dompdf->setPaper('A4','potrait');
		$this->dompdf->render();
		ob_end_clean();
		$this->dompdf->stream($inforperson->cust_name, array("Attachment"=>0));



	}else{
		redirect(base_url(), 'refresh');
	}

}

public function Virtual_Box_Information()
{
	if ($this->session->userdata('user_login_access') != False) {

		$id = base64_decode($this->input->get('I'));

		$data['inforperson'] = $this->Box_Application_model->get_virtual_box_list_perperson($id);
		$data['paymentlist'] = $this->Box_Application_model->get_virtual_box_payment_list_perperson($id);
		$this->load->view('box/virtual_box_information',$data);
	}else{
		redirect(base_url(), 'refresh');
	}

}

public function Gotobox()
{
	if ($this->session->userdata('user_login_access') != False) {

		$boxnumber = $this->input->post('box_numbersearch');
		$region = $this->input->post('region');
//getBox
		$box = $this->Box_Application_model->get_box_rental23($boxnumber,$region);
		if(!empty($box)){
			$details_cust_id = $box->reff_cust_id;
			$I=base64_encode($details_cust_id);
			redirect(base_url('Box_Application/Box_Information?I='.$I));

		}else{
			$this->session->set_flashdata('infor','The Box number is not available in the system, Please register it');
			redirect($this->agent->referrer());}

		}else{
			redirect(base_url(), 'refresh');
		}

	}


	public function Updateboxtransactionlocation()
	{
		if ($this->session->userdata('user_login_access') != False) {

			$billid = $this->input->post('billid');
//getBox
			$box = $this->Box_Application_model->update_box_transaction_location($billid);
			echo $box;
			if(!empty($billid)){
				$this->session->set_flashdata('infor2','The Transaction Updated Successfully');
				redirect($this->agent->referrer());

			}else{
				$this->session->set_flashdata('infor2','The Transaction is not available');
				redirect($this->agent->referrer());}

			}else{
				redirect(base_url(), 'refresh');
			}

		}

		public function UpdateBoxFull()
		{
			if ($this->session->userdata('user_login_access') != False) {

				$box_id = $this->input->post('box_number');
				$cust_id = $this->input->post('cust_id');
				$region = $this->input->post('region');
				$branch = $this->input->post('branch');


				$box = array();
				$box = array('box_number'=>$box_id,'box_status'=>'Occupied','reff_cust_id'=>$cust_id,'region'=>$region,'branch'=>$branch);
				$this->Box_Application_model->save_box_number($box);

//$data['box_numbers'] = $this->Box_Application_model->update_box_numbers($box,$box_id);

				echo "Successfully Update";
			}else{
				redirect(base_url(), 'refresh');
			}

		}
		public function Add_Box_Number()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				$data['region'] = $this->employee_model->regselect();
				$data['emslist'] = base64_decode($this->input->get('I'));
				$data['box_numbers'] = $this->Box_Application_model->get_box_numbers();
				$this->load->view('box/add_box_number',$data);
			}
			else{
				redirect(base_url());
			}
		}
		public function RenewalBox()
		{
			if ($this->session->userdata('user_login_access') != False) {

//$cust_id = base64_decode($this->input->get('I'));
				$cust_ids = $this->input->post('cust_id');
				$cust_id = base64_decode($cust_ids);



				$box = $this->Box_Application_model->get_customer_info($cust_id);
				$serial    = 'PBOX'.date("YmdHis");
				$price = $box->price;
				$renter = $box->box_tariff_category;
				$vat = floor($price * 0.18);
				$total1 = $vat + $price;

				$data = array(

					'transactiondate'=>date("Y-m-d"),
					'serial'=>$serial,
					'paidamount'=>$total1,
					'CustomerID'=>$cust_id,
					'Customer_mobile'=>$box->mobile,
					'region'=>$box->region,
					'district'=>$box->district,
					'transactionstatus'=>'POSTED',
					'bill_status'=>'PENDING',
					'paymentFor'=>'POSTSBOX'

				);

				$this->Box_Application_model->save_transactions($data);






				$id= $box->id;
// $data1 = array();
// $data1 = array(

// 	'status'=>'OldPaid'

// );
// $this->Box_Application_model->update_old_transactions($data1,$id);

//add outstanding
				$lastoutstanding=$this->Box_Application_model->get_box_outstanding_last_perperson($cust_id);
//new outstanding
				$id = $this->session->userdata('user_login_id');
				$info = $this->employee_model->GetBasic($id);
				$o_region = $info->em_region;
				$year = (int)$lastoutstanding->year + 1;
				$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;

				$Outstanding1 = array();
				$Outstanding1 = array('amount'=>$total1,'year'=>$year,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);

				$this->Box_Application_model->save_Outstanding($Outstanding1);



				$paidamount = $total1;
				$district   = $box->district;
				$region     = $box->region;
				$mobile     = $box->mobile;
				$renter     = $box->box_tariff_category;
				$serviceId = 'POSTBOX';

				$transaction = $this->getBillGepgBillId($serial, $paidamount,$district,$region,$mobile,$renter,$serviceId);

				$serial1 = $transaction->billid;
				$update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
				$this->Box_Application_model->update_transactions($update,$serial1);


				$price = @$box->price;
				$renter = @$box->box_tariff_category;
				$vat = floor($price * 0.18);
				$total1 = $vat + $price;

				$total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$transaction->controlno.' Kwaajili ya huduma ya RENTER BOX,Kiasi unachotakiwa kulipia ni TSH.'.number_format($total1,2);

				$servicename="Renew Box";
				$this->Sms_model->send_sms_trick3($mobile,$total,$servicename);
				$data['total'] ='The amount to be paid for RENTER BOX is '. ' '.number_format($price,2).'  and VAT to be paid is'.' '. number_format($vat,2).'  The TOTAL amount is '.' '.number_format($total1,2).
				' Pay through this control number'.' '.@$transaction->controlno ;
//$this->load->view('box/renewalbox',$data);
//redirect($this->agent->referrer());
 //redirect(base_url('Box_Application/Box_Information?I='.$cust_ids));

				echo $total;


			}else{
				redirect(base_url(), 'refresh');
			}

		}

		public function Auto_sms(){
			if(!$this->input->is_cli_request())
			{
				echo "This script can only be accessed via the command line" . PHP_EOL;
				return;
			     //* * * * * wget http://192.168.33.3:88/Box_Application/Auto_sms
			      //* * * * * /usr/bin/php /var/www/pmis.posta.co.tz/public_html/index.php Box_Application Auto_sms
			}
			$servicename="Renew Box";
		         $renewsms= $this->Sms_model->get_sms_unsent();//get_sms_byservice($servicename);
		         foreach ($renewsms as $key => $value) {
		              //send sms
		         	$mobile = $value->MobileNumber;
		         	$sms =$value->message;
		         	$id=$value->id;
		         	$data =$this->Sms_model->send_sms_success($mobile,$sms,$id);
		               //update
		               //$this->Sms_model->Update_sms($id);


		         }



		     }

		     public function GetBulk()
		     {
        #Redirect to Admin dashboard after authentication
		     	if ($this->session->userdata('user_login_access') == 1)
		     	{

		     		$serial = $this->input->post('serial');
		     		$list = $this->Box_Application_model->get_ems_bulk_list($serial);




		     		if (empty($list)) {
		     			echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
		     			<tr><th>Ems Type</th><th>Ems Tariff Category: </th><th>Weight Step in KG</th></tr>
		     			<tr><td colspan='3'>Not available</td></tr>
		     			</table>";

		     		}else{
                //echo json_encode($list);
		     			echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
		     			<tr><th>Ems Type</th><th>Ems Tariff Category: </th><th>Weight Step in KG</th></tr>";
		     			$rows ="";

		     			foreach ($list as $value) {

		     				$rows1 = "<tr><td>".$value->ems_type."</td><td>".$value->cat_type."</td><td>".$value->weight."</td>";

		     				$rows =$rows.$rows1;
		     			}
		     			echo $rows;

		     			echo  "<tr><td></td><td></td><td></td></tr></table> ";


		     		}
		     	}

		     }



		     public function Ems()
		     {
		     	if ($this->session->userdata('user_login_access') != false){

		     		if($this->session->userdata('status') == "NotEnded" && $this->session->userdata('user_type') == "EMPLOYEE"){

		     			$data['total'] = $this->Box_Application_model->get_ems_sum();
		     			$data['emslist'] = $this->Box_Application_model->get_ems_list_pending();
		     			$data['region'] = $this->employee_model->regselect();
		     			$this->load->view('billing/ems_application_list',$data);

		     		}else{

		     			$data['region'] = $this->employee_model->regselect();
	//$data['ems_type'] = $this->Box_Application_model->ems_type();
		     			$data['ems_cat'] = $this->Box_Application_model->ems_cat();
		     			$data['region'] = $this->employee_model->regselect();
		     			$this->load->view('billing/ems_application_form',$data);
		     		}
		     	}
		     	else{
		     		redirect(base_url());
		     	}
		     }
		     public function Send()
		     {
		     	if ($this->session->userdata('user_login_access') != false)
		     	{
		     		$data['AskFor'] = $AskFor = $this->input->get('AskFor');
		     		$this->session->set_userdata('askfor',$AskFor);

		     		$data['region'] = $this->employee_model->regselect();
		     		$data['ems_cat'] = $this->Box_Application_model->ems_cat();
		     		$data['I'] = base64_decode($this->input->get('I'));
		     		$data['acc_no'] = $this->input->get('acc_no');
		     		$this->load->view('billing/ems_application_form_send',$data);
		     	}
		     	else{
		     		redirect(base_url());
		     	}
		     }

		     public function Ems_Application_Pending_Supervisor()
		     {
		     	if ($this->session->userdata('user_login_access') != false)
		     	{
		     		$emid = base64_decode($this->input->get('I'));
		     		$data['info'] = $this->ContractModel->get_employee_info($emid);
		     		$data['emcode'] = $this->session->set_userdata('getpfno',$data['info']->em_code);
		     		$data['empid'] = $this->session->set_userdata('getempid',$emid);
		     		$this->load->view('domestic_ems/track_emp_report_dashboard',@$data);
		     	}
		     	else{
		     		redirect(base_url());
		     	}
		     }


		     public function Ems_application_sent()
		     {
		     	if ($this->session->userdata('user_login_access') != false){

		     		$emid = base64_decode($this->input->get('I'));
		     		$data['region'] = $this->employee_model->regselect();
		     		$data['emselect'] = $this->employee_model->emselect();
		     		$data['agselect'] = $this->employee_model->agselect();

		     		if ($this->session->userdata('user_type') == "ACCOUNTANT-HQ" || $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' || $this->session->userdata('user_type') == "BOP") {

		     			$date = $this->input->post('date');
		     			$date2 = $this->input->post('date2');
		     			$month = $this->input->post('month');
		     			$month = $this->input->post('month');
		     			$month2 = $this->input->post('month2');
		     			$year4 = $this->input->post('year');
		     			$region = $this->input->post('region');
		     			$type = $this->input->post('ems_type');
		     			if(empty($region))
		     			{
		     				$region = 'Dar es salaam';
		     				$type  = 'EMS';

		     			}

		     			$data['total'] = $this->Box_Application_model->get_ems_sumACC($region,$date,$date2,$month,$month2,$year4,$type);
		     			$data['emslist'] = $this->Box_Application_model->get_ems_listAcc($region,$date,$date2,$month,$month2,$year4,$type);

		     		} else {

		     			$date = $this->input->post('date');
		     			$month = $this->input->post('month');

		     			if (!empty($date) || !empty($month)) {
		     				$data['total'] = $this->Box_Application_model->get_ems_sumSearch_sent($date,$month);
		     				$data['emslist'] = $this->Box_Application_model->get_ems_listSearch_sent($date,$month);
		     			} else {
		     				$data['total'] = $this->Box_Application_model->get_ems_sum_sent();
		     				$data['emslist'] = $this->Box_Application_model->get_ems_list_sent();
		     			}
		     		}   

		     		$this->load->view('domestic_ems/ems_application_sent',$data);

		     	}
		     	else{
		     		redirect(base_url());
		     	}

		     }


		     public function GetEmployee(){

		     	$brandname = $this->input->post('brandname',TRUE);  
      //run the query for the cities we specified earlier  
		     	echo $this->Box_Application_model->GeEmployeeByBranch($brandname);
		     }


		     public function Ems_application_admin()
		     {
		     	if ($this->session->userdata('user_login_access') != false){

		     		$emid = base64_decode($this->input->get('I'));
		     		$data['region'] = $this->employee_model->regselect();
		     		$data['emselect'] = $this->employee_model->emselect();
		     		$data['agselect'] = $this->employee_model->agselect();

		     		if ($this->session->userdata('user_type') == "ACCOUNTANT-HQ" || $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' || $this->session->userdata('user_type') == "BOP") {


		     			$date2 = $this->input->post('date2');
		     			$month2 = $this->input->post('month2');
		     			$year4 = $this->input->post('year');
		     			$region = $this->input->post('region');
		     			$type = $this->input->post('ems_type');


		     			$month = $this->input->post('month');
		     			$date = $this->input->post('date');
		     			$region = $this->input->post('region');
		     			$branch = $this->input->post('branch');
		     			$empcode = $this->input->post('empcode');
		     			if(empty($region))
		     			{
		     				$region = 'Dar es salaam';
		     				$type  = 'EMS';

        }  //$region,$date,$date2,$month,$month2,$year4,$type

        $data['total'] = $this->Box_Application_model->get_ems_sumAdmin($branch,$date,$month,$type,$empcode,$date2,$month2,$year4);
        $data['emslist'] = $this->Box_Application_model->get_ems_listAdmin($branch,$date,$month,$type,$empcode,$date2,$month2,$year4);

    } else {

    	$date = $this->input->post('date');
    	$month = $this->input->post('month');

    	if (!empty($date) || !empty($month)) {
    		$data['total'] = $this->Box_Application_model->get_ems_sumSearch_sent($date,$month);
    		$data['emslist'] = $this->Box_Application_model->get_ems_listSearch_sent($date,$month);
    	} else {
    		$data['total'] = $this->Box_Application_model->get_ems_sum_sent();
    		$data['emslist'] = $this->Box_Application_model->get_ems_list_sent();
    	}
    }   
    
    $this->load->view('domestic_ems/ems_application_admin',$data);

}
else{
	redirect(base_url());
}

}


public function getAssignedDeliveryItems(){
	if ($this->session->userdata('user_login_access') != false){
		$fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');

		$response  = array();
		$payload  = array();

		if (!empty($fromdate) && !empty($todate)) {
			$list = $this->Box_Application_model->getWaitingForDelivery($fromdate,$todate);

			if ($list) {
				$count = 1;
				
				$completed = 0;
				$pending = 1;

				foreach ($list as $key => $value) {
					$sn = $count++;

					$fromdata  = $this->Box_Application_model->GetBasic($value['empid']);

					$new[$value['empid']]['fullname']  = $fromdata->first_name.' '.$fromdata->middle_name.' '.$fromdata->last_name;
					$new[$value['empid']]['em_region']  = $fromdata->em_region;
					$new[$value['empid']]['em_branch']  = $fromdata->em_branch;
					$new[$value['empid']]['completed']  = $value['completed'];
					$new[$value['empid']]['pending'] = $value['pending'];
					$new[$value['empid']]['fromdate'] = $fromdate;
					$new[$value['empid']]['todate'] = $todate;
					$new[$value['empid']]['empid'] = $value['empid'];
					//$new[$value['empid']]['total'] = (int)$value['pending'] + (int)$value['completed']

				}
				

				$response['status'] = 'Success';
				$response['msg'] = $new;

			}else{
				$response['status'] = 'Error';
				$response['msg'] = 'No data';
			}

			
		}else{
			$response['status'] = 'Error';
			$response['msg'] = 'Specify from and to date';
		}

		print_r(json_encode($response));		
	}else{
		redirect(base_url());
	}
}





public function Receive_scanned_item()
{
	if ($this->session->userdata('user_login_access') != false){

		$emid = base64_decode($this->input->get('I'));
		$data['region'] = $this->employee_model->regselect();
		$data['emselect'] = $this->employee_model->delivereselect();
		$data['agselect'] = $this->employee_model->agselect();

		$data['emslist1'] = $this->Box_Application_model->get_ems_back_list();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['ems'] = $this->Box_Application_model->count_ems();


		$data['bags'] = $this->Box_Application_model->count_bags();



		$this->load->view('domestic_ems/Receive_scanned_item',$data);

	}
	else{
		redirect(base_url());
	}

}

public function passTodelivery(){
	if ($this->session->userdata('user_login_access') != false){
		$data['fromsection'] = isset($_GET['from']);
		$data['region'] = $this->employee_model->regselect();
		$data['emselect'] = $this->employee_model->delivereselect();
		$data['agselect'] = $this->employee_model->agselect();

		$data['emslist1'] = $this->Box_Application_model->get_ems_back_list();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['ems'] = $this->Box_Application_model->count_ems();

		$data['bags'] = $this->Box_Application_model->count_bags();


		$this->load->view('domestic_ems/pass_to_delivery',$data);
	}else{
		redirect(base_url());
	}
}

public function getOperatorPendingDelivering(){
	if ($this->session->userdata('user_login_access') != false){
		$operator = $this->input->post('operator');
		$assignedby = $this->session->userdata('user_login_id');

		
		if ($operator) {
			$delivery = $this->Box_Application_model->checkPendingDeliveryItems($operator,$assignedby);

			if ($delivery) {
				$count = 1;
				foreach ($delivery as $key => $value) {
					$sn = $count++;

					echo "<tr class='receiveRow'> <td>".$sn."</td>
					<td>".$value['s_fullname']."</td>
					<td>".$value['fullname']."</td>
					<td>".$value['s_district']."</td>
					<td>".$value['branch']."</td>
					<td>".$value['Barcode']."</td>
					<td><a href='#' 
					data-transid='".$value['id']."'
					data-barcode='".$value['Barcode']."' onclick='removeAssignedItem(this)' 
					class='btn btn-info btn-sm'><i class='fa fa-trash-o'></i> Remove</a></td>
					</tr>";

				}
				
			}else{
				echo "<tr> <td colspan='6'>No data found</td></tr>";
			}
			
		}else{

		}

	}else{
		redirect(base_url());
	}
}

public function delivering(){
	if ($this->session->userdata('user_login_access') != false){
		$assignedby = $this->session->userdata('user_login_id');
		$data['comefrom'] = isset($_GET['comefrom']);
		$data['emselect'] = $this->employee_model->delivereselect();
		$operator = $this->input->post('operator');
		$fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');

		if (!empty($operator) && !empty($fromdate) && !empty($todate)) {

			$data['info'] = $this->ContractModel->get_employee_info($operator);
			$data['info_assignedby'] = $this->ContractModel->get_employee_info($assignedby);
			$data['fromdate'] = $fromdate;
			$data['todate'] = $todate;

			$data['delivering'] = $this->Box_Application_model->checkDeliveringList($operator,$fromdate,$todate,$assignedby);
		}

		$this->load->view('domestic_ems/delivering',$data);
	}else{
		redirect(base_url());
	}
}


public function passToDeliveringProcess(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$operator = $this->input->post('operator');
		$type = $this->input->post('type');
		$sn = $this->input->post('sn');

		$EEMS = $this->Box_Application_model->get_item_ems_for_delivery($barcode);
		
		$response  = array();
		$payload  = array();

		$basicinfo = $this->employee_model->GetBasic($emid);
		$region = $basicinfo->em_region;
		$em_branch = $basicinfo->em_branch;

		if (!empty($EEMS)) {
			
			if (sizeof($EEMS) > 1) {

				$response['status'] = 'Error';
				$response['msg'] = 'This barcode is entered more than one, please check with admin';

				//echo "<tr> <td colspan='6'><h5><strong>".$barcode."</strong> This barcode is entered more than one, please check with admin </h5></td></tr>";
			}else{

				$payload['barcode '] = $EEMS[0]['Barcode'];
				$payload['senderid '] = $EEMS[0]['CustomerID'];
				$payload['empid '] = $operator;//deliver personel
				$payload['wfd_type '] = $type;//'single','pending' for bulk
				$payload['service_type '] = 'ems';
				$payload['assignedby '] = $emid;

				//Try to find if it exist
				$checkBarcode = $this->Box_Application_model->checkDeliveryItems($EEMS[0]['Barcode'],$operatorname="");

				if ($checkBarcode) {
					$response['status'] = 'Error';
					$response['msg'] = $barcode." Barcode it already assigned, check with admin";

					//echo "<tr> <td colspan='6'><h5><strong>".$barcode."</strong> Barcode exist, check with admin</h5></td></tr>";

				}else{

					//$Operatorbasicinfo = $this->employee_model->GetBasic($operator);
					//operatorFull name
					//$OpatorFullName = $Operatorbasicinfo->first_name.' '.$Operatorbasicinfo->middle_name.' '.$Operatorbasicinfo->last_name;

					//'description'=>'Assigned for delivery '.$em_branch.' - ('.$OpatorFullName.')'

					//for tracing
					$trace_data = array(
						'emid'=>$emid,
						'transid'=>$EEMS[0]['id'],
						'office_name'=>'DELIVERY',
						'description'=>'Assigned for delivery '.$em_branch,
						'pass_to'=>$operator,
						'status'=>'Delivery');

					$this->Box_Application_model->tracing($trace_data);

					//for track
					$track_data = array(
						'emid'=>$emid,
						'transid'=>$EEMS[0]['id'],
						'office_name'=>'DELIVERY',
						'description'=>'Delivery',
						'pass_to'=>$operator,
						'type'=>1,
						'status'=>'Delivery');

					//saving the data
					$this->Box_Application_model->save_waiting_for_delivery($payload);

					$response['status'] = 'Success';
					$response['msg'] = "<tr style='background:blue;color:white;'> 
					<td>".$sn."</td>
					<td>".$EEMS[0]['s_fullname']."</td>
					<td>".$EEMS[0]['fullname']."</td>
					<td>".$EEMS[0]['s_district']."</td>
					<td>".$EEMS[0]['branch']."</td>
					<td>".$EEMS[0]['Barcode']."</td>
					<td><a href='#' 
					data-transid='".$EEMS[0]['id']."'
					data-barcode='".$EEMS[0]['Barcode']."' onclick='removeAssignedItem(this)'
					class='btn btn-info btn-sm'><i class='fa fa-trash-o'></i> Remove</a></td></tr>";
				}
			}
			
		}else{
			$response['status'] = 'Error';
			$response['msg'] = 'No data found';

			//echo "<tr> <td colspan='6'><h5>No data found for this barcode <strong>".$barcode."</strong></h5></td></tr>";
		}
		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}

public function removeAssignedItemDelivering(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$operator = $this->input->post('operator');

		if ($barcode) {
			//removing into the database;
			$this->Box_Application_model->delete_waiting_for_delivery($barcode);

			$Operatorbasicinfo = $this->employee_model->GetBasic($operator);
			//operatorFull name
			$OpatorFullName = $Operatorbasicinfo->first_name.' '.$Operatorbasicinfo->middle_name.' '.$Operatorbasicinfo->last_name;

			$OpatorBranch = $Operatorbasicinfo->em_branch;

			//for tracing
			$trace_data = array(
				'emid'=>$emid,
				'transid'=>$transid,
				'office_name'=>'InWard',
				'description'=>'Removed from delivery Personel '.$OpatorBranch.' - ('.$OpatorFullName.')',
				'status'=>'Removed');

			//saving into the trace table
			$this->Box_Application_model->tracing($trace_data);
		}


	}else{
		redirect(base_url());
	}
}

/*public function close_bag_items()
{
if ($this->session->userdata('user_login_access') != false){

$emid = base64_decode($this->input->get('I'));
$data['region'] = $this->employee_model->regselect();
$data['emselect'] = $this->employee_model->delivereselect();
$data['agselect'] = $this->employee_model->agselect();

    $data['emslist1'] = $this->Box_Application_model->get_ems_back_list();
    $data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
    $data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
    $data['ems'] = $this->Box_Application_model->count_ems();


    $data['bags'] = $this->Box_Application_model->count_bags();
    
   
    
    $this->load->view('ems/close_bag_items',$data);

}
else{
redirect(base_url());
}

}*/

public function close_bag_items(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = base64_decode($this->input->get('I'));
		$data['region'] = $this->employee_model->regselect();
		$data['emselect'] = $this->employee_model->delivereselect();
		$data['agselect'] = $this->employee_model->agselect();

		$data['emslist1'] = $this->Box_Application_model->get_ems_back_list();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['ems'] = $this->Box_Application_model->count_ems();


		$data['bags'] = $this->Box_Application_model->count_bags();

		$this->load->view('ems/close_bag_items',$data);
    //$this->load->view('ems/close_bag_items_old',$data);
	}else{
		redirect(base_url());
	}

}

public function Ems_Application_List_Ajax()
{
	$start_date = $this->time = date('Y-m-d H:i:s', strtotime($this->input->post("start_date")));
	$end_date = $this->time = date('Y-m-d H:i:s', strtotime($this->input->post("end_date")));
	$pay_type = $this->input->post('pay_type');
	$region = $this->security->xss_clean($this->input->post('region'));
	$region = $region != "" ? $region : false;

	$total = 0;
	$emslist = $this->Box_Application_model->get_ems_listAcc($start_date, $end_date, $pay_type, $region);

	echo '<table id="Ems_Application_List_Ajax_Table" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">';
	if( ! empty($emslist))
	{
		echo '<tr>';
		if($pay_type == 'Cash') echo '<th>Control Number</th>'; else echo '<th>Addressee</th>';
		echo '<th>Barcode</th>';
		if($pay_type == "Bill") echo '<th>Origin</th>';
		echo '<th>Destination</th>';
		echo '<th>Date</th>';
		echo '<th>Weight</th>';
		echo '<th>Postage (Tsh.)</th>';
		echo '<th>VAT (Tsh.)</th>';
		echo '<th>Total (Tsh.)</th>';
		echo '<th style="text-align: right;">Payment Status</th>';
		echo '</tr>';
		foreach($emslist as $row)
		{
			$total += $row->paidamount;

			echo '<tr>';
			if($pay_type == 'Cash') echo '<td>'.$row->billid.'</td>'; else echo '<td>'.$row->s_fullname.'</td>';
			echo '<td>'.$row->Barcode.'</td>';
			if($pay_type == "Bill") echo '<td>'.$row->region.'</td>';
			echo '<td>'.$row->r_region.'</td>';
			echo '<td>'.$row->paymentdate.'</td>';
			echo '<td>'.$row->weight.'</td>';
			echo '<td>'.$row->postage.'</td>';
			echo '<td>'.$row->vat.'</td>';
			echo '<td>'.$row->paidamount.'</td>';
			echo '<td style="text-align: right;">'.$row->status.'</td>';
			echo '</tr>';
		}
	}
	else
	{
		echo "<tr>
		<td colspan='7'>No Data Found</td>
		</tr>";
	}
	echo "</table>";
}


public function Ems_Application_List()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$emid = base64_decode($this->input->get('I'));
		$data['region'] = $this->employee_model->regselect();
		$data['emselect'] = $this->employee_model->emselect();
		$data['agselect'] = $this->employee_model->agselect();

		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{

			// if ($this->session->userdata('user_type') == "ACCOUNTANT-HQ" || $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' || $this->session->userdata('user_type') == "BOP")
			// {

			$user_type = $this->session->userdata('user_type');

			$start_date = $this->time = date('Y-m-d H:i:s', strtotime($this->input->post("start_date")));

			$end_date = $this->time = date('Y-m-d H:i:s', strtotime($this->input->post("end_date")));

			$pay_type = $this->input->post('pay_type');

			$region = $this->security->xss_clean($this->input->post('region'));
			$region = $region != "" ? $region : false;

			// if(empty($region))
			// {
			// 	$region = 'Dar es salaam';
			// }
			// $data['total'] = $this->Box_Application_model->get_ems_sumACC($region,$date,$date2,$month,$month2,$year4,$type);
				// $data['emslist'] = $this->Box_Application_model->get_ems_listAcc($region,$date,$date2,$month,$month2,$year4,$type);
			
			$emslist = $this->Box_Application_model->get_ems_listAcc($start_date, $end_date, $pay_type, $region);
			$total = 0;
			foreach($emslist as $row)
			{
				$total += $row->paidamount;
			}
			$data['emslist'] = $emslist;
			$data['total'] = $total;				
			$data['pay_type'] = $pay_type;
			// echo '<pre>';
			// echo $user_type.'|'.$start_date.'|'.$end_date.'|'.$pay_type.'|'.$region.'<br>';
			// print_r($emslist);		
			
			// }
			// else
			// {
			// 	$pf = $this->input->post('pf');
			// 	$date = $this->input->post('date');
			// 	$month = $this->input->post('month');

			// 	if(!empty($pf))
			// 	{
			// 		//turn code to emid
			// 		$emid2=$this->Box_Application_model->getemid($pf);
			// 		$emid2=$emid2->em_id;
			// 		if(!empty($emid2))
			// 		{

			// 			if (!empty($date) || !empty($month)) {

			// 				$data['total'] = $this->Box_Application_model->get_ems_sumSearchpf($date,$month,$emid2);
			// 				$data['emslist'] = $this->Box_Application_model->get_ems_listSearchpf($date,$month,$emid2);
			// 			} else {
			// 				$data['total'] = $this->Box_Application_model->get_ems_sum();
			// 				$data['emslist'] = $this->Box_Application_model->get_ems_list();
			// 			}

			// 		} 

			// 	}else{

			// 		if (!empty($date) || !empty($month)) {
			// 			$data['total'] = $this->Box_Application_model->get_ems_sumSearch($date,$month);
			// 			$data['emslist'] = $this->Box_Application_model->get_ems_listSearch($date,$month);
			// 		} else {
			// 			$data['total'] = $this->Box_Application_model->get_ems_sum();
			// 			$data['emslist'] = $this->Box_Application_model->get_ems_list();
			// 		}
			// 	}
			// }
		}
		$this->load->view('domestic_ems/ems_application_list_new', $data, 'refresh');
	}
	else
	{
		redirect(base_url());
	}
}


public function get_zone_sentList(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->input->post('emid');
		$office_name = $this->input->post('office_name');
		$pass_to = $this->session->userdata('user_login_id');
		$return_to = $this->input->post('controller');

		if (!empty($emid)) {

			$emslist = $this->unregistered_model->get_mails_application_list($office_name,$barcode='',$pass_to);

			if ($emslist) {

				$count = 1;
				$temp = '';
				foreach ($emslist as $key => $value) {
					$sn = $count++;

					$temp .="<tr data-emid='".$emid."' data-transid='".$value->t_id."' class='".$value->Barcode." tr".$value->t_id." receiveRow'> <td>".$sn."</td>
					<td>".$value->sender_fullname."</td>
					<td>".$value->receiver_fullname."</td>
					<td>".$value->sender_date_created."</td>
					<td>".$value->sender_branch."</td>
					<td>".$value->reciver_branch."</td>
					<td>".$value->Barcode."</td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value->t_id."' class='form-check-input ".$value->Barcode."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}

				$temp .='<tr><td colspan="7"></td><td style="float: right;">
				<a class="btn btn-success" href="'.base_url().'Services/'.$return_to.'" class="text-white"><i class="" aria-hidden="true"></i> Receive </a>
				</td></tr>';

				$response['status'] = "Success";
				$response['msg'] = $temp;
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "No data";
			}
		}else{
			$response['status'] = "Error";
			$response['msg'] = "No pf number";
		}

		print_r(json_encode($response));

	}else{
		redirect(base_url());
	}
}


public function zone_receive(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$passfrom = $this->input->post('passfrom');
		//$receive_office_name = $this->input->post('office_name');

		if (!empty($barcode) && !empty($transid)) {

			//getting user or staff department section
			$staff_section = $this->employee_model->getEmpDepartmentSections($emid);

			$office_trace_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';
			
			$data = array(
				'office_name'=>$office_trace_name,
				'created_by'=>$emid);

			$this->unregistered_model->update_transactions_data($data,$transid);

			//for tracing
			$trace_data = array(
				'emid'=>$passfrom,
				'trans_type'=>'mails',
				'pass_to'=>$emid,
				'transid'=>$transid,
				'office_name'=>$office_trace_name,
				'status'=>'RECEIVE');

			$this->Box_Application_model->tracing($trace_data);

			$response['status'] = "Success";
			$response['transid'] = $transid;
			$response['barcode'] = $barcode;
			$response['msg'] = "received";

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please specify the fromdate and todate";
		}

		print_r(json_encode($response));

	}else{
		redirect(base_url());
	}
}

public function MailsPassToOperatorByzone(){
	if ($this->session->userdata('user_login_access') != false){
		$barcode = $this->input->post('barcode');
		$operator = $this->input->post('operator');
		$zonetype = $this->input->post('zonetype');
		$sn = $this->input->post('sn');
		$office_name = $this->input->post('office_name');
		//$pass_from = $this->input->post('pass_from');

		$emid = $this->session->userdata('user_login_id');
		//getting staff section
		$staff_section = $this->employee_model->getEmpDepartmentSections($emid);

		if (!empty($barcode) && !empty($emid)) {
			//filter data by using barcode
			$emslist = $this->unregistered_model->get_mails_application_list($office_name,$barcode,$emid_to='');


			if ($emslist) {

			//process of passing
				$data = array(
					'pass_to'=>$operator,
					'office_name'=>$zonetype,
					'pass_from'=>$staff_section[0]['name'],
					'created_by'=>$emid);

				$this->unregistered_model->update_transactions_data($data,$emslist[0]->t_id);


			//for tracing
				$trace_data = array(
					'emid'=>$emid,
					'trans_type'=>'mails',
					'pass_to'=>$operator,
					'transid'=>$emslist[0]->t_id,
					'office_name'=>$zonetype,
					'status'=>'IN');

				$this->Box_Application_model->tracing($trace_data);

				$count = 1;
				$temp = '';
				foreach ($emslist as $key => $value) {
					$sn = (!empty($sn))? $sn:$count++;

					$temp .="<tr data-transid='".$value->t_id."' class='".$value->Barcode." tr".$value->t_id." receiveRow'> <td>".$sn."</td>
					<td>".$value->sender_fullname."</td>
					<td>".$value->receiver_fullname."</td>
					<td>".$value->sender_date_created."</td>
					<td>".$value->paidamount."</td>
					<td>".$value->register_weght."</td>
					<td>".$value->sender_branch."</td>
					<td>".$value->reciver_branch."</td>
					<td>".$value->billid."</td>
					<td>".$value->Barcode."</td>
					<td><a href='#' 
					data-transid='".$value->t_id."'
					data-barcode='".$value->Barcode."' onclick='removeMailsPassedItem(this)' 
					class='btn btn-info btn-sm'><i class='fa fa-trash-o'></i> Remove</a></td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value->t_id."' class='form-check-input ".$value->Barcode."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}

				$response['status'] = "Success";
				$response['msg'] = $temp;
				$response['total'] = sizeof($emslist);
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "Huduma Haijalipiwa";
			}

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please enter barcode";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}


public function getMailsPassedItemsByOperator(){
	if ($this->session->userdata('user_login_access') != false){
		$assignedby = $this->session->userdata('user_login_id');

		$operator = $this->input->post('operator');

		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$fromdate = $date;
		$todate = $date;
		$selected_section = $this->input->post('zonetype');
		$removefunction = $this->input->post('removefunction');
		$forditributer = $this->input->post('forditributer');


		if (!empty($operator) && !empty($fromdate) && !empty($todate)) {

			$listdata  = $this->Box_Application_model->transTracingMaster(
				$transid='',
				$assignedby,
				$operator,
				$office_name=$selected_section,
				$status='IN',$fromdate,$todate,$trans_type='',$type='');


			if ($listdata) {

				$count = 1;
				$temp = '';
				foreach ($listdata as $key => $trace) {
					$sn = $count++;

					$tranDetails  = $this->unregistered_model->transanctionsData($trace['transid']);


					$temp .="<tr data-transid='".$tranDetails[0]['t_id']."' 
					class='".$tranDetails[0]['Barcode']." tr".$tranDetails[0]['t_id']." receiveRow'> <td>".$sn."</td>
					<td>".$tranDetails[0]['sender_fullname']."</td>
					<td>".$tranDetails[0]['receiver_fullname']."</td>
					<td>".$tranDetails[0]['sender_date_created']."</td>";


					if ($forditributer != 'yes') {
						$temp.="<td>".$tranDetails[0]['paidamount']."</td>
						<td>".$tranDetails[0]['register_weght']."</td>";
					}

					$temp.="<td>".$tranDetails[0]['sender_branch']."</td>
					<td>".$tranDetails[0]['reciver_branch']."</td>
					<td>".$tranDetails[0]['billid']."</td>
					<td>".$tranDetails[0]['Barcode']."</td>
					<td><a href='#' 
					data-transid='".$tranDetails[0]['t_id']."'
					data-barcode='".$tranDetails[0]['Barcode']."' onclick='".$removefunction."(this)' 
					class=''><i class='fa fa-trash-o'></i> Remove</a></td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$tranDetails[0]['t_id']."' class='form-check-input ".$tranDetails[0]['Barcode']."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}
            	//removeInWardPassedItem

				$response['status'] = "Success";
				$response['msg'] = $temp;
				$response['total'] = sizeof($listdata);
			}else{
				$response['status'] = "Error";
				$response['msg'] = "Huduma Haijalipiwa";
			}
			print_r(json_encode($response));
		}
	}else{
		redirect(base_url());
	}
}


public function removeMailsPassedItem(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$operator = $this->input->post('operator');
		$return_office = $this->input->post('return_office');

		if ($barcode) {

			//process of passing
			$data = array(
				'pass_to'=>'',
				'office_name'=>$return_office,
				'pass_from'=>'',
				'created_by'=>$emid);

			
			$this->unregistered_model->update_transactions_data($data,$transid);


			$Operatorbasicinfo = $this->employee_model->GetBasic($operator);
			//operatorFull name
			$OpatorFullName = $Operatorbasicinfo->first_name.' '.$Operatorbasicinfo->middle_name.' '.$Operatorbasicinfo->last_name;

			//for tracing
			$trace_data = array(
				'emid'=>$emid,
				'transid'=>$transid,
				'office_name'=>'InWard Mails',
				'description'=>'Deleted by ('.$OpatorFullName.')',
				'status'=>'Removed');

			//saving into the trace table
			$this->Box_Application_model->tracing($trace_data);
		}


	}else{
		redirect(base_url());
	}
}


public function InwardMailsPassToOperatorByzone(){
	if ($this->session->userdata('user_login_access') != false){
		$barcode = $this->input->post('barcode');
		$operator = $this->input->post('operator');
		$zonetype = $this->input->post('zonetype');
		$sn = $this->input->post('sn');

		$emid = $this->session->userdata('user_login_id');

		if (!empty($barcode) && !empty($emid)) {
			//filter data by using barcode
			$emslist = $this->unregistered_model->get_mails_application_list('InWard Open receive',$barcode,$emid_to='');


			if ($emslist) {

			//process of passing
				$data = array(
					'pass_to'=>$operator,
					'office_name'=>$zonetype,
					'pass_from'=>'InWard Open',
					'created_by'=>$emid);

				$this->unregistered_model->update_transactions_data($data,$emslist[0]->t_id);


			//for tracing
				$trace_data = array(
					'emid'=>$emid,
					'pass_to'=>$operator,
					'transid'=>$emslist[0]->t_id,
					'office_name'=>$zonetype,
					'status'=>'IN');

				$this->Box_Application_model->tracing($trace_data);

				$count = 1;
				$temp = '';
				foreach ($emslist as $key => $value) {
					$sn = $count++;

					$temp .="<tr data-transid='".$value->t_id."' class='".$value->Barcode." tr".$value->t_id." receiveRow'> <td>".$sn."</td>
					<td>".$value->sender_fullname."</td>
					<td>".$value->receiver_fullname."</td>
					<td>".$value->sender_date_created."</td>
					<td>".$value->paidamount."</td>
					<td>".$value->register_weght."</td>
					<td>".$value->sender_branch."</td>
					<td>".$value->reciver_branch."</td>
					<td>".$value->billid."</td>
					<td>".$value->Barcode."</td>
					<td><a href='#' 
					data-transid='".$value->t_id."'
					data-barcode='".$value->Barcode."' onclick='removeMailsPassedItem(this)' 
					class='btn btn-info btn-sm'><i class='fa fa-trash-o'></i> Remove</a></td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value->t_id."' class='form-check-input ".$value->Barcode."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}

				// $temp .='<tr><td colspan="11"></td><td style="float: right;">
				// <a class="btn btn-success" href="'.base_url().'Services/Distributer" class="text-white"><i class="" aria-hidden="true"></i> Receive </a>
				// 	</td></tr>';

				$response['status'] = "Success";
				$response['msg'] = $temp;
				$response['total'] = sizeof($emslist);
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "Huduma Haijalipiwa";
			}

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please enter barcode";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}

public function get_em_counter_searchList(){
	if ($this->session->userdata('user_login_access') != false){
		$fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');
		$office_name = 'Counter';

		$emid = $this->session->userdata('user_login_id');

		if (!empty($fromdate) && !empty($todate)) {
			$emslist = $this->Box_Application_model->get_ems_list_SearchData($fromdate,$todate,$barcode='',$office_name,$emid);

			if ($emslist) {

				$count = 1;
				$temp = '';
				foreach ($emslist as $key => $value) {
					$sn = $count++;

					if ($value['s_pay_type'] == 'Cash'){

						if ($value['status'] == 'NotPaid') {
							$pay_status  = "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
						}else{
							$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
						}

					}else{

						$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
					}

					if ($value['s_pay_type'] != 'Cash' && $value['office_name'] == 'Counter'){

						$checkBox = '';
					}else{
						$checkBox = "disabled='disabled' checked";
					}

					$temp .="<tr class='tr".$value['id']."'> <td>".$sn."</td>
					<td>".$value['s_fullname']."</td>
					<td>".$value['fullname']."</td>
					<td>".$value['date_registered']."</td>
					<td>".$value['paidamount']."</td>
					<td>".$value['weight']."</td>
					<td>".$value['s_district']."</td>
					<td>".$value['add_type']."</td>
					<td>".$value['branch']."</td>
					<td>".$value['billid']."</td>
					<td>".$value['Barcode']."</td>
					<td>".$pay_status."</td>;
					<td>".$value['paychannel']."</td>
					<td style='text-align:center;'>
					<div class='form-check'>
					<input type='checkbox' name='transactions' value='".$value['id']."' class='form-check-input' style='padding-right:50px;' ".$checkBox." />
					<label class='form-check-label' for='remember-me'></label>
					</div></td>
					<td>Details</td></tr>";
				}

				$response['status'] = "Success";
				$response['msg'] = $temp;

			}else{
				$response['status'] = "Error";
				$response['msg'] = "No results";
			}

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please specify the fromdate and todate";
		}


		print_r(json_encode($response));

	}else{
		redirect(base_url());
	}
}

public function pcum_sent_receive(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$passfrom = $this->input->post('passfrom');

		if (!empty($barcode) && !empty($transid)) {
			
			$data = array(
				'office_name'=>'PCUM receive',
				'created_by'=>$emid);

			$this->Box_Application_model->update_office_name($transid,$data);

			//for tracing
			$trace_data = array(
				'emid'=>$passfrom,
				'pass_to'=>$emid,
				'transid'=>$transid,
				'office_name'=>'PCUM',
				'status'=>'RECEIVE');

			$this->Box_Application_model->tracing($trace_data);

			$response['status'] = "Success";
			$response['transid'] = $transid;
			$response['barcode'] = $barcode;
			$response['msg'] = "received";

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please specify the fromdate and todate";
		}

		print_r(json_encode($response));

	}else{
		redirect(base_url());
	}
}

public function despatch_receive(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$passfrom = $this->input->post('passfrom');

		if (!empty($barcode) && !empty($transid)) {
			
			$data = array(
				'office_name'=>'Despatch receive',
				'created_by'=>$emid);

			$this->Box_Application_model->update_office_name($transid,$data);

			//for tracing
			$trace_data = array(
				'emid'=>$passfrom,
				'pass_to'=>$emid,
				'transid'=>$transid,
				'office_name'=>'Despatch',
				'status'=>'RECEIVE');

			$this->Box_Application_model->tracing($trace_data);

			$response['status'] = "Success";
			$response['transid'] = $transid;
			$response['barcode'] = $barcode;
			$response['msg'] = "received";

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please specify the fromdate and todate";
		}

		print_r(json_encode($response));

	}else{
		redirect(base_url());
	}
}

public function get_despatch_sentList(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->input->post('emid');
		$pass_to = $this->session->userdata('user_login_id');

		if (!empty($emid)) {


			$emslist = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode='','Despatch',$emid,$pass_to);

			if ($emslist) {

				$count = 1;
				$temp = '';
				foreach ($emslist as $key => $value) {
					$sn = $count++;

					if ($value['s_pay_type'] == 'Cash'){

						if ($value['status'] == 'NotPaid') {
							$pay_status  = "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
						}else{
							$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
						}
						
					}else{

						$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
					}

					$temp .="<tr data-emid='".$emid."' data-transid='".$value['id']."' class='".$value['Barcode']." tr".$value['id']." receiveRow'> <td>".$sn."</td>
					<td>".$value['s_fullname']."</td>
					<td>".$value['fullname']."</td>
					<td>".$value['date_registered']."</td>
					<td>".$value['s_district']."</td>
					<td>".$value['branch']."</td>
					<td>".$value['Barcode']."</td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value['id']."' class='form-check-input ".$value['Barcode']."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}

				$temp .='<tr><td colspan="7"></td><td style="float: right;">
				<a class="btn btn-success" href="'.base_url().'Services/Despatch" class="text-white"><i class="" aria-hidden="true"></i> Receive </a>
				</td></tr>';

				$response['status'] = "Success";
				$response['msg'] = $temp;
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "No data";
			}
		}else{
			$response['status'] = "Error";
			$response['msg'] = "No pf number";
		}

		print_r(json_encode($response));

	}else{
		redirect(base_url());
	}
}

public function send_to_distributer_office(){
	if ($this->session->userdata('user_login_access') != false){
		$transactionList = $this->input->post('transData');

		$emid = $this->session->userdata('user_login_id');

		if (!empty($transactionList)) {
			foreach ($transactionList as $key => $id) {

				$checkPay = $this->Box_Application_model->check_payment($id,$type='');

				if ($checkPay->status == 'Paid' || $checkPay->status == 'Bill') {

					$data = array(
						'office_name'=>'Distributer',
						'pass_from'=>'Counter',
						'created_by'=>$emid);

					$this->Box_Application_model->update_office_name($id,$data);

					//for tracing
					$trace_data = array(
						'emid'=>$emid,
						'transid'=>$id,
						'office_name'=>'Distributer',
						'status'=>'IN');

					$this->Box_Application_model->tracing($trace_data);
				}
			}

			$response['status'] = "Success";
			$response['msg'] = 'Items send to distributer Successfully';
			$response['trans'] = $transactionList;

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please select atleast one";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}

public function distributer_receive(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$passfrom = $this->input->post('passfrom');

		if (!empty($barcode) && !empty($transid)) {
			
			$data = array(
				'office_name'=>'Distributer receive',
				'created_by'=>$emid);

			$this->Box_Application_model->update_office_name($transid,$data);

			//for tracing
			$trace_data = array(
				'emid'=>$passfrom,
				'pass_to'=>$emid,
				'transid'=>$transid,
				'office_name'=>'Distributer',
				'status'=>'RECEIVE');

			$this->Box_Application_model->tracing($trace_data);

			$response['status'] = "Success";
			$response['transid'] = $transid;
			$response['barcode'] = $barcode;
			$response['msg'] = "received";

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please specify the fromdate and todate";
		}

		print_r(json_encode($response));

	}else{
		redirect(base_url());
	}
}

public function item_transfer_distributer(){
	if ($this->session->userdata('user_login_access') != false){
		$assignedby = $this->session->userdata('user_login_id');
		$data['emselect'] = $this->employee_model->delivereselect();
		$operator = $this->input->post('operator');
		$fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');
		$data['operator_zone'] = $this->input->post('operator_zone');
		$data['selected_section'] = $this->input->post('searched_name');

		$data['sectiondata'] = $this->employee_model->getDepartmentSections(7);

        //user details
		$todata  = $this->Box_Application_model->GetBasic($assignedby);

		$toFullName = $todata->first_name.' '.$todata->middle_name.' '.$todata->last_name;

		if (!empty($operator) && !empty($fromdate) && !empty($todate)) {

			$data['info'] = $this->ContractModel->get_employee_info($operator);
			$data['info_assignedby'] = $this->ContractModel->get_employee_info($assignedby);
			$data['fromdate'] = $fromdate;
			$data['todate'] = $todate;

            /*$listdata  = $this->Box_Application_model->transTracingMaster(
                $transid='',
                $operator,
                $assignedby,
                $office_name='Distributer',
                $status='RECEIVE',$fromdate,$todate,$trans_type='',$type='');*/


            //process of assigning status
                if ($data['operator_zone'] == 1) {
                	$statusAssign = '';

                	$listdata  = $this->Box_Application_model->transTracingMaster(
                		$transid='',
                		$operator,
                		$assignedby,
                		$office_name=$data['selected_section'],
                		$status='RECEIVE',$fromdate,$todate,$trans_type='',$type='');

                }else{

                	$listdata  = $this->Box_Application_model->transTracingMaster(
                		$transid='',
                		$assignedby,
                		$operator,
                		$office_name=$data['selected_section'],
                		$status='IN',$fromdate,$todate,$trans_type='',$type='');
                }

                if ($listdata) {

                	foreach ($listdata as $key => $trace) {
            		//$tranDetails  = $this->Box_Application_model->searchTransaction($trace['transid'],$barcode='',$cnumber='',$mobile='');

                		$tranDetails  = $this->Box_Application_model->transanctionsData($trace['transid']);

                		$fromdata  = $this->Box_Application_model->GetBasic($trace['emid']);

                		$tranDetails[0]['fromFullName']  = $fromdata->first_name.' '.$fromdata->middle_name.' '.$fromdata->last_name;

                		$tranDetails[0]['trans_status']  = $trace['status'];

                		$data['listdata'][] = $tranDetails[0];
                	}
                }
            }

            $this->load->view('domestic_ems/transfer_distributer_list',$data);
        }else{
        	redirect(base_url());
        }
    }

    public function item_transfer_inward(){
    	if ($this->session->userdata('user_login_access') != false){
    		$assignedby = $this->session->userdata('user_login_id');
    		$data['emselect'] = $this->employee_model->delivereselect();
    		$operator = $this->input->post('operator');
    		$fromdate = $this->input->post('fromdate');
    		$todate = $this->input->post('todate');
    		$data['selected_section'] = $this->input->post('searched_name');
        //7 for
    		$data['sectiondata'] = $this->employee_model->getDepartmentSections(7);

        //user details
    		$todata  = $this->Box_Application_model->GetBasic($assignedby);

    		$toFullName = $todata->first_name.' '.$todata->middle_name.' '.$todata->last_name;

    		if (!empty($operator) && !empty($fromdate) && !empty($todate)) {

    			$data['info'] = $this->ContractModel->get_employee_info($operator);
    			$data['info_assignedby'] = $this->ContractModel->get_employee_info($assignedby);
    			$data['fromdate'] = $fromdate;
    			$data['todate'] = $todate;

    			$listdata  = $this->Box_Application_model->transTracingMaster(
    				$transid='',
    				$assignedby,
    				$operator,
    				$office_name=$data['selected_section'],
    				$status='IN',$fromdate,$todate,$trans_type='',$type='');

            //echo "<pre>";
            //print_r($data['selected_section']);
            //print_r($operator);



    			if ($listdata) {

    				foreach ($listdata as $key => $trace) {

    					$tranDetails  = $this->Box_Application_model->transanctionsData($trace['transid']);

    					$fromdata  = $this->Box_Application_model->GetBasic($trace['emid']);

    					$newList[@$tranDetails[0]['Barcode']]['Barcode'] = @$tranDetails[0]['Barcode'];
    					$newList[@$tranDetails[0]['Barcode']]['fromFullName'] = @$fromdata->first_name.' '.@$fromdata->middle_name.' '.@$fromdata->last_name;

    					$newList[@$tranDetails[0]['Barcode']]['trans_status']  = @$trace['status'];
    					$newList[@$tranDetails[0]['Barcode']]['s_fullname']  = @$tranDetails[0]['s_fullname'];

    					$newList[@$tranDetails[0]['Barcode']]['fullname']  = @$tranDetails[0]['fullname'];
    				}


    				$data['listdata'] = @$newList;

    			}
    		}

    		$this->load->view('domestic_ems/transfer_inward_list',$data);
    	}else{
    		redirect(base_url());
    	}
    }

    public function item_transfer_pickup(){
    	if ($this->session->userdata('user_login_access') != false){
    		$assignedby = $this->session->userdata('user_login_id');
    		$data['emselect'] = $this->employee_model->delivereselect();
    		$operator = $this->input->post('operator');
    		$fromdate = $this->input->post('fromdate');
    		$todate = $this->input->post('todate');
    		$data['selected_section'] = $this->input->post('searched_name');

        //7 for
    		$data['sectiondata'] = $this->employee_model->getDepartmentSections(7);

        //user details
    		$todata  = $this->Box_Application_model->GetBasic($assignedby);

    		$toFullName = $todata->first_name.' '.$todata->middle_name.' '.$todata->last_name;

    		if (!empty($operator) && !empty($fromdate) && !empty($todate)) {

    			$data['info'] = $this->ContractModel->get_employee_info($operator);
    			$data['info_assignedby'] = $this->ContractModel->get_employee_info($assignedby);
    			$data['fromdate'] = $fromdate;
    			$data['todate'] = $todate;

    			$listdata  = $this->Box_Application_model->transTracingMaster(
    				$transid='',
    				$assignedby,
    				$operator,
    				$office_name=$data['selected_section'],
    				$status='IN',$fromdate,$todate,$trans_type='',$type='');

    			if ($listdata) {

    				foreach ($listdata as $key => $trace) {

    					$tranDetails  = $this->Box_Application_model->transanctionsData($trace['transid']);

    					$fromdata  = $this->Box_Application_model->GetBasic($trace['emid']);

    					$newList[$tranDetails[0]['Barcode']]['Barcode'] = $tranDetails[0]['Barcode'];
    					$newList[$tranDetails[0]['Barcode']]['fromFullName'] = $fromdata->first_name.' '.$fromdata->middle_name.' '.$fromdata->last_name;

    					$newList[$tranDetails[0]['Barcode']]['trans_status']  = $trace['status'];
    					$newList[$tranDetails[0]['Barcode']]['s_fullname']  = $tranDetails[0]['s_fullname'];

    					$newList[$tranDetails[0]['Barcode']]['fullname']  = $tranDetails[0]['fullname'];
    				}

    				$data['listdata'] = $newList;

    			}
    		}

    		$this->load->view('domestic_ems/transfer_pickup_list.php',$data);
    	}else{
    		redirect(base_url());
    	}
    }

    public function item_transfer_despatch(){
    	if ($this->session->userdata('user_login_access') != false){
    		$assignedby = $this->session->userdata('user_login_id');
    		$data['emselect'] = $this->employee_model->delivereselect();
    		$operator = $this->input->post('operator');
    		$fromdate = $this->input->post('fromdate');
    		$todate = $this->input->post('todate');
    		$data['selected_section'] = $this->input->post('searched_name');

    		$data['sectiondata'] = $this->employee_model->getDepartmentSections();

        //user details
    		$todata  = $this->Box_Application_model->GetBasic($assignedby);

    		$toFullName = $todata->first_name.' '.$todata->middle_name.' '.$todata->last_name;

    		if (!empty($operator) && !empty($fromdate) && !empty($todate)) {

    			$data['info'] = $this->ContractModel->get_employee_info($operator);
    			$data['info_assignedby'] = $this->ContractModel->get_employee_info($assignedby);
    			$data['fromdate'] = $fromdate;
    			$data['todate'] = $todate;

    			$listdata  = $this->Box_Application_model->transTracingMaster(
    				$transid='',
    				$operator,
    				$assignedby,
    				$office_name='Despatch',
    				$status='RECEIVE',$fromdate,$todate,$trans_type='',$type='');

    			if ($listdata) {

            	/*foreach ($listdata as $key => $trace) {
            		//$tranDetails  = $this->Box_Application_model->searchTransaction($trace['transid'],$barcode='',$cnumber='',$mobile='');

            		$tranDetails  = $this->Box_Application_model->transanctionsData($trace['transid']);

            		$fromdata  = $this->Box_Application_model->GetBasic($trace['emid']);

            		$tranDetails[0]['fromFullName']  = $fromdata->first_name.' '.$fromdata->middle_name.' '.$fromdata->last_name;

            		$tranDetails[0]['trans_status']  = $trace['status'];

            		$data['listdata'][] = $tranDetails[0];
            	}*/

            	foreach ($listdata as $key => $trace) {

            		$tranDetails  = $this->Box_Application_model->transanctionsData($trace['transid']);

            		$fromdata  = $this->Box_Application_model->GetBasic($trace['emid']);

            		$newList[$tranDetails[0]['Barcode']]['Barcode'] = $tranDetails[0]['Barcode'];
            		$newList[$tranDetails[0]['Barcode']]['fromFullName'] = $fromdata->first_name.' '.$fromdata->middle_name.' '.$fromdata->last_name;

            		$newList[$tranDetails[0]['Barcode']]['trans_status']  = $trace['status'];
            		$newList[$tranDetails[0]['Barcode']]['s_fullname']  = $tranDetails[0]['s_fullname'];

            		$newList[$tranDetails[0]['Barcode']]['fullname']  = $tranDetails[0]['fullname'];

            		//$data['listdata'][] = $newList;
            	}
            	$data['listdata'] = $newList;

            }
        }

        $this->load->view('domestic_ems/transfer_despatch_list',$data);
    }else{
    	redirect(base_url());
    }
}


//MAILS
public function item_mails_transfer(){
	if ($this->session->userdata('user_login_access') != false){
		$assignedby = $this->session->userdata('user_login_id');
		$data['emselect'] = $this->employee_model->delivereselect();
		$operator = $this->input->post('operator');
		$fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');

		$fromzone = $this->input->post('fromzone');
		$print_status = $this->input->post('print_status');

		$data['selected_section'] = $this->input->post('searched_name');
		$data['sectiondata'] = $this->employee_model->getDepartmentSections(23);

        // $data['fromzone'] = (!empty($fromzone))? $fromzone:$_GET['fromzone'];
        // $data['print_status'] = (!empty($print_status))? $print_status:$_GET['print_status'];

		$data['fromzone'] = (!empty($_GET['fromzone']))? $_GET['fromzone']:$fromzone;
		$data['print_status'] = (!empty($_GET['print_status']))? $_GET['print_status']:$print_status;

        //get staff section
		$staff_section = $this->employee_model->getEmpDepartmentSections($assignedby);

        //user details
		$todata  = $this->Box_Application_model->GetBasic($assignedby);

		$toFullName = $todata->first_name.' '.$todata->middle_name.' '.$todata->last_name;

		if (!empty($operator) && !empty($fromdate) && !empty($todate)) {

			$data['info'] = $this->ContractModel->get_employee_info($operator);
			$data['info_assignedby'] = $this->ContractModel->get_employee_info($assignedby);
			$data['fromdate'] = $fromdate;
			$data['todate'] = $todate;
			$data['current_scetion'] = $staff_section[0]['name'];

             //get the data for printing
			if(!empty($data['print_status'])){
				$print_status = $data['print_status'];
	        	//$office_name=$staff_section[0]['name'];//.' receive'
				$office_name=$data['selected_section'];
				$trans_createdby = $assignedby;
				$trans_pass_to = $operator;
			}else{
				$print_status = 'RECEIVE';
				$office_name=$staff_section[0]['name'].' receive';
				$trans_createdby = $operator;
				$trans_pass_to = $assignedby;
			}


			$listdata  = $this->Box_Application_model->transTracingMaster(
				$transid='',
				$trans_createdby,
				$trans_pass_to,
				$office_name,
				$print_status,$fromdate,$todate,$trans_type='mails',$type='');


			if ($listdata) {

				foreach ($listdata as $key => $trace) {

					$tranDetails  = $this->unregistered_model->transanctionsData($trace['transid']);

					$fromdata  = $this->Box_Application_model->GetBasic($trace['emid']);

					$newList[$tranDetails[0]['Barcode']]['Barcode'] = $tranDetails[0]['Barcode'];
					$newList[$tranDetails[0]['Barcode']]['fromFullName'] = $fromdata->first_name.' '.$fromdata->middle_name.' '.$fromdata->last_name;

					$newList[$tranDetails[0]['Barcode']]['trans_status']  = $trace['status'];
					$newList[$tranDetails[0]['Barcode']]['sender_fullname']  = $tranDetails[0]['sender_fullname'];

					$newList[$tranDetails[0]['Barcode']]['fullname']  = $tranDetails[0]['receiver_fullname'];
				}

				$data['listdata'] = $newList;

			}
		}

		$this->load->view('domestic_ems/transfer_mails_list',$data);
	}else{
		redirect(base_url());
	}
}

public function get_counter_sentList(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->input->post('emid');

		if (!empty($emid)) {
			//$emslist = $this->Box_Application_model->get_ems_list_SearchData($fromdate='',$todate='',$barcode='','Distributer',$emid);


			$emslist = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode='','Distributer',$emid,$pass_to='');

			// print_r($emslist);
			// die();

			
			if ($emslist) {

				$count = 1;
				$temp = '';
				foreach ($emslist as $key => $value) {
					$sn = $count++;

					$temp .="<tr data-emid='".$emid."' data-transid='".$value['id']."' class='".$value['Barcode']." tr".$value['id']." receiveRow'> <td>".$sn."</td>
					<td>".$value['s_fullname']."</td>
					<td>".$value['fullname']."</td>
					<td>".$value['date_registered']."</td>
					<td>".$value['s_district']."</td>
					<td>".$value['branch']."</td>
					<td>".$value['billid']."</td>
					<td>".$value['Barcode']."</td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value['id']."' class='form-check-input ".$value['Barcode']."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}

				$temp .='<tr><td colspan="8"></td><td style="float: right;">
				<a class="btn btn-success" href="'.base_url().'Services/Distributer" class="text-white"><i class="" aria-hidden="true"></i> Receive </a>
				</td></tr>';

				$response['status'] = "Success";
				$response['msg'] = $temp;
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "No data";
			}
		}else{
			$response['status'] = "Error";
			$response['msg'] = "No pf number";
		}

		print_r(json_encode($response));

	}else{
		redirect(base_url());
	}
}

public function get_inward_sentList(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->input->post('emid');
		$pass_to = $this->session->userdata('user_login_id');

		if (!empty($emid)) {


			$emslist = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode='','InWard',$emid,$pass_to);

			if ($emslist) {

				$count = 1;
				$temp = '';
				foreach ($emslist as $key => $value) {
					$sn = $count++;

					if ($value['s_pay_type'] == 'Cash'){

						if ($value['status'] == 'NotPaid') {
							$pay_status  = "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
						}else{
							$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
						}
						
					}else{

						$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
					}

					$temp .="<tr data-emid='".$emid."' data-transid='".$value['id']."' class='".$value['Barcode']." tr".$value['id']." receiveRow'> <td>".$sn."</td>
					<td>".$value['s_fullname']."</td>
					<td>".$value['fullname']."</td>
					<td>".$value['date_registered']."</td>
					<td>".$value['s_district']."</td>
					<td>".$value['branch']."</td>
					<td>".$value['Barcode']."</td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value['id']."' class='form-check-input ".$value['Barcode']."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}

				$temp .='<tr><td colspan="7"></td><td style="float: right;">
				<a class="btn btn-success" href="'.base_url().'Services/InWard" class="text-white"><i class="" aria-hidden="true"></i> Receive </a>
				</td></tr>';

				$response['status'] = "Success";
				$response['msg'] = $temp;
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "No data";
			}
		}else{
			$response['status'] = "Error";
			$response['msg'] = "No pf number";
		}

		print_r(json_encode($response));

	}else{
		redirect(base_url());
	}
}


public function get_pcum_sentList(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->input->post('emid');
		$pass_to = $this->session->userdata('user_login_id');

		if (!empty($emid)) {

			$emslist = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode='','PCUM',$emid,$pass_to);

			if ($emslist) {

				$count = 1;
				$temp = '';
				foreach ($emslist as $key => $value) {
					$sn = $count++;

					if ($value['s_pay_type'] == 'Cash'){

						if ($value['status'] == 'NotPaid') {
							$pay_status  = "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
						}else{
							$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
						}
						
					}else{

						$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
					}

					$temp .="<tr data-emid='".$emid."' data-transid='".$value['id']."' class='".$value['Barcode']." tr".$value['id']." receiveRow'> <td>".$sn."</td>
					<td>".$value['s_fullname']."</td>
					<td>".$value['fullname']."</td>
					<td>".$value['date_registered']."</td>
					<td>".$value['s_district']."</td>
					<td>".$value['branch']."</td>
					<td>".$value['Barcode']."</td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value['id']."' class='form-check-input ".$value['Barcode']."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}

				$temp .='<tr><td colspan="7"></td><td style="float: right;">
				<a class="btn btn-success" href="'.base_url().'Services/pcum_passed_receive_list" class="text-white"><i class="" aria-hidden="true"></i> Receive </a>
				</td></tr>';

				$response['status'] = "Success";
				$response['msg'] = $temp;
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "No data";
			}
		}else{
			$response['status'] = "Error";
			$response['msg'] = "No pf number";
		}

		print_r(json_encode($response));

	}else{
		redirect(base_url());
	}
}

public function get_bag_itemlist(){
	if ($this->session->userdata('user_login_access') != false){
		$bagnoText = $this->input->post('bagnoText');
		$emid = $this->session->userdata('user_login_id');

		if (!empty($bagnoText)) {
			//get bag details
			$bag = $this->Box_Application_model->getBag($bagnoText);
			//get the bag item from the transactions
			$emslist = $this->Box_Application_model->getBagItemListBybagNumber($bagnoText);

			if ($emslist) {

				$temp = '';
				$count = 1;

				foreach ($emslist as $key => $value) {
					$sn = $count++;

					$destinations123='';
					if(!empty($value['r_region']) && !is_numeric($value['r_region']) ){
						$destinations123=$value['branch'];

					}else{
						$destinations123=$value['r_region2'];

					}

					$temp .="<tr data-transid='".$value['id']."' class='".$value['Barcode']." tr".$value['id']." receiveRowsd'
					id='tr".$value['id']."'> <td>".$sn."</td>
					<td>".$value['s_fullname']."</td>
					<td>".$value['fullname']."</td>
					<td>".$value['date_registered']."</td>
					<td>".$value['s_district']."</td>
					<td>".$destinations123."</td>
					<td>".$value['Barcode']."</td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value['id']."' class='form-check-input ".$value['Barcode']."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div>
					<button data-transid='".$value['id']."' href='#' onclick='Deletevalue(this)' title='Remove fom bag' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-trash-o'></i></button>
					</td></tr>";

				}
				
				$response['from'] = $bag['bag_region'];
				$response['to'] = $bag['bag_branch'];
				$response['status'] = "Success";
				$response['msg'] = $temp;
				$response['total'] = sizeof($emslist);
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "No data";
			}
		}else{
			$response['status'] = "Error";
			$response['msg'] = "No Barcode number";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}

public function assign_item_bag_process(){
	if ($this->session->userdata('user_login_access') != false){
		$barcode = strtoupper($this->input->post('barcode'));
		$rec_region = $this->input->post('rec_region');
		$rec_branch = $this->input->post('rec_branch');
		$bagssno = $this->input->post('bagno');
		$bagnoText = $this->input->post('bagnoText');
		$emid = $this->session->userdata('user_login_id');
		$pass_to = $this->session->userdata('user_login_id');
		//$sn = $this->input->post('sn');
		$sn = $this->input->post('sn');
		

		if (!empty($emid)) {
			//user information
			$basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;


			$emslist = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode,'Despatch receive',$emid,$pass_to);

			//print_r($emslist);
			//die();

			if ($emslist) {

				if ($bagnoText == 'New Bag') {

					$bagno = $this->Box_Application_model->createbagNumber($rec_branch,$em_branch);
					//process of saving the bag information

					$tz = 'Africa/Nairobi';
					$tz_obj = new DateTimeZone($tz);
					$today = new DateTime("now", $tz_obj);
					$now = $today->format("Y-m-d  H:i:s");

					//$now = date("Y-m-d H:i:s");
					$bagInfor = array(
						'bag_number' =>$bagno['num'],
						'bag_region' =>$rec_region, 
						'bag_branch' =>$rec_branch, 
						'dc'=>$bagno['dc'], 
						'date_created' =>$now, 
						'service_type' =>'EMS', 
						'bag_region_from' =>$region, 
						'bag_branch_from' =>$em_branch,
						'bag_created_by ' =>$emid
					);

					$bagnoId = $this->Box_Application_model->save_bag($bagInfor);

					$select = '<option selected value="'.$bagnoId.'">'.$bagno['num'].'</option>';

					$bagnoText = $bagno['num'];//bag name
				}else{
					$bagnoId = $bagssno;//bag Id
					$bagnoText = $bagnoText; //bag name
				}

				//check the transaction payment
				if ($emslist[0]['s_pay_type'] == 'Cash') {

					$paymentStatus = ($emslist[0]['status'] == 'Paid')? 1:0;

				}else if($emslist[0]['s_pay_type'] == 'PostPaid'){
					$paymentStatus = ($emslist[0]['status'] == 'Bill')? 1:0;
				}else{
					$paymentStatus = ($emslist[0]['status'] == 'Paid')? 1:0;
				}

				//print_r($paymentStatus);
				//die();

				if ($paymentStatus) {


				//process of assigning the items in the bag
					$transData = array(
						'isBagNo'=>$bagnoText,
						'isBagBy'=>$emid,
						'office_name'=>'Back',
						'bag_status'=>'isBag');

					$this->Box_Application_model->update_back_office_Barcode($barcode,$transData);

				//for tracing
					$trace_data = array(
						'emid'=>$emid,
						'transid'=>$emslist[0]['id'],
						'office_name'=>'Despatch',
						'description'=>'In Bag from '.$em_branch,
						'status'=>'BAG');

					$this->Box_Application_model->tracing($trace_data);


				//for track
					$track_data = array(
						'emid'=>$emid,
						'transid'=>$emslist[0]['id'],
						'office_name'=>'Despatch',
						'description'=>'Sorting Facility from '.$em_branch,
						'type'=>1,
						'status'=>'Sorting Facility');

					$this->Box_Application_model->tracing($track_data);

					$temp = '';
					foreach ($emslist as $key => $value) {

						if ($value['s_pay_type'] == 'Cash'){

							if ($value['status'] == 'NotPaid') {
								$pay_status  = "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
							}else{
								$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
							}
							
						}else{

							$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
						}

						$temp .="<tr style='background:blue;color:white;' data-transid='".$value['id']."' class='".$value['Barcode']." tr".$value['id']." receiveRowd'
						id='tr".$value['id']."'> <td>".$sn."</td>
						<td>".$value['s_fullname']."</td>
						<td>".$value['fullname']."</td>
						<td>".$value['date_registered']."</td>
						<td>".$value['s_district']."</td>
						<td>".$value['branch']."</td>
						<td>".$value['Barcode']."</td>
						<td>
						<div class='form-check' style='padding-left: 53px;float:left'>
						<input type='checkbox' name='transactions' value='".$value['id']."' class='form-check-input ".$value['Barcode']."' style='padding-right:50px;' />
						<label class='form-check-label' for='remember-me'></label>
						</div>
						<button data-transid='".$value['id']."' href='#' onclick='Deletevalue(this)' title='Cancel' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-trash-o'></i></button>
						</td></tr>";

					}

					$response['status'] = "Success";
					$response['msg'] = $temp;
					$response['total'] = sizeof($emslist);
					if(!empty($select)) $response['select'] = $select;

				}else{
					$response['status'] = "Error";
					$response['msg'] = "Huduma Haijalipiwa";
				}
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "Huduma hii bado aujapasiwa au aujaipokea";
			}
		}else{
			$response['status'] = "Error";
			$response['msg'] = "No pf number";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}


public function assign_item_bag_general_process(){
	if ($this->session->userdata('user_login_access') != false){
		$barcode = $this->input->post('barcode');
		$rec_region = $this->input->post('rec_region');
		$rec_branch = $this->input->post('rec_branch');
		$bagssno = $this->input->post('bagno');
		$bagnoText = $this->input->post('bagnoText');
		$emid = $this->session->userdata('user_login_id');
		$pass_to = $this->session->userdata('user_login_id');
		$sn = $this->input->post('sn');
		

		if (!empty($emid)) {
			//user information
			$basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;


			$emslist = $this->Box_Application_model->getTransactionsOfficeBybarcode233($barcode,$Despatch="",$staffId="",$pass_to="");

			// print_r($emslist);
			// die();

			if ($emslist) {

				if ($bagnoText == 'New Bag') {
					$bagno = $this->Box_Application_model->createbagNumber($rec_branch,$em_branch);
					//process of saving the bag information
					$tz = 'Africa/Nairobi';
					$tz_obj = new DateTimeZone($tz);
					$today = new DateTime("now", $tz_obj);
					$now = $today->format("Y-m-d  H:i:s");

					//$now = date("Y-m-d");
					// 'date_created' =>$now, 
					$bagInfor = array(
						'bag_number' =>$bagno['num'], 
						'bag_region' =>$rec_region, 
						'bag_branch' =>$rec_branch,
						'dc'=>$bagno['dc'], 
						'date_created' =>$now,
						'service_type' =>'EMS', 
						'bag_region_from' =>$region, 
						'bag_branch_from' =>$em_branch,
						'bag_created_by' =>$emid
					);

					$bagnoId = $this->Box_Application_model->save_bag($bagInfor);

					$select = '<option selected value="'.$bagnoId.'">'.$bagno['num'].'</option>';

					$bagnoText = $bagno['num'];//bag name

				}else{
					$bagnoId = $bagssno;//bag Id
					$bagnoText = $bagnoText; //bag name
				}

				//check the transaction payment
				if ($emslist[0]['s_pay_type'] == 'Cash') {
					$paymentStatus = ($emslist[0]['status'] == 'Paid')? 1:0;
				}else{
					$paymentStatus = ($emslist[0]['status'] == 'Bill')? 1:0;
				}

				if ($paymentStatus) {
					
					//process of assigning the items in the bag
					$transData = array(
						'isBagNo'=>$bagnoText,
						'isBagBy'=>$emid,
						'office_name'=>'Back',
						'bag_status'=>'isBag');

					//$this->Box_Application_model->update_back_office_Barcode($barcode,$transData);

					$this->Box_Application_model->update_office_name($emslist[0]['id'],$transData);

					//for tracing
					$trace_data = array(
						'emid'=>$emid,
						'transid'=>$emslist[0]['id'],
						'office_name'=>'Despatch',
						'description'=>'Received sorting facility '.$em_branch,
						'status'=>'BAG');

					$this->Box_Application_model->tracing($trace_data);


					//for track
					$track_data = array(
						'emid'=>$emid,
						'transid'=>$emslist[0]['id'],
						'office_name'=>'Despatch',
						'description'=>'Received sorting facility '.$em_branch,
						'type'=>1,
						'status'=>'Sorting Facility');
					//.$em_branch

					$this->Box_Application_model->tracing($track_data);

					$temp = '';
					foreach ($emslist as $key => $value) {

						if ($value['s_pay_type'] == 'Cash'){

							if ($value['status'] == 'NotPaid') {
								$pay_status  = "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
							}else{
								$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
							}
							
						}else{

							$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
						}
						//style='background:blue;color:white;'
						$destinations123='';
						if(!empty($value['r_region']) && !is_numeric($value['r_region']) ){
							$destinations123=$value['branch'];

						}else{
							$destinations123=$value['r_region2'];

						}

						$temp .="<tr data-transid='".$value['id']."' class='".$value['Barcode']." tr".$value['id']." receiveRowd'
						id='tr".$value['id']."'
						> <td>".$sn."</td>
						<td>".$value['s_fullname']."</td>
						<td>".$value['fullname']."</td>
						<td>".$value['date_registered']."</td>
						<td>".$value['s_district']."</td>
						<td>".$destinations123."</td>
						<td>".$value['Barcode']."</td>
						<td>
						<div class='form-check' style='padding-left: 53px;float:left'>
						<input type='checkbox' name='transactions' value='".$value['id']."' class='form-check-input ".$value['Barcode']."' style='padding-right:50px;' />
						<label class='form-check-label' for='remember-me'></label>
						</div>
						<button data-transid='".$value['id']."' href='#' onclick='Deletevalue(this)' title='Cancel' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-trash-o'></i></button>
						</td></tr>";

					}

					$response['status'] = "Success";
					$response['msg'] = $temp;
					$response['total'] = sizeof($emslist);
					if(!empty($select)) $response['select'] = $select;

				}else{
					$response['status'] = "Error";
					$response['msg'] = "Huduma Haijalipiwa";
				}

				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "No data";
			}
		}else{
			$response['status'] = "Error";
			$response['msg'] = "No pf number";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}


public function close_bag_items_process(){
	if ($this->session->userdata('user_login_access') != false){
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['bags'] = $this->Box_Application_model->count_bags();

		$this->load->view('ems/close_bag_items_process.php',$data);
	}else{
		redirect(base_url());
	}
}

public function delete_selected_bag(){
	if ($this->session->userdata('user_login_access') != false){
		$bagsNo = $_GET['bagno'];
		$returnto = $_GET['returnto'];

		if ($bagsNo) {
			$this->Box_Application_model->deleteBagInfo($bagsNo);
		}

		redirect('Box_Application/'.$returnto);

	}else{
		redirect(base_url());
	}
}

public function editBarcodeprocess(){
	if ($this->session->userdata('user_login_access') != false) {
		$Barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$reasonMessage = $this->input->post('reasonMessage');

		$checkdata = $this->Box_Application_model->check_barcode($Barcode);
		;

		if(!empty($checkdata)) {
			$res['status'] = 'error';
			$res['message'] = 'Barcode hii '.$checkdata['Barcode'].' Imeshatumika';
		}else{
            	//update process
			$updateData = array('Barcode' =>$Barcode,'edit_reason_Message'=>$reasonMessage);
			$this->Box_Application_model->update_old_transactions($updateData,$transid);
			$res['status'] = 'Success';
			$res['message'] = 'Edited Successfully';
		}
            //response
		print_r(json_encode($res));

	}else{
		redirect(base_url());
	}
}

public function despatch_bags_list(){
	if ($this->session->userdata('user_login_access') != false){

		$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
		$data['ems'] = $this->Box_Application_model->count_ems();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['bags'] = $this->Box_Application_model->count_bags();
		$this->load->view('ems/ems_despatch_bag_list.php',$data);
	}else{
		redirect(base_url());
	}
}

public function inward_receive(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$passfrom = $this->input->post('passfrom');

		if (!empty($barcode) && !empty($transid)) {
			
			$data = array(
				'office_name'=>'InWard receive',
				'created_by'=>$emid);

			$this->Box_Application_model->update_office_name($transid,$data);

			//for tracing
			$trace_data = array(
				'emid'=>$passfrom,
				'pass_to'=>$emid,
				'transid'=>$transid,
				'office_name'=>'InWard',
				'status'=>'RECEIVE');

			$this->Box_Application_model->tracing($trace_data);

			$response['status'] = "Success";
			$response['transid'] = $transid;
			$response['barcode'] = $barcode;
			$response['msg'] = "received";

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please specify the fromdate and todate";
		}

		print_r(json_encode($response));

	}else{
		redirect(base_url());
	}
}

public function Distributer_pass_view(){
	if ($this->session->userdata('user_login_access') != false){
		$data['sectiondata'] = $this->employee_model->getDepartmentSections();

		$this->load->view('domestic_ems/ems_distributer_pass_list',$data);
	}else{
		redirect(base_url());
	}
}


public function PCUMPassToOperatorByzone(){
	if ($this->session->userdata('user_login_access') != false){
		$barcode = $this->input->post('barcode');
		$operator = $this->input->post('operator');
		$zonetype = $this->input->post('zonetype');
		$sno = $this->input->post('sn');

		$emid = $this->session->userdata('user_login_id');

		if (!empty($barcode) && !empty($emid)) {
			//filter data by using barcode
			$emslist = $this->Box_Application_model->get_ems_forPCUMlist($zonetype,$barcode,$emid);
			// print_r($emslist);
			// die();

			if ($emslist) {

			//process of passing
				$data = array(
					'pass_to'=>$operator,
					'office_name'=>$zonetype,
					'pass_from'=>'PCUM',
					'created_by'=>$emid);

				$this->Box_Application_model->update_office_name($emslist[0]->id,$data);


			//for tracing
				$trace_data = array(
					'emid'=>$emid,
					'pass_to'=>$operator,
					'transid'=>$emslist[0]->id,
					'office_name'=>$zonetype,
					'status'=>'IN');


				$this->Box_Application_model->tracing($trace_data);

				$count = 1;
				$temp = '';
				foreach ($emslist as $key => $value) {
					$sn = (!empty($sno))? $sno:$count++;

					if ($value->s_pay_type == 'Cash'){

						if ($value->status == 'NotPaid') {
							$pay_status  = "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
						}else{
							$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
						}
						
					}else{

						$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
					}

					$temp .="<tr data-transid='".$value->id."' class='".$value->Barcode." tr".$value->id." receiveRow'> <td>".$sn."</td>
					<td>".$value->s_fullname."</td>
					<td>".$value->fullname."</td>
					<td>".$value->date_registered."</td>
					<td>".$value->paidamount."</td>
					<td>".$value->weight."</td>
					<td>".$value->s_district."</td>
					<td>".$value->branch."</td>
					<td>".$value->billid."</td>
					<td>".$value->Barcode."</td>
					<td>".$pay_status."</td>
					<td><a href='#' 
					data-transid='".$value->id."'
					data-barcode='".$value->Barcode."' onclick='removePCUMPassedItem(this)' 
					class=''><i class='fa fa-trash-o'></i> Remove</a></td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value->id."' class='form-check-input ".$value->Barcode."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}

				$response['status'] = "Success";
				$response['msg'] = $temp;
				$response['total'] = sizeof($emslist);
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "Huduma Haijalipiwa";
			}

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please enter barcode";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}


public function DespatchPassToOperatorByzone(){
	if ($this->session->userdata('user_login_access') != false){
		$barcode = $this->input->post('barcode');
		$operator = $this->input->post('operator');
		$zonetype = $this->input->post('zonetype');
		$sno = $this->input->post('sn');

		$emid = $this->session->userdata('user_login_id');

		if (!empty($barcode) && !empty($emid)) {
			
			//filter data by using barcode
			$emslist = $this->Box_Application_model->get_ems_bill_forPickup_list('Despatch receive',$barcode,$emid);


			if ($emslist) {

			//process of passing
				$data = array(
					'pass_to'=>$operator,
					'office_name'=>$zonetype,
					'pass_from'=>'Despatch',
					'created_by'=>$emid);

				$this->Box_Application_model->update_office_name($emslist[0]->id,$data);


			//for tracing
				$trace_data = array(
					'emid'=>$emid,
					'pass_to'=>$operator,
					'transid'=>$emslist[0]->id,
					'office_name'=>$zonetype,
					'status'=>'IN');

				$this->Box_Application_model->tracing($trace_data);

				$count = 1;
				$temp = '';
				foreach ($emslist as $key => $value) {
					$sn = (!empty($sno))? $sno:$count++;

					if ($value->s_pay_type == 'Cash'){

						if ($value['status'] == 'NotPaid') {
							$pay_status  = "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
						}else{
							$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
						}
						
					}else{

						$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
					}

					$temp .="<tr data-transid='".$value->id."' class='".$value->Barcode." tr".$value->id." receiveRow'> <td>".$sn."</td>
					<td>".$value->s_fullname."</td>
					<td>".$value->fullname."</td>
					<td>".$value->date_registered."</td>
					<td>".$value->paidamount."</td>
					<td>".$value->weight."</td>
					<td>".$value->s_district."</td>
					<td>".$value->branch."</td>
					<td>".$value->billid."</td>
					<td>".$value->Barcode."</td>
					<td>".$pay_status."</td>
					<td><a href='#' 
					data-transid='".$value->id."'
					data-barcode='".$value->Barcode."' onclick='removeDespatchPassedItem(this)' 
					class=''><i class='fa fa-trash-o'></i> Remove</a></td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value->id."' class='form-check-input ".$value->Barcode."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}

				// $temp .='<tr><td colspan="11"></td><td style="float: right;">
				// <a class="btn btn-success" href="'.base_url().'Services/Distributer" class="text-white"><i class="" aria-hidden="true"></i> Receive </a>
				// 	</td></tr>';

				$response['status'] = "Success";
				$response['msg'] = $temp;
				$response['total'] = sizeof($emslist);
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "Transaction not found";
			}

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please enter barcode";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}

public function PassToOperatorByzone(){
	if ($this->session->userdata('user_login_access') != false){
		$barcode = $this->input->post('barcode');
		$operator = $this->input->post('operator');
		$zonetype = $this->input->post('zonetype');
		$sno = $this->input->post('sn');

		$emid = $this->session->userdata('user_login_id');

		if (!empty($barcode) && !empty($emid)) {
			//filter data by using barcode
			$emslist = $this->Box_Application_model->get_ems_bill_forPickup_list('Pickup',$barcode,$emid);

			//$emslist = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode,'Distributer receive',$empid='');

			if ($emslist) {

			//process of passing
				$data = array(
					'pass_to'=>$operator,
					'office_name'=>$zonetype,
					'pass_from'=>'Pickup',
					'created_by'=>$emid);

				$this->Box_Application_model->update_office_name($emslist[0]->id,$data);


			//for tracing
				$trace_data = array(
					'emid'=>$emid,
					'pass_to'=>$operator,
					'transid'=>$emslist[0]->id,
					'office_name'=>$zonetype,
					'status'=>'IN');

				$this->Box_Application_model->tracing($trace_data);

				$count = 1;
				$temp = '';
				foreach ($emslist as $key => $value) {
					$sn = (!empty($sno))? $sno:$count++;

					if ($value->s_pay_type == 'Cash'){

						if ($value->status == 'NotPaid') {
							$pay_status  = "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
						}else{
							$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
						}
						
					}else{

						$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
					}

					$temp .="<tr data-transid='".$value->id."' class='".$value->Barcode." tr".$value->id." receiveRow'> <td>".$sn."</td>
					<td>".$value->s_fullname."</td>
					<td>".$value->fullname."</td>
					<td>".$value->date_registered."</td>
					<td>".$value->paidamount."</td>
					<td>".$value->weight."</td>
					<td>".$value->s_district."</td>
					<td>".$value->branch."</td>
					<td>".$value->billid."</td>
					<td>".$value->Barcode."</td>
					<td>".$pay_status."</td>
					<td><a href='#' 
					data-transid='".$value->id."'
					data-barcode='".$value->Barcode."' onclick='removePickupPassedItem(this)' 
					class=''><i class='fa fa-trash-o'></i> Remove</a></td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value->id."' class='form-check-input ".$value->Barcode."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}

				// $temp .='<tr><td colspan="11"></td><td style="float: right;">
				// <a class="btn btn-success" href="'.base_url().'Services/Distributer" class="text-white"><i class="" aria-hidden="true"></i> Receive </a>
				// 	</td></tr>';

				$response['status'] = "Success";
				$response['msg'] = $temp;
				$response['total'] = sizeof($emslist);
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "Huduma Haijalipiwa";
			}

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please enter barcode";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}

public function removePCUMPassedItem(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$operator = $this->input->post('operator');

		if ($barcode) {

			$staff_section = $this->employee_model->getEmpDepartmentSections($emid);

			//process of passing
			$data = array(
				'pass_to'=>'',
				'office_name'=>'PCUM',
				'pass_from'=>'',
				'created_by'=>$emid);

			$this->Box_Application_model->update_office_name($transid,$data);


			$Operatorbasicinfo = $this->employee_model->GetBasic($operator);
			//operatorFull name
			$OpatorFullName = $Operatorbasicinfo->first_name.' '.$Operatorbasicinfo->middle_name.' '.$Operatorbasicinfo->last_name;

			//update trace to remove IN
			$this->Box_Application_model->update_trace_data(
				$emid,
				$transid,
				$operator,
				array('status'=>'remove IN'));


			//for tracing
			$trace_data = array(
				'emid'=>$emid,
				'transid'=>$transid,
				'office_name'=>'PCUM',
				'description'=>'Deleted by ('.$OpatorFullName.')',
				'status'=>'Removed');

			//saving into the trace table
			$this->Box_Application_model->tracing($trace_data);
		}


	}else{
		redirect(base_url());
	}
}


public function removePickupPassedItem(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$operator = $this->input->post('operator');

		if ($barcode) {

			//process of passing
			$data = array(
				'pass_to'=>'',
				'office_name'=>'Pickup',
				'pass_from'=>'',
				'created_by'=>$emid);

			$this->Box_Application_model->update_office_name($transid,$data);


			$Operatorbasicinfo = $this->employee_model->GetBasic($operator);
			//operatorFull name
			$OpatorFullName = $Operatorbasicinfo->first_name.' '.$Operatorbasicinfo->middle_name.' '.$Operatorbasicinfo->last_name;

			//update trace to remove IN
			$this->Box_Application_model->update_trace_data(
				$emid,
				$transid,
				$operator,
				array('status'=>'remove IN'));

			//for tracing
			$trace_data = array(
				'emid'=>$emid,
				'transid'=>$transid,
				'office_name'=>'Pickup',
				'description'=>'Deleted by ('.$OpatorFullName.')',
				'status'=>'Removed');

			//saving into the trace table
			$this->Box_Application_model->tracing($trace_data);
		}


	}else{
		redirect(base_url());
	}
}


public function removeDespatchPassedItem(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$operator = $this->input->post('operator');
		$from_operator = $this->input->post('from_operator');
		$selected_zone = $this->input->post('zone');

		if ($barcode) {

			//process of passing
			$data = array(
				'pass_to'=>'',
				'office_name'=>'Despatch',
				'pass_from'=>'',
				'created_by'=>$emid);

			$this->Box_Application_model->update_office_name($transid,$data);


			$Operatorbasicinfo = $this->employee_model->GetBasic($operator);
			//operatorFull name
			$OpatorFullName = $Operatorbasicinfo->first_name.' '.$Operatorbasicinfo->middle_name.' '.$Operatorbasicinfo->last_name;

			//update trace to remove IN
			$this->Box_Application_model->update_trace_data(
				$emid,
				$transid,
				$operator,
				array('status'=>'remove IN'));


			//for tracing
			$trace_data = array(
				'emid'=>$emid,
				'transid'=>$transid,
				'office_name'=>'Despatch',
				'description'=>'Deleted by ('.$OpatorFullName.')',
				'status'=>'Removed');

			//saving into the trace table
			$this->Box_Application_model->tracing($trace_data);
		}


	}else{
		redirect(base_url());
	}
}


//---RECEIVE NON BAG EMS

public function Receive_non_mails_bag_item(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = base64_decode($this->input->get('I'));
		$this->load->view('inlandMails/receive_non_bag_items.php');
	}else{
		redirect(base_url());
	}
}

public function receiveScanNonBagItemMails(){
	if ($this->session->userdata('user_login_access') != false){
		$barcode = $this->input->post('barcode');
		$operator = $this->input->post('operator');
		$zonetype = $this->input->post('zonetype');
		$sn = $this->input->post('sn');

		$emid = $this->session->userdata('user_login_id');

		if (!empty($barcode) && !empty($emid)) {
			//filter data by using barcode
			$emslist = $this->unregistered_model->get_ems_paid_list($barcode,$createdby='');
			
			if ($emslist) {

			//process of passing
				$data = array(
					'pass_to'=>$operator,
					'office_name'=>'InWard Open receive',
					'pass_from'=>'InWard Open',
					'created_by'=>$emid);

				$this->unregistered_model->update_transactions_data($data,$emslist[0]->t_id);

			//for tracing
				$trace_data = array(
					'emid'=>$emid,
					'trans_type'=>'mails',
					'transid'=>$emslist[0]->t_id,
					'office_name'=>'InWard Open receive',
					'description'=>'Pass from Non Bag section (Mails)',
					'status'=>'IN');

				$this->Box_Application_model->tracing($trace_data);

				$count = 1;
				$temp = '';
				foreach ($emslist as $key => $value) {

					$sn = (!empty($sn))? $sn:$count++;

					$temp .="<tr data-transid='".$value->t_id."' class='".$value->Barcode." tr".$value->t_id." receiveRow'> <td>".$sn."</td>
					<td>".$value->sender_fullname."</td>
					<td>".$value->receiver_fullname."</td>
					<td>".$value->sender_date_created."</td>
					<td>".$value->paidamount."</td>
					<td>".$value->register_weght."</td>
					<td>".$value->sender_branch."</td>
					<td>".$value->reciver_branch."</td>
					<td>".$value->billid."</td>
					<td>".$value->Barcode."</td>
					<td>".$value->status."</td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value->t_id."' class='form-check-input ".$value->Barcode."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}

				$response['status'] = "Success";
				$response['msg'] = $temp;
				$response['total'] = sizeof($emslist);
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "Huduma Haijalipiwa";
			}

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please enter barcode";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}

//---RECEIVE NON BAG EMS

public function Receive_non_bag_item(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = base64_decode($this->input->get('I'));
		$this->load->view('ems/Receive_non_bag_item');
	}else{
		redirect(base_url());
	}
}


public function receiveScanNonBagItem(){
	if ($this->session->userdata('user_login_access') != false){
		$barcode = $this->input->post('barcode');
		$operator = $this->input->post('operator');
		$zonetype = $this->input->post('zonetype');
		$sn = $this->input->post('sn');

		$emid = $this->session->userdata('user_login_id');

		if (!empty($barcode) && !empty($emid)) {
			//filter data by using barcode
			$emslist = $this->Box_Application_model->get_ems_paid_list($barcode,$createdby='');

			if ($emslist) {

			//process of passing
				$data = array(
					'pass_to'=>$operator,
					'office_name'=>'InWard receive',
					'pass_from'=>'InWard',
					'created_by'=>$emid);

				$this->Box_Application_model->update_office_name($emslist[0]->id,$data);


			//for tracing
				$trace_data = array(
					'emid'=>$emid,
			//'pass_to'=>$operator,
					'transid'=>$emslist[0]->id,
					'office_name'=>'InWard receive',
					'description'=>'Pass from Non Bag section (EMS)',
					'status'=>'IN');

				$this->Box_Application_model->tracing($trace_data);

				$count = 1;
				$temp = '';
				foreach ($emslist as $key => $value) {

					$sn = $count++;

					if ($value->s_pay_type == 'Cash'){

						if ($value->status == 'NotPaid') {
							$pay_status  = "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
						}else{
							$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
						}
						
					}else{

						$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
					}

					$temp .="<tr data-transid='".$value->id."' class='".$value->Barcode." tr".$value->id." receiveRow'> <td>".$sn."</td>
					<td>".$value->s_fullname."</td>
					<td>".$value->fullname."</td>
					<td>".$value->date_registered."</td>
					<td>".$value->paidamount."</td>
					<td>".$value->weight."</td>
					<td>".$value->s_district."</td>
					<td>".$value->branch."</td>
					<td>".$value->billid."</td>
					<td>".$value->Barcode."</td>
					<td>".$pay_status."</td>;
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value->id."' class='form-check-input ".$value->Barcode."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}

				$response['status'] = "Success";
				$response['msg'] = $temp;
				$response['total'] = sizeof($emslist);
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "Huduma Haijalipiwa";
			}

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please enter barcode";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}


public function item_received_non_bag(){
	if ($this->session->userdata('user_login_access') != false){
		$assignedby = $this->session->userdata('user_login_id');
		$data['emselect'] = $this->employee_model->delivereselect();
		$operator = $this->input->post('operator');
		$fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');
		$data['selected_section'] = $this->input->post('searched_name');

        //7 for
		$data['sectiondata'] = $this->employee_model->getDepartmentSections(7);

        //user details
		$todata  = $this->Box_Application_model->GetBasic($assignedby);

		$toFullName = $todata->first_name.' '.$todata->middle_name.' '.$todata->last_name;

		if (!empty($fromdate) && !empty($todate)) {

			$data['info'] = $this->ContractModel->get_employee_info($operator);
			$data['info_assignedby'] = $this->ContractModel->get_employee_info($assignedby);
			$data['fromdate'] = $fromdate;
			$data['todate'] = $todate;


			$listdata  = $this->Box_Application_model->NonBagtransTracingMaster(
				$transid='',
				$assignedby,
				$pass_to='',
				$office_name='InWard receive',
				$status='IN',
				$fromdate,$todate,
				$trans_type='',
				$type='',
				$description='Pass from Non Bag section');

			if ($listdata) {

				foreach ($listdata as $key => $trace) {

					$tranDetails  = $this->Box_Application_model->transanctionsData($trace['transid']);

					$fromdata  = $this->Box_Application_model->GetBasic($trace['emid']);

					if ($trace['description'] != 'removed') {
						$newList[$tranDetails[0]['Barcode']]['Barcode'] = $tranDetails[0]['Barcode'];
						$newList[$tranDetails[0]['Barcode']]['fromFullName'] = $fromdata->first_name.' '.$fromdata->middle_name.' '.$fromdata->last_name;

						$newList[$tranDetails[0]['Barcode']]['trans_status']  = $trace['status'];
						$newList[$tranDetails[0]['Barcode']]['description']  = $trace['description'];
						$newList[$tranDetails[0]['Barcode']]['s_fullname']  = $tranDetails[0]['s_fullname'];

						$newList[$tranDetails[0]['Barcode']]['fullname']  = $tranDetails[0]['fullname'];
					}
				}

            	// echo "<pre>";
            	// print_r($newList);
            	// die();

				$data['listdata'] = $newList;

			}
		}

		$this->load->view('ems/item_received_nonbag_list.php',$data);
	}else{
		redirect(base_url());
	}
}

//-------------Deriverying Mails start here!!

public function passTodeliveryMails(){
	if ($this->session->userdata('user_login_access') != false){
		$fromzone = $_GET['fromzone'];

		$data['region'] = $this->employee_model->regselect();
		$data['emselect'] = $this->employee_model->delivereselectByType($fromzone);
		$data['agselect'] = $this->employee_model->agselect();

		$data['emslist1'] = $this->Box_Application_model->get_ems_back_list();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['ems'] = $this->Box_Application_model->count_ems();

		$data['bags'] = $this->Box_Application_model->count_bags();


		$this->load->view('domestic_ems/pass_mails_delivery',$data);
	}else{
		redirect(base_url());
	}
}

public function passToDeliveringProcessMails(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$operator = $this->input->post('operator');
		$type = $this->input->post('type');
		$sn = $this->input->post('sn');

		$EEMS = $this->unregistered_model->get_mails_application_list($staff_section="",$barcode,$pass_to="");

		$response  = array();
		$payload  = array();

		$basicinfo = $this->employee_model->GetBasic($emid);
		$region = $basicinfo->em_region;
		$em_branch = $basicinfo->em_branch;

		if (!empty($EEMS)) {
			
			if (sizeof($EEMS) > 1) {

				$response['status'] = 'Error';
				$response['msg'] = 'This barcode is entered more than one, please check with admin';

			}else{

				$payload['barcode '] = $EEMS[0]->Barcode;
				$payload['senderid '] = $EEMS[0]->senderp_id;
				$payload['empid '] = $operator;//deliver personel
				$payload['wfd_type '] = $type;//'single','pending' for bulk
				$payload['service_type '] = 'mail';
				$payload['assignedby '] = $emid;

				//Try to find if it exist
				//$checkBarcode = $this->Box_Application_model->checkDeliveryItems($EEMS[0]['Barcode'],$operatorname="");


				// if ($checkBarcode) {
				// 	$response['status'] = 'Error';
				// 	$response['msg'] = $barcode." Barcode it already assigned, check with admin";
				// }else{

				$Operatorbasicinfo = $this->employee_model->GetBasic($operator);

					//operatorFull name
				$OpatorFullName = $Operatorbasicinfo->first_name.' '.$Operatorbasicinfo->middle_name.' '.$Operatorbasicinfo->last_name;

					//for tracing
				$trace_data = array(
					'emid'=>$emid,
					'trans_type'=>'mails',
					'transid'=>$EEMS[0]->t_id,
					'office_name'=>'DELIVERY',
					'description'=>'Assigned for delivery '.$em_branch.' - ('.$OpatorFullName.')',
					'pass_to'=>$operator,
					'status'=>'Delivery');

				$this->Box_Application_model->tracing($trace_data);


					//saving the data
				$this->Box_Application_model->save_waiting_for_delivery($payload);

				$response['status'] = 'Success';
				$response['msg'] = "<tr style='background:blue;color:white;'> 
				<td>".$sn."</td>
				<td>".$EEMS[0]->sender_fullname."</td>
				<td>".$EEMS[0]->receiver_fullname."</td>
				<td>".$EEMS[0]->sender_branch."</td>
				<td>".$EEMS[0]->reciver_branch."</td>
				<td>".$EEMS[0]->Barcode."</td>
				<td><a href='#' 
				data-transid='".$EEMS[0]->t_id."'
				data-barcode='".$EEMS[0]->Barcode."' onclick='removeAssignedItem(this)' 
				class='btn btn-info btn-sm'><i class='fa fa-trash-o'></i> Remove</a></td></tr>";

		                 //echo $html;
				//}

			}
			
		}else{
			$response['status'] = 'Error';
			$response['msg'] = 'No data found';
		}
		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}

public function getOperatorPendingDeliveringMails(){
	if ($this->session->userdata('user_login_access') != false){
		$operator = $this->input->post('operator');
		$assignedby = $this->session->userdata('user_login_id');

		if ($operator) {

			$delivery = $this->unregistered_model->checkPendingDeliveryItemsMails($operator,$assignedby);

			if ($delivery) {
				$count = 1;
				foreach ($delivery as $key => $value) {
					$sn = $count++;

					echo "<tr class='receiveRow'> <td>".$sn."</td>
					<td>".$value['sender_fullname']."</td>
					<td>".$value['receiver_fullname']."</td>
					<td>".$value['sender_branch']."</td>
					<td>".$value['reciver_branch']."</td>
					<td>".$value['Barcode']."</td>
					<td><a href='#' 
					data-transid='".$value['t_id']."'
					data-barcode='".$value['Barcode']."' onclick='removeAssignedItem(this)' 
					class='btn btn-info btn-sm'><i class='fa fa-trash-o'></i> Remove</a></td>
					</tr>";
				}
				
			}else{
				echo "<tr> <td colspan='6'>No pending assigned</td></tr>";
			}
			
		}else{

		}

	}else{
		redirect(base_url());
	}
}

public function removeAssignedItemDeliveringMails(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$operator = $this->input->post('operator');

		if ($barcode) {
			//removing into the database;
			$this->Box_Application_model->delete_waiting_for_delivery($barcode);

			$Operatorbasicinfo = $this->employee_model->GetBasic($operator);
			//operatorFull name
			$OpatorFullName = $Operatorbasicinfo->first_name.' '.$Operatorbasicinfo->middle_name.' '.$Operatorbasicinfo->last_name;

			$OpatorBranch = $Operatorbasicinfo->em_branch;

			//for tracing
			$trace_data = array(
				'emid'=>$emid,
				'transid'=>$transid,
				'office_name'=>'Posta mlangoni',
				'description'=>'Removed from delivery Personel '.$OpatorBranch.' - ('.$OpatorFullName.')',
				'status'=>'Removed');

			//saving into the trace table
			$this->Box_Application_model->tracing($trace_data);
		}


	}else{
		redirect(base_url());
	}
}

//-----------------MAILS END here


public function InwardPassToOperatorByzone(){
	if ($this->session->userdata('user_login_access') != false){
		$barcode = $this->input->post('barcode');
		$operator = $this->input->post('operator');
		$zonetype = $this->input->post('zonetype');
		$sn = $this->input->post('sn');

		$emid = $this->session->userdata('user_login_id');

		if (!empty($barcode) && !empty($emid)) {
			//filter data by using barcode
			$emslist = $this->Box_Application_model->get_ems_bill_forInward_list('InWard receive',$barcode,$emid);

			if ($emslist) {

			//process of passing
				$data = array(
					'pass_to'=>$operator,
					'office_name'=>$zonetype,
					'pass_from'=>'InWard',
					'created_by'=>$emid);

				$this->Box_Application_model->update_office_name($emslist[0]->id,$data);


			//for tracing
				$trace_data = array(
					'emid'=>$emid,
					'pass_to'=>$operator,
					'transid'=>$emslist[0]->id,
					'office_name'=>$zonetype,
					'status'=>'IN');

				$this->Box_Application_model->tracing($trace_data);

				$count = 1;
				$temp = '';

				foreach ($emslist as $key => $value) {
					$sn = $count++;

					$temp .="<tr data-transid='".$value->id."' class='".$value->Barcode." tr".$value->id." receiveRow'> <td>".$sn."</td>
					<td>".$value->s_fullname."</td>
					<td>".$value->fullname."</td>
					<td>".$value->date_registered."</td>
					<td>".$value->paidamount."</td>
					<td>".$value->weight."</td>
					<td>".$value->s_district."</td>
					<td>".$value->branch."</td>
					<td>".$value->billid."</td>
					<td>".$value->Barcode."</td>
					<td><a href='#' 
					data-transid='".$value->id."'
					data-barcode='".$value->Barcode."' onclick='removeInWardPassedItem(this)' 
					class='btn btn-info btn-sm'><i class='fa fa-trash-o'></i> Remove</a></td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value->id."' class='form-check-input ".$value->Barcode."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}
				

				// $temp .='<tr><td colspan="11"></td><td style="float: right;">
				// <a class="btn btn-success" href="'.base_url().'Services/Distributer" class="text-white"><i class="" aria-hidden="true"></i> Receive </a>
				// 	</td></tr>';

				$response['status'] = "Success";
				$response['msg'] = $temp;
				$response['total'] = sizeof($emslist);
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "Huduma Haijalipiwa";
			}

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please enter barcode";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}


public function getPassedItemsByOperator(){
	if ($this->session->userdata('user_login_access') != false){
		$assignedby = $this->session->userdata('user_login_id');

		$operator = $this->input->post('operator');
		$date = date('Y-m-d');

		$fromdate = $date;
		$todate = $date;
		$selected_section = $this->input->post('zonetype');
		$removefunction = $this->input->post('removefunction');
		$forditributer = $this->input->post('forditributer');


		if (!empty($operator) && !empty($fromdate) && !empty($todate)) {

			$listdata  = $this->Box_Application_model->transTracingMaster(
				$transid='',
				$assignedby,
				$operator,
				$office_name=$selected_section,
				$status='IN',$fromdate,$todate,$trans_type='',$type='');


			if ($listdata) {

				$count = 1;
				$temp = '';
				foreach ($listdata as $key => $trace) {
					$sn = $count++;

					$tranDetails  = $this->Box_Application_model->transanctionsData($trace['transid']);

					$temp .="<tr data-transid='".@$tranDetails[0]['id']."' 
					class='".@$tranDetails[0]['Barcode']." tr".@$tranDetails[0]['id']." receiveRow'> <td>".$sn."</td>
					<td>".@$tranDetails[0]['s_fullname']."</td>
					<td>".@$tranDetails[0]['fullname']."</td>
					<td>".@$tranDetails[0]['date_registered']."</td>";

					if (@$forditributer != 'yes') {
						$temp.="<td>".@$tranDetails[0]['paidamount']."</td>
						<td>".@$tranDetails[0]['weight']."</td>";
					}

					$temp.="<td>".@$tranDetails[0]['s_district']."</td>
					<td>".@$tranDetails[0]['branch']."</td>
					<td>".@$tranDetails[0]['billid']."</td>
					<td>".@$tranDetails[0]['Barcode']."</td>
					<td><a href='#' 
					data-transid='".@$tranDetails[0]['id']."'
					data-barcode='".@$tranDetails[0]['Barcode']."' onclick='".@$removefunction."(this)' 
					class=''><i class='fa fa-trash-o'></i> Remove</a></td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".@$tranDetails[0]['id']."' class='form-check-input ".@$tranDetails[0]['Barcode']."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}

				$response['status'] = "Success";
				$response['msg'] = $temp;
				$response['total'] = sizeof($listdata);
			}else{
				$response['status'] = "Error";
				$response['msg'] = "Huduma Haijalipiwa";
			}
			print_r(json_encode($response));
		}
	}else{
		redirect(base_url());
	}
}


public function removeInWardPassedItem(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$operator = $this->input->post('operator');

		if ($barcode) {

			//process of passing
			$data = array(
				'pass_to'=>'',
				'office_name'=>'InWard receive',
				'pass_from'=>'',
				'created_by'=>$emid);

			$this->Box_Application_model->update_office_name($transid,$data);


			$Operatorbasicinfo = $this->employee_model->GetBasic($operator);
			//operatorFull name
			$OpatorFullName = $Operatorbasicinfo->first_name.' '.$Operatorbasicinfo->middle_name.' '.$Operatorbasicinfo->last_name;

			//update trace to remove IN
			$this->Box_Application_model->update_trace_data(
				$emid,
				$transid,
				$operator,
				array('status'=>'remove IN'));
			

			//for tracing
			$trace_data = array(
				'emid'=>$emid,
				'transid'=>$transid,
				'office_name'=>'InWard',
				'description'=>'Deleted by ('.$OpatorFullName.')',
				'status'=>'Removed');

			//saving into the trace table
			$this->Box_Application_model->tracing($trace_data);
		}


	}else{
		redirect(base_url());
	}
}


public function removeDistributerPassedItem(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$operator = $this->input->post('operator');

		if ($barcode) {

			//process of passing
			$data = array(
				'pass_to'=>'',
				'office_name'=>'Distributer receive',
				'pass_from'=>'',
				'created_by'=>$emid);

			$this->Box_Application_model->update_office_name($transid,$data);


			$Operatorbasicinfo = $this->employee_model->GetBasic($operator);
			//operatorFull name
			$OpatorFullName = $Operatorbasicinfo->first_name.' '.$Operatorbasicinfo->middle_name.' '.$Operatorbasicinfo->last_name;

			//update trace to remove IN
			$this->Box_Application_model->update_trace_data(
				$emid,
				$transid,
				$operator,
				array('status'=>'remove IN'));

			//for tracing
			$trace_data = array(
				'emid'=>$emid,
				'transid'=>$transid,
				'office_name'=>'Distributer',
				'description'=>'Deleted from ('.$OpatorFullName.')',
				'status'=>'Removed');

			//saving into the trace table
			$this->Box_Application_model->tracing($trace_data);
		}


	}else{
		redirect(base_url());
	}
}


public function DistributerPassToOperatorByzone(){
	if ($this->session->userdata('user_login_access') != false){
		$barcode = $this->input->post('barcode');
		$operator = $this->input->post('operator');
		$zonetype = $this->input->post('zonetype');

		$emid = $this->session->userdata('user_login_id');

		if (!empty($barcode) && !empty($emid)) {
			//filter data by using barcode
			$emslist = $this->Box_Application_model->getTransactionsOfficeBybarcode($barcode,'Distributer receive',$empid='',$pass_to='');

			if ($emslist) {

			//process of passing
				$data = array(
					'pass_to'=>$operator,
					'office_name'=>$zonetype,
					'pass_from'=>'Distributer',
					'created_by'=>$emid);

				$this->Box_Application_model->update_office_name($emslist[0]['id'],$data);

			//for tracing
				$trace_data = array(
					'emid'=>$emid,
					'pass_to'=>$operator,
					'transid'=>$emslist[0]['id'],
					'office_name'=>$zonetype,
					'status'=>'IN');

				$this->Box_Application_model->tracing($trace_data);

				$count = 1;
				$temp = '';
				foreach ($emslist as $key => $value) {
					$sn = $count++;

					if ($value['s_pay_type'] == 'Cash'){

						if ($value['status'] == 'NotPaid') {
							$pay_status  = "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
						}else{
							$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
						}
						
					}else{

						$pay_status  = "<button class='btn btn-success btn-sm' disabled>Paid</button>";
					}

					$temp .="<tr data-transid='".$value['id']."' class='".$value['Barcode']." tr".$value['id']." receiveRow'> <td>".$sn."</td>
					<td>".$value['s_fullname']."</td>
					<td>".$value['fullname']."</td>
					<td>".$value['date_registered']."</td>
					<td>".$value['s_district']."</td>
					<td>".$value['branch']."</td>
					<td>".$value['billid']."</td>
					<td>".$value['Barcode']."</td>
					<td><a href='#' 
					data-transid='".$value['id']."'
					data-barcode='".$value['Barcode']."' onclick='removeDistributerPassedItem(this)' 
					class='btn btn-info btn-sm'><i class='fa fa-trash-o'></i> Remove</a></td>
					<td>
					<div class='form-check' style='padding-left: 53px;float:left'>
					<input type='checkbox' name='transactions' value='".$value['id']."' class='form-check-input ".$value['Barcode']."' style='padding-right:50px;' />
					<label class='form-check-label' for='remember-me'></label>
					</div></td></tr>";

				}

				// $temp .='<tr><td colspan="11"></td><td style="float: right;">
				// <a class="btn btn-success" href="'.base_url().'Services/Distributer" class="text-white"><i class="" aria-hidden="true"></i> Receive </a>
				// 	</td></tr>';

				$response['status'] = "Success";
				$response['msg'] = $temp;
				
			}else{
				$response['status'] = "Error";
				$response['msg'] = "Huduma Haijalipiwa";
			}

		}else{
			$response['status'] = "Error";
			$response['msg'] = "Please enter barcode";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}


public function Ems_Application_bill_List()
{
	if ($this->session->userdata('user_login_access') != false){

		$emid = base64_decode($this->input->get('I'));
		$data['region'] = $this->employee_model->regselect();
		$data['emselect'] = $this->employee_model->emselect();
		$data['agselect'] = $this->employee_model->agselect();

		if ($this->session->userdata('user_type') == "ACCOUNTANT-HQ" || $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' || $this->session->userdata('user_type') == "BOP") {

			$date = $this->input->post('date');
			$date2 = $this->input->post('date2');
			$month = $this->input->post('month');
			$month = $this->input->post('month');
			$month2 = $this->input->post('month2');
			$year4 = $this->input->post('year');
			$region = $this->input->post('region');
			$type = $this->input->post('ems_type');
			if(empty($region))
			{
				$region = 'Dar es salaam';
				$type  = 'EMS';

			}

			$data['total'] = $this->Box_Application_model->get_ems_bill_sumACC($region,$date,$date2,$month,$month2,$year4,$type);
			$data['emslist'] = $this->Box_Application_model->get_ems_bill_listAcc($region,$date,$date2,$month,$month2,$year4,$type);

		} else {

			$pf = $this->input->post('pf');
			$date = $this->input->post('date');
			$month = $this->input->post('month');

			if(!empty($pf)){
        	//turn code to emid
				$emid2=$this->Box_Application_model->getemid($pf);
				$emid2=$emid2->em_id;
				if(!empty($emid2))
				{

					if (!empty($date) || !empty($month)) {

						$data['total'] = $this->Box_Application_model->get_ems_bill_sumSearchpf($date,$month,$emid2);
						$data['emslist'] = $this->Box_Application_model->get_ems_bill_listSearchpf($date,$month,$emid2);
					} else {
						$data['total'] = $this->Box_Application_model->get_ems_bill_sum();
						$data['emslist'] = $this->Box_Application_model->get_ems_bill_list();
					}

				} 

			}else{

				if (!empty($date) || !empty($month)) {
					$data['total'] = $this->Box_Application_model->get_ems_bill_sumSearch($date,$month);
					$data['emslist'] = $this->Box_Application_model->get_ems_bill_listSearch($date,$month);
				} else {
					$data['total'] = $this->Box_Application_model->get_ems_bill_sum();
					$data['emslist'] = $this->Box_Application_model->get_ems_bill_list();
				}
			}
		}   

		$this->load->view('domestic_ems/Ems_Application_bill_List',$data);

	}
	else{
		redirect(base_url());
	}

}

public function getEmployeeinshift(){

	$date = $this->input->post('date',TRUE);  
      //run the query for the cities we specified earlier  
	echo $this->Box_Application_model->GetEmployeeAssignedByDate($date);
}


public function Ems_Application_List1()
{
	if ($this->session->userdata('user_login_access') != false){

		$emid = base64_decode($this->input->get('I'));

		$data['emid'] = $emid;
		if ($this->session->userdata('user_type') == "SUPERVISOR") {

			if(empty($emid)){

				$data['total'] = $this->Box_Application_model->get_ems_sum();
				$data['emslist'] = $this->Box_Application_model->get_ems_list();
				$data['region'] = $this->employee_model->regselect();
				$this->load->view('billing/ems_application_list_supervisor',$data);

			}else{

				$data['total'] = $this->Box_Application_model->get_ems_sum();
				$data['emslist'] = $this->Box_Application_model->get_ems_list_by_emid($emid);
				$data['region'] = $this->employee_model->regselect();
				$id = $emid;
				$data['getJob'] = $this->employee_model->get_services_byEmId($id);
				$data['getCounter'] = $this->Box_Application_model->get_counter_byEmId($id);

				$this->load->view('billing/ems_application_list1',$data);

			}


		} else {

			$data['total'] = $this->Box_Application_model->get_ems_sum();
			$data['emslist']=$lst = $this->Box_Application_model->get_ems_list();
			$data['region'] = $this->employee_model->regselect();

	//echo json_encode($lst);

			$this->load->view('billing/ems_application_list',$data);

		}



	}
	else{
		redirect(base_url());
	}
}
public function Ems_BackOffice()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$data['total'] = $this->Box_Application_model->get_backoffice_sum();
		$data['emslist'] = $this->Box_Application_model->get_backoffice_list();
		$this->load->view('billing/ems_backoffice_list',$data);
	}
	else{
		redirect(base_url());
	}
}


public function customer_ems_price_vat()
{
	$weight = $this->input->post('weight');
	$emsCat = $this->input->post('tariffCat');
	$branch = $this->session->userdata('user_branch');

	if($branch=="Tarakea(holoholo)" || $branch=="Namanga" || $branch=="Mtukula" || $branch=="Tunduma" || $branch=="Kyaka" || $branch=="Tanga-HPO"){
		$price = $this->Box_Application_model->special_ems_cus_price($weight);
	}
	else
	{
		$price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
	}

	$vat = $price->vat;
	$emsprice = $price->tariff_price;
	$totalPrice = $vat + $emsprice;

	if (empty($price)) {

		echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
		<tr><th colspan='2'>TBS TANZANIA SPECIAL TARIFF</th></tr>
		<tr><th colspan='2'>Charges</th></tr>
		<tr><th colspan='2'>Charges</th></tr>
		<tr><td><b>Price:</b></td><td>0</td></tr>
		<tr><td><b>Vat:</b></td><td>0</td></tr>
		<tr><td><b>Total Price:</b></td><td>0</td></tr>
		</table><br />";

	}
	else
	{

		echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
		<tr><th colspan='2'>TBS TANZANIA SPECIAL TARIFF</th></tr>
		<tr><th colspan='2' style=''>Charges</th></tr>
		<tr><th>Description</th><th>Amount (Tsh.)</th></tr>
		<tr><td><b>Price:</b></td><td>".$emsprice."</td></tr>
		<tr><td><b>Vat:</b></td><td>".$vat."</td></tr>
		<tr><td><b>Total Price:</b></td><td>".number_format($totalPrice)."</td></tr>
		</table><br />
		";
	//<input type='text' name ='price1' value='$totalPrice' class='price1'>
			// <input type='text' name ='vat' value='$vat' class='price1'>
			// <input type='text' name ='price2' value='$emsprice' class='price1'>
	}

}





public function Ems_price_vat()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$emsCat = $this->input->post('tariffCat');
		$weight = $this->input->post('weight');
		$acc_no = $this->input->post('acc_no');

		if($weight > 10){

			$weight10    = 10;


			$getPrice    = $this->Box_Application_model->ems_cat_price10($emsCat,$weight10);

			$vat10       = $getPrice->vat;
			$price10     = $getPrice->tariff_price;
			$totalprice10 = $vat10 + $price10;

			$diff   =  $weight - $weight10;

			if ($diff <= 0.5) {

				if ($emsCat == 1) {
					$totalPrice = $totalprice10 + 2300;
				} else {
					$totalPrice = $totalprice10 + 3500;
				}

				$dvat = $totalPrice * 0.18;
				$dprice = $totalPrice - ($totalPrice * 0.18);
				if($acc_no=="POSTPAID-1651"){ echo "TBS TANZANIA SPECIAL TARIFF";}
				echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
				<tr><th colspan='2' style=''>Charges</th></tr>
				<tr><th>Description</th><th>Amount (Tsh.)</th></tr>

				<tr><td><b>Price:</b></td><td><input class='dprice' readonly value='".$dprice."'/></td></tr>
				<tr><td><b>Vat:</b></td><td><input class='dpvat' readonly value='".$dvat."'/></td></tr>
				<tr><td><b>Total Price:</b></td><td><input class='dpTotalPrice' readonly value='".@$totalPrice."'/></td>


				</table>

				";

			// <input type='text' name ='price1' value='$totalPrice' class='price1'>
			// <input type='text' name ='vat' value='$dvat' class='price1'>
			// <input type='text' name ='price2' value='$dprice' class='price1'>

			} else {

				$whole   = floor($diff);
				$decimal = fmod($diff,1);
				if ($decimal == 0) {

					if ($emsCat == 1) {
						$totalPrice = $totalprice10 + ($whole*1000/500)*2300;
					} else {
						$totalPrice = $totalprice10 + ($whole*1000/500)*3500;
					}

				} else {

					if ($decimal <= 0.5) {

						if ($emsCat == 1) {
							$totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300;
						} else {
							$totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500;
						}

					} else {

						if ($emsCat == 1) {
							$totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300+2300;
						} else {
							$totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500+3500;
						}
					}

				}
				$dvat = $totalPrice * 0.18;
				$dprice = $totalPrice - ($totalPrice * 0.18);

				if($acc_no=="POSTPAID-1651"){ echo "TBS TANZANIA SPECIAL TARIFF";}
				echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
				<tr><th colspan='2' style=''>Charges</th></tr>
				<tr><th>Description</th><th>Amount (Tsh.)</th></tr>

				<tr><td><b>Price:</b></td><td><input class='dprice' readonly value='".$dprice."'/></td></tr>
				<tr><td><b>Vat:</b></td><td><input class='dpvat' readonly value='".$dvat."'/></td></tr>
				<tr><td><b>Total Price:</b></td><td><input class='dpTotalPrice' readonly value='".@$totalPrice."'/></td>

				</table><br />

				";
			// <input type='text' name ='price1' value='$totalPrice' class='price1'>
			// <input type='text' name ='vat' value='$dvat' class='price1'>
			// <input type='text' name ='price2' value='$dprice' class='price1'>
			}


		}else{


			$price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);


			if (empty($price)) {

				if($acc_no=="POSTPAID-1651"){ echo "TBS TANZANIA SPECIAL TARIFF";}
				echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
				<tr><th colspan='2'>Charges</th></tr>
				<tr><td><b>Price:</b></td><td>0</td></tr>
				<tr><td><b>Vat:</b></td><td>0</td></tr>
				<tr><td><b>Total Price:</b></td><td>0</td></tr>
				</table><br />";

			}else{

				$vat = $price->vat;
				$emsprice = $price->tariff_price;
				$totalPrice = $vat + $emsprice;

				if($acc_no=="POSTPAID-1651"){ echo "TBS TANZANIA SPECIAL TARIFF";}
				echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
				<tr><th colspan='2' style=''>Charges</th></tr>
				<tr><th>Description</th><th>Amount (Tsh.)</th></tr>
				<tr><td><b>Price:</b></td><td><input class='dprice' readonly value='".$emsprice."' /></td></tr>
				<tr><td><b>Vat:</b></td><td><input class='dpvat' readonly value='".$vat."' /></td></tr>
				<tr><td><b>Total Price:</b></td><td><input class='dpTotalPrice' readonly value='".$totalPrice."' /></td>
				</tr>
				</table><br />

				";

			// <input type='text' name ='price1' value='$totalPrice' class='price1'>
			// <input type='text' name ='vat' value='$vat' class='price1'>
			// <input type='text' name ='price2' value='$emsprice' class='price1'>

			}
		}

	}else{
		redirect(base_url());
	}
}

public function Ems_price_vat_Get($emsCat,$weight)
{
	if ($this->session->userdata('user_login_access') != false)
	{


		if($weight > 10){

			$weight10    = 10;
			$getPrice    = $this->Box_Application_model->ems_cat_price10($emsCat,$weight10);

			$vat10       = $getPrice->vat;
			$price10     = $getPrice->tariff_price;
			$totalprice10 = $vat10 + $price10;

			$diff   =  $weight - $weight10;

			if ($diff <= 0.5) {

				if ($emsCat == 1) {
					$totalPrice = $totalprice10 + 2300;
				} else {
					$totalPrice = $totalprice10 + 3500;
				}

				$dvat = $totalPrice * 0.18;
				$dprice = $totalPrice - ($totalPrice * 0.18);


			} else {

				$whole   = floor($diff);
				$decimal = fmod($diff,1);
				if ($decimal == 0) {

					if ($emsCat == 1) {
						$totalPrice = $totalprice10 + ($whole*1000/500)*2300;
					} else {
						$totalPrice = $totalprice10 + ($whole*1000/500)*3500;
					}

				} else {

					if ($decimal <= 0.5) {

						if ($emsCat == 1) {
							$totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300;
						} else {
							$totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500;
						}

					} else {

						if ($emsCat == 1) {
							$totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300+2300;
						} else {
							$totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500+3500;
						}
					}

				}
				$dvat = $totalPrice * 0.18;
				$dprice = $totalPrice - ($totalPrice * 0.18);

			}


		}else{

			$price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);

			$vat = $price->vat;
			$emsprice = $price->tariff_price;
			$totalPrice = $vat + $emsprice;




		}

	}else{
		redirect(base_url());
	}
}

public function getnumber(){

	$getuniquelastnumber= $this->Box_Application_model->get_last_number();

            //check length
	if(empty($getuniquelastnumber) || is_null($getuniquelastnumber)){
		$number = 1;
		$nmbur = array();
		$nmbur = array('number'=>$number);

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('tracknumber',$nmbur);

		$no_of_digit = 5;

		$length = strlen((string)$number);
		$numberk = '';
		for($i = $length;$i<$no_of_digit;$i++)
		{
			$numberk = '0'.$numberk;
		}

		$number=$numberk.$number;


	}else{
		$no_of_digit = 5;
		$numbers = @$getuniquelastnumber->number;
		$numbers=$numbers+1;
		$number = @$getuniquelastnumber->number;

		$length = strlen((string)$number);
		$numbera='';
		for($i = $length;$i<$no_of_digit;$i++)
		{
			$numbera = '0'.$numbera;
		}
		$number=$numbera.$numbers;


		$nmbur = array();
		$nmbur = array('number'=>$numbers);
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('tracknumber',$nmbur);


	}

	return $number;
}


public function Register_Ems_Action()
{
	if ($this->session->userdata('user_login_access') != false)
	{

		$id = $this->session->userdata('user_login_id');
		$info = $this->employee_model->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;
		$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;

		$TotalOtheritemArrayamounts = $this->input->post('TotalOtheritemArrayamounts');
		$TotalOtheritemArrayvalues = $this->input->post('TotalOtheritemArrayvalues');
		if(!empty($_POST['OtheritemArray']))
		{
			$myArray2 = $_POST['OtheritemArray'];
			$OtheritemArray    = json_decode($myArray2);

		}

		$TotalNonweightamounts = $this->input->post('TotalNonweightamounts');
		$TotalNonweightvalues = $this->input->post('TotalNonweightvalues');
//$OutstandingArray = $this->input->post('OutstandingArray');
//$myArray2 = $_REQUEST['OutstandingArray'];
		if(!empty($_POST['NonweightArray']))
		{
			$myArray = $_POST['NonweightArray'];
			$NonweightArray    = json_decode($myArray);

		}

		$prc=0;


		$Barcode = $this->input->post('Barcode');
		$sender_address = $this->input->post('s_mobilev');
		$receiver_address = $this->input->post('r_mobilev');
		$target_url = "http://192.168.33.7/api/virtual_box/";


		if(empty($sender_address) && empty($receiver_address)){

			$addressT = "physical";
			$addressR = "physical";
			$s_fname = $this->input->post('s_fname');
			$s_address = $this->input->post('s_address');
			$s_email = $this->input->post('s_email');
			$s_mobile = $mobile = $this->input->post('s_mobile');
			$r_fname = $this->input->post('r_fname');
			$r_address = $this->input->post('r_address');
			$r_mobile = $this->input->post('r_mobile');
			$r_email = $this->input->post('r_email');
			$rec_region = $this->input->post('region_to');
			$rec_dropp = $this->input->post('district');

		}

		if(empty($sender_address)){
			$addressT = "physical";
			$s_fname = $this->input->post('s_fname');
			$s_address = $this->input->post('s_address');
			$s_email = $this->input->post('s_email');
			$s_mobile = $mobile = $this->input->post('s_mobile');
		}

		if (empty($receiver_address)) {

			$addressR = "physical";
			$r_fname = $this->input->post('r_fname');
			$r_address = $this->input->post('r_address');
			$r_mobile = $this->input->post('r_mobile');
			$r_email = $this->input->post('r_email');
			$rec_region = $this->input->post('region_to');
			$rec_dropp = $this->input->post('district');

		}
		if (!empty($sender_address)) {

			$addressT = "virtual";

			$phone =  $sender_address;


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

			$s_fname = $answer->full_name;
			$s_address = $answer->phone;
			$s_email = '';
			$s_mobile = $answer->phone;

		}if(!empty($receiver_address)){

			$addressR = "virtual";
			$phone =  $receiver_address;


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

			$r_fname = $answer->full_name;
			$r_address = $answer->phone;
			$r_mobile = $answer->phone;
			$r_email = '';
			$rec_region = $answer->region;
			$rec_dropp = $answer->post_office;

		}


		$id = $this->session->userdata('user_login_id');
		$info = $this->employee_model->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;
//$operator = 'PF'. '  '.$info->em_code. '  '.$info->first_name.'  '.$info->middle_name. '  '.$info->last_name;

		$transactionstatus   = 'POSTED';
		$bill_status  = 'PENDING';
		$PaymentFor = 'Post Cargo';
		$transactiondate = date("Y-m-d");
		$fullname  = $s_fname;
		$mobile = $s_mobile;
		$source = $this->employee_model->get_code_source($o_region);
		$dest = $this->employee_model->get_code_dest($rec_region);

		$bagsNo = $source->reg_code . $dest->reg_code;
		$serial    = 'CARGO'.date("YmdHis").$source->reg_code;

		$number = $this->getnumber();

		@$trackNo = 'PC'.@$source->reg_code . @$dest->reg_code.$number.'TZ';



		$emstype = '';
		$emsCat = 0;
		$weight = '';
	//$prc = $this->input->post('price');
		$sender = array();
		$sender = array('serial'=>$serial,'ems_type'=>$emstype,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$s_mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$info->em_id,'track_number'=>$trackNo,'add_type'=>$addressT);

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('sender_info',$sender);
		$last_id = $db2->insert_id();


		$receiver = array();
		$receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp,'add_type'=>$addressR);

		$db2->insert('receiver_info',$receiver);

	//get price by cat id and weight range;




		if($TotalOtheritemArrayamounts > 0 ) 
		{
			if($TotalOtheritemArrayvalues == 0){

	//echo json_encode($OutstandingArray);
				$type = $OtheritemArray[0]->boxtype;
				$weight =$OtheritemArray[0]->weight;
				if ($type == "fooditem") {
					$price = $this->unregistered_model->food_item_price($weight);
				} elseif($type == "nonfooditem"){
					$price = $this->unregistered_model->nonfood_item_price($weight);
				}else{
					$price = $this->unregistered_model->nonfood_item_price($weight);
				}
				$emsprice = $price->tarrif + $price->vat;
				$prc = $prc + $emsprice;

				$Outstanding11 = array();
				$Outstanding11 = array('type'=>$type,'item_price'=>$emsprice,'weight'=>$weight,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);
				$this->Box_Application_model->save_posts_cargo($Outstanding11);



			}
			else
			{

				foreach ($OtheritemArray as $key => $variable) {

					$type = $variable->boxtype;
					$weight =$variable->weight;


					if ($type == "fooditem") {
						$price = $this->unregistered_model->food_item_price($weight);
					} elseif($type == "nonfooditem"){
						$price = $this->unregistered_model->nonfood_item_price($weight);
					}else{
						$price = $this->unregistered_model->nonfood_item_price($weight);
					}
					$emsprice = $price->tarrif + $price->vat;
					$prc = $prc + $emsprice;

					$Outstanding = array();
					$Outstanding = array('type'=>$type,'item_price'=>$emsprice,'weight'=>$weight,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);
					$this->Box_Application_model->save_posts_cargo($Outstanding);

				}

			}

		}


		if($TotalNonweightamounts > 0 ) 
		{
			if($TotalNonweightvalues == 0){

	//echo json_encode($OutstandingArray);
				$type = 'Non Weighted';
				$item = $NonweightArray[0]->item;
				$destination =$NonweightArray[0]->destination;
				$price = $this->unregistered_model->nonweighed_item_price($item,$destination);
				$emsprice = $price->tarrif + $price->vat;
				$prc = $prc + $emsprice;

				$Outstanding = array();
				$Outstanding = array('type'=>$type,'item'=>$item,'item_price'=>$emsprice,'destination'=>$destination,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);
				$this->Box_Application_model->save_posts_cargo($Outstanding);

			}
			else
			{

				foreach ($NonweightArray as $key => $variable) {

					$type = 'Non Weighted';
					$item = $variable->item;
					$destination =$variable->destination;
					$price = $this->unregistered_model->nonweighed_item_price($item,$destination);
					$emsprice = $price->tarrif + $price->vat;
					$prc = $prc + $emsprice;
					$Outstanding = array();
					$Outstanding = array('type'=>$type,'item'=>$item,'item_price'=>$emsprice,'destination'=>$destination,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);
					$this->Box_Application_model->save_posts_cargo($Outstanding);


				}

			}

		}




		$data22 = array(

			'transactiondate'=>date("Y-m-d"),
			'serial'=>$serial,
			'paidamount'=>$prc,
			'CustomerID'=>$last_id,
			'Customer_mobile'=>$mobile,
			'region'=>$o_region,
			'Barcode'=>strtoupper($Barcode),
			'district'=>$o_branch,
			'transactionstatus'=>'POSTED',
			'bill_status'=>'PENDING',
			'paymentFor'=>$PaymentFor

		);

   //echo json_encode($data22) ;

		$this->Box_Application_model->save_transactions($data22);

		$paidamount = $prc;
		$region = $o_region;
		$district = $o_branch;
		$renter   = $s_fname;
		$serviceId = 'POST_CARGO';
		$trackno = $trackNo;


		$sender_region = $this->session->userdata('user_region');
		$sender_branch = $this->session->userdata('user_branch');

		$postbill =  $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackNo); 
//$this->getBillGepgBillId($serial, $paidamount,$district,$region,$mobile,$renter,$serviceId);

		if (!empty($postbill->controlno)  ) {


				  // $trackno = array();
      //           $trackno = array('track_number'=>$trackNo);

      //            $this->billing_model->update_sender_info($last_id,$trackno);

			$info = $this->employee_model->GetBasic($id);
			$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
			$location= $info->em_region.' - '.$info->em_branch;
			$loc= $info->em_region.' - '.$info->em_branch;
			$data = array();
			$data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

			$this->Box_Application_model->save_location($data);

               // $this->unregistered_model->update_sender_info($last_id,$trackno);
                //$serial = $postbill->billid;

			$update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
			$this->billing_model->update_transactions($update,$serial);

                // $update = array();

                // $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
                // $this->unregistered_model->update_register_transactions1($update,$serial);

			$data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Post Cargo  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);

            //if (!empty($transaction->$controlno)) {

                //$this->load->view('inlandMails/posts-cargo-control-number-form',$data);

			try {
				$this->Sms_model->send_sms_trick($mobile,$sms);
			}
			catch (Exception $e) {
							   //echo json_encode($sms); 
			}	               

			echo json_encode($sms);
		}else{

			$repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackNo); 

                // $trackno = array();
                // $trackno = array('track_number'=>$trackNo);
                //  $this->billing_model->update_sender_info($last_id,$trackno);




			$info = $this->employee_model->GetBasic($id);
			$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
			$location= $info->em_region.' - '.$info->em_branch;
			$data = array();
			$data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

			$this->Box_Application_model->save_location($data);

                //$this->unregistered_model->update_sender_info($last_id,$trackno);

                //@$serial = $repostbill->billid;
			$update = array();
			$update = array('billid'=>$repostbill->controlno,'bill_status'=>'SUCCESS');
			$this->billing_model->update_transactions($update,$serial);

			$data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya Post Cargo  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                //$this->load->view('inlandMails/posts-cargo-control-number-form',$data);   

			try {
				$this->Sms_model->send_sms_trick($mobile,$sms);
			}
			catch (Exception $e) {
							   //echo json_encode($sms); 
			}

			echo json_encode($sms); 
		}
	}
	else{
		redirect(base_url());
	}

}




public function Register_Ems_Action_save_bulk()
{
	if ($this->session->userdata('user_login_access') != false)
	{

		$id = $this->session->userdata('user_login_id');
		$info = $this->employee_model->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;
		$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;

		$TotalOtheritemArrayamounts = $this->input->post('TotalOtheritemArrayamounts');
		$TotalOtheritemArrayvalues = $this->input->post('TotalOtheritemArrayvalues');
		if(!empty($_POST['OtheritemArray']))
		{
			$myArray2 = $_POST['OtheritemArray'];
			$OtheritemArray    = json_decode($myArray2);

		}

		$TotalNonweightamounts = $this->input->post('TotalNonweightamounts');
		$TotalNonweightvalues = $this->input->post('TotalNonweightvalues');
//$OutstandingArray = $this->input->post('OutstandingArray');
//$myArray2 = $_REQUEST['OutstandingArray'];
		if(!empty($_POST['NonweightArray']))
		{
			$myArray = $_POST['NonweightArray'];
			$NonweightArray    = json_decode($myArray);

		}

		$prc=0;


            $Barcode = strtoupper($this->input->post('Barcode'));//strtoupper()
            $sender_address = $this->input->post('s_mobilev');
            $receiver_address = $this->input->post('r_mobilev');
            $target_url = "http://192.168.33.7/api/virtual_box/";


            if(empty($sender_address) && empty($receiver_address)){

            	$addressT = "physical";
            	$addressR = "physical";
            	$s_fname = $this->input->post('s_fname');
            	$s_address = $this->input->post('s_address');
            	$s_email = $this->input->post('s_email');
            	$s_mobile = $mobile = $this->input->post('s_mobile');
            	$r_fname = $this->input->post('r_fname');
            	$r_address = $this->input->post('r_address');
            	$r_mobile = $this->input->post('r_mobile');
            	$r_email = $this->input->post('r_email');
            	$rec_region = $this->input->post('region_to');
            	$rec_dropp = $this->input->post('district');

            }

            if(empty($sender_address)){
            	$addressT = "physical";
            	$s_fname = $this->input->post('s_fname');
            	$s_address = $this->input->post('s_address');
            	$s_email = $this->input->post('s_email');
            	$s_mobile = $mobile = $this->input->post('s_mobile');
            }

            if (empty($receiver_address)) {

            	$addressR = "physical";
            	$r_fname = $this->input->post('r_fname');
            	$r_address = $this->input->post('r_address');
            	$r_mobile = $this->input->post('r_mobile');
            	$r_email = $this->input->post('r_email');
            	$rec_region = $this->input->post('region_to');
            	$rec_dropp = $this->input->post('district');

            }
            if (!empty($sender_address)) {

            	$addressT = "virtual";

            	$phone =  $sender_address;


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

            	$s_fname = $answer->full_name;
            	$s_address = $answer->phone;
            	$s_email = '';
            	$s_mobile = $answer->phone;

            }if(!empty($receiver_address)){

            	$addressR = "virtual";
            	$phone =  $receiver_address;


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

            	$r_fname = $answer->full_name;
            	$r_address = $answer->phone;
            	$r_mobile = $answer->phone;
            	$r_email = '';
            	$rec_region = $answer->region;
            	$rec_dropp = $answer->post_office;

            }


            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
//$operator = 'PF'. '  '.$info->em_code. '  '.$info->first_name.'  '.$info->middle_name. '  '.$info->last_name;

            $transactionstatus   = 'POSTED';
            $bill_status  = 'PENDING';
            $PaymentFor = 'Post Cargo';
            $transactiondate = date("Y-m-d");
            $fullname  = $s_fname;
            $mobile = $s_mobile;
            $source = $this->employee_model->get_code_source($o_region);
            $dest = $this->employee_model->get_code_dest($rec_region);

            $bagsNo = @$source->reg_code . @$dest->reg_code;


            $serial = $this->input->post('serial');
            if(empty($serial)){
            	$serial = 'CARGO'.date("YmdHis").$source->reg_code;

            }

            $number = $this->getnumber();

            @$trackNo = 'PC'.@$source->reg_code . @$dest->reg_code.$number.'TZ';



            $emstype = '';
            $emsCat = 0;
            $weight = '';
	//$prc = $this->input->post('price');
            $sender = array();
            $sender = array('serial'=>$serial,'ems_type'=>$emstype,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$s_mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$info->em_id,'track_number'=>$trackNo,'add_type'=>$addressT);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();


            $receiver = array();
            $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp,'add_type'=>$addressR);

            $db2->insert('receiver_info',$receiver);

	//get price by cat id and weight range;




            if($TotalOtheritemArrayamounts > 0 ) 
            {
            	if($TotalOtheritemArrayvalues == 0){

	//echo json_encode($OutstandingArray);
            		$type = $OtheritemArray[0]->boxtype;
            		$weight =$OtheritemArray[0]->weight;
            		if ($type == "fooditem") {
            			$price = $this->unregistered_model->food_item_price($weight);
            		} elseif($type == "nonfooditem"){
            			$price = $this->unregistered_model->nonfood_item_price($weight);
            		}else{
            			$price = $this->unregistered_model->nonfood_item_price($weight);
            		}
            		$emsprice = $price->tarrif + $price->vat;
            		$prc = $prc + $emsprice;

            		$Outstanding11 = array();
            		$Outstanding11 = array('type'=>$type,'item_price'=>$emsprice,'weight'=>$weight,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);
            		$this->Box_Application_model->save_posts_cargo($Outstanding11);



            	}
            	else
            	{

            		foreach ($OtheritemArray as $key => $variable) {

            			$type = $variable->boxtype;
            			$weight =$variable->weight;


            			if ($type == "fooditem") {
            				$price = $this->unregistered_model->food_item_price($weight);
            			} elseif($type == "nonfooditem"){
            				$price = $this->unregistered_model->nonfood_item_price($weight);
            			}else{
            				$price = $this->unregistered_model->nonfood_item_price($weight);
            			}
            			$emsprice = $price->tarrif + $price->vat;
            			$prc = $prc + $emsprice;

            			$Outstanding = array();
            			$Outstanding = array('type'=>$type,'item_price'=>$emsprice,'weight'=>$weight,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);
            			$this->Box_Application_model->save_posts_cargo($Outstanding);

            		}

            	}

            }


            if($TotalNonweightamounts > 0 ) 
            {
            	if($TotalNonweightvalues == 0){

	//echo json_encode($OutstandingArray);
            		$type = 'Non Weighted';
            		$item = $NonweightArray[0]->item;
            		$destination =$NonweightArray[0]->destination;
            		$price = $this->unregistered_model->nonweighed_item_price($item,$destination);
            		$emsprice = $price->tarrif + $price->vat;
            		$prc = $prc + $emsprice;

            		$Outstanding = array();
            		$Outstanding = array('type'=>$type,'item'=>$item,'item_price'=>$emsprice,'destination'=>$destination,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);
            		$this->Box_Application_model->save_posts_cargo($Outstanding);

            	}
            	else
            	{

            		foreach ($NonweightArray as $key => $variable) {

            			$type = 'Non Weighted';
            			$item = $variable->item;
            			$destination =$variable->destination;
            			$price = $this->unregistered_model->nonweighed_item_price($item,$destination);
            			$emsprice = $price->tarrif + $price->vat;
            			$prc = $prc + $emsprice;
            			$Outstanding = array();
            			$Outstanding = array('type'=>$type,'item'=>$item,'item_price'=>$emsprice,'destination'=>$destination,'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);
            			$this->Box_Application_model->save_posts_cargo($Outstanding);


            		}

            	}

            }


            $data22 = array(

            	'transactiondate'=>date("Y-m-d"),
            	'serial'=>$serial,
            	'paidamount'=>$prc,
            	'CustomerID'=>$last_id,
            	'Customer_mobile'=>$mobile,
            	'region'=>$o_region,
            	'district'=>$o_branch,
            	'Barcode'=>strtoupper($Barcode),
            	'transactionstatus'=>'POSTED',
            	'bill_status'=>'PENDING',
            	'paymentFor'=>$PaymentFor

            );

   //echo json_encode($data22) ;

            $this->Box_Application_model->save_transactions($data22);

            $id = $emid = $this->session->userdata('user_login_id');

            $sender_id=$last_id;
            $operator=$emid;
            $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);


            echo "<table style='width:100%;' class='table table-bordered'>
            <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
            $alltotal = 0;
            foreach ($listbulk as $key => $value) { 

            	$alltotal =$alltotal + $value->paidamount;
            	echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->paidamount,2)."</td>
            	<td>


            	<button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>

            	</td></tr>";
            }

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>




            echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
            </table>
            <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
            <input type='hidden' name ='serial' value=".$serial." class='serial'>
            <input type='hidden' name ='operator' value=".$operator." class='operator'>

            ";

        }

        else{
        	redirect(base_url());
        }

    }


    public function delete_cargo_bulk_info()
    {


    	$senderid = $this->input->post('senderid');
    	$serial = $this->input->post('serial');
            //echo $senderid;
             // echo $serial;

           // $senderid = base64_decode($this->input->get('I')); 
           //  $serial = base64_decode($this->input->get('S')); 

    	$this->unregistered_model->delete_bulk_bysenderid_info($senderid);

    	$emid  = $this->session->userdata('user_login_id');
    	$operator=$emid;
    	$listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);


    	echo "<table style='width:100%;' class='table table-bordered'>
    	<tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
    	$alltotal = 0;
    	foreach ($listbulk as $key => $value) { 

    		$alltotal =$alltotal + $value->paidamount;
    		echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->paidamount,2)."</td>
    		<td>


    		<button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>

    		</td></tr>";
    	}

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>




    	echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
    	</table>
    	<input type='hidden' name ='senders' value=".$senderid." class='senders'>
    	<input type='hidden' name ='serial' value=".$serial." class='serial'>
    	<input type='hidden' name ='operator' value=".$operator." class='operator'>

    	";


          // $this->session->set_flashdata('success','Deleted Successfull');
    }




    public function save_cargo_info(){


    	$id  = $this->session->userdata('user_login_id');
    	$info = $this->employee_model->GetBasic($id);
    	$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
    	$location= $info->em_region.' - '.$info->em_branch;
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




    	$paidamount = $alltotal;
    	$region = $listbulk[0]->s_region;
    	$district = $listbulk[0]->s_district;
    	$renter   =  $listbulk[0]->s_fullname;
    	$serviceId = 'POST_CARGO';
    	$trackNo = $serial;
    	$mobile = $listbulk[0]->s_mobile;


    	$sender_region = $this->session->userdata('user_region');
    	$sender_branch = $this->session->userdata('user_branch');

    	$postbill =  $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackNo); 
//$this->getBillGepgBillId($serial, $paidamount,$district,$region,$mobile,$renter,$serviceId);

    	if (!empty($postbill->controlno)  ) {



    		$update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
    		$this->billing_model->update_transactions($update,$serial);

                // $update = array();

                // $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
                // $this->unregistered_model->update_register_transactions1($update,$serial);

    		$data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Post Cargo  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);

            //if (!empty($transaction->$controlno)) {

                //$this->load->view('inlandMails/posts-cargo-control-number-form',$data);

    		try {
    			$this->Sms_model->send_sms_trick($mobile,$sms);
    		}
    		catch (Exception $e) {
							   //echo json_encode($sms); 
    		}	               

    		echo json_encode($sms);
    	}else{

    		$repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackNo); 

                // $trackno = array();

                //@$serial = $repostbill->billid;
    		$update = array();
    		$update = array('billid'=>$repostbill->controlno,'bill_status'=>'SUCCESS');
    		$this->billing_model->update_transactions($update,$serial);

    		$data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya Post Cargo  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                //$this->load->view('inlandMails/posts-cargo-control-number-form',$data);   

    		try {
    			$this->Sms_model->send_sms_trick($mobile,$sms);
    		}
    		catch (Exception $e) {
							   //echo json_encode($sms); 
    		}

    		echo json_encode($sms); 
    	}


    }




    public function Register_Ems_Action_bulk()
    {
    	if ($this->session->userdata('user_login_access') != false)
    	{

    		$id = $this->session->userdata('user_login_id');
    		$info = $this->employee_model->GetBasic($id);
    		$o_region = $info->em_region;
    		$o_branch = $info->em_branch;
    		$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;



    		$prc=0;
    		$cargo = $this->input->post('cargo');
    		$price = $this->input->post('price');

    		$Barcode = $this->input->post('Barcode');

//echo  $price.'price'.' cargo'.$cargo;


    		$s_fname = $this->input->post('s_fname');
    		$s_address = $this->input->post('s_address');
    		$s_email = $this->input->post('s_email');
    		$mobile = $this->input->post('s_mobile');
    		$s_mobile = $mobile;
//$regionp = $this->input->post('regionp');
//$branchdropp = $this->input->post('branchdropp');
    		$r_fname = $s_fname;
    		$r_address = $s_address;
    		$r_mobile = $mobile;
    		$r_email = $s_email;
    		$rec_region = $this->input->post('rec_region');
    		$rec_dropp = $this->input->post('rec_dropp');


    		$id = $this->session->userdata('user_login_id');
    		$info = $this->employee_model->GetBasic($id);
    		$o_region = $info->em_region;
    		$o_branch = $info->em_branch;
//$operator = 'PF'. '  '.$info->em_code. '  '.$info->first_name.'  '.$info->middle_name. '  '.$info->last_name;

    		$transactionstatus   = 'POSTED';
    		$bill_status  = 'PENDING';
    		$PaymentFor = 'Post Cargo';
    		$transactiondate = date("Y-m-d");
    		$fullname  = $s_fname;
    		$source = $this->employee_model->get_code_source($o_region);
    		$dest = $this->employee_model->get_code_dest($rec_region);

    		$bagsNo = $source->reg_code . $dest->reg_code;
    		$serial    = 'CARGO'.date("YmdHis").$source->reg_code;


    		$number = $this->getnumber();

    		@$trackNo = 'PC'.@$source->reg_code . @$dest->reg_code.$number.'TZ';


    		$emstype = '';
    		$emsCat = 0;
    		$weight = '';
	//$prc = $this->input->post('price');
    		$sender = array();
    		$sender = array('serial'=>$serial,'ems_type'=>$cargo,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$info->em_id,'track_number'=>$trackNo);

    		$db2 = $this->load->database('otherdb', TRUE);
    		$db2->insert('sender_info',$sender);
    		$last_id = $db2->insert_id();


    		$receiver = array();
    		$receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'address'=>$s_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp);

    		$db2->insert('receiver_info',$receiver);

	//get price by cat id and weight range;


    		$prc = $price;


    		$data22 = array(

    			'transactiondate'=>date("Y-m-d"),
    			'serial'=>$serial,
    			'paidamount'=>$prc,
    			'CustomerID'=>$last_id,
    			'Customer_mobile'=>$mobile,
    			'region'=>$o_region,
    			'district'=>$o_branch,
    			'Barcode'=>strtoupper($Barcode),
    			'transactionstatus'=>'POSTED',
    			'bill_status'=>'PENDING',
    			'paymentFor'=>$PaymentFor

    		);

   //echo json_encode($data22) ;

    		$this->Box_Application_model->save_transactions($data22);

    		$paidamount = $prc;
    		$region = $o_region;
    		$district = $o_branch;
    		$renter   = $s_fname;
    		$serviceId = 'POST_CARGO';
    		$trackno = $trackNo;

    		$sender_region = $this->session->userdata('user_region');
    		$sender_branch = $this->session->userdata('user_branch');

    		$postbill = $this->getBillGepgBillId($serial, $paidamount,$district,$region,$mobile,$renter,$serviceId);

    		if (!empty($postbill->controlno)  ) {

                // $source = $this->employee_model->get_code_source($sender_region);
                // $dest = $this->employee_model->get_code_dest($rec_region);
                // $bagsNo = $source->reg_code . $dest->reg_code;

                // $first4 = substr($postbill->controlno, 4);
    			$trackNo = $trackno;

                // $trackno = array();
                // $trackno = array('track_number'=>$trackNo);
                //  $this->billing_model->update_sender_info($last_id,$trackno);


    			$info = $this->employee_model->GetBasic($id);
    			$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
    			$location= $info->em_region.' - '.$info->em_branch;
    			$data = array();
    			$data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

    			$this->Box_Application_model->save_location($data);

                //$this->unregistered_model->update_sender_info($last_id,$trackno);
                //$serial = $postbill->billid;

    			$update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
    			$this->billing_model->update_transactions($update,$serial);

                // $update = array();

                // $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
                // $this->unregistered_model->update_register_transactions1($update,$serial);

    			$data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Post Cargo  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);

            //if (!empty($transaction->$controlno)) {

                //$this->load->view('inlandMails/posts-cargo-control-number-form',$data);

    			try {
    				$this->Sms_model->send_sms_trick($mobile,$sms);
    			}
    			catch (Exception $e) {
							   //echo json_encode($sms); 
    			}	               

    			echo json_encode($sms);
    		}else{

    			$repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackno); 

                // $source = $this->employee_model->get_code_source($sender_region);
                // $dest = $this->employee_model->get_code_dest($rec_region);
                // $bagsNo = $source->reg_code . $dest->reg_code;


                // $first4 = substr($repostbill->controlno, 4);
                // $trackNo = $bagsNo.$first4;
                // $trackno = array();
                // $trackno = array('track_number'=>$trackNo);
                // $this->billing_model->update_sender_info($last_id,$trackno);

    			$trackNo = $trackno;


    			$info = $this->employee_model->GetBasic($id);
    			$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
    			$location= $info->em_region.' - '.$info->em_branch;
    			$data = array();
    			$data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

    			$this->Box_Application_model->save_location($data);

                //$this->unregistered_model->update_sender_info($last_id,$trackno);

                //@$serial = $repostbill->billid;
    			$update = array();
    			$update = array('billid'=>$repostbill->controlno,'bill_status'=>'SUCCESS');
    			$this->billing_model->update_transactions($update,$serial);

    			$data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya Post Cargo  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                //$this->load->view('inlandMails/posts-cargo-control-number-form',$data);   

    			try {
    				$this->Sms_model->send_sms_trick($mobile,$sms);
    			}
    			catch (Exception $e) {
							   //echo json_encode($sms); 
    			}

    			echo json_encode($sms); 
    		}
    	}
    	else{
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

    	$url = "http://192.168.33.2/payments/paymentAPI.php";
    	$ch = curl_init($url);

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

public function getBillGepgBillIdCommission($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId){

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

public function getBillGepgBillIdzerorate($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId,$custname){

	$AppID = 'POSTAPORTAL';

	$data = array(
		'AppID'=>$AppID,
		'BillAmt'=>$paidamount,
		'serial'=>$serial,
		'District'=>$region,
		'Region'=>$district,
		'service'=>$serviceId,
		'item'=>$renter,
		'mobile'=>$mobile,
		'custname'=>$custname
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

public function getBillGepgBillId($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId){

	$AppID = 'POSTAPORTAL';

	$data = array(
		'AppID'=>$AppID,
		'BillAmt'=>$paidamount,
		'serial'=>$serial,
		'District'=>$region,
		'Region'=>$district,
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
public function EMS_Billing_Edit(){

	if ($this->session->userdata('user_login_access') != false)
	{
		$id = base64_decode($this->input->get('I'));
		echo $id;
		if(!empty($id))
		{

			$data['custinfo'] = $this->billing_model->get_ems_companies_byId($id);

		}
		$data['region'] = $this->employee_model->regselect();
		$this->load->view('billing/ems_companies_edit',$data);
	}
	else{
		redirect(base_url());
	}

}

public function EMS_Billing(){

	if ($this->session->userdata('user_login_access') != false)
	{
	//$id = base64_decode($this->input->get('I'));
	// if(!empty($id))
	// {
		
		//$data['custinfo'] = $this->billing_model->get_companies_byId($id);

	//}
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
public function BackOffice(){

	if ($this->session->userdata('user_login_access') != false)
	{
		$data['emslist1'] = $this->Box_Application_model->get_ems_back_list();
//$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
//$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
//$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
//$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
		$data['ems'] = $this->Box_Application_model->count_ems();

		$data['bags'] = $this->Box_Application_model->count_bags();
		$this->load->view('backend/dashboard_backoffice',$data);
	}
	else{
		redirect(base_url());
	}

}



public function BackOffice_Search(){
	

	if ($this->session->userdata('user_login_access') != false)
	{
		$date = $this->input->post('date');
		$month = $this->input->post('month');

   //echo($date);
   //echo($month);
		$list = [];
		$list[] = $this->Box_Application_model->get_ems_back_list_Search($date,$month);
		$list[] = $this->Box_Application_model->get_ems_back_list_international_Search($date,$month);
   //array_push($list['emslist1'], $lists );
  // $list[] = $this->Box_Application_model->get_ems_back_list_international_Search($date,$month);
		$list2['emslist1'] = $list;
  // echo 'List 2'.json_encode($list2['emslist1']);4


		$data['emslist1'] = $this->Box_Application_model->get_ems_back_list_international_Search($date,$month);
//$data['emslist1'] = $this->Box_Application_model->get_ems_back_list_Searchold($date,$month);


//$data['emslist1'] = $datass;
// echo 'data '.json_encode($data);

//echo json_encode($data['emslist1']);
//$arr = [1, 2, 3];
//$arr[] = 4; // $arr = [1,2,3,4]

// $data['despatchCount'] = $this->Box_Application_model->count_despatch_out_search($date,$month);
// $data['despatchInCount'] = $this->Box_Application_model->count_despatch_in_SEARCH($date,$month);
// $data['ems'] = $this->Box_Application_model->count_ems_SEARCH($date,$month);
// $data['bags'] = $this->Box_Application_model->count_bags_SEARCH($date,$month);

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


public function despatch_out(){

	if ($this->session->userdata('user_login_access') != false)
	{
// $data['emslist'] = $this->Box_Application_model->get_ems_back_list();
// $data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
// $data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
		$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
		$data['ems'] = $this->Box_Application_model->count_ems();

		$data['bags'] = $this->Box_Application_model->count_bags();
		$this->load->view('ems/despatch_out',$data);
	}
	else{
		redirect(base_url());
	}

}
public function despatch_in(){

	if ($this->session->userdata('user_login_access') != false)
	{
// $data['emslist'] = $this->Box_Application_model->get_ems_back_list();
// $data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
// $data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
		$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
		$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['ems'] = $this->Box_Application_model->count_ems();

		$data['bags'] = $this->Box_Application_model->count_bags();
		$this->load->view('ems/despatch_in',$data);
	}
	else{
		redirect(base_url());
	}

}


public function delivery_bills_despatched(){

	if ($this->session->userdata('user_login_access') != false)
	{
// $data['emslist'] = $this->Box_Application_model->get_ems_back_list();
// $data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
// $data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
		$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
		$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['ems'] = $this->Box_Application_model->count_ems();

		$data['bags'] = $this->Box_Application_model->count_bags();
		$this->load->view('ems/delivery_bills_despatched',$data);
	}
	else{
		redirect(base_url());
	}

}


public function delivery_bills_despatched_Form(){

	if ($this->session->userdata('user_login_access') != false)
	{
// $data['emslist'] = $this->Box_Application_model->get_ems_back_list();
// $data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
// $data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
		$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
		$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['ems'] = $this->Box_Application_model->count_ems();

		$data['bags'] = $this->Box_Application_model->count_bags();

		$date = $this->input->post('date_time');

		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$today = $today->format('Y-m-d');
		$year = date('Y',strtotime($date));
		$month = date('m',strtotime($date));
		$day = date('d',strtotime($date));
		$regionfrom = $this->session->userdata('user_region');

		if(empty($date)){
			$date=$today;
			$data['getInfo'] = $this->Box_Application_model->get_despatch_in_delivery($year,$month,$day);
		}else{$data['getInfo'] = $this->Box_Application_model->get_despatch_way_in_per_date($year,$month,$day);}



		$this->load->view('ems/delivery_bills_despatched_Form',$data);
	}
	else{
		redirect(base_url());
	}

}


public function ems_back_list(){

	if ($this->session->userdata('user_login_access') != false)
	{
		$data['emslist'] = $this->Box_Application_model->get_ems_back_list();
		$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
		$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
		$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
		$data['ems'] = $this->Box_Application_model->count_ems();

		$data['bags'] = $this->Box_Application_model->count_bags();
		$this->load->view('ems/ems_back_list',$data);
	}
	else{
		redirect(base_url());
	}

}
public function ems_back_list_per_date(){

	if ($this->session->userdata('user_login_access') != false)
	{
		$data['emslist'] = $this->Box_Application_model->get_ems_back_list_per_date();
		$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
		$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
		$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
		$data['ems'] = $this->Box_Application_model->count_ems();

		$data['bags'] = $this->Box_Application_model->count_bags();
		$this->load->view('ems/ems_back_list_per_date',$data);
	}
	else{
		redirect(base_url());
	}

}

/*public function ems_bags_list(){

if ($this->session->userdata('user_login_access') != false)
{
//$data['emslist'] = $this->Box_Application_model->get_ems_back_list_per_date();
//$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
//$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
//$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
$data['ems'] = $this->Box_Application_model->count_ems();
$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
$data['bags'] = $this->Box_Application_model->count_bags();
$this->load->view('ems/ems_bags_list',$data);
}
else{
redirect(base_url());
}

}*/

public function ems_bags_list(){

	if ($this->session->userdata('user_login_access') != false){
		
		$data['ems'] = $this->Box_Application_model->count_ems();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['bags'] = $this->Box_Application_model->count_bags();

		$userid = $this->session->userdata('user_login_id');

		if ($this->session->userdata('user_type') == 'ADMIN') {
			$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
		}else{
			$data['emsbags'] = $this->Box_Application_model->get_ems_bags_listByUser($userid);
		}

		$this->load->view('ems/ems_bags_list',$data);
	}else{
		redirect(base_url());
	}
}

public function ems_bags_list_form(){

	if ($this->session->userdata('user_login_access') != false)
	{
//$data['emslist'] = $this->Box_Application_model->get_ems_back_list_per_date();
//$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
		$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
//$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
//$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
		$data['ems'] = $this->Box_Application_model->count_ems();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['bags'] = $this->Box_Application_model->count_bags();
		$this->load->view('ems/ems_bags_list_form',$data);
	}
	else{
		redirect(base_url());
	}

}
public function download2()  {

	$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
//$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
//$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
	$data['ems'] = $this->Box_Application_model->count_ems();
	$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
	$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
	$data['bags'] = $this->Box_Application_model->count_bags();
	$trn = $this->input->get('trn');

// $data['getInfo'] =$getInfo= $this->Box_Application_model->get_item_from_bags($trn);

	$data['getbags'] =$BAGS01= $this->Box_Application_model->get_item_from_bagstwo($trn);

	if( $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' ){
		$bag_region_from=@$BAGS01->bag_region_from;
		$data['getInfo'] =$getInfo= $this->Box_Application_model->get_item_from_bags_admin($trn,$bag_region_from);

	}else{ $data['getInfo'] =$getInfo= $this->Box_Application_model->get_item_from_bags($trn);}
	$data['bagno'] = $trn;
	$this->load->view('ems/ems_item_list_bags_word',$data);
}


public function Waybill_download()  {

	$type  = 'EMS';
	$despno = $this->input->get('despno');
	$data['itemlist'] = $this->Box_Application_model->take_bags_desp_list($type,$despno);
	$data['itemdata'] = $this->Box_Application_model->take_bags_desp_listtwo($type,$despno);
	$this->load->view('ems/waybill_worddoc',@$data);

}

public function download3()  {

	$trn = $this->input->get('trn');

	$data['getInfo'] = $getInfo=$this->Box_Application_model->get_item_from_bags($trn);

	$data['getbags'] =$getbags= $this->Box_Application_model->get_item_from_bagstwo($trn);
	$data['bagno'] =$bagno= $trn;


	header("Content-type: application/vnd.ms-word");  
           //header("Content-Disposition: attachment;Filename=".rand().".doc"); 
	header("Content-Disposition: attachment;Filename=".$trn.".doc");  
	header("Pragma: no-cache");  
	header("Expires: 0"); 

	$sn=1; $trlist='';
	foreach ($getInfo as  $value) {
		$trlist=$trlist. '  <tr>

		<td style=" border: 1px solid black;"> '.$sn.' </td>
		<td style=" border: 1px solid black;"> '.$value->track_number.' </td>
		<td style=" border: 1px solid black;"> '.@$value->Barcode.'  </td>
		<td style=" border: 1px solid black;">'.$value->s_region.'</td>
		<td style=" border: 1px solid black;" colspan="2">'.$value->s_district.'</td>
		<td style=" border: 1px solid black;">'. $value->r_region.'</td>
		<td style=" border: 1px solid black;" colspan="2">'.$value->branch.'</td>
		<td style=" border: 1px solid black;">              </td></tr>';
		$sn++;
	}
	$GETSEAL =$this->Box_Application_model->get_item_from_bagsDESPATCHED($getbags->bag_number);


	echo  '<div class="">
	<link href="'.base_url().'assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<script src="'.base_url().'assets/plugins/jquery/jquery.min.js"></script>

	<div id="div1">

	<table  class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">



	<tr>
	<th colspan="3">
	</th>
	<th colspan="4">


	<img src="'.base_url().'assets/images/tcp.png" height="50px" width="100px" style="display: block; margin-left: auto; margin-right: auto;"/>
	<center>TANZANIA POSTS CORPORATION <br>
	Bag Items List
	</center>


	</th>
	<th colspan="2">
	</th>
	</tr>


	<tr>
	<th colspan="3">
	Bag Number:'.$getbags->bag_number. '
	</th>
	<th colspan="3">
	Date:'.$getbags->date_created. '
	</th>

	<th colspan="4" rowspan="2">
	<p style="margin-right: 60px;">Dispatching Office Date Stamp</p>
	</th>
	</tr>

	<tr>
	<th colspan="2">
	Bag Type:EMS Bag
	</th>

	</tr>

	<tr>
	<th colspan="3">
	From: '.$getbags->bag_region_from.'
	</th>
	<th colspan="3">
	To: '.$getbags->bag_branch.'
	</th>
	</tr>

	<tr>
	<th colspan="3">
	Weight: '.$getbags->bag_weight.' Kgs
	</th>
	<th colspan="6">
	Despatch No: '.$getbags->despatch_no.'
	</th>
	</tr>
	</table>
	<table  class=" table table-hover table-bordered" cellspacing="0" width="100%">

	<tr style="border:1px">
	</tr>
	</table>
	<br />

	<table  class="display  nowrap table table-hover table-bordered" cellspacing="0" width="100%" >
	<thead>
	<tr style="border:1px">
	<th style=" border: 1px solid black;"> S/No. </th>
	<th style=" border: 1px solid black;">Item Number</th>
	<th style=" border: 1px solid black;">Barcode Number</th>
	<th style=" border: 1px solid black;">Origin Region</th>
	<th style=" border: 1px solid black;" colspan="2">Origin Branch</th>
	<th  style=" border: 1px solid black;">Destination</th>
	<th style=" border: 1px solid black;" colspan="2">Destination Branch</th>
	<th style=" border: 1px solid black;" >Addl.Services</th>


	</tr>
	</thead>

	<tbody class="">'.$trlist.




	' 
	</tbody>
	</table>
	<br />

	<table  class=" table table-hover table-bordered" cellspacing="0" width="100%">
	<tr style="font-size:22px ;" >
	<th colspan="4"><b>Seal No: </b>'. @$GETSEAL->Seal. '</th>
	<th colspan="5">Remarks: 

	</th>
	</tr>
	<br><br><br><br><br><br>

	<tr style="font-size:22px ;">
	<td colspan="3">Despatched by ........................................</td>
	<td colspan="3">Carried by ........................................... </td>
	<td colspan="3">Received by ...............................</td>
	</tr>

	<tr style="font-size:22px ;">
	<td>Receiving Office Date Stamp:

	</td>
	</tr>

	</table>


	</div>

	<script src="'.base_url().'assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="'.base_url().'assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="'.base_url().'assets/export/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>

	</div>'; 

}



public function download()  {
	$this->load->library('Phpword');

	$trn = $this->input->get('trn');

 // $data['getInfo'] =$getInfo= $this->Box_Application_model->get_item_from_bags($trn);

	$data['getbags'] =$BAGS01= $this->Box_Application_model->get_item_from_bagstwo($trn);

	if( $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' ){
		$bag_region_from=@$BAGS01->bag_region_from;
		$data['getInfo'] =$getInfo= $this->Box_Application_model->get_item_from_bags_admin($trn,$bag_region_from);

	}else{ $data['getInfo'] =$getInfo= $this->Box_Application_model->get_item_from_bags($trn);}
	$data['bagno'] = $trn;

 // require_once APPPATH.'\third_party\PHPWord.php';


// $this->load->view('ems/ems_item_list_bags',$data);

		//  create new file and remove Compatibility mode from word title

	$phpWord = new \PhpOffice\PhpWord\PhpWord();
	$phpWord->getCompatibility()->setOoxmlVersion(14);
	$phpWord->getCompatibility()->setOoxmlVersion(15);

		//$targetFile = "./global/uploads/";
	$filename = 'test.docx';

		// add style settings for the title and paragraph


	$section = $phpWord->addSection();
	$section->addText('Title', array('bold' => true,'underline' => 'single','name'=> 'arial','size' => 21,'color' =>'red'),array('align' => 'center', 'spaceAfter' => 10));
	$section->addTextBreak(1);

	$section->addTextBreak(1);
	$section->addText('Description', array('name'=> 'arial','size' => 14),array('align' => 'left', 'spaceAfter' => 100));
	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
	$objWriter->save($filename);
		// send results to browser to download
		 // $header = $sec->createHeader();
   //          $header->addWatermark('images/CC_watermark.png', array('marginTop'=>1015, 'marginLeft'=>-80));


// 		$this->output->set_header("HTTP/1.0 200 OK");
// $this->output->set_header("HTTP/1.1 200 OK");
// $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', $last_update).' GMT');
// $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
// $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
// $this->output->set_header("Pragma: no-cache");

	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
		//$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', $last_update).' GMT');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . filesize($filename));
	flush();
	readfile($filename);
		unlink($filename); // deletes the temporary file
		exit;
	}


	public function ems_item_list_bags(){

		if ($this->session->userdata('user_login_access') != false)
		{
//$data['emslist'] = $this->Box_Application_model->get_ems_back_list_per_date();
//$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
			$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
//$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
//$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
			$data['ems'] = $this->Box_Application_model->count_ems();
			$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
			$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
			$data['bags'] = $this->Box_Application_model->count_bags();

			$trn = $this->input->get('trn');

 // $data['getInfo'] =$getInfo= $this->Box_Application_model->get_item_from_bags($trn);

			$data['getbags'] =$BAGS01= $this->Box_Application_model->get_item_from_bagstwo($trn);

			if( $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' ){
				$bag_region_from=@$BAGS01->bag_region_from;
				$data['getInfo'] =$getInfo= $this->Box_Application_model->get_item_from_bags_admin($trn,$bag_region_from);

			}else{ $data['getInfo'] =$getInfo= $this->Box_Application_model->get_item_from_bags($trn);}
			$data['bagno'] = $trn;


			$this->load->view('ems/ems_item_list_bags',$data);
		}
		else{
			redirect(base_url());
		}

	}

	public function Bill_Repost(){
		if ($this->session->userdata('user_login_access') != false) {


			$this->load->view('domestic_ems/Bill_Repost');
		} else {
			redirect(base_url());
		}

	}

	public function Ems_Bill_Repost(){
		if ($this->session->userdata('user_login_access') != false) {


			$this->load->view('domestic_ems/Ems_Bill_Repost');
		} else {
			redirect(base_url());
		}

	}

	public function Bill_Repost_Search(){

		if ($this->session->userdata('user_login_access') != false)
		{
			$controlno = $this->input->post('bill');
			if(!empty($controlno)){
				$repost =$this->Box_Application_model->getBillPaymentrepost($controlno);

				if ( !empty($repost->receipt)){
					$data['message'] = 'Successfull Reposted'.json_encode($repost);
					echo  $data['message'];

				}else{
					$data['message'] = 'Malipo hayajapokelewa kutoka hazina';
					echo  $data['message'];

				}


			}else{
				//no contronumber on pmis
				$data['message'] = "Try again";
				echo  $data['message'];
			}
			
			
			

		} else {
			redirect(base_url());
		}

	}


	public function Bill_Repost_Search2(){

		if ($this->session->userdata('user_login_access') != false)
		{
			$controlno    = $this->input->post('bill');

			$check = $this->billing_model->checkValue($controlno);
			$check2 = $this->unregistered_model->checkValueRegister($controlno);
			$check3 = $this->unregistered_model->checkValueDerivery($controlno);
			$check4 = $this->parcel_model->checkValueParcInter($controlno);
			$check5 = $this->dashboard_model->checkValue_real_estate($controlno);
			$check6 = $this->parking_model->checkValue_parking($controlno);
			$check7 = $this->parking_model->checkValue_parking_wallet($controlno);
			if (!empty(@$check) || !empty(@$check2) || !empty(@$check3) || !empty(@$check4) || !empty(@$check6) || !empty(@$check7) ){

				if (!empty(@$check)){
					$AppID = "POSTAPORTAL";
					$paidamount=$check->paidamount;
					$serial=$check->serial;
					@$repost =$this->Box_Application_model->getBillPayment($serial,$paidamount);

				}elseif(!empty(@$check2)){
					$AppID = "POSTAPORTAL";
					$paidamount=$check2->paidamount;
					$serial=$check2->serial;
					@$repost =$this->Box_Application_model->getBillPayment($serial,$paidamount);

				}elseif(!empty(@$check3)){
					$AppID = "POSTAPORTAL";
					$paidamount=$check3->paidamount;
					$serial=$check3->serial;
					@$repost =$this->Box_Application_model->getBillPayment($serial,$paidamount);

				}elseif(!empty(@$check4)){
					$AppID = "POSTAPORTAL";
					$paidamount=$check4->paidamount;
					$serial=$check4->serial;
					@$repost =$this->Box_Application_model->getBillPayment($serial,$paidamount);

				}elseif(!empty(@$check5)){
					$AppID = "POSTAPORTAL";
					$paidamount=$check5->paidamount;
					$serial=$check5->serial;
					@$repost =$this->Box_Application_model->getBillPayment($serial,$paidamount);

				}elseif(!empty(@$check6)){
					$AppID = "POSTAPORTAL";
					$paidamount=$check6->paidamount;
					$serial=$check6->serial;
					@$repost =$this->Box_Application_model->getBillPayment($serial,$paidamount);

				}elseif(!empty(@$check7)){
					$AppID = "POSTAPORTAL";
					$paidamount=$check7->paidamount;
					$serial=$check7->serial;
					@$repost =$this->Box_Application_model->getBillPayment($serial,$paidamount);

				}else{

				}








   //      			$amount = @$paidamount;
			// $controlno =@$controlno;// $update1['controlno'];
			// $receiptno = @$repost->receipt; //$update1['receiptno'];
			// $channel   = @$repost->channel; //$update1['channel'];
			// $date = @$repost->paydate; //$update1['date'];

			// if (@$check->receipt == $receiptno || @$check2->receipt == $receiptno || @$check3->receipt == $receiptno || @$check4->receipt == $receiptno || @$check6->receipt == $receiptno || @$check7->receipt == $receiptno){

			// 		$data = array('status'=>'102','description'=>"DUPLICATE Entry",'controlno'=>$controlno,'receiptno'=>$receiptno);

			// 		$this->billing_model->insert_logs($data);

			// 		 $data['message'] = "Alredy Updated";
			// 		  echo  $data['message'];

			//    }else{


			// 		$data = array('status'=>'100','description'=>"Successful",'controlno'=>$controlno);

			// 		$update = array('paymentdate'=>$date,'receipt'=>$receiptno,'paidamount'=>$amount,'status'=>'Paid','paychannel'=>$channel);

			// 		$serial = $controlno;
			// 		//$this->billing_model->update_transactions2($update,$serial);
			// 		$this->billing_model->update_transactions2($update,$serial);
			// 		$this->unregistered_model->update_register_transactions($update,$serial);
			// 		$this->unregistered_model->update_delivery_transactions1($update,$serial);
			// 		$this->parcel_model->update_parcel_international_transactions1($update,$serial);
			// 		$this->parking_model->update_parking_transactions1($update,$serial);
			// 		$this->parking_model->update_parking_wallet_transaction($update,$serial);
			// 		$this->billing_model->insert_logs($data);

			// 		if(!empty($receiptno)){

			// 			 $data['message'] = "Successfull Reposted";
			// 		  echo  $data['message'];

			// 		}else{

			// 			 $data['message'] = "Failed ";
			// 		  echo  $data['message'];
			// 		}




         	         //  $serial=$transactions->serial;
                   //  $paidamount=$transactions->paidamount;
                   //  $region=str_replace("'", '', $transactions->region);
                   //  $district=str_replace("'", '', $transactions->district);
                   //  $mobile = $transactions->Customer_mobile;
                   //  @$renter ='Ems Bill Repost';
                   //  $serviceId = $transactions->PaymentFor;

                   //  @$controNo = $this->getBillGepgBillId($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId);

                   // $serial1 = $controNo->billid;
                   // $update = array('billid'=>$controNo->controlno,'bill_status'=>'SUCCESS');
                   // $this->Box_Application_model->update_transactions($update,$serial1);


        // }

				$data['message'] = "Successfull Reposted";
				echo  $data['message'];

			}else{
	//no contronumber on pmis



				$data['message'] = "Successfull Reposted";
				echo  $data['message'];



			}
		}
		else{
			redirect(base_url());
		}

	}


	public function Ems_Bill_Repost_Search(){

		if ($this->session->userdata('user_login_access') != false)
		{
			$controlno    = $this->input->post('bill');

			$check = $this->Box_Application_model->get_ems_repost($controlno); 
		 //$check = $this->Box_Application_model->get_ems_repost2($controlno); 
		 //helsb

		  //$check = $this->billing_model->checkValue($value->billid);
			$serial=@$check->serial;
			$id=@$check->id;
			$paidamount=@$check->paidamount;
			$region=str_replace("'", '', @$check->region);
			$district=str_replace("'", '', @$check->district);
			$mobile = @$check->Customer_mobile;
			$renter   = 'ems_heslb';
			$serviceId = 'EMS_POSTAGE';

              //$transaction =@$this->Box_Application_model->getBill_Ems_Repost_Payment2($serial,$paidamount);
			$transaction = @$this->getBillGepgBillId($serial,$paidamount,$district,$region,$mobile,$renter,$serviceId);


			if (!empty(@$check)){


				if(!empty($transaction->receipt)){

					$paid='Paid';

					$update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS','receipt'=>@$transaction->receipt,
						'paychannel'=>@$transaction->channel,'paymentdate'=>@$transaction->paydate,
						'status'=>@$paid);
					$this->Box_Application_model->update_transactions($update,$serial);

					if( $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER'){
						$data['message'] = 'Successfull Reposted'.json_encode($transaction);
						echo  $data['message'];

					}else{ 
						$data['message'] = 'Successfull Reposted';
						echo  $data['message'];
					}

				}else{

					if( $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' ){
						$data['message'] = 'Invalid Not Payed '.json_encode($transaction);
						echo  $data['message'];
					}else{
						$data['message'] = 'Invalid';
						echo  $data['message'];

					}

				}



	       //$this->Box_Application_model->update_old_transactions($data1,$id){

                 // echo  json_decode($transaction);
                 // echo json_encode($transaction);





			}else{
				if( $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' ){
					$data['message'] = 'Invalid '.json_encode($transaction);
					echo  $data['message'];
				}else{
					$data['message'] = 'Invalid';
					echo  $data['message'];

				}



			}







		}
		else{
			redirect(base_url());
		}

	}

	public function ems_item_list_bags_remove(){

		if ($this->session->userdata('user_login_access') != false)
		{

	//$data['emslist'] = $this->Box_Application_model->get_ems_back_list_per_date();
//$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
			$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
//$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
//$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
			$data['ems'] = $this->Box_Application_model->count_ems();
			$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
			$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
			$data['bags'] = $this->Box_Application_model->count_bags();


			$trck = $this->input->get('trck');
			$bagno = $this->input->get('bagno');
			$data['bagno'] = $bagno;

			$transaction = $this->Box_Application_model->get_transactions_row($trck);
			$data2 = array();
			$data2 = array('isBagNo'=>'007','bag_status'=>'isNotBag');
			$this->Box_Application_model->update_back_office($transaction->id,$data2);


			$data['getInfo'] = $this->Box_Application_model->get_item_from_bags($bagno);

			$data['getbags'] = $this->Box_Application_model->get_item_from_bagstwo($bagno);




			$this->load->view('ems/ems_item_list_bags_update',$data);
		}
		else{
			redirect(base_url());
		}

	}

	public function ems_item_list_bags_update(){

		if ($this->session->userdata('user_login_access') != false)
		{
//$data['emslist'] = $this->Box_Application_model->get_ems_back_list_per_date();
//$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
			$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
//$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
//$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
			$data['ems'] = $this->Box_Application_model->count_ems();
			$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
			$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
			$data['bags'] = $this->Box_Application_model->count_bags();

			$trn = $this->input->get('trn');
			$data['bagno'] = $trn;

// $data['getInfo'] =$getInfo= $this->Box_Application_model->get_item_from_bags($trn);

			$data['getbags'] =$BAGS01= $this->Box_Application_model->get_item_from_bagstwo($trn);

			if( $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' ){
				$bag_region_from=@$BAGS01->bag_region_from;
				$data['getInfo'] =$getInfo= $this->Box_Application_model->get_item_from_bags_admin($trn,$bag_region_from);

			}else{ $data['getInfo'] =$getInfo= $this->Box_Application_model->get_item_from_bags($trn);}

			$this->load->view('ems/ems_item_list_bags_update',$data);
		}
		else{
			redirect(base_url());
		}

	}


	public function pending_bags_despatch_list(){

		if ($this->session->userdata('user_login_access') != false)
		{
			$data['emslist'] = $this->Box_Application_model->get_ems_back_list_per_date();
			$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
			$data['emsbags'] = $this->Box_Application_model->get_pending_bags_list();
			$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
			$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
			$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
			$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
			$data['ems'] = $this->Box_Application_model->count_ems();

			$data['bags'] = $this->Box_Application_model->count_bags();
			$this->load->view('ems/pending_bags_despatch_list',$data);
		}
		else{
			redirect(base_url());
		}

	}

	public function receiveBagItems(){
		if ($this->session->userdata('user_login_access') != false){
			$emid = $this->session->userdata('user_emid');
		//receive despatch number from the view
			$despatchNo = $this->input->post('despatchno');
		//receive bagNo number from the view
			$bagno = $this->input->post('bagno');

		//update the despatch list
			$updateDataDespatch = array('despatch_status'=>'Received','received_by'=>$emid);
			$this->Box_Application_model->update_despatch_list($despatchNo,$updateDataDespatch);

		//update_bag_status
			$updateDataBag = array('bag_isopen'=>1,'bag_openby'=>$emid);
			$this->Box_Application_model->update_bag_status($despatchNo,$bagno,$updateDataBag);

		//update the bag status ->backoffice
		//$this->Box_Application_model->update_list($bagno,array('office_name'=>'Back'));

		//update the bag status ->backoffice
			$this->Box_Application_model->update_list($bagno,
				array(
					'office_name'=>'InWard receive',
					'created_by' => $emid
				));

		//retrieve the bag item from the list
			$listItem = $this->Box_Application_model->get_item_from_bags_list($bagno);

		//process of getting despatch items
		//method='POST' action='receive_action' enctype='multipart/form-data'
			echo "<table id='fromServer1' class='display nowrap table table-bordered fromServer2 receiveTable' cellspacing='0' width='100%'>
			<thead>
			<tr>
			<th colspan='6'>Receive Bag (".$bagno.") Item (s)  for dispatch - ".$despatchNo."</th>
			<th>
			<div class='input-group'>
			<input id='edValue' type='text' class='form-control edValue' onInput='edValueKeyPress();' onChange='edValueKeyPress();'>
			<br /><br /></div>
			<div class='input-group'>
			<span id='lblValue' class='lblValue'>Barcode scan: </span><br /></div>
			<div class='input-group'>
			<span id='results' class='results' style='color: red;'></span>
			</div>
			</th>
			</tr>

			<tr>
			<th>S/No</th>
			<th>Date registered</th>
			<th>Branch Origin</th>
			<th>Destination Origin</th>
			<th>Barcode Number</th>
			<th>Status</th>
			<th>Action</th>
			</tr>
			</thead>
			<tbody class=''>";
			$count = 0;
			foreach ($listItem as $key => $value) {
				$count++;

				if ($value->office_name == 'InWard receive'){
					$statusItem = 'InWard receive';
				}else if ($value->office_name == 'Back'){
					$statusItem = 'BackOffice';
				}else if($value->office_name == 'Received'){
					$statusItem = 'Successfull Received';
				}

				echo "<tr class='receiveRow'>
				<td>".$count."</td>
				<td>".$value->date_registered."</td>
				<td>".$value->s_region."</td>
				<td>".$value->r_region."</td>
				<td>".strtolower($value->Barcode)."</td>
				<td>".$statusItem."</td>
				<td>
				<div class='form-check' style='padding-left: 53px;float:left'>
				<input type='checkbox' name='I' class='form-check-input checkSingle ".$value->Barcode."' id='remember-me$key' value='".$value->id."'></div>
				<div style='cursor: pointer;float:right' class='badge' data-itemid='".$value->id."' onclick='enquaryItem(this)'>Equary</div>
				</td>
				</tr>";
			}

			echo "</tbody></table>";
			echo "<table class='table' style='width: 100%;'>
			<tbody>
			<tr><td style='float: right;'>
			<div class='statusText'></div></td></tr>
			<tr><td colspan='11'></td><td style='float: right;'>
			<button data-despno=".$despatchNo." onclick='return formSubmit(this);' class='btn btn-success'>Receive</button>
			</td></tr></tbody></table>";
		}

	}

	public function receiveBags(){
		if ($this->session->userdata('user_login_access') != false){
			$type  = 'EMS';
			$despno = $this->input->post('despno');

			$emid = $this->session->userdata('user_emid');
		//receive despatch number from the view
			$despatchNo = $this->input->post('despatchno');

		//update the despatch list
			$this->Box_Application_model->update_despatch_list($despno,
				array('despatch_status'=>'Received','received_by'=>$emid));


		//$data['bags'] = $this->Box_Application_model->count_bags();
			$itemList = $this->Box_Application_model->take_bags_desp_list($type,$despno);

			echo "<table id='fromServer1' class='display nowrap table table-bordered fromServer2 receiveTable' cellspacing='0' width='100%'>
			<thead>
			<tr><th colspan='6'>Receive Bag(s)  for dispatch - ".$despno."</th></tr>
			<tr>
			<th>Bag Number</th>
			<th>Bag Source</th>
			<th>Bag Destination</th>
			<th>Date Bag Created</th>
			<th>Total Item Number</th>
			<th>Bag Received By</th>
			</tr>
			</thead>
			<tbody class=''>";
			$count = 0;

			foreach ($itemList as $key => $value) {
				$count++;
				$bagsNo = $value->bag_number;

				$updatebag = array('bags_status'=>'isReceived','bag_received_by'=>$emid);
				//update the bag
				$this->Box_Application_model->update_bag_status($despno,$bagsNo,$updatebag);

				$totalBag = $this->Box_Application_model->count_bags_desp_list($bagsNo);

				echo "<tr class='receiveRow'>
				<td>
				<button class='btn btn-warning' data-bagno='$bagsNo' data-despno='$despno' onclick='receiveBagItems(this)'>".$value->bag_number."</button></td>
				<td>".$value->bag_region_from."</td>
				<td>".$value->bag_region."</td>
				<td>".$value->date_created."</td>
				<td>".$totalBag."</td>
				<td>".$value->bag_received_by."</td>
				</tr>";
			}

			echo "</tbody></table>
			<table class='table' style='width: 100%;'><tr><td style='float: right;'>
			<div class='statusText'></div></td></tr></table>";

		}else{
			redirect(base_url());
		}
	}

	function enquaryItem(){
		if ($this->session->userdata('user_login_access') != false){
		//userid - LoggedIn
			$emid = $this->session->userdata('user_emid');
		//item Id
			$itemid = $this->input->post('itemid');

			$updateData = array('itemequaryby'=>$emid,'itemequary'=>'yes');
		//update the item
			$this->Box_Application_model->update_transactions_for_equary($updateData,$itemid);

			echo 'Success';

		}else{
			redirect(base_url());
		}
	}

	function equaryItemList(){
		if ($this->session->userdata('user_login_access') != false){
			$equaryBy = $this->session->userdata('user_emid');

			$userType = $this->session->userdata('user_type');

			if($userType != 'ADMIN' ){
				$data['emsEquaryList'] = $this->Box_Application_model->get_item_from_bags_equary_list($equaryBy);
			}else{
				$data['emsEquaryList'] = $this->Box_Application_model->get_item_from_bags_equary_list('');
			}

			$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
			$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
			$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
			$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
			$data['ems'] = $this->Box_Application_model->count_ems();
			$data['total'] = $this->Box_Application_model->get_backoffice_sum();

			$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
			$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
			$data['bags'] = $this->Box_Application_model->count_bags();
			$data['emselect'] = $this->employee_model->delivereselect();

			$this->load->view('ems/received_equary_items',$data);
		}else{
			redirect(base_url());
		}
	}


	public function despatched_bags_list(){

		if ($this->session->userdata('user_login_access') != false)
		{
			$data['emslist'] = $this->Box_Application_model->get_ems_back_list_per_date();
			$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
			$data['emsbags'] = $this->Box_Application_model->get_despatched_bags_list();
			$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
			$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
			$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
			$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
			$data['ems'] = $this->Box_Application_model->count_ems();

			$data['bags'] = $this->Box_Application_model->count_bags();
			$this->load->view('ems/despatched_bags_list',$data);
		}
		else{
			redirect(base_url());
		}

	}
	public function posta_gilo()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$comp_name    = $this->input->post('comp_name');
			$comp_address = $this->input->post('comp_address');
			$comp_phone   = $this->input->post('comp_phone');
			$comp_region  = $this->input->post('comp_region');

			$data = array();
			$data = array('com_name'=>$comp_name,'com_address'=>$comp_address,'com_phone'=>$comp_phone,'com_region'=>$comp_region);

			$this->billing_model->save_company_details($data);
			echo "Successfully Added";
		}
		else{
			redirect(base_url());
		}
	}
	public function ems_billing_action()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$comp_name    = $this->input->post('comp_name');
			$comp_address = $this->input->post('comp_address');
			$comp_phone   = $this->input->post('comp_phone');
			$comp_region  = $this->input->post('comp_region');
			$tin_number   = $this->input->post('tin_number');
			$vrn  = $this->input->post('vrn');

			$id = $this->session->userdata('user_login_id');
			$info = $this->employee_model->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;

			$data = array();
			$data = array('com_name'=>$comp_name,'com_address'=>$comp_address,'com_phone'=>$comp_phone,'com_region'=>$o_region,'com_branch'=>$o_branch,'tin_number'=>$tin_number,'vrn'=>$vrn);


			$this->billing_model->save_ems_billing_company_details($data);
			echo "Successfully Added";

		}
		else{
			redirect(base_url());
		}
	}

	public function ems_billing_action_Edit()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$comp_name    = $this->input->post('comp_name');
			$comp_address = $this->input->post('comp_address');
			$comp_phone   = $this->input->post('comp_phone');
			$comp_region  = $this->input->post('comp_region');
			$tin_number   = $this->input->post('tin_number');
			$com_id   = $this->input->post('com_id');
			$vrn  = $this->input->post('vrn');

			$id = $this->session->userdata('user_login_id');
			$info = $this->employee_model->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;

			$data = array();
			$data = array('com_name'=>$comp_name,'com_address'=>$comp_address,'com_phone'=>$comp_phone,'com_region'=>$o_region,'com_branch'=>$o_branch,'tin_number'=>$tin_number,'vrn'=>$vrn);


			$this->billing_model->update_ems_billing_company_details($data,$com_id);

//$datas['company'] = $this->billing_model->get_ems_billing_companies_list();
//$this->load->view('billing/ems_billing_companies_list',$datas);

			echo "Successfully Edited";
  //$comid= base64_encode($com_id);
 //redirect(base_url('Box_Application/EMS_Billing_Edit?I='.$comid));
  //redirect(base_url('Box_Application/ems_billing_list'));
//$data['custinfo'] = $this->billing_model->get_ems_companies_byId($com_id);
//$data['region'] = $this->employee_model->regselect();
	//$this->load->view('billing/ems_companies_edit',$data);


		}
		else{
			redirect(base_url());
		}
	}

	public function Mails_billing_action()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$comp_name    = $this->input->post('comp_name');
			$comp_address = $this->input->post('comp_address');
			$comp_phone   = $this->input->post('comp_phone');
			$comp_region  = $this->input->post('comp_region');
			$tin_number   = $this->input->post('tin_number');
			$vrn  = $this->input->post('vrn');

			$id = $this->session->userdata('user_login_id');
			$info = $this->employee_model->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;

			$data = array();
			$data = array('com_name'=>$comp_name,'com_address'=>$comp_address,'com_phone'=>$comp_phone,'com_region'=>$o_region,'com_branch'=>$o_branch,'tin_number'=>$tin_number,'vrn'=>$vrn);

			$this->billing_model->save_mails_billing_company_details($data);
			echo "Successfully Added";
		}
		else{
			redirect(base_url());
		}
	}
	public function posta_gilo_list()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$data['company'] = $this->billing_model->get_companies_list();
			$this->load->view('billing/companies_list',$data);
		}
		else{
			redirect(base_url());
		}
	}
	public function ems_billing_list()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$data['company'] = $this->billing_model->get_ems_billing_companies_list();
			$this->load->view('billing/ems_billing_companies_list',$data);
		}
		else{
			redirect(base_url());
		}
	}
	public function Mails_billing_list()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$data['company'] = $this->billing_model->get_mails_billing_companies_list();
			$this->load->view('billing/mails_billing_companies_list',$data);
		}
		else{
			redirect(base_url());
		}
	}
	public function issuepayment()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$id   = $this->input->post('commid');
			$amount = $this->input->post('amount');
			$data['company'] = $this->billing_model->get_companies_byId($id);

			$serial = 'PG'.date("YmdHis");
			$paidamount = $amount;
			$region = $data['company']->com_region;
			$district = $data['company']->com_region;
			$renter   = $data['company']->com_name;
			$serviceId = 'POSTAGILO';
			$mobile = $data['company']->com_phone;
			$PaymentFor = 'POSTAGILO';

			$data = array(

				'transactiondate'=>date("Y-m-d"),
				'serial'=>$serial,
				'paidamount'=>$amount,
				'CustomerID'=>$data['company']->com_id,
				'Customer_mobile'=>$mobile,
				'region'=>$region,
				'district'=>$district,
				'transactionstatus'=>'POSTED',
				'bill_status'=>'PENDING',
				'paymentFor'=>$PaymentFor

			);

			$this->Box_Application_model->save_transactions($data);


			$transaction = $this->getBillGepgBillId($serial,$paidamount,$district,$region,$mobile,$renter,$serviceId);

			$serial1 = $transaction->billid;
			$update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
			$this->billing_model->update_transactions($update,$serial1);

			echo 'Successfully Billing Issued';
		}
		else{
			redirect(base_url());
		}
	}
	public function issueemspayment()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$id   = $this->input->post('commid');
			$datedue   = $this->input->post('datedue');
			$description   = $this->input->post('description');
			$amount = $this->input->post('amount');
			$data['company'] = $this->billing_model->get_ems_companies_byId($id);
			$invoice = array();
			$invoice = array('invoice_details'=>$description,'invoice_date'=>$datedue,'invcust_id'=>$id);
//$this->Box_Application_model->save_invoice($invoice);

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('invoice',$invoice);
			$last_id = $db2->insert_id();

			$serial = 'EB'.date("YmdHis");
			$paidamount = $amount;
			$region = $data['company']->com_region;
			$district = $data['company']->com_region;
			$renter   = $data['company']->com_name;
			$serviceId = 'EMS_POSTAGE';
			$mobile = $data['company']->com_phone;
			$PaymentFor = 'EMSBILLING';
			$trackingno = 18;
			$data = array();
			$data = array(

				'transactiondate'=>date("Y-m-d h:i"),
				'serial'=>$serial,
				'paidamount'=>$amount,
				'CustomerID'=>$last_id,
				'Customer_mobile'=>$mobile,
				'region'=>$region,
				'district'=>$district,
				'transactionstatus'=>'POSTED',
				'bill_status'=>'PENDING',
				'paymentFor'=>$PaymentFor
			);



			$this->Box_Application_model->save_transactions($data);


			$transaction = $this->getBillGepgBillId($serial,$paidamount,$district,$region,$mobile,$renter,$serviceId,$trackingno);

			$serial1 = $transaction->billid;
			$update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
			$this->billing_model->update_transactions($update,$serial1);

			echo 'Successfully Billing Issued';

		}
		else{
			redirect(base_url());
		}
	}

	public function issuemailspayment()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$id   = $this->input->post('commid');
			$datedue   = $this->input->post('datedue');
			$description   = $this->input->post('description');
			$amount = $this->input->post('amount');
			$data['company'] = $this->billing_model->get_mails_companies_byId($id);
			$invoice = array();
			$invoice = array('invoice_details'=>$description,'invoice_date'=>$datedue,'invcust_id'=>$id);
//$this->Box_Application_model->save_invoice($invoice);

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('invoice',$invoice);
			$last_id = $db2->insert_id();

			$serial = 'MB'.date("YmdHis");
			$paidamount = $amount;
			$region = $data['company']->com_region;
			$district = $data['company']->com_region;
			$renter   = $data['company']->com_name;
			$serviceId = 'MAIL';
			$mobile = $data['company']->com_phone;
			$PaymentFor = 'MAILSBILLING';
			$custname = $data['company']->com_name.'-ZERORATE';
			$trackingno = 19;
			$data = array();
			$data = array(

				'transactiondate'=>date("Y-m-d h:i"),
				'serial'=>$serial,
				'paidamount'=>$amount,
				'CustomerID'=>$last_id,
				'Customer_mobile'=>$mobile,
				'region'=>$region,
				'district'=>$district,
				'transactionstatus'=>'POSTED',
				'bill_status'=>'PENDING',
				'paymentFor'=>$PaymentFor
			);



			$this->Box_Application_model->save_transactions($data);


			$transaction = $this->getBillGepgBillIdzerorate($serial,$paidamount,$district,$region,$mobile,$renter,$serviceId,$trackingno,$custname);

			$serial1 = $transaction->billid;
			$update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
			$this->billing_model->update_transactions($update,$serial1);

			echo 'Successfully Billing Issued';

		}
		else{
			redirect(base_url());
		}
	}
	public function commission_issuepayment()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$id   = $this->input->post('commid');
			$amount = $this->input->post('amount');


			$data['company'] = $this->billing_model->get_commission_agency_byId($id);

			$serial = 'COMM'.date("YmdHis");
			$paidamount = $amount;
			$region = $data['company']->com_region;
			$district = $data['company']->com_region;
			$renter   = $data['company']->com_name;
			$serviceId = 'COMMISSION';
			$mobile = $data['company']->com_phone;
			$PaymentFor = 'COMMISSION';


			$data = array(

				'transactiondate'=>date("Y-m-d"),
				'serial'=>$serial,
				'paidamount'=>$amount,
				'CustomerID'=>$data['company']->com_id,
				'Customer_mobile'=>$mobile,
				'region'=>$region,
				'district'=>$district,
				'transactionstatus'=>'POSTED',
				'bill_status'=>'PENDING',
				'paymentFor'=>$PaymentFor

			);

			$this->Box_Application_model->save_transactions($data);


//$transaction = $this->getBillGepgBillIdCommission($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId);
			$transaction = $this->getBillGepgBillId($serial,$paidamount,$district,$region,$mobile,$renter,$serviceId);

// $serial1 = $transaction->billid;
// $update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
// $this->billing_model->update_transactions($update,$serial1);

			if (!empty($transaction)) {


				$serial1 = $transaction->billid;
				$update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
				$this->billing_model->update_transactions($update,$serial1);

			}else{
				$transaction1 = $this->getBillGepgBillId($serial,$paidamount,$district,$region,$mobile,$renter,$serviceId);


				@$serial1 = $transaction1->billid;
				$update = array('billid'=>@$transaction1->controlno,'bill_status'=>'SUCCESS');
				$this->billing_model->update_transactions($update,$serial1);


			}


			echo 'Successfully Billing Issued';
			redirect(base_url('Box_Application/commission_agency_list'));

		}
		else{
			redirect(base_url());
		}
	}
	public function get_bill_gilo()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$id = $this->input->get('id');
			$service = $this->input->get('services');

			$data['billing'] = $this->billing_model->get_gilo_billing_list($id,$service);
			$this->load->view('billing/gilo_billing_list',$data);
		}
		else{
			redirect(base_url());
		}
	}
	public function get_bill_ems()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$id = $this->input->get('id');
			$service = $this->input->get('services');

			$data['billing'] = $this->billing_model->get_ems_billing_list($id,$service);
			$this->load->view('billing/ems_billing_list',$data);
		}
		else{
			redirect(base_url());
		}
	}
	public function get_bill_Mails()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$id = $this->input->get('id');
			$service = $this->input->get('services');

			$data['billing'] = $this->billing_model->get_mails_billing_list($id,$service);
			$this->load->view('billing/mails_billing_list',$data);
		}
		else{
			redirect(base_url());
		}
	}
	public function get_bill_ems_list()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$id = base64_decode($this->input->get('I'));
			$data['billing'] = $this->billing_model->get_ems_billing_list2($id);
			$this->load->view('billing/ems_billing_list2',$data);
		}
		else{
			redirect(base_url());
		}
	}
	public function get_commission_bill_list()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$id = $this->input->get('id');
			$service = $this->input->get('services');

			$data['billing'] = $this->Box_Application_model->get_commission_by_id($id,$service);
			$this->load->view('billing/commission_billing_list',$data);
		}
		else{
			redirect(base_url());
		}
	}
	public function issuedpayment_view()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$data['id'] = base64_decode($this->input->get('I'));
			$this->load->view('billing/billing_issues',$data);
		}
		else{
			redirect(base_url());
		}
	}
	public function issuedpayment_ems_billing_view()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$data['id'] = base64_decode($this->input->get('I'));
			$this->load->view('billing/ems_billing_issues',$data);
		}
		else{
			redirect(base_url());
		}
	}
	public function issuedpayment_mails_billing_view()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$data['id'] = base64_decode($this->input->get('I'));
			$this->load->view('billing/mails_billing_issues.php',$data);
		}
		else{
			redirect(base_url());
		}
	}
	public function send_to_back_office()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$type = $this->input->post('type');
			$select = $this->input->post('I');
			$emid = $this->input->post('emid');
			$id = $this->session->userdata('user_emid');

			$tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$date = $today->format('Y-m-d');

			$userdata  = $this->Box_Application_model->GetBasic($emid);

			if ($this->session->userdata('user_type') == "SUPERVISOR1") {
//check if user as a pending task
				$getPending = $this->Box_Application_model->get_pending_task($emid);
				$check = $this->Box_Application_model->getEndingDate($emid,$date);
//echo $check->supervisor_name;
				if (!empty($check->supervisor_name)) {

					echo "Day already Ended";
				} else{

					if (!empty($getPending)) {


						$data = array();
						$data = array('supervisor_name'=>$id,'sup_status'=>'NotEnded');
						$this->Box_Application_model->Update_SupervisorJob($data,$emid);

						$update = array();
						$update = array('assign_status'=>'NotEnded','date_assign'=>$date);
						$this->employee_model->Update_Jobassign($update,$emid);

						echo "Shift Not Ended";
					} else {

						$data = array();
						$data = array('supervisor_name'=>$id,'supervisee_name'=>$emid,'sup_status'=>'Ended');
						$this->Box_Application_model->Save_SupervisorJob($data);

						$update = array();
						$update = array('assign_status'=>'Ended','date_assign'=>$date);
						$this->employee_model->Update_Jobassign($update,$emid);

						echo "Shift Ended Successfully";

					}

				}

			} else {

				if (!empty($select)) {
					for ($i=0; $i <@sizeof($select) ; $i++) {

						$id = $select[$i];

						$checkPay = $this->Box_Application_model->check_payment($id,$type);

						if ($checkPay->status == 'Paid' || $checkPay->status == 'Bill') {

							$data = array();
							$data = array('office_name'=>'Back');

							$this->Box_Application_model->update_back_office($id,$data);


			//for tracing
							$trace_data = array(
								'emid'=>$emid,
								'transid'=>$id,
								'office_name'=>'Back Office',
								'description'=>'Received counter '.$userdata->em_branch,
								'status'=>'Received counter');

							$this->Box_Application_model->tracing($trace_data);

			//for tracing
							$track_data = array(
								'emid'=>$emid,
								'transid'=>$id,
								'office_name'=>'Back Office',
								'description'=>'Received counter '.$userdata->em_branch,
								'type'=> 1,
								'status'=>'Received counter');

							$this->Box_Application_model->tracing($track_data);
						}

					}
					echo "Successfully Send To Back Office";
				}else{

					echo "Please select item to transfer";
				}
# code...
			}

		}
		else{
			redirect(base_url());
		}
	}

	public function send_to_back_office_supervisor()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$type = $this->input->post('type');
			$select = $this->input->post('I');
			$emid = $this->input->post('emid');
			$id = $this->session->userdata('user_emid');

			$tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$date = $today->format('Y-m-d');

			if (!empty($select)) {
				for ($i=0; $i <@sizeof($select) ; $i++) {

					$id = $select[$i];

					$checkPay = $this->Box_Application_model->check_payment($id,$type);

					if ($checkPay->status == 'Paid' || $checkPay->status == 'Bill') {

						$data = array();
						$data = array('office_name'=>'Back');

						$this->Box_Application_model->update_back_office($id,$data);
					}

				}
				echo "Successfully Send To Back Office";
			}else{

				echo "Please select item to transfer";
			}

		}
		else{
			redirect(base_url());
		}
	}
	public function receive_item()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$select = $this->input->post('I');
			$emid = $this->session->userdata('user_emid');
			$getInfo = $this->employee_model->GetBasic($emid);
			$users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
			$loc = ' - '.$getInfo->em_branch;
//echo $weight;
			if (empty($select)) {
				echo "Please Select Atleast One Item";
			} else {

				for ($i=0; $i <@sizeof($select) ; $i++) {

					$id = $select[$i];
					$data = array();
					$data = array('office_name'=>'Received','item_received_by'=>$emid);
					$this->Box_Application_model->update_back_office($id,$data);

	 // $getInfo = $this->employee_model->GetBasic($emid);
  //                           $users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
  //                           $loc = $getInfo->em_region.' - '.$getInfo->em_branch;

					$db='sender_info';
					$senderinfo = $this->Box_Application_model->get_sender_info123($id);

					$Barcode=$senderinfo->Barcode;

					$event = "Sorting Facility";
					$location ='Received Sorting Facility '.$loc;
					$data = array();
					$data = array('track_no'=>@$Barcode,'location'=>$location,'user'=>@$users,'event'=>$event);

					$this->Box_Application_model->save_location($data);

					$smobile =@$senderinfo->s_mobile;
					$rmobile =@$senderinfo->mobile;
					$stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umepokelewa '.' '.$getInfo->em_region.' - '.$getInfo->em_branch;
					$this->Sms_model->send_sms_trick($smobile,$stotal);
					$this->Sms_model->send_sms_trick($rmobile,$stotal);
				}

				echo "Successfully Received";
			}
		}

		else{
			redirect(base_url());
		}
	}








	public function close_bags()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$action = $this->input->post('action');
			$select = $this->input->post('I');
			$bagss = $this->input->post('bagss');
			$region = $this->input->post('region');
			$district = $this->input->post('district');
			$weight = $this->input->post('weight');
			$id = $this->session->userdata('user_login_id');
			$info = $this->employee_model->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;
			$rec_region = $region;
			$emid = $info->em_id;
			$type = 'EMS';

			$source = $this->employee_model->get_code_source($o_region);
			$dest = $this->employee_model->get_code_dest($rec_region);
	// $rondom = substr(date('dHis'), 1);
	$billcode = '5';//bag code in tracking number
	// @$bagsNo = $source->reg_code . $dest->reg_code.$billcode.$rondom;


	$year = date("y");
                //$number = $this->getbagnumber();  
	$number = $this->getbagnumber_branch($o_branch);
	$bagsNo = 'EMS-BAG'.@$source->reg_code.@$dest->reg_code.$year.$number.'TZ';
	


	if($action=='exchage'){

		if(!empty($select)){

			for ($i=0; $i <@sizeof($select) ; $i++) {

				$id = $select[$i];

				$this->Box_Application_model->transfer_to_office_exchange($id);
			}

			echo 'Successfully Transfered To Office of Exchange';


		}
		else{

			echo 'Please Select Atleast One Item To Transfer ';

		}

		

	}
	elseif($action=='Delivery'){

		if(!empty($select)){

			for ($i=0; $i <@sizeof($select) ; $i++) {

				$id = $select[$i];

				$this->Box_Application_model->transfer_for_delivery($id);
			}

			echo 'Successfully Transfered for Delivery';


		}
		else{

			echo 'Please Select Atleast One Item To Transfer for Delivery';

		}

		

	}else{
		$getInfo = $this->employee_model->GetBasic($emid);
		$users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
		$loc = ' - '.$getInfo->em_branch;


		if($bagss == 'New Bag'){

			if(!empty($select)){
				if(empty($region)){
					echo 'Please Select Destination Region';
				}elseif(empty($district)){
					echo 'Please Select Destination Branch';
				}elseif(empty($weight)){
					echo 'Please Fill Bag Weight';
				}else{

					$bag = array();
					$bag = array('bag_number'=>$bagsNo,'bag_weight'=>$weight,
						'service_type'=>'EMS','bag_region_from'=>$o_region,'bag_branch_from'=>$o_branch,'bag_created_by'=>$emid);
					$this->Box_Application_model->save_bag($bag);

					for ($i=0; $i <@sizeof($select) ; $i++) {

						$id = $select[$i];

						$checkRegion = $this->Box_Application_model->get_sender_info123($id);

		//if($checkRegion->r_region == $region &&  $checkRegion->branch == $district){
			//if($checkRegion->r_region == $region ){

						$bag = array();
						$bag = array('bag_region'=>$region,'bag_branch'=>$district);
						$this->Box_Application_model->update_bag($bag,$bagsNo);

						$data = array();
						$data = array('isBagNo'=>$bagsNo,'bag_status'=>'isBag');
						$this->Box_Application_model->update_back_office($id,$data);




						$db='sender_info';
						$senderinfo = $this->Box_Application_model->get_sender_info123($id);

						$Barcode=$senderinfo->Barcode;

						$event = "Sorting Facility";
						$location ='Ready for Transit '.$loc;
						$data = array();
						$data = array('track_no'=>@$Barcode,'location'=>$location,'user'=>@$users,'event'=>$event);

						$this->Box_Application_model->save_location($data);

						$smobile =@$senderinfo->s_mobile;
						$rmobile =@$senderinfo->mobile;
						$stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umesafirishwa '.'kutoka '.$getInfo->em_branch;
						$this->Sms_model->send_sms_trick($smobile,$stotal);
						$this->Sms_model->send_sms_trick($rmobile,$stotal);



		//}else{

			//$this->Box_Application_model->delete_bag($bagsNo);

			//echo "This Item Is Not Corresponding To this Bag";

		//}
					}
					echo 'Successfully Bag Close';

				}
			}else{
				echo 'Please Select Atleast One Item To close';
			}

		}
		else{
		//get Bag by bag id
			$getbaginfo = $this->Box_Application_model->get_bag_by_id($bagss);

			if(!empty($select)){
				if(empty($weight)){
					echo 'Please Fill Bag Weight';
				}else{



					$bagsNo = $getbaginfo->bag_number;

					$bag = array();
					$bag = array('bag_weight'=>$weight);
					$this->Box_Application_model->update_bag($bag,$bagsNo);


					for ($i=0; $i <@sizeof($select) ; $i++) {

						$id = $select[$i];

		//$checkRegion = $this->Box_Application_model->get_region($id,$type);
						$checkRegion = $this->Box_Application_model->get_region($id);

		//if($checkRegion->r_region == $region &&  $checkRegion->branch == $district){
			//if($checkRegion->r_region == $region ){

			// $bag = array();
			// $bag = array('bag_region'=>$region,'bag_branch'=>$district);
			// $this->Box_Application_model->update_bag($bag,$bagsNo);

						$data = array();
						$data = array('isBagNo'=>$bagsNo,'bag_status'=>'isBag');
						$this->Box_Application_model->update_back_office($id,$data);


						$db='sender_info';
						$senderinfo = $this->Box_Application_model->get_sender_info123($id);

						$Barcode=$senderinfo->Barcode;

						$event = "Sorting Facility";
						$location ='Ready for Transit '.$loc;
						$data = array();
						$data = array('track_no'=>@$Barcode,'location'=>$location,'user'=>@$users,'event'=>$event);

						$this->Box_Application_model->save_location($data);

						$smobile =@$senderinfo->s_mobile;
						$rmobile =@$senderinfo->mobile;
						$stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umesafirishwa '.'kutoka '.$getInfo->em_region.' - '.$getInfo->em_branch;
						$this->Sms_model->send_sms_trick($smobile,$stotal);
						$this->Sms_model->send_sms_trick($rmobile,$stotal);

		//}else{

			//$this->Box_Application_model->delete_bag($bagsNo);

			//echo "This Item Is Not Corresponding To this Bag";

		//}
					}
					echo 'Successfully Bag Close';

				}
			}else{
				echo 'Please Select Atleast One Item To close';
			}



		}

	}

	


	

	

}
else{
	redirect(base_url());
}
}

public function bags_item_list()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$type  = $this->input->post('type');
		$bagno = $this->input->post('bagno');
		$reg   = $this->input->post('reg');

		$itemlist = $this->Box_Application_model->take_bags_item_list($type,$bagno);

		foreach ($itemlist as $value) {
			echo "<tr>
			<td>$value->s_fullname</td>
			<td>$value->fullname</td>
			<td>$value->ems_type</td>
			<td>$value->cat_name</td>
			<td>".number_format($value->paidamount,2)."</td>
			<td>$value->r_region</td>
			<td>$value->billid</td>
			</tr>";
		}

	}
	else{
		redirect(base_url());
	}
}

public function bags_list_despatch()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$type  = 'EMS';
		$despno = $this->input->get('despno');
//$data['emslist'] = $this->Box_Application_model->get_ems_back_list();
//$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
//$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
//$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
//$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['ems'] = $this->Box_Application_model->count_ems();
		$data['bags'] = $this->Box_Application_model->count_bags();
		$data['itemlist'] = $this->Box_Application_model->take_bags_desp_list($type,$despno);
		$this->load->view('ems/bags_list_despatched',$data);
	}
	else{
		redirect(base_url());
	}
}


public function list_delivery_bills_despatched()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$type  = 'EMS';
		$despno = $this->input->get('despno');
//$data['emslist'] = $this->Box_Application_model->get_ems_back_list();
//$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
//$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
//$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
//$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['ems'] = $this->Box_Application_model->count_ems();
		$data['bags'] = $this->Box_Application_model->count_bags();
		$data['itemlist'] = $this->Box_Application_model->take_bags_desp_list($type,$despno);
		$data['itemdata'] = $this->Box_Application_model->take_bags_desp_listtwo($type,$despno);
		$this->load->view('ems/delivery_bills_despatched_list',@$data);
	}
	else{
		redirect(base_url());
	}
}

public function getdespatchnumber_branch($branch){

	$getuniquelastnumber= $this->Box_Application_model->get_last_despatchnumber_branch($branch);

            //check length
	if(empty($getuniquelastnumber) || is_null($getuniquelastnumber)){
		$number = 1;
		$nmbur = array();
		$nmbur = array('number'=>$number,'branch'=>$branch);

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('despatchnumber',$nmbur);

		$no_of_digit = 5;

		$length = strlen((string)$number);
		$numberk = '';
		for($i = $length;$i<$no_of_digit;$i++)
		{
			$numberk = '0'.$numberk;
		}

		$number=$numberk.$number;


	}else{
		$no_of_digit = 5;
		$numbers = @$getuniquelastnumber->number;
		$numbers=$numbers+1;
		$number = @$getuniquelastnumber->number;

		$length = strlen((string)$number);
		$numbera='';
		for($i = $length;$i<$no_of_digit;$i++)
		{
			$numbera = '0'.$numbera;
		}
		$number=$numbera.$numbers;


		$nmbur = array();
		$nmbur = array('number'=>$numbers,'branch'=>$branch);
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('despatchnumber',$nmbur);


	}

	return $number;
}


public function getdespatchnumber(){

	$getuniquelastnumber= $this->Box_Application_model->get_last_despatchnumber();

            //check length
	if(empty($getuniquelastnumber) || is_null($getuniquelastnumber)){
		$number = 1;
		$nmbur = array();
		$nmbur = array('number'=>$number);

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('despatchnumber',$nmbur);

		$no_of_digit = 5;

		$length = strlen((string)$number);
		$numberk = '';
		for($i = $length;$i<$no_of_digit;$i++)
		{
			$numberk = '0'.$numberk;
		}

		$number=$numberk.$number;


	}else{
		$no_of_digit = 5;
		$numbers = @$getuniquelastnumber->number;
		$numbers=$numbers+1;
		$number = @$getuniquelastnumber->number;

		$length = strlen((string)$number);
		$numbera='';
		for($i = $length;$i<$no_of_digit;$i++)
		{
			$numbera = '0'.$numbera;
		}
		$number=$numbera.$numbers;


		$nmbur = array();
		$nmbur = array('number'=>$numbers);
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('despatchnumber',$nmbur);


	}

	return $number;
}

public function getbagnumber_branch($branch){

	$getuniquelastnumber= $this->Box_Application_model->get_last_bagnumber_branch($branch);

            //check length
	if(empty($getuniquelastnumber) || is_null($getuniquelastnumber)){
		$number = 1;
		$nmbur = array();
		$nmbur = array('number'=>$number,'branch'=>$branch);

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('bagnumber',$nmbur);

		$no_of_digit = 5;

		$length = strlen((string)$number);
		$numberk = '';
		for($i = $length;$i<$no_of_digit;$i++)
		{
			$numberk = '0'.$numberk;
		}

		$number=$numberk.$number;


	}else{
		$no_of_digit = 5;
		$numbers = @$getuniquelastnumber->number;
		$numbers=$numbers+1;
		$number = @$getuniquelastnumber->number;

		$length = strlen((string)$number);
		$numbera='';
		for($i = $length;$i<$no_of_digit;$i++)
		{
			$numbera = '0'.$numbera;
		}
		$number=$numbera.$numbers;


		$nmbur = array();
		$nmbur = array('number'=>$numbers,'branch'=>$branch);
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('bagnumber',$nmbur);


	}

	return $number;
}


public function getbagnumber(){

	$getuniquelastnumber= $this->Box_Application_model->get_last_bagnumber();

            //check length
	if(empty($getuniquelastnumber) || is_null($getuniquelastnumber)){
		$number = 1;
		$nmbur = array();
		$nmbur = array('number'=>$number);

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('bagnumber',$nmbur);

		$no_of_digit = 5;

		$length = strlen((string)$number);
		$numberk = '';
		for($i = $length;$i<$no_of_digit;$i++)
		{
			$numberk = '0'.$numberk;
		}

		$number=$numberk.$number;


	}else{
		$no_of_digit = 5;
		$numbers = @$getuniquelastnumber->number;
		$numbers=$numbers+1;
		$number = @$getuniquelastnumber->number;

		$length = strlen((string)$number);
		$numbera='';
		for($i = $length;$i<$no_of_digit;$i++)
		{
			$numbera = '0'.$numbera;
		}
		$number=$numbera.$numbers;


		$nmbur = array();
		$nmbur = array('number'=>$numbers);
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('bagnumber',$nmbur);


	}

	return $number;
}

public function bags_despatch()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$select = $this->input->post('I');
		$transtype = $this->input->post('transport_type');
		$transname = $this->input->post('transport_name');
		$reg_no = $this->input->post('reg_no');
		$region = $this->input->post('region');
		$district = $this->input->post('district');
		$transcost = $this->input->post('transport_cost');
		$Seal = $this->input->post('Seal');
		$bagregfrom = $this->session->userdata('user_region');
		$bagreg     = $this->input->post('region');
		$id = $this->session->userdata('user_login_id');
		$info = $this->Box_Application_model->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		$type    = $this->input->post('type');

		if($type=="combine")
		{
                    //update bags
			if (empty($select)) {
				$data['errormessage'] = "Please Select Atleast One Bag ";
				echo $data['errormessage'];
			} else {

				for ($i=0; $i <sizeof($select) ; $i++) { 
					$id = $select[$i];

					$update = array();
					$update = array('type'=>'Combine');

					$this->Box_Application_model->update_bags_info($update,$id);
				}

				$data['message'] = "Successfull Bags Sent in combine";
				echo $data['message'];


			}


		}else{  
			if (!empty($select)) {



				$source = $this->employee_model->get_code_source($o_region);
	 $source_branch = $this->employee_model->get_code_branch($o_branch);//branch_id
	 $dest = $this->employee_model->get_code_dest($region);
	 $year = date("y");


                //$number = $this->getdespatchnumber();
	 $number = $this->getdespatchnumber_branch($o_branch);

	 $desno = 'DESPATCH-EMS-'.@$source->reg_code . @$dest->reg_code.$year.$number.'TZ';

// $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
// $desno = 'DES'.rand(10,100);
// $serial = '';
// for ($i = 0; $i < 3; $i++) {
// 	for ($j = 0; $j < 5; $j++) {
// 		$serial .= $tokens[rand(0, 35)];
// 	}

// 	if ($i < 2) {
// 		$serial .= '-';
// 	}
// }

//$despatchNo = $desno.'-'.$serial;
	 $despatchNo = $desno;

	 $data = array();
	 $data = array('desp_no'=>$despatchNo,'region_from'=>$o_region,'branch_from'=>$o_branch,'transport_type'=>$transtype,'Seal'=>$Seal,'transport_name'=>$transname,'registration_number'=>$reg_no,'transport_cost'=>$transcost,'despatch_status'=>'Sent','region_to'=>$region,'branch_to'=>$district);
	 $this->Box_Application_model->save_despatch_info($data);

	 for ($i=0; $i <@sizeof($select) ; $i++) {

	 	$id = $select[$i];
	 	$checkRegion = $this->Box_Application_model->get_region_bag($id);
	//if($region == $checkRegion->bag_region && $district == $checkRegion->bag_branch){
	 	if($region == $checkRegion->bag_region){
	 		$update = array('bags_status'=>'isDespatch','despatch_no'=>$despatchNo);
	 		$this->Box_Application_model->update_bags_list($id,$update);
	 		echo "Successfully Bags Despatched";


		//update location

	 		$senderinfo = $this->Box_Application_model->despatched_bags_item_list($checkRegion->bag_number);
	 		$emid=   $this->session->userdata('user_login_id');
	 		$getInfo = $this->employee_model->GetBasic($emid);
	 		$users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
	 		$loc = ' - '.$getInfo->em_branch;

	 		foreach ($senderinfo as $key => $value) {
                               	// code...

	 			$track_number=$value->track_number;
	 			$Barcode=@$value->Barcode;

	 			$event = "Despatch Facility";
	 			$location ='On Transit From '.$loc;
	 			$data = array();
	 			$data = array('track_no'=>@$track_number,'location'=>$location,'user'=>@$users,'event'=>$event);

	 			$this->Box_Application_model->save_location($data);

	 			$smobile =@$value->s_mobile;
	 			$rmobile =@$value->mobile;
	 			$stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umesafirishwa '.'kutoka '.$getInfo->em_region.' - '.$getInfo->em_branch;
	 			$this->Sms_model->send_sms_trick($smobile,$stotal);
	 			$this->Sms_model->send_sms_trick($rmobile,$stotal);

	 		}





	 	}else{
	 		$this->Box_Application_model->delete_despatch($despatchNo);
	 	}

	 }
	}else{
		$data['errormessage'] = "Please Select Atleast One Bag ";
		echo $data['errormessage'];
// echo "Please Select Atleast One";
	}
}

}else{
	redirect(base_url());
}

}


/*public function bags_despatch_process(){
	if ($this->session->userdata('user_login_access') != false){
		$select = $this->input->post('I');
		$transtype = $this->input->post('transport_type');
		$transname = $this->input->post('transport_name');
		$reg_no = $this->input->post('reg_no');
		$region = $this->input->post('region');
		$district = $this->input->post('district');
		$transcost = $this->input->post('transport_cost');
		$Seal = $this->input->post('Seal');
		$weight = $this->input->post('weight');
		$bagregfrom = $this->session->userdata('user_region');
		$bagreg     = $this->input->post('region');
		$type    = $this->input->post('type');

		//user information
		$id = $this->session->userdata('user_login_id');
		$info = $this->Box_Application_model->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;


		if (!empty($select)) {
			//creating despatch number
			$despatchNo = $this->Box_Application_model->createDespatchNumber($o_branch,$district);

			$data = array(
				'desp_no'=>$despatchNo['num'],
				'region_from'=>$o_region,
				'branch_from'=>$o_branch,
				'transport_type'=>$transtype,
				'Seal'=>$Seal,
				'dc' =>$despatchNo['dc'],
				'despatch_date'=>date("Y-m-d"),
				'transport_name'=>$transname,
				'registration_number'=>$reg_no,
				'transport_cost'=>$transcost,
				'despatch_status'=>'Sent',
				'region_to'=>$region,
				'branch_to'=>$district);

			//saving the despatch
			$this->Box_Application_model->save_despatch_info($data);
			
			foreach ($select as $key => $id) {

				$checkRegion = $this->Box_Application_model->get_region_bag($id);
				
				//select district (branch) must match with bag district (branch)
				if($region == $checkRegion->bag_region){

					$update = array(
						'bags_status'=>'isDespatch',
						'bag_weight '=>$weight,
						'despatch_no'=>$despatchNo['num']);

					$this->Box_Application_model->update_bags_list($id,$update);

					echo "Successfully Bags Despatched";

					$senderinfo = $this->Box_Application_model->despatched_bags_item_list($checkRegion->bag_number);

                        
					//information
					$users = $info->em_code .'  '.$info->first_name.' '.$info->middle_name.'  '.$info->last_name;

					//from which branch
					$loc = ' - '.$info->em_branch;

					foreach ($senderinfo as $key => $value) {
						$track_number=$value->track_number;
                          	$Barcode=@$value->Barcode;

						$event = "Despatch Facility";
						$location ='On Transit '.$loc;
						
					     $data = array(
					     	'track_no'=>@$track_number,
					     	'location'=>$location,
					     	'user'=>@$users,'event'=>$event);

					     $this->Box_Application_model->save_location($data);
                         }


				}else{
					$this->Box_Application_model->delete_despatch($despatchNo['num']);
				}
			}

		}else{
			$data['errormessage'] = "Please Select Atleast One Bag ";
	 		echo $data['errormessage'];
		}

	}else{
		redirect(base_url());
	}
}*/

public function bags_despatch_process(){
	if ($this->session->userdata('user_login_access') != false){
		$select = $this->input->post('I');
		$transtype = $this->input->post('transport_type');
		$transname = $this->input->post('transport_name');
		$reg_no = $this->input->post('reg_no');
		$region = $this->input->post('region');
		$district = $this->input->post('district');
		$transcost = $this->input->post('transport_cost');
		$Seal = $this->input->post('Seal');
		$weight = $this->input->post('weight');
		$bagregfrom = $this->session->userdata('user_region');
		$bagreg     = $this->input->post('region');
		$type    = $this->input->post('type');

		$remarkslist    = @$this->input->post('ln');
		$remarks='';
		if ($remarkslist) {
			for ($i=0; $i <sizeof($remarkslist) ; $i++) { 
				$list = $remarkslist[$i];
				$remarks    =$remarks.$list.', ';
			}
		}
		if ($remarks) {
			$love['remarks'] = $remarks;
			$remarkData = $remarks;
		}else{
			$remarkData = 'Nill';
		}

		//user information
		$emid = $this->session->userdata('user_login_id');
		$info = $this->Box_Application_model->GetBasic($emid);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;


		if (!empty($select)) {
			//creating despatch number
			$despatchNo = $this->Box_Application_model->createDespatchNumber($o_branch,$district);

			$data = array(
				'desp_no'=>$despatchNo['num'],
				'region_from'=>$o_region,
				'branch_from'=>$o_branch,
				'transport_type'=>$transtype,
				'Seal'=>$Seal,
				'dc'=>$despatchNo['dc'],
				'despatch_date'=>date("Y-m-d"),
				'transport_name'=>$transname,
				'registration_number'=>$reg_no,
				'transport_cost'=>$transcost,
				'despatch_status'=>'Sent',
				'region_to'=>$region,
				'remark'=>$remarkData,
				'branch_to'=>$district);

			//saving the despatch
			$this->Box_Application_model->save_despatch_info($data);
			
			foreach ($select as $key => $id) {

				$checkRegion = $this->Box_Application_model->get_region_bag($id);

				//select district (branch) must match with bag district (branch)
				if($region == $checkRegion->bag_region){

					$update = array(
						'bags_status'=>'isDespatch',
						'bag_weight '=>$weight,
						'despatch_no'=>$despatchNo['num']);

					$this->Box_Application_model->update_bags_list($id,$update);

					echo "Successfully Bags Despatched";

					$senderinfo = $this->Box_Application_model->despatched_bags_item_list($checkRegion->bag_number);

					foreach ($senderinfo as $key => $transData) {
						//for tracing
						$trace_data = array(
							'emid'=>$emid,
							'transid'=>$transData->id,
							'office_name'=>'Despatch',
							'description'=>'On Transit from '.$o_branch,
							'status'=>'BAG Closed');

						$this->Box_Application_model->tracing($trace_data);

						//for track
						$track_data = array(
							'emid'=>$emid,
							'transid'=>$transData->id,
							'office_name'=>'Despatch',
							'description'=>'On Transit from '.$o_branch,
							'type'=>1,
							'status'=>'On Transit');
						
						$this->Box_Application_model->tracing($track_data);
					}

					

				}else{
					$this->Box_Application_model->delete_despatch($despatchNo['num']);
				}
			}

		}else{
			$data['errormessage'] = "Please Select Atleast One Bag ";
			echo $data['errormessage'];
		}

	}else{
		redirect(base_url());
	}
}

public function despatch_action()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$select = $this->input->post('I');
//echo json_encode($select);
		$emid = $this->session->userdata('user_emid');
		if (!empty($select)) {

			for ($i=0; $i <@sizeof($select) ; $i++) {

				$id = $select[$i];
		//$id = $select;

		// echo json_encode($id);

				$update = array();
				$update = array('despatch_status'=>'Received','received_by'=>$emid);
				$this->Box_Application_model->update_despatch_list($id,$update);

				$update1 = array();
				$update1 = array('bags_status'=>'isReceived','bag_received_by'=>$emid);
				$this->Box_Application_model->update_bags_list1($id,$update1);

				$getBagNo = $this->Box_Application_model->get_bag_number($id);
				foreach ($getBagNo as $value) {

					$ids = $value->bag_number;
					$update2 = array();
					$update2 = array('office_name'=>'Back');
					$this->Box_Application_model->update_list($ids,$update2);
				}

			}


//echo "Successfully Despatch Received";
			redirect('Box_Application/received_item_from_out');
		}else{
			echo "Please Select Atleast One Box";
		}

	}
	else{
		redirect(base_url());
	}
}

public function receive_action(){
	$select = $this->input->post('selected');
	$despatchno = $this->input->post('despatchno');

	if ($this->session->userdata('user_login_access') != false){

		$emid = $this->session->userdata('user_emid');
		$getInfo = $this->employee_model->GetBasic($emid);
		$o_region = $getInfo->em_region;
		$o_branch = $getInfo->em_branch;

		if (!empty($select)) {
			$selectedArray = explode(',',$select);

			if(is_array($selectedArray)){

				foreach ($selectedArray as $key => $id) {

					$db='sender_info';
					$senderinfo = $this->Box_Application_model->get_sender_info123($id);
					$Barcode = $senderinfo->Barcode;


					$update2 = array(
						'item_received_by'=>$emid,
						'office_name'=>'InWard receive',
				     	//'office_name'=>'Received',
						'Barcode'=>@$Barcode);

					$this->Box_Application_model->update_transactions_for_sender($update2,$id);

					//for tracing
					$trace_data = array(
						'emid'=>$emid,
						'transid'=>$id,
						'office_name'=>'InWard',
						'description'=>'Received Sorting Facility '.$o_branch,
						'status'=>'BAG receive');

					$this->Box_Application_model->tracing($trace_data);

					//for track
					$track_data = array(
						'emid'=>$emid,
						'transid'=>$id,
						'office_name'=>'InWard',
						'description'=>'Received Sorting Facility '.$o_branch,
						'type'=>1,
						'status'=>'Received Sorting Facility');

					$this->Box_Application_model->tracing($track_data);

				}
			}

			//get the pending bags which does not open
			$pendingBag = $this->Box_Application_model->take_bags_desp_not_received_list('EMS',$despatchno);

			echo "<table id='fromServer1' class='display nowrap table table-bordered fromServer2 receiveTable' cellspacing='0' width='100%'>
			<thead>
			<tr>
			<th>Bag Number</th>
			<th>Bag Source</th>
			<th>Bag Destination</th>
			<th>Date Bag Created</th>
			<th>Total Item Number</th>
			<th>Bag Received By</th>
			</tr>
			</thead>
			<tbody class=''>";

			if($pendingBag){

				$count = 0;

				foreach ($pendingBag as $key => $value) {
					$count++;
					$bagsNo = $value->bag_number;

					$updatebag = array('bags_status'=>'isReceived','bag_received_by'=>$emid);
					//update the bag
					$this->Box_Application_model->update_bag_status($despatchno,$bagsNo,$updatebag);

					$totalBag = $this->Box_Application_model->count_bags_desp_list($bagsNo);

					echo "<tr class='receiveRow'>
					<td>
					<button class='btn btn-warning' data-bagno='$bagsNo' data-despno='$despatchno' onclick='receiveBagItems(this)'>".$value->bag_number."</button></td>
					<td>".$value->bag_region_from."</td>
					<td>".$value->bag_region."</td>
					<td>".$value->date_created."</td>
					<td>".$totalBag."</td>
					<td>".$value->bag_received_by."</td>
					</tr>";
				}

				
			}else{

				echo "<tr><td colspan='6'><h4 style='color: blue;'>No pending bag (s) for dispatch - ".$despatchno."</h4></td></tr>";
			}

			echo "</tbody></table>
			<table class='table' style='width: 100%;'><tr><td style='float: right;'>
			<div class='statusText'></div></td></tr></table>";

		}else{
			echo "Please Select Atleast One Box";
		}

	}else{
		redirect(base_url());
	}
}


public function receive_action_old()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$select = $this->input->post('I');
		$emid = $this->session->userdata('user_emid');
		$getInfo = $this->employee_model->GetBasic($emid);
		$users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
		$loc = ' - '.$getInfo->em_branch;
		if (!empty($select)) {

			for ($i=0; $i <@sizeof($select) ; $i++) {

				$id = $select[$i];
				$update2 = array();
				$update2 = array('item_received_by'=>$emid,'office_name'=>'Received');

				$this->Box_Application_model->update_transactions_for_sender($update2,$id);

// $getBagNo = $this->Box_Application_model->get_bag_number($id);  
// foreach ($getBagNo as $value) {

// 	$id = $value->bag_number;
// 	$update2 = array();
// 	$update2 = array('item_received_by'=>$emid,'office_name'=>'Received');
// 	$this->Box_Application_model->update_list($id,$update2);
// }

		 // $getInfo = $this->employee_model->GetBasic($emid);
  //                           $users = $getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
  //                           $loc = $getInfo->em_region.' - '.$getInfo->em_branch;

				$db='sender_info';
				$senderinfo = $this->Box_Application_model->get_sender_info123($id);

				$Barcode=$senderinfo->Barcode;

				$event = "Sorting Facility";
				$location ='Received Sorting Facility '.$loc;
				$data = array();
				$data = array('track_no'=>@$Barcode,'location'=>$location,'user'=>@$users,'event'=>$event);

				$this->Box_Application_model->save_location($data);

				$smobile =@$senderinfo->s_mobile;
				$rmobile =@$senderinfo->mobile;
				$stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$Barcode. ' umepokelewa '.' '.$getInfo->em_region.' - '.$getInfo->em_branch;
				$this->Sms_model->send_sms_trick($smobile,$stotal);
				$this->Sms_model->send_sms_trick($rmobile,$stotal);
			}
			echo "Successfully Item Received";
		}else{
			echo "Please Select Atleast One Box";
		}

	}
	else{
		redirect(base_url());
	}
}


public function Qrcode_generate()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$data['list'] = $this->Box_Application_model->qrcode_list();

		$this->load->library('Pdf');
		$html= $this->load->view('billing/qrcode_list',$data,TRUE);
		$this->load->library('Pdf');
		$this->dompdf->loadHtml($html);
		$this->dompdf->setPaper('A4','potrait');
		$this->dompdf->render();
		$this->dompdf->stream('example.pdf', array("Attachment"=>0));
	}
	else{
		redirect(base_url());
	}
}
public function item_qrcode()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$code =base64_decode($this->input->get('code'));

		$data['item'] = $this->Box_Application_model->get_qrcode_item($code);

		$this->load->library('Pdf');
		$html= $this->load->view('billing/item_qrcode',$data,TRUE);
		$this->load->library('Pdf');
		$this->dompdf->loadHtml($html);
		$this->dompdf->setPaper('A4','potrait');
		$this->dompdf->render();
		$this->dompdf->stream($code, array("Attachment"=>0));
	}
	else{
		redirect(base_url());
	}
}
public function get_item_list()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$bagno = base64_decode($this->input->get('I'));

//$data['emslist'] = $this->Box_Application_model->get_ems_back_list();
//$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
//$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
//$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
		$data['bagslist'] = $this->Box_Application_model->get_item_from_bags_list($bagno);
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['ems'] = $this->Box_Application_model->count_ems();
		$data['bags'] = $this->Box_Application_model->count_bags();
		$this->load->view('ems/bags_items_list',$data);
	}
	else{
		redirect(base_url());
	}
}

public function find_branch_delivery()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$userregion = $this->session->userdata('user_region');
		$userbranch = $this->session->userdata('user_branch');
		$select = $this->input->post('I');

		if (!empty($select)) {

			for ($i=0; $i <@sizeof($select) ; $i++) {

				$id = $select[$i];

				$data = array();
				$data = array('s_status'=>'Received');
				$this->Box_Application_model->update_sender_status($id,$data);

				$getDetails = $this->Box_Application_model->get_details_by_id($id);

				$branch = $getDetails->branch;
				$region = $getDetails->r_region;
				$mobile = $getDetails->mobile;


				if ( $branch == $userbranch && $userregion == $region ) {

					$total ='KARIBU POSTA KIGANJANI,mzigo wako wenye namba hizi hapa'.'  '.$getDetails->track_number.''.' umewasili kwenye ofisi zetu za mokoa wa'.' '.$region.' tawi la '.$getDetails->branch;
					$this->Sms_model->send_sms_trick($mobile,$total);

				}

			}
			echo "Successfully Received";

		}else{
			echo "Please Select Atleast One Item";
		}



	}
	else{
		redirect(base_url());
	}
}

public function Commission(){

	if ($this->session->userdata('user_login_access') != false)
	{
		$data['region'] = $this->employee_model->regselect();
		$this->load->view('billing/commission_agency_registration',$data);
	}
	else{
		redirect(base_url());
	}

}

public function commission_registration()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$comp_name    = $this->input->post('comp_name');
		$comp_address = $this->input->post('comp_address');
		$comp_phone  = $this->input->post('comp_phone');
		$comp_region = $this->input->post('comp_region');

		$data = array();
		$data = array('com_name'=>$comp_name,'com_address'=>$comp_address,'com_phone'=>$comp_phone,'com_region'=>$comp_region);

		$this->billing_model->save_commission_registration($data);
		echo "Successfully Added";
	}
	else{
		redirect(base_url());
	}
}

public function commission_agency_list()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$data['company'] = $this->Box_Application_model->commission_agency_list();
		$this->load->view('billing/commission_agency_list',$data);
	}
	else{
		redirect(base_url());
	}
}

public function delete_commission_agent_info(){
	$codeid = base64_decode($this->input->get('I'));
	$this->Box_Application_model->delete_commission_agency_info($codeid);
	$this->session->set_flashdata('message','Agency information deleted successfully');
	redirect('Box_Application/commission_agency_list');
}

public function commission_issuedpayment_view()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$data['id'] = base64_decode($this->input->get('I'));
		$this->load->view('billing/commission_billing_issues',$data);
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

public function contract_action()
{

	$cont_id = $this->input->post('cont_id');
	$conttype = $this->input->post('cont_type');
	$agtype = $this->input->post('agreement_type');
	$partiesname = $this->input->post('parties_name');
	$mobile = $this->input->post('mobile');
	$con_region = $this->input->post('con_region');
//$start_date = $this->input->post('start_date');
//$contract_year = $this->input->post('contract_year');
//$year=date('Y', strtotime($start_date)) + $contract_year;
//$month=date('m', strtotime($start_date));
//$day=date('d', strtotime($start_date));
//$end_date = $year.'-'.$month.'-'.$day;
//$cont_price = $this->input->post('cont_price');
//$mode_payment = $this->input->post('mode_payment');

	$data = array();
	$data = array('cont_type'=>$conttype,'parties_name'=>$partiesname,'agreement_type'=>$agtype,'mobile'=>$mobile,'region'=>$con_region,'status'=>'ACTIVE');

	$results = $this->Box_Application_model->save_contract($data);

	$this->session->set_flashdata("success","Contract Information has been Successfully Added");

	redirect($this->agent->referrer());
}

public function Contract_list()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$data['contract'] = $this->Box_Application_model->get_contract_lists();
		$this->load->view('legal/contract_list_view',$data);
	}
	else{
		redirect(base_url());
	}
}


public function cancel_contract()
{
	$empid = $this->session->userdata('user_emid');
	$cont_id = $this->input->post('conid');
	$status = $this->input->post('status');
	$contract_year = $this->input->post('contract_year');
	$mode_payment = $this->input->post('mode_payment');
	$cont_price = $this->input->post('cont_price');
	$image_url = $this->input->post('image_url');
	$start_date = date("Y-m-d",strtotime($this->input->post('start_date')));
	$end_date = date("Y-m-d",strtotime($this->input->post('end_date')));
	$emrand1 = substr($empid,0,3).rand(1000,2000); 
	$emrand = str_replace("'", '', $emrand1);

	if($status=="isComplete"){

		if($_FILES['image_url']['name']){

			$file_name = $_FILES['image_url']['name'];
			$fileSize = $_FILES["image_url"]["size"]/1024;
			$fileType = $_FILES["image_url"]["type"];
			$new_file_name='';
			$new_file_name .= @$emrand;

			$config = array(
				'file_name' => $new_file_name,
				'upload_path' => "./assets/images/users",
				'allowed_types' => "pdf",
				'overwrite' => False,
                'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "800",
                'max_width' => "800"
            );

			$this->load->library('Upload', $config);
			$this->upload->initialize($config);   

			if (!$this->upload->do_upload('image_url')) {
                //echo $this->upload->display_errors();
				$this->session->set_flashdata("feedback","Warning! Contract file must be PDF File and fill all necessary contract fields, Please try again..");
			} else {

				$path = $this->upload->data();
				$img_url = $path['file_name'];

				$data = array();
				$data = array('start_date'=>$start_date,
					'contract_year'=>$contract_year,
					'end_date'=>$end_date,
					'mode_payment'=>$mode_payment,
					'cont_price'=>$cont_price,
					'scann_docu'=>$img_url,
					'status'=>$status);
				$this->Box_Application_model->update_contract_item($data,$cont_id);

				//echo "Successfully Updated";
				$this->session->set_flashdata("success","Contract Information has been Successfully Updated");
			}

		}
	}

	else{
		$data = array();
		$data = array('status'=>$status);
		$this->Box_Application_model->update_contract_item($data,$cont_id);

				//echo "Successfully Updated";
		$this->session->set_flashdata("success","Contract Information has been Successfully Updated");
	}



	redirect($this->agent->referrer());
}


public function delete_selected_contract(){
	$id = $this->input->get('id');
	$results = $this->Box_Application_model->delte_contract_selected($id);

	if($results)
	{
		$this->session->set_flashdata("success","Contract Information has been Successfully deleted");	
	}
	else
	{
		$this->session->set_flashdata("feedback","Failed to delete contract Information");
	}

	redirect($this->agent->referrer());
}



public function Report()
{
	if ($this->session->userdata('user_login_access') != false)
	{
// $document = 'Document';
// $parcel = 'Parcel';
// $data['reportd'] = $this->Box_Application_model->get_ems_report_Document($document);
// 		//$data['reportdd'] = $this->Box_Application_model->get_ems_report_Document_Day($document);
// $data['reportp'] = $this->Box_Application_model->get_ems_report_Parcel($parcel);
// $data['reportpd'] = $this->Box_Application_model->get_ems_report_Parcel_Day($parcel);
		$this->load->view('billing/ems_report');
	}
	else{
		redirect(base_url());
	}
}
public function Get_ems_report()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$date = $this->input->post('date');
		$type = $this->input->post('type');
		$cat = $this->input->post('category');

		echo json_encode($date.$type.$cat);
	}
	else{
		redirect(base_url());
	}
}
public function ems_action_receiver()
{
	if ($this->session->userdata('user_login_access') != false)
	{
		$id = $this->input->post('id');
		$info = $this->Box_Application_model->get_sender_info($id);
		$operator = $this->session->userdata('user_login_id');

		$r_fname = $this->input->post('r_fname');
		$r_address = $this->input->post('r_address');
		$r_mobile = $this->input->post('r_mobile');
		$r_email = $this->input->post('r_email');
		$rec_region = $this->input->post('region_to');
		$rec_dropp = $this->input->post('district');


		$serial    = 'EMS'.date("YmdHis");
		$transactionstatus   = 'POSTED';
		$bill_status  = 'PENDING';
		$PaymentFor = 'EMS';
		$transactiondate = date("Y-m-d");
		$fullname  = $info->s_fullname;

		$emsCat = $info->cat_type;
		$weight = $info->weight;
		$regionp = $info->s_region;

		$price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
		$vat = $price->vat;
//$total1 = $vat + $price->tariff_price;
		$total1 = $vat + $price->tariff_price;
		$o_region = $regionp;
		$source = $this->employee_model->get_code_source($o_region);
		$dest = $this->employee_model->get_code_dest($rec_region);

		$bagsNo = $source->reg_code . $dest->reg_code;


		$sender = array();
		$sender = array('ems_type'=>$info->ems_type,'cat_type'=>$info->cat_type,'weight'=>$info->weight,'s_fullname'=>$info->s_fullname,'s_address'=>$info->s_address,'s_email'=>$info->s_email,'s_mobile'=>$info->s_mobile,'s_region'=>$info->s_region,'s_district'=>$info->s_district,'operator'=>$operator);

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('sender_info',$sender);
		$last_id = $db2->insert_id();


		$receiver = array();
		$receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp);

		$db2->insert('receiver_info',$receiver);

//get price by cat id and weight range;

		$data = array(

			'transactiondate'=>date("Y-m-d"),
			'serial'=>$serial,
			'paidamount'=>$total1,
			'CustomerID'=>$last_id,
			'Customer_mobile'=>$info->s_mobile,
			'region'=>$regionp,
			'district'=>$info->s_district,
			'transactionstatus'=>'POSTED',
			'bill_status'=>'PENDING',
			'paymentFor'=>$PaymentFor

		);

		$this->Box_Application_model->save_transactions($data);

		$paidamount = $total1;
		$region = $info->s_region;
		$district = $info->s_district;
		$renter   = $info->ems_type;
		$mobile   = $info->s_mobile;
		$serviceId = 'EMS';
		$trackno = $bagsNo;
		$transaction = $this->getBillGepgBillIdEMS($serial,$paidamount,$district,$region,$mobile,$renter,$serviceId,$trackno);
		@$serial1 = $transaction->billid;

		if (@$transaction->controlno != '') {
	# code...

			$update = array('billid'=>@$transaction->controlno,'bill_status'=>'SUCCESS');
			$this->billing_model->update_transactions($update,$serial1);

//$serial1 = '995120555284';

			$first4 = substr(@$transaction->controlno, 4);
			$trackNo = $bagsNo.$first4;
			$data1 = array();
			$data1 = array('track_number'=>$trackNo);

			$this->billing_model->update_sender_info($last_id,$data1);

			$total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($total1,2);

			$total2 ='The amount to be paid for EMS is '. ' '.number_format($price->tariff_price,2).'  and VAT to be paid is'.' '. number_format($vat,2).'  The TOTAL amount is '.' '.number_format($total1,2).' Pay through this control number'.' '.@$transaction->controlno ;

			$this->Sms_model->send_sms_trick($mobile,$total);

// echo json_encode($total2);

			echo "Successfully Saved";

		}else{

			echo "Refresh EMS Application List To Get Control Number";
		}

	}
	else{
		redirect(base_url());
	}
}
public function supervisortrackjob123($emid,$date)
{

	$year = date('Y',strtotime($date));
	$month = date('m',strtotime($date));
	$day = date('d',strtotime($date));


	$info = $this->Box_Application_model->GetBasic($emid);
	$region = $info->em_region;
	$branch = $info->em_branch;

	$sumtotal=0;


	            //$getInfo = array();

	    //         $getInfo = [new Supervisor_ViewModel($value->sender_id,$value->date_registered,
		   // $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
		   // $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
     //       $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
     //       $value->email,$value->mobile, 
     //       $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_NECTA')];

	$getInfo = array();
  $type = 'NECTA';//Necta
  $DB = 'transactions';
              // $NECTA =$this->Reports_model->get_Paid_Report_list_for_search($type,$date,$month,$region,$DB);
  $NECTA =$this->Box_Application_model->get_details_per_date_by_emid_Sender($type,$year,$month,$day,$emid,$DB);
  echo 'HIYO '.json_encode( $NECTA);
  foreach ($NECTA as $key => $value) {



  	$getInfo[] = $this->Supervisor_ViewModel->view_data('kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','10','kula','kula','kula');
  	$getInfo[] = $this->Supervisor_ViewModel->view_data('kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','kula','10','kula','kula','kumi');




  }

				//$getInfo = (object)$getInfo;

  echo ' HIYO2 '.json_encode( $getInfo);

             //echo ' HIYO3 '.json_encode( $myArray);

  foreach ($getInfo as $key => $values) {
  	$values = (object)$values;
             	# code...
             	//$sumtotal =  $sumtotal + $values['paidamount'];
  	$sumtotal =  $sumtotal + $values->paidamount;

  	echo $sumtotal;
  }


  return $getInfo;
}

public function supervisortrackjob($emid,$date)
{
	
	$year = date('Y',strtotime($date));
	$month = date('m',strtotime($date));
	$day = date('d',strtotime($date));


	$info = $this->Box_Application_model->GetBasic($emid);
	$region = $info->em_region;
	$branch = $info->em_branch;

	$sumtotal=0;


	$getInfo = array();


                $type = 'EMS';//DomesticDocument
                $DB = 'transactions';
                $EMS =$this->Box_Application_model->get_details_per_date_by_emid_Sender1($type,$year,$month,$day,$emid,$DB);

                foreach (@$EMS as $key => $value) {
                	$getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                		$value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                		$value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                		$value->email,$value->mobile, 
                		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','Ems_DomesticDocument',$value->Barcode);

                	$sumtotal =  $sumtotal + $value->paidamount;
                }

               $type = 'EMSBILLING';//ems posta global bill --  ems_bill_companies 3
               $DB = 'transactions';
               $EMSBILLING =$this->Box_Application_model->get_details_per_date_by_emid_Sender1($type,$year,$month,$day,$emid,$DB);
               foreach (@$EMSBILLING as $key => $value) {
               	$getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
               		$value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
               		$value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
               		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
               		$value->email,$value->mobile, 
               		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','ems_posta_global_bill',$value->Barcode);
               	$sumtotal =  $sumtotal + $value->paidamount;
               }


               $type = 'EMS_INTERNATIONAL';//ems international
               $DB = 'transactions';
               $EMS_INTERNATIONAL =$this->Box_Application_model->get_details_per_date_by_emid_Sender1($type,$year,$month,$day,$emid,$DB);
               foreach (@$EMS_INTERNATIONAL as $key => $value) {
               	$getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
               		$value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
               		$value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
               		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
               		$value->email,$value->mobile, 
               		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_INTERNATIONAL',$value->Barcode);
               	$sumtotal =  $sumtotal + $value->paidamount;
               }



               $type = 'LOAN BOARD';//Loan Board(HESLB)
               $DB = 'transactions';
               $loan_board =$this->Box_Application_model->get_details_per_date_by_emid_Sender1($type,$year,$month,$day,$emid,$DB);
               foreach (@$loan_board as $key => $value) {
               	$getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
               		$value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
               		$value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
               		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
               		$value->email,$value->mobile, 
               		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_LOAN_BOARD',$value->Barcode);
               	$sumtotal =  $sumtotal + $value->paidamount;
               }



               $type = 'EMS_HESLB';//Loan Board(HESLB)
               $DB = 'transactions';
               $EMS_HESLB =$this->Box_Application_model->get_details_per_date_by_emid_Sender1($type,$year,$month,$day,$emid,$DB);
               foreach (@$EMS_HESLB as $key => $value) {
               	$getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
               		$value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
               		$value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
               		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
               		$value->email,$value->mobile, 
               		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_LOAN_BOARD',$value->Barcode);
               	$sumtotal =  $sumtotal + $value->paidamount;
               }



                $type = 'NECTA';//Necta
                $DB = 'transactions';
              // $NECTA =$this->Reports_model->get_Paid_Report_list_for_search($type,$date,$month,$region,$DB);
                $NECTA =$this->Box_Application_model->get_details_per_date_by_emid_Sender1($type,$year,$month,$day,$emid,$DB);
                //echo 'HIYO '.json_encode( $NECTA);
                foreach ($NECTA as $key => $value) {
                	$getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                		$value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                		$value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                		$value->email,$value->mobile, 
                		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_NECTA',$value->Barcode);
             //echo ' HIYO2 '.json_encode( $getInfos);
                	$sumtotal =  $sumtotal + $value->paidamount;
                }







                $type = 'EMS-CARGO';//Ems Cargo
                $DB = 'transactions';
                $EmsCargo =$this->Box_Application_model->get_details_per_date_by_emid_Sender1($type,$year,$month,$day,$emid,$DB);
                foreach (@$EmsCargo as $key => $value) {
                	$getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                		$value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                		$value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                		$value->email,$value->mobile, 
                		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_Cargo',$value->Barcode);
                	$sumtotal =  $sumtotal + $value->paidamount;
                }






                 $type = 'PCUM';//Pcum
                 $DB = 'transactions';
                 $PCUM =$this->Box_Application_model->get_details_per_date_by_emid_Sender_serial1($type,$year,$month,$day,$emid,$DB);
                 foreach (@$PCUM as $key => $value) {
                 	$getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                 		$value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 		$value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 		$value->email,$value->mobile, 
                 		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_PCUM',$value->Barcode);
                 	$sumtotal =  $sumtotal + $value->paidamount;
                 }



                 //MAIL



               $type = 'MAIL';//INTERNATIONALREGISTER -- 
               $DB = 'transactions';
               $DB1 = 'registered_international';
               @$info = $this->employee_model->GetBasic($emid);
               $emcode = @$info->em_code;
               $INTERNATIONALREGISTER =$this->Box_Application_model->get_details_per_date_by_emid_registered_international($type,$year,$month,$day,$emcode,$DB,$DB1);
               foreach (@$INTERNATIONALREGISTER as $key => $value) {
               	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
               		'', $value->s_region, $value->s_district,'ONLINE',
               		'','', $value->s_mobile,$emid, '',
               		$value->r_region,$value->branch,$value->receiver_id, '', '',
               		'',$value->mobile, 
               		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_INTERNATIONALREGISTER');
               	$sumtotal =  $sumtotal + $value->paidamount;
               }



               $type = 'register_billing';//REGISTEREDBILL 
               $DB = 'transactions';
               $DB1 = 'credit_customer';
               $register_billing =$this->Box_Application_model->get_details_per_date_by_emid_RegisterBill($type,$year,$month,$day,$emid,$DB,$DB1);
               foreach (@$register_billing as $key => $value) {
               	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
               		'', $value->s_region, $value->s_district,$value->s_fullname,
               		$value->s_address,$value->s_email, $value->s_mobile,$value->operator, '',
               		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
               		$value->email,$value->mobile, 
               		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_REGISTEREDBILL');
               	$sumtotal =  $sumtotal + $value->paidamount;
               }




               $type = 'STAMP';//SALES OF STAMP 
               $DB = 'transactions';
               $DB1 = 'stamp';
               $STAMP=$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
               foreach (@$STAMP as $key => $value) {
               	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
               		'', $value->s_region, $value->s_district,'',
               		'','', $value->s_mobile,$value->operator, '',
               		$value->r_region,$value->branch,$value->receiver_id, '', '',
               		'',$value->mobile, 
               		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_STAMP');
               	$sumtotal =  $sumtotal + $value->paidamount;
               }



               $type = 'PBOX';//PRIVATE BOX RENTAL FEES --customer_details 2-haina operator
               $DB = 'transactions';
              // $BOX =$this->Box_Application_model->get_details_per_date_by_emid_Sender($type,$year,$month,$day,$emid,$DB);


                 $type = 'AuthorityCard'; //--AuthorityCard
                 $DB = 'transactions';
                 $DB1 = 'authoritycard';

                 $AuthorityCard =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
                 foreach (@$AuthorityCard as $key => $value) {
                 	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 		'', $value->s_region, $value->s_district,'',
                 		'','', $value->s_mobile,$value->operator, '',
                 		$value->r_region,$value->branch,$value->receiver_id, '', '',
                 		'',$value->mobile, 
                 		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_AuthorityCard');
                 	$sumtotal =  $sumtotal + $value->paidamount;
                 }




                $type = 'KEYDEPOSITY';//KEYDEPOSITY
                $DB = 'transactions';
                $DB1 = 'keydeposity';
                $KEYDEPOSITY =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
                foreach (@$KEYDEPOSITY as $key => $value) {
                	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                		'', $value->s_region, $value->s_district,'',
                		'','', $value->s_mobile,$value->operator, '',
                		$value->r_region,$value->branch,$value->receiver_id, '', '',
                		'',$value->mobile, 
                		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_KEYDEPOSITY');
                	$sumtotal =  $sumtotal + $value->paidamount;
                }


                

                $type = 'CARGO';//POSTSCARGO 
                $DB = 'transactions';
                $CARGO =$this->Box_Application_model->get_details_per_date_by_emid_Sender_serial($type,$year,$month,$day,$emid,$DB);
                foreach (@$CARGO as $key => $value) {
                	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                		$value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                		$value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                		$value->email,$value->mobile, 
                		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_POSTSCARGO');
                	$sumtotal =  $sumtotal + $value->paidamount;
                }



              $type = 'COMM'; //COMMISSION AGENCY 1 -haina operator
              $DB = 'transactions';
              $DB1 = 'commission_agency'; 
              // $COMM =$this->Box_Application_model->get_details_per_date_by_emid_Sender($type,$year,$month,$day,$emid,$DB);

                   $type = 'P';//PARKING  
                  // $DB = 'parking_transactions';
                   $DB1 = 'parking'; 
                   $parking_transactions =$this->Box_Application_model->get_details_per_date_by_emid_Parking($type,$year,$month,$day,$emid,$DB,$DB1);
                   foreach (@$parking_transactions as $key => $value) {
                   	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                   		'', $value->s_region, $value->s_district,$value->s_fullname,
                   		'','', '',$value->operator, '',
                   		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, '',
                   		'','', 
                   		$value->billid, '', $value->status,$value->id, $value->paidamount,'','','','parking_Auto');
                   	$sumtotal =  $sumtotal + $value->paidamount;
                   }

                   @$id = @$emid;
                   @$info = $this->Box_Application_model->GetBasic($id); 
                   $fulloperatorName= " PF:". '   '.@$info->em_code.'   '.@$info->first_name. '   '. @$info->middle_name.' '.@$info->last_name.  '';

			 $type = 'P';//PARKING  
			 $DB = 'parking_transactions';
                   // $DB1 = 'parking'; 
			 $parking_transactions =$this->Box_Application_model->get_details_per_date_by_emid_Parking2($type,$year,$month,$day,$emid,$DB,$DB1);
			 foreach (@$parking_transactions as $key => $value) {
			 	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
			 		'', 'Dar es salaam', 'GPO',$fulloperatorName,
			 		'','', '',$value->operator, '',
			 		'Dar es salaam','GPO',$value->receiver_id, $fulloperatorName, '',
			 		'','', 
			 		$value->billid, '', $value->status,$value->id, $value->paidamount,'','','','parking_Poss_bulk');
			 	$sumtotal =  $sumtotal + $value->paidamount;
			 }


               $type = 'INTERNET'; //INTERNET
               $DB = 'transactions';
               $DB1 = 'internet';
               $INTERNET =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
               foreach (@$INTERNET as $key => $value) {
               	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
               		'', $value->s_region, $value->s_district,'',
               		'','', $value->s_mobile,$value->operator, '',
               		$value->r_region,$value->branch,$value->receiver_id, '', '',
               		'',$value->mobile, 
               		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','INTERNET');
               	$sumtotal =  $sumtotal + $value->paidamount;
               }


               $type = 'POSTASHOP'; //post_shop
               $DB = 'transactions';
               $DB1 = 'post_shop';
               $POSTASHOP =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
               foreach (@$POSTASHOP as $key => $value) {
               	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
               		'', $value->s_region, $value->s_district,'',
               		'','', $value->s_mobile,$value->operator, '',
               		$value->r_region,$value->branch,$value->receiver_id, '', '',
               		'',$value->mobile, 
               		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','POSTASHOP');
               	$sumtotal =  $sumtotal + $value->paidamount;
               }


                $type = 'POSTABUS';//postabus
                $DB = 'transactions';
                $DB1 = 'postabus';
                $POSTABUS =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
                foreach (@$POSTABUS as $key => $value) {
                	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                		'', $value->s_region, $value->s_district,'',
                		'','', $value->s_mobile,$value->operator, '',
                		$value->r_region,$value->branch,$value->receiver_id, '', '',
                		'',$value->mobile, 
                		$value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','POSTABUS');
                	$sumtotal =  $sumtotal + $value->paidamount;
                }







              $type = 'Register';//DOMESTICREGISTER
              $DB = 'register_transactions';
              $register_transactions =$this->Box_Application_model->get_details_per_date_by_emid_Sender_person($type,$year,$month,$day,$emid,$DB);
              foreach (@$register_transactions as $key => $value) {
              	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
              		$value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
              		$value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
              		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
              		'',$value->mobile, 
              		$value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_DOMESTICREGISTER');
              	$sumtotal =  $sumtotal + $value->paidamount;
              }



                $type = 'Parcel';//PARCEL POST DOMESTIC
                $DB = 'register_transactions';
                $Parcel =$this->Box_Application_model->get_details_per_date_by_emid_Sender_person($type,$year,$month,$day,$emid,$DB);
                foreach (@$Parcel as $key => $value) {
                	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                		$value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                		$value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                		'',$value->mobile, 
                		$value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_PARCEL_POST_DOMESTIC');
                	$sumtotal =  $sumtotal + $value->paidamount;
                }


               $type = 'PInter';//PARCEL POST INTERNATIONAL
                $DB = 'register_transactions'; //parcel_international_transactions
                $PInter =$this->Box_Application_model->get_details_per_date_by_emid_Sender_person($type,$year,$month,$day,$emid,$DB);
                foreach (@$PInter as $key => $value) {
                	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                		$value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                		$value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                		'',$value->mobile, 
                		$value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_PARCEL_POST_INTERNATIONAL');
                	$sumtotal =  $sumtotal + $value->paidamount;
                }



               $type = 'DSmallPackets';//SMALL PACKETS DOMESTIC 
               $DB = 'register_transactions';
               $DSmallPackets =$this->Box_Application_model->get_details_per_date_by_emid_Sender_person($type,$year,$month,$day,$emid,$DB);
               foreach (@$DSmallPackets as $key => $value) {
               	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
               		$value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
               		$value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
               		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
               		'',$value->mobile, 
               		$value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_SMALL_PACKETS_DOMESTIC');
               	$sumtotal =  $sumtotal + $value->paidamount;
               }


                $type = 'Derivery';//SMALL PACKETS Derivery 
                $DB = 'derivery_transactions';
                $Derivery =$this->Box_Application_model->get_details_per_date_by_emid_Derivery($type,$year,$month,$day,$emid,$DB);
                foreach (@$Derivery as $key => $value) {
                	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                		'', $value->s_region, $value->s_district,$value->s_fullname,
                		'','', $value->s_mobile,$value->operator, '',
                		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, '',
                		'',$value->mobile, 
                		$value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_SMALL_PACKETS_Derivery');
                	$sumtotal =  $sumtotal + $value->paidamount;
                }




                


                $type = 'Residential';//residential estate_information
                $DB = 'real_estate_transactions';
                $Residential =$this->Box_Application_model->get_details_per_date_by_emid_RealEstate($type,$year,$month,$day,$emid,$DB);
                foreach (@$Residential as $key => $value) {
                	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                		'', $value->s_region, $value->s_district,$value->s_fullname,
                		$value->s_address,'', $value->s_mobile,$value->operator, '',
                		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                		'',$value->mobile, 
                		$value->billid, '', $value->status,$value->id, $value->paidamount,'','','','Real_Estate_Residential');
                	$sumtotal =  $sumtotal + $value->paidamount;
                }


               $type = 'Land';//residential Land
               $DB = 'real_estate_transactions';
               $Land =$this->Box_Application_model->get_details_per_date_by_emid_RealEstate($type,$year,$month,$day,$emid,$DB);
               foreach (@$Land as $key => $value) {
               	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
               		'', $value->s_region, $value->s_district,$value->s_fullname,
               		$value->s_address,'', $value->s_mobile,$value->operator, '',
               		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
               		'',$value->mobile, 
               		$value->billid, '', $value->status,$value->id, $value->paidamount,'','','','Real_Estate_Land');
               	$sumtotal =  $sumtotal + $value->paidamount;
               }
               


                $type = 'Offices';//residential Offices
                $DB = 'real_estate_transactions';
                $Offices =$this->Box_Application_model->get_details_per_date_by_emid_RealEstate($type,$year,$month,$day,$emid,$DB);
                foreach (@$Offices as $key => $value) {
                	$getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                		'', $value->s_region, $value->s_district,$value->s_fullname,
                		$value->s_address,'', $value->s_mobile,$value->operator, '',
                		$value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                		'',$value->mobile, 
                		$value->billid, '', $value->status,$value->id, $value->paidamount,'','','','Real_Estate_Offices');
                	$sumtotal =  $sumtotal + $value->paidamount;
                }




                return $getInfo;

            }

            public function Get_bill_EMSDate1()
            {
            	if ($this->session->userdata('user_login_access') != false)
            	{
            		$date = $this->input->post('date_time');
            		$emid = $this->input->post('emid');
//$emid = $this->input->post('emidag');
            		$year = date('Y',strtotime($date));
            		$month = date('m',strtotime($date));
            		$day = date('d',strtotime($date));

//echo $day.' '.$date.' '.$emid;

            		$id = $this->session->userdata('user_login_id');
            		$info = $this->Box_Application_model->GetBasic($id);
            		$region = $info->em_region;
            		$branch = $info->em_branch;
            		$sumtotal=0;
            		if ($this->session->userdata('user_type') == "SUPERVISOR") {
            			$getInfo = @$this->Box_Application_model->get_ems_bill_per_date_by_emid1($year,$month,$day,$emid);

		// $getInfos=$this->supervisortrackjob($emid,$date);

            			foreach (@$getInfo as $key => $value) {
            				$value = (object)$value;
            				$sumtotal=$sumtotal + $value->paidamount;
            			}



            		} else {
            			$getInfo = @$this->Box_Application_model->get_ems_bill_per_date1($year,$month,$day,$emid);
            		}

// $data['total'] = $this->Box_Application_model->get_ems_sum12($year,$month,$day);
// @$paidamount = $data['total']->paidamount;
            		$data['total'] = @$sumtotal;
            		@$paidamount = @$sumtotal;


//echo 'HIYO'.json_decode($getInfo);

            		echo
            		"<form method='POST' action='send_to_back_office'>
            		<table id='fromServer' class='display nowrap table table-hover table-striped table-bordered searchResult' cellspacing='0' width='100%'>
            		<thead>
            		<tr><th colspan='11'></th><th colspan=''><div class='form-check' style='padding-left:60px;' id='showCheck3'>
            		<input type='checkbox'  class='form-check-input' id='checkAll3' style=''>
            		<label class='form-check-label' for='remember-me'>All</label>
            		</div></th>
            		<th></th>
            		</tr>

            		<tr>
            		<th>Sender Name</th>
            		<th>Registered Date</th>
            		<th>Amount (Tsh.)</th>
            		<th>Region Origin</th>
            		<th>Branch Origin</th>
            		<th>Destination</th>
            		<th>Destination Branch</th>
            		<th>Bill Number</th>
            		<th>Tracking Number</th>
            		<th>Barcode Number</th>
            		<th>Transfer Status</th>
            		<th style='text-align: right;''>Payment Status</th>
            		<th>
            		Item Status
            		</th>
            		<th>
            		action
            		</th>
            		</tr>
            		</thead>

            		<tbody>";
            		if (!empty($getInfo)) {

            			foreach (@$getInfo as $value) {@$value = (object)$value;
	// <td><a href='#' class='myBtn' data-sender_id='$value->sender_id'>$value->s_fullname</a></td>
            				echo "<tr>
            				<td>$value->s_fullname</td>
            				<td>$value->date_registered</td>
            				<td>".number_format($value->paidamount,2)."</td>
            				<td>$value->s_region</td>
            				<td>$value->s_district</td>
            				<td>$value->r_region</td>
            				<td>$value->branch</td>
            				";

            				echo "
            				<td>$value->track_number</td>
            				<td>@$value->Barcode</td>
            				<td>";
            				if ($value->office_name == 'Back' || $value->office_name == 'Despatch') {
            					echo "<button type='button' class='btn btn-sm btn-success' disabled='disabled'>Successfully Transfer</button>";
            				}else{
            					echo "<button type='button' class='btn btn-sm btn-danger' disabled='disabled'> Pending To Transfer</button>";
            				}
            				echo"</td>
            				<td style='text-align: right;'>";
            				if($value->status != 'Bill'){
            					echo "<button class='btn btn-danger btn-sm'>Not Paid</button>";
            				}else{
            					echo "<button class='btn btn-success btn-sm'>Paid</button>";
            				}
            				"</td></td>";
            				echo "<td style = 'text-align:center;'>";
            				echo "<div class='form-check'>";

            				if (($value->status == 'Paid' || $value->status == 'Bill') && $value->office_name == 'Counter'){

            					echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle3' id='remember-me' value='$value->id'>
            					<label class='form-check-label' for='remember-me'></label>";

            				}else{

            					echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;' checked>
            					<label class='form-check-label' for='remember-me'></label>";
            				}


            				echo"</div>
            				</td>
            				<td style = 'text-align:center;'>
            				<a href='#' class='btn btn-info btn-sm getDetails1' data-sender_id='$value->sender_id' data-receiver_id='$value->receiver_id' data-s_fullname='$value->s_fullname' data-s_address='$value->s_address' data-s_email='$value->s_email' data-s_mobile='$value->s_mobile' data-s_region='$value->s_region' data-r_fullname='$value->fullname' data-s_address='$value->address' data-r_email='$value->email' data-r_mobile='$value->mobile' data-r_region='$value->r_region'
            				data-operator='"; $id = $value->operator;
            				@$info = $this->employee_model->GetBasic($id);
            				echo @$info->em_code.'  '.@$info->first_name.'  '.@$info->middle_name.'  '.@$info->last_name;  echo "'>Details</a>
            				</td>
            				</tr>";
            			}
            		}else{
            			echo "<tr>
            			<td colspan='15' style='color:red;text-align:center;'>No Data Found</td></tr>";
            		}
            		echo" </tbody>

            		</table>
            		<input type='hidden' name='type' value='EMS'>
            		<input type='hidden' class='id' name='emid' id='emid' value='$emid'>
            		<br><br>
            		<table style='width: 100%;'>
            		<tr>
            		<td colspan='' style='text-align: right;'></td>
            		<td colspan=''></td>
            		<td colspan=''>

            		</td>

            		<td colspan='11' style='text-align: right;'><button type='submit' class='btn btn-info'>Back Office >>> </button></td>
            		</tr>
            		</table>
            		</form>

            		<div id='myModal1' class='modal fade' role='dialog' style='padding-top:200px; font-size:24px;'>
            		<div class='modal-dialog'>
            		<div class='modal-content'>
            		<div class='modal-header'>
            		<button type='button' class='close' data-dismiss='modal'>&times;</button>
            		<h2 class='modal-title'> Information</h2>
            		</div>
            		<div class='modal-body'>
            		<div class='row'><div class='col-md-12'><b>Sender Information</b></div></div>
            		<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='sfname'></span></div></div>
            		<div class='row'><div class='col-md-12'>address: &nbsp;&nbsp;<span class='saddress'></span></div></div>
            		<div class='row'><div class='col-md-12'>Email: &nbsp;&nbsp;<span class='semail'></span></div></div>
            		<div class='row'><div class='col-md-12'>Mobile: &nbsp;&nbsp;<span class='smobile'></span></div></div>
            		<div class='row'><div class='col-md-12'>Region: &nbsp;&nbsp;<span class='sregion'></span></div></div>
            		<br>
            		<div class='row'><div class='col-md-12'><b>Receiver Information</b></div></div>
            		<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='rfname'></span></div></div>
            		<div class='row'><div class='col-md-12'>address: &nbsp;&nbsp;<span class='raddress'></span></div></div>
            		<div class='row'><div class='col-md-12'>Email: &nbsp;&nbsp;<span class='remail'></span></div></div>
            		<div class='row'><div class='col-md-12'>Mobile: &nbsp;&nbsp;<span class='rmobile'></span></div></div>
            		<div class='row'><div class='col-md-12'>Region: &nbsp;&nbsp;<span class='rregion'></span></div></div>
            		<br>
            		<div class='row'><div class='col-md-12'><b>Service Operator</b></div></div>
            		<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='operator'></span></div></div>
            		</div>
            		</div>
            		</div>
            		</div>
            		</div>
            		<div class='modal fade' id='myModal' role='dialog' style='padding-top: 100px;'>
            		<div class='modal-dialog modal-lg'>

            		<!-- Modal content-->
            		<div class='modal-content'>
            		<div class='modal-header'>
            		<button type='button' class='close' data-dismiss='modal'>&times;</button>
            		</div>
            		<form role='form' action='ems_action_receiver' method='post' onsubmit='disableButton()'>
            		<div class='modal-body'>
            		<div class='row'>
            		<div class='col-md-12'>
            		<h3>Step 3 of 4  - Reciever Personal Details</h3>
            		</div>

            		<div class='col-md-6'>
            		<label>Full Name:</label>
            		<input type='text' name='r_fname' id='r_fname' class='form-control' onkeyup='myFunction()' required='required'>
            		</div>
            		<div class='col-md-6'>
            		<label>Address:</label>
            		<input type='text' name='r_address' id='r_address' class='form-control' onkeyup='myFunction()' required='required'>
            		</div>
            		<div class='col-md-6'>
            		<label>Email:</label>
            		<input type='email' name='r_email' id='r_email' class='form-control' onkeyup='myFunction()'>
            		</div>
            		<div class='col-md-6'>
            		<label>Mobile Number</label>
            		<input type='mobile' name='r_mobile' id='r_mobile' class='form-control' onkeyup='myFunction()' required='required'>
            		</div>
            		<div class='col-md-6'>
            		<label class='control-label'>Region</label>
            		<select name='region_to' value='' class='form-control custom-select' required id='rec_region' onChange='getRecDistrict();' required='required'>
            		<option value=''>--Select Region--</option>";
            		$regionlist = $this->employee_model->regselect();
            		foreach($regionlist as $value){
            			echo "<option value='$value->region_name'>$value->region_name</option>";
            		}
            		echo "</select>
            		</div>
            		<div class='col-md-6'>
            		<label>Reciever Branch</label>
            		<select name='district' value='' class='form-control custom-select'  id='rec_dropp' required='required'>
            		<option>--Select Branch--</option>
            		</select>

            		</div>

            		</div>
            		</div>
            		<div class='' style='float: right;padding-right: 30px;padding-bottom: 10px;'>

            		<input type='hidden' name='id' id='comid'>
            		<button type='submit' class='btn btn-info pull-left'><span class='glyphicon glyphicon-remove'></span>Save Information</button>
            		<button type='submit' class='btn btn-warning pull-left' data-dismiss='modal'>Cancel</button>
            		</div>
            		</form>
            		</div>
            		<div class='modal-footer'>

            		</div>

            		</div>
            		</div>
            		<script>
            		$(document).ready(function(){
            			$('.getDetails1').click(function(){

            				$('.sfname').html($(this).attr('data-s_fullname'));
            				$('.saddress').html($(this).attr('data-s_address'));
            				$('.semail').html($(this).attr('data-s_email'));
            				$('.smobile').html($(this).attr('data-s_mobile'));
            				$('.sregion').html($(this).attr('data-s_region'));
            				$('.rfname').html($(this).attr('data-r_fullname'));
            				$('.raddress').html($(this).attr('data-r_address'));
            				$('.remail').html($(this).attr('data-r_email'));
            				$('.rmobile').html($(this).attr('data-r_mobile'));
            				$('.rregion').html($(this).attr('data-r_region'));
            				$('.operator').html($(this).attr('data-operator'));
            				$('#myModal1').modal();

            				});
            				});
            				</script>
            				<script type='text/javascript'>
            				$(document).ready(function() {
            					$('#checkAll3').change(function() {
            						if (this.checked) {
            							$('.checkSingle3').each(function() {
            								this.checked=true;
            								});
            								} else {
            									$('.checkSingle3').each(function() {
            										this.checked=false;
            										});
            									}
            									});

            									$('.checkSingle3').click(function () {
            										if ($(this).is(':checked')) {
            											var isAllChecked = 0;

            											$('.checkSingle3').each(function() {
            												if (!this.checked)
            												isAllChecked = 1;
            												});

            												if (isAllChecked == 0) {
            													$('#checkAll3').prop('checked', true);
            												}
            											}
            											else {
            												$('#checkAll3').prop('checked', false);
            											}
            											});
            											});
            											</script>
            											<script>
            											$(document).ready(function(){
            												$('.myBtn').click(function(){

            													var text1 = $(this).attr('data-sender_id');
            													$('#comid').val(text1);
            													$('#myModal').modal();
            													});
            													});
            													</script>
            													";

            												}
            												else{
            													redirect(base_url());
            												}
            											}

            											public function Get_EMSDate1()
            											{
            												if ($this->session->userdata('user_login_access') != false)
            												{
            													$date = $this->input->post('date_time');
//$emid = $this->input->post('emid');
            													$emid = $this->input->post('emidag');
            													$year = date('Y',strtotime($date));
            													$month = date('m',strtotime($date));
            													$day = date('d',strtotime($date));

//echo $day.' '.$date.' '.$emid;

            													$id = $this->session->userdata('user_login_id');
            													$info = $this->Box_Application_model->GetBasic($id);
            													$region = $info->em_region;
            													$branch = $info->em_branch;
            													$sumtotal=0;
            													if ($this->session->userdata('user_type') == "SUPERVISOR") {
 // @$getInfo = $this->Box_Application_model->get_ems_per_date_by_emid1($year,$month,$day,$emid);

            														$getInfo=$this->supervisortrackjob($emid,$date);

            														foreach (@$getInfo as $key => $value) {
            															$value = (object)$value;
            															$sumtotal=$sumtotal + $value->paidamount;
            														}



            													} else {
            														@$getInfo = $this->Box_Application_model->get_ems_per_date1($year,$month,$day,$emid);
            													}

// $data['total'] = $this->Box_Application_model->get_ems_sum12($year,$month,$day);
// @$paidamount = $data['total']->paidamount;
            													$data['total'] = @$sumtotal;
            													@$paidamount = @$sumtotal;


//echo 'HIYO'.json_decode($getInfo);

            													echo
            													"<form method='POST' action='send_to_back_office'>
            													<table id='fromServer' class='display nowrap table table-hover table-striped table-bordered searchResult' cellspacing='0' width='100%'>
            													<thead>
            													<tr><th colspan='11'></th><th colspan=''><div class='form-check' style='padding-left:60px;' id='showCheck3'>
            													<input type='checkbox'  class='form-check-input' id='checkAll3' style=''>
            													<label class='form-check-label' for='remember-me'>All</label>
            													</div></th>
            													<th></th>
            													</tr>

            													<tr>
            													<th>Sender Name</th>
            													<th>Registered Date</th>
            													<th>Amount (Tsh.)</th>
            													<th>Region Origin</th>
            													<th>Branch Origin</th>
            													<th>Destination</th>
            													<th>Destination Branch</th>
            													<th>Bill Number</th>
            													<th>Tracking Number</th>
            													<th>Transfer Status</th>
            													<th style='text-align: right;''>Payment Status</th>
            													<th>
            													Item Status
            													</th>
            													<th>
            													action
            													</th>
            													</tr>
            													</thead>

            													<tbody>";
            													if (!empty($getInfo)) {

            														foreach ($getInfo as $value) {$value = (object)$value;
	// <td><a href='#' class='myBtn' data-sender_id='$value->sender_id'>$value->s_fullname</a></td>
            															echo "<tr>
            															<td>$value->s_fullname</td>
            															<td>$value->date_registered</td>
            															<td>".number_format($value->paidamount,2)."</td>
            															<td>$value->s_region</td>
            															<td>$value->s_district</td>
            															<td>$value->r_region</td>
            															<td>$value->branch</td>
            															<td>";
            															echo $value->billid;
	// if ($value->status == "Bill") {
	// 	echo strtoupper($value->s_pay_type);
	// } else {
	// 	echo $value->billid;
	// }

            															echo "</td>
            															<td>$value->track_number</td>
            															<td>";
            															if ($value->office_name == 'Received' || $value->office_name == 'Despatch') {
            																echo "<button type='button' class='btn btn-sm btn-success' disabled='disabled'>Successfully Transfer</button>";
            															}else{
            																echo "<button type='button' class='btn btn-sm btn-danger' disabled='disabled'> Pending To Transfer</button>";
            															}
            															echo"</td>
            															<td style='text-align: right;'>";
            															if($value->status == 'NotPaid'){
            																echo "<button class='btn btn-danger btn-sm'>Not Paid</button>";
            															}else{
            																echo "<button class='btn btn-success btn-sm'>Paid</button>";
            															}
            															"</td></td>";
            															echo "<td style = 'text-align:center;'>";
            															echo "<div class='form-check'>";

            															if (($value->status == 'Paid' || $value->status == 'Bill') && $value->office_name == 'Counter'){

            																echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle3' id='remember-me' value='$value->id'>
            																<label class='form-check-label' for='remember-me'></label>";

            															}else{

            																echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;' checked>
            																<label class='form-check-label' for='remember-me'></label>";
            															}


            															echo"</div>
            															</td>
            															<td style = 'text-align:center;'>
            															<a href='#' class='btn btn-info btn-sm getDetails1' data-sender_id='$value->sender_id' data-receiver_id='$value->receiver_id' data-s_fullname='$value->s_fullname' data-s_address='$value->s_address' data-s_email='$value->s_email' data-s_mobile='$value->s_mobile' data-s_region='$value->s_region' data-r_fullname='$value->fullname' data-s_address='$value->address' data-r_email='$value->email' data-r_mobile='$value->mobile' data-r_region='$value->r_region'
            															data-operator='"; $id = $value->operator;
            															@$info = $this->employee_model->GetBasic($id);
            															echo @$info->em_code.'  '.@$info->first_name.'  '.@$info->middle_name.'  '.@$info->last_name;  echo "'>Details</a>
            															</td>
            															</tr>";
            														}
            													}else{
            														echo "<tr>
            														<td colspan='15' style='color:red;text-align:center;'>No Data Found</td></tr>";
            													}
            													echo" </tbody>

            													</table>
            													<input type='hidden' name='type' value='EMS'>
            													<input type='hidden' class='id' name='emid' id='emid' value='$emid'>
            													<br><br>
            													<table style='width: 100%;'>
            													<tr>
            													<td colspan='' style='text-align: right;'></td>
            													<td colspan=''></td>
            													<td colspan=''>

            													</td>

            													<td colspan='11' style='text-align: right;'><button type='submit' class='btn btn-info'>Back Office >>> </button></td>
            													</tr>
            													</table>
            													</form>

            													<div id='myModal1' class='modal fade' role='dialog' style='padding-top:200px; font-size:24px;'>
            													<div class='modal-dialog'>
            													<div class='modal-content'>
            													<div class='modal-header'>
            													<button type='button' class='close' data-dismiss='modal'>&times;</button>
            													<h2 class='modal-title'> Information</h2>
            													</div>
            													<div class='modal-body'>
            													<div class='row'><div class='col-md-12'><b>Sender Information</b></div></div>
            													<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='sfname'></span></div></div>
            													<div class='row'><div class='col-md-12'>address: &nbsp;&nbsp;<span class='saddress'></span></div></div>
            													<div class='row'><div class='col-md-12'>Email: &nbsp;&nbsp;<span class='semail'></span></div></div>
            													<div class='row'><div class='col-md-12'>Mobile: &nbsp;&nbsp;<span class='smobile'></span></div></div>
            													<div class='row'><div class='col-md-12'>Region: &nbsp;&nbsp;<span class='sregion'></span></div></div>
            													<br>
            													<div class='row'><div class='col-md-12'><b>Receiver Information</b></div></div>
            													<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='rfname'></span></div></div>
            													<div class='row'><div class='col-md-12'>address: &nbsp;&nbsp;<span class='raddress'></span></div></div>
            													<div class='row'><div class='col-md-12'>Email: &nbsp;&nbsp;<span class='remail'></span></div></div>
            													<div class='row'><div class='col-md-12'>Mobile: &nbsp;&nbsp;<span class='rmobile'></span></div></div>
            													<div class='row'><div class='col-md-12'>Region: &nbsp;&nbsp;<span class='rregion'></span></div></div>
            													<br>
            													<div class='row'><div class='col-md-12'><b>Service Operator</b></div></div>
            													<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='operator'></span></div></div>
            													</div>
            													</div>
            													</div>
            													</div>
            													</div>
            													<div class='modal fade' id='myModal' role='dialog' style='padding-top: 100px;'>
            													<div class='modal-dialog modal-lg'>

            													<!-- Modal content-->
            													<div class='modal-content'>
            													<div class='modal-header'>
            													<button type='button' class='close' data-dismiss='modal'>&times;</button>
            													</div>
            													<form role='form' action='ems_action_receiver' method='post' onsubmit='disableButton()'>
            													<div class='modal-body'>
            													<div class='row'>
            													<div class='col-md-12'>
            													<h3>Step 3 of 4  - Reciever Personal Details</h3>
            													</div>

            													<div class='col-md-6'>
            													<label>Full Name:</label>
            													<input type='text' name='r_fname' id='r_fname' class='form-control' onkeyup='myFunction()' required='required'>
            													</div>
            													<div class='col-md-6'>
            													<label>Address:</label>
            													<input type='text' name='r_address' id='r_address' class='form-control' onkeyup='myFunction()' required='required'>
            													</div>
            													<div class='col-md-6'>
            													<label>Email:</label>
            													<input type='email' name='r_email' id='r_email' class='form-control' onkeyup='myFunction()'>
            													</div>
            													<div class='col-md-6'>
            													<label>Mobile Number</label>
            													<input type='mobile' name='r_mobile' id='r_mobile' class='form-control' onkeyup='myFunction()' required='required'>
            													</div>
            													<div class='col-md-6'>
            													<label class='control-label'>Region</label>
            													<select name='region_to' value='' class='form-control custom-select' required id='rec_region' onChange='getRecDistrict();' required='required'>
            													<option value=''>--Select Region--</option>";
            													$regionlist = $this->employee_model->regselect();
            													foreach($regionlist as $value){
            														echo "<option value='$value->region_name'>$value->region_name</option>";
            													}
            													echo "</select>
            													</div>
            													<div class='col-md-6'>
            													<label>Reciever Branch</label>
            													<select name='district' value='' class='form-control custom-select'  id='rec_dropp' required='required'>
            													<option>--Select Branch--</option>
            													</select>

            													</div>

            													</div>
            													</div>
            													<div class='' style='float: right;padding-right: 30px;padding-bottom: 10px;'>

            													<input type='hidden' name='id' id='comid'>
            													<button type='submit' class='btn btn-info pull-left'><span class='glyphicon glyphicon-remove'></span>Save Information</button>
            													<button type='submit' class='btn btn-warning pull-left' data-dismiss='modal'>Cancel</button>
            													</div>
            													</form>
            													</div>
            													<div class='modal-footer'>

            													</div>

            													</div>
            													</div>
            													<script>
            													$(document).ready(function(){
            														$('.getDetails1').click(function(){

            															$('.sfname').html($(this).attr('data-s_fullname'));
            															$('.saddress').html($(this).attr('data-s_address'));
            															$('.semail').html($(this).attr('data-s_email'));
            															$('.smobile').html($(this).attr('data-s_mobile'));
            															$('.sregion').html($(this).attr('data-s_region'));
            															$('.rfname').html($(this).attr('data-r_fullname'));
            															$('.raddress').html($(this).attr('data-r_address'));
            															$('.remail').html($(this).attr('data-r_email'));
            															$('.rmobile').html($(this).attr('data-r_mobile'));
            															$('.rregion').html($(this).attr('data-r_region'));
            															$('.operator').html($(this).attr('data-operator'));
            															$('#myModal1').modal();

            															});
            															});
            															</script>
            															<script type='text/javascript'>
            															$(document).ready(function() {
            																$('#checkAll3').change(function() {
            																	if (this.checked) {
            																		$('.checkSingle3').each(function() {
            																			this.checked=true;
            																			});
            																			} else {
            																				$('.checkSingle3').each(function() {
            																					this.checked=false;
            																					});
            																				}
            																				});

            																				$('.checkSingle3').click(function () {
            																					if ($(this).is(':checked')) {
            																						var isAllChecked = 0;

            																						$('.checkSingle3').each(function() {
            																							if (!this.checked)
            																							isAllChecked = 1;
            																							});

            																							if (isAllChecked == 0) {
            																								$('#checkAll3').prop('checked', true);
            																							}
            																						}
            																						else {
            																							$('#checkAll3').prop('checked', false);
            																						}
            																						});
            																						});
            																						</script>
            																						<script>
            																						$(document).ready(function(){
            																							$('.myBtn').click(function(){

            																								var text1 = $(this).attr('data-sender_id');
            																								$('#comid').val(text1);
            																								$('#myModal').modal();
            																								});
            																								});
            																								</script>
            																								";

            																							}
            																							else{
            																								redirect(base_url());
            																							}
            																						}


            																						public function Get_Employee_report()
            																						{
            																							if ($this->session->userdata('user_login_access') != false)
            																							{
            																								$date = $this->input->post('date_time');
            																								$emid = $this->input->post('emid');
//$emid = $this->input->post('emidag');
            																								if(empty($date)){
            																									$tz = 'Africa/Nairobi';
            																									$tz_obj = new DateTimeZone($tz);
            																									$today = new DateTime(null, $tz_obj);
            																									$date = $today->format('Y-m-d');
            																								}

            																								$year = date('Y',strtotime($date));
            																								$month = date('m',strtotime($date));
            																								$day = date('d',strtotime($date));

//echo $day.' '.$date.' '.$emid;

            																								$id = $this->session->userdata('user_login_id');
            																								$info = $this->Box_Application_model->GetBasic($id);
            																								$region = $info->em_region;
            																								$branch = $info->em_branch;
            																								$sumtotal=0;

 // @$getInfo = $this->Box_Application_model->get_ems_per_date_by_emid1($year,$month,$day,$emid);

            																								$getInfo=$this->supervisortrackjob($emid,$date);

            																								foreach (@$getInfo as $key => $value) {
            																									$value = (object)$value;
            																									$sumtotal=$sumtotal + $value->paidamount;
            																								}





// $data['total'] = $this->Box_Application_model->get_ems_sum12($year,$month,$day);
// @$paidamount = $data['total']->paidamount;
            																								$data['total'] = @$sumtotal;
            																								@$paidamount = @$sumtotal;


//echo 'HIYO'.json_decode($getInfo);

            																								echo
            																								"<form method='POST' action='send_to_back_office'>
            																								<table id='fromServer' class='display nowrap table table-hover table-striped table-bordered searchResult' cellspacing='0' width='100%'>
            																								<thead>
            																								<tr><th colspan='11'></th><th colspan=''><div class='form-check' style='padding-left:60px;' id='showCheck3'>
            																								<input type='checkbox'  class='form-check-input' id='checkAll3' style=''>
            																								<label class='form-check-label' for='remember-me'>All</label>
            																								</div></th>
            																								<th></th>
            																								</tr>

            																								<tr>
            																								<th>Sender Name</th>
            																								<th>Registered Date</th>
            																								<th>Amount (Tsh.)</th>
            																								<th>Region Origin</th>
            																								<th>Branch Origin</th>
            																								<th>Destination</th>
            																								<th>Destination Branch</th>
            																								<th>Bill Number</th>
            																								<th>Tracking Number</th>
            																								<th>Transfer Status</th>
            																								<th style='text-align: right;''>Payment Status</th>
            																								<th>
            																								Item Status
            																								</th>
            																								<th>
            																								action
            																								</th>
            																								</tr>
            																								</thead>

            																								<tbody>";
            																								if (!empty($getInfo)) {

            																									foreach ($getInfo as $value) {$value = (object)$value;
	// <td><a href='#' class='myBtn' data-sender_id='$value->sender_id'>$value->s_fullname</a></td>
            																										echo "<tr>
            																										<td>$value->s_fullname</td>
            																										<td>$value->date_registered</td>
            																										<td>".number_format($value->paidamount,2)."</td>
            																										<td>$value->s_region</td>
            																										<td>$value->s_district</td>
            																										<td>$value->r_region</td>
            																										<td>$value->branch</td>
            																										<td>";
            																										echo $value->billid;
	// if ($value->status == "Bill") {
	// 	echo strtoupper($value->s_pay_type);
	// } else {
	// 	echo $value->billid;
	// }

            																										echo "</td>
            																										<td>$value->track_number</td>
            																										<td>";
            																										if ($value->office_name == 'Received' || $value->office_name == 'Despatch') {
            																											echo "<button type='button' class='btn btn-sm btn-success' disabled='disabled'>Successfully Transfer</button>";
            																										}else{
            																											echo "<button type='button' class='btn btn-sm btn-danger' disabled='disabled'> Pending To Transfer</button>";
            																										}
            																										echo"</td>
            																										<td style='text-align: right;'>";
            																										if($value->status == 'NotPaid'){
            																											echo "<button class='btn btn-danger btn-sm'>Not Paid</button>";
            																										}else{
            																											echo "<button class='btn btn-success btn-sm'>Paid</button>";
            																										}
            																										"</td></td>";
            																										echo "<td style = 'text-align:center;'>";
            																										echo "<div class='form-check'>";

            																										if (($value->status == 'Paid' || $value->status == 'Bill') && $value->office_name == 'Counter'){

            																											echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle3' id='remember-me' value='$value->id'>
            																											<label class='form-check-label' for='remember-me'></label>";

            																										}else{

            																											echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;' checked>
            																											<label class='form-check-label' for='remember-me'></label>";
            																										}


            																										echo"</div>
            																										</td>
            																										<td style = 'text-align:center;'>
            																										<a href='#' class='btn btn-info btn-sm getDetails1' data-sender_id='$value->sender_id' data-receiver_id='$value->receiver_id' data-s_fullname='$value->s_fullname' data-s_address='$value->s_address' data-s_email='$value->s_email' data-s_mobile='$value->s_mobile' data-s_region='$value->s_region' data-r_fullname='$value->fullname' data-s_address='$value->address' data-r_email='$value->email' data-r_mobile='$value->mobile' data-r_region='$value->r_region'
            																										data-operator='"; $id = $value->operator;
            																										@$info = $this->employee_model->GetBasic($id);
            																										echo @$info->em_code.'  '.@$info->first_name.'  '.@$info->middle_name.'  '.@$info->last_name;  echo "'>Details</a>
            																										</td>
            																										</tr>";
            																									}
            																								}else{
            																									echo "<tr>
            																									<td colspan='15' style='color:red;text-align:center;'>No Data Found</td></tr>";
            																								}
            																								echo" </tbody>

            																								</table>
            																								<input type='hidden' name='type' value='EMS'>
            																								<input type='hidden' class='id' name='emid' id='emid' value='$emid'>
            																								<br><br>
            																								<table style='width: 100%;'>
            																								<tr>
            																								<td colspan='' style='text-align: right;'></td>
            																								<td colspan=''></td>
            																								<td colspan=''>

            																								</td>

            																								<td colspan='11' style='text-align: right;'><button type='submit' class='btn btn-info'>Back Office >>> </button></td>
            																								</tr>
            																								</table>
            																								</form>

            																								<div id='myModal1' class='modal fade' role='dialog' style='padding-top:200px; font-size:24px;'>
            																								<div class='modal-dialog'>
            																								<div class='modal-content'>
            																								<div class='modal-header'>
            																								<button type='button' class='close' data-dismiss='modal'>&times;</button>
            																								<h2 class='modal-title'> Information</h2>
            																								</div>
            																								<div class='modal-body'>
            																								<div class='row'><div class='col-md-12'><b>Sender Information</b></div></div>
            																								<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='sfname'></span></div></div>
            																								<div class='row'><div class='col-md-12'>address: &nbsp;&nbsp;<span class='saddress'></span></div></div>
            																								<div class='row'><div class='col-md-12'>Email: &nbsp;&nbsp;<span class='semail'></span></div></div>
            																								<div class='row'><div class='col-md-12'>Mobile: &nbsp;&nbsp;<span class='smobile'></span></div></div>
            																								<div class='row'><div class='col-md-12'>Region: &nbsp;&nbsp;<span class='sregion'></span></div></div>
            																								<br>
            																								<div class='row'><div class='col-md-12'><b>Receiver Information</b></div></div>
            																								<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='rfname'></span></div></div>
            																								<div class='row'><div class='col-md-12'>address: &nbsp;&nbsp;<span class='raddress'></span></div></div>
            																								<div class='row'><div class='col-md-12'>Email: &nbsp;&nbsp;<span class='remail'></span></div></div>
            																								<div class='row'><div class='col-md-12'>Mobile: &nbsp;&nbsp;<span class='rmobile'></span></div></div>
            																								<div class='row'><div class='col-md-12'>Region: &nbsp;&nbsp;<span class='rregion'></span></div></div>
            																								<br>
            																								<div class='row'><div class='col-md-12'><b>Service Operator</b></div></div>
            																								<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='operator'></span></div></div>
            																								</div>
            																								</div>
            																								</div>
            																								</div>
            																								</div>
            																								<div class='modal fade' id='myModal' role='dialog' style='padding-top: 100px;'>
            																								<div class='modal-dialog modal-lg'>

            																								<!-- Modal content-->
            																								<div class='modal-content'>
            																								<div class='modal-header'>
            																								<button type='button' class='close' data-dismiss='modal'>&times;</button>
            																								</div>
            																								<form role='form' action='ems_action_receiver' method='post' onsubmit='disableButton()'>
            																								<div class='modal-body'>
            																								<div class='row'>
            																								<div class='col-md-12'>
            																								<h3>Step 3 of 4  - Reciever Personal Details</h3>
            																								</div>

            																								<div class='col-md-6'>
            																								<label>Full Name:</label>
            																								<input type='text' name='r_fname' id='r_fname' class='form-control' onkeyup='myFunction()' required='required'>
            																								</div>
            																								<div class='col-md-6'>
            																								<label>Address:</label>
            																								<input type='text' name='r_address' id='r_address' class='form-control' onkeyup='myFunction()' required='required'>
            																								</div>
            																								<div class='col-md-6'>
            																								<label>Email:</label>
            																								<input type='email' name='r_email' id='r_email' class='form-control' onkeyup='myFunction()'>
            																								</div>
            																								<div class='col-md-6'>
            																								<label>Mobile Number</label>
            																								<input type='mobile' name='r_mobile' id='r_mobile' class='form-control' onkeyup='myFunction()' required='required'>
            																								</div>
            																								<div class='col-md-6'>
            																								<label class='control-label'>Region</label>
            																								<select name='region_to' value='' class='form-control custom-select' required id='rec_region' onChange='getRecDistrict();' required='required'>
            																								<option value=''>--Select Region--</option>";
            																								$regionlist = $this->employee_model->regselect();
            																								foreach($regionlist as $value){
            																									echo "<option value='$value->region_name'>$value->region_name</option>";
            																								}
            																								echo "</select>
            																								</div>
            																								<div class='col-md-6'>
            																								<label>Reciever Branch</label>
            																								<select name='district' value='' class='form-control custom-select'  id='rec_dropp' required='required'>
            																								<option>--Select Branch--</option>
            																								</select>

            																								</div>

            																								</div>
            																								</div>
            																								<div class='' style='float: right;padding-right: 30px;padding-bottom: 10px;'>

            																								<input type='hidden' name='id' id='comid'>
            																								<button type='submit' class='btn btn-info pull-left'><span class='glyphicon glyphicon-remove'></span>Save Information</button>
            																								<button type='submit' class='btn btn-warning pull-left' data-dismiss='modal'>Cancel</button>
            																								</div>
            																								</form>
            																								</div>
            																								<div class='modal-footer'>

            																								</div>

            																								</div>
            																								</div>
            																								<script>
            																								$(document).ready(function(){
            																									$('.getDetails1').click(function(){

            																										$('.sfname').html($(this).attr('data-s_fullname'));
            																										$('.saddress').html($(this).attr('data-s_address'));
            																										$('.semail').html($(this).attr('data-s_email'));
            																										$('.smobile').html($(this).attr('data-s_mobile'));
            																										$('.sregion').html($(this).attr('data-s_region'));
            																										$('.rfname').html($(this).attr('data-r_fullname'));
            																										$('.raddress').html($(this).attr('data-r_address'));
            																										$('.remail').html($(this).attr('data-r_email'));
            																										$('.rmobile').html($(this).attr('data-r_mobile'));
            																										$('.rregion').html($(this).attr('data-r_region'));
            																										$('.operator').html($(this).attr('data-operator'));
            																										$('#myModal1').modal();

            																										});
            																										});
            																										</script>
            																										<script type='text/javascript'>
            																										$(document).ready(function() {
            																											$('#checkAll3').change(function() {
            																												if (this.checked) {
            																													$('.checkSingle3').each(function() {
            																														this.checked=true;
            																														});
            																														} else {
            																															$('.checkSingle3').each(function() {
            																																this.checked=false;
            																																});
            																															}
            																															});

            																															$('.checkSingle3').click(function () {
            																																if ($(this).is(':checked')) {
            																																	var isAllChecked = 0;

            																																	$('.checkSingle3').each(function() {
            																																		if (!this.checked)
            																																		isAllChecked = 1;
            																																		});

            																																		if (isAllChecked == 0) {
            																																			$('#checkAll3').prop('checked', true);
            																																		}
            																																	}
            																																	else {
            																																		$('#checkAll3').prop('checked', false);
            																																	}
            																																	});
            																																	});
            																																	</script>
            																																	<script>
            																																	$(document).ready(function(){
            																																		$('.myBtn').click(function(){

            																																			var text1 = $(this).attr('data-sender_id');
            																																			$('#comid').val(text1);
            																																			$('#myModal').modal();
            																																			});
            																																			});
            																																			</script>
            																																			";

            																																		}
            																																		else{
            																																			redirect(base_url());
            																																		}
            																																	}



            																																	public function Get_EMSDate12()
            																																	{
            																																		if ($this->session->userdata('user_login_access') != false)
            																																		{
            																																			$date = $this->input->post('date_time');
//$emid = $this->input->post('emid');
            																																			$emid = $this->input->post('emidag');
            																																			$year = date('Y',strtotime($date));
            																																			$month = date('m',strtotime($date));
            																																			$day = date('d',strtotime($date));

//echo $day.' '.$date.' '.$emid;

            																																			if ($this->session->userdata('user_type') == "SUPERVISOR") {
            																																				@$getInfo = $this->Box_Application_model->get_ems_per_date_by_emid1($year,$month,$day,$emid);
            																																			} else {
            																																				@$getInfo = $this->Box_Application_model->get_ems_per_date1($year,$month,$day,$emid);
            																																			}

            																																			$data['total'] = $this->Box_Application_model->get_ems_sum12($year,$month,$day);
            																																			@$paidamount = $data['total']->paidamount;
            																																			echo
            																																			"<form method='POST' action='send_to_back_office'>
            																																			<table id='fromServer' class='display nowrap table table-hover table-striped table-bordered searchResult' cellspacing='0' width='100%'>
            																																			<thead>
            																																			<tr><th colspan='11'></th><th colspan=''><div class='form-check' style='padding-left:60px;' id='showCheck3'>
            																																			<input type='checkbox'  class='form-check-input' id='checkAll3' style=''>
            																																			<label class='form-check-label' for='remember-me'>All</label>
            																																			</div></th>
            																																			<th></th>
            																																			</tr>
            																																			<tr>
            																																			<th>Sender Name</th>
            																																			<th>Registered Date</th>
            																																			<th>Amount (Tsh.)</th>
            																																			<th>Region Origin</th>
            																																			<th>Branch Origin</th>
            																																			<th>Destination</th>
            																																			<th>Destination Branch</th>
            																																			<th>Bill Number</th>
            																																			<th>Tracking Number</th>
            																																			<th>Transfer Status</th>
            																																			<th style='text-align: right;''>Payment Status</th>
            																																			<th>
            																																			Item Status
            																																			</th>
            																																			<th>
            																																			action
            																																			</th>
            																																			</tr>
            																																			</thead>

            																																			<tbody>";
            																																			if (!empty($getInfo)) {

            																																				foreach ($getInfo as $value) {
            																																					echo "<tr>
            																																					<td><a href='#' class='myBtn' data-sender_id='$value->sender_id'>$value->s_fullname</a></td>
            																																					<td>$value->date_registered</td>
            																																					<td>".number_format($value->paidamount,2)."</td>
            																																					<td>$value->s_region</td>
            																																					<td>$value->s_district</td>
            																																					<td>$value->r_region</td>
            																																					<td>$value->branch</td>
            																																					<td>";
            																																					if ($value->status == "Bill") {
            																																						echo strtoupper($value->s_pay_type);
            																																					} else {
            																																						echo $value->billid;
            																																					}

            																																					echo "</td>
            																																					<td>$value->track_number</td>
            																																					<td>";
            																																					if ($value->office_name == 'Received' || $value->office_name == 'Despatch') {
            																																						echo "<button type='button' class='btn btn-sm btn-success' disabled='disabled'>Successfully Transfer</button>";
            																																					}else{
            																																						echo "<button type='button' class='btn btn-sm btn-danger' disabled='disabled'> Pending To Transfer</button>";
            																																					}
            																																					echo"</td>
            																																					<td style='text-align: right;'>";
            																																					if($value->status == 'NotPaid'){
            																																						echo "<button class='btn btn-danger btn-sm'>Not Paid</button>";
            																																					}else{
            																																						echo "<button class='btn btn-success btn-sm'>Paid</button>";
            																																					}
            																																					"</td></td>";
            																																					echo "<td style = 'text-align:center;'>";
            																																					echo "<div class='form-check'>";

            																																					if (($value->status == 'Paid' || $value->status == 'Bill') && $value->office_name == 'Counter'){

            																																						echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle3' id='remember-me' value='$value->id'>
            																																						<label class='form-check-label' for='remember-me'></label>";

            																																					}else{

            																																						echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;' checked>
            																																						<label class='form-check-label' for='remember-me'></label>";
            																																					}


            																																					echo"</div>
            																																					</td>
            																																					<td style = 'text-align:center;'>
            																																					<a href='#' class='btn btn-info btn-sm getDetails1' data-sender_id='$value->sender_id' data-receiver_id='$value->receiver_id' data-s_fullname='$value->s_fullname' data-s_address='$value->s_address' data-s_email='$value->s_email' data-s_mobile='$value->s_mobile' data-s_region='$value->s_region' data-r_fullname='$value->fullname' data-s_address='$value->address' data-r_email='$value->email' data-r_mobile='$value->mobile' data-r_region='$value->r_region'
            																																					data-operator='"; $id = $value->operator;
            																																					@$info = $this->employee_model->GetBasic($id);
            																																					echo @$info->em_code.'  '.@$info->first_name.'  '.@$info->middle_name.'  '.@$info->last_name;  echo "'>Details</a>
            																																					</td>
            																																					</tr>";
            																																				}
            																																			}else{
            																																				echo "<tr>
            																																				<td colspan='15' style='color:red;text-align:center;'>No Data Found</td></tr>";
            																																			}
            																																			echo" </tbody>

            																																			</table>
            																																			<input type='hidden' name='type' value='EMS'>
            																																			<input type='hidden' class='id' name='emid' id='emid' value='$emid'>
            																																			<br><br>
            																																			<table style='width: 100%;'>
            																																			<tr>
            																																			<td colspan='' style='text-align: right;'></td>
            																																			<td colspan=''></td>
            																																			<td colspan=''>

            																																			</td>

            																																			<td colspan='11' style='text-align: right;'><button type='submit' class='btn btn-info'>Back Office >>> </button></td>
            																																			</tr>
            																																			</table>
            																																			</form>

            																																			<div id='myModal1' class='modal fade' role='dialog' style='padding-top:200px; font-size:24px;'>
            																																			<div class='modal-dialog'>
            																																			<div class='modal-content'>
            																																			<div class='modal-header'>
            																																			<button type='button' class='close' data-dismiss='modal'>&times;</button>
            																																			<h2 class='modal-title'>EMS Information</h2>
            																																			</div>
            																																			<div class='modal-body'>
            																																			<div class='row'><div class='col-md-12'><b>Sender Information</b></div></div>
            																																			<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='sfname'></span></div></div>
            																																			<div class='row'><div class='col-md-12'>address: &nbsp;&nbsp;<span class='saddress'></span></div></div>
            																																			<div class='row'><div class='col-md-12'>Email: &nbsp;&nbsp;<span class='semail'></span></div></div>
            																																			<div class='row'><div class='col-md-12'>Mobile: &nbsp;&nbsp;<span class='smobile'></span></div></div>
            																																			<div class='row'><div class='col-md-12'>Region: &nbsp;&nbsp;<span class='sregion'></span></div></div>
            																																			<br>
            																																			<div class='row'><div class='col-md-12'><b>Receiver Information</b></div></div>
            																																			<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='rfname'></span></div></div>
            																																			<div class='row'><div class='col-md-12'>address: &nbsp;&nbsp;<span class='raddress'></span></div></div>
            																																			<div class='row'><div class='col-md-12'>Email: &nbsp;&nbsp;<span class='remail'></span></div></div>
            																																			<div class='row'><div class='col-md-12'>Mobile: &nbsp;&nbsp;<span class='rmobile'></span></div></div>
            																																			<div class='row'><div class='col-md-12'>Region: &nbsp;&nbsp;<span class='rregion'></span></div></div>
            																																			<br>
            																																			<div class='row'><div class='col-md-12'><b>Service Operator</b></div></div>
            																																			<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='operator'></span></div></div>
            																																			</div>
            																																			</div>
            																																			</div>
            																																			</div>
            																																			</div>
            																																			<div class='modal fade' id='myModal' role='dialog' style='padding-top: 100px;'>
            																																			<div class='modal-dialog modal-lg'>

            																																			<!-- Modal content-->
            																																			<div class='modal-content'>
            																																			<div class='modal-header'>
            																																			<button type='button' class='close' data-dismiss='modal'>&times;</button>
            																																			</div>
            																																			<form role='form' action='ems_action_receiver' method='post' onsubmit='disableButton()'>
            																																			<div class='modal-body'>
            																																			<div class='row'>
            																																			<div class='col-md-12'>
            																																			<h3>Step 3 of 4  - Reciever Personal Details</h3>
            																																			</div>

            																																			<div class='col-md-6'>
            																																			<label>Full Name:</label>
            																																			<input type='text' name='r_fname' id='r_fname' class='form-control' onkeyup='myFunction()' required='required'>
            																																			</div>
            																																			<div class='col-md-6'>
            																																			<label>Address:</label>
            																																			<input type='text' name='r_address' id='r_address' class='form-control' onkeyup='myFunction()' required='required'>
            																																			</div>
            																																			<div class='col-md-6'>
            																																			<label>Email:</label>
            																																			<input type='email' name='r_email' id='r_email' class='form-control' onkeyup='myFunction()'>
            																																			</div>
            																																			<div class='col-md-6'>
            																																			<label>Mobile Number</label>
            																																			<input type='mobile' name='r_mobile' id='r_mobile' class='form-control' onkeyup='myFunction()' required='required'>
            																																			</div>
            																																			<div class='col-md-6'>
            																																			<label class='control-label'>Region</label>
            																																			<select name='region_to' value='' class='form-control custom-select' required id='rec_region' onChange='getRecDistrict();' required='required'>
            																																			<option value=''>--Select Region--</option>";
            																																			$regionlist = $this->employee_model->regselect();
            																																			foreach($regionlist as $value){
            																																				echo "<option value='$value->region_name'>$value->region_name</option>";
            																																			}
            																																			echo "</select>
            																																			</div>
            																																			<div class='col-md-6'>
            																																			<label>Reciever Branch</label>
            																																			<select name='district' value='' class='form-control custom-select'  id='rec_dropp' required='required'>
            																																			<option>--Select Branch--</option>
            																																			</select>

            																																			</div>

            																																			</div>
            																																			</div>
            																																			<div class='' style='float: right;padding-right: 30px;padding-bottom: 10px;'>

            																																			<input type='hidden' name='id' id='comid'>
            																																			<button type='submit' class='btn btn-info pull-left'><span class='glyphicon glyphicon-remove'></span>Save Information</button>
            																																			<button type='submit' class='btn btn-warning pull-left' data-dismiss='modal'>Cancel</button>
            																																			</div>
            																																			</form>
            																																			</div>
            																																			<div class='modal-footer'>

            																																			</div>

            																																			</div>
            																																			</div>
            																																			<script>
            																																			$(document).ready(function(){
            																																				$('.getDetails1').click(function(){

            																																					$('.sfname').html($(this).attr('data-s_fullname'));
            																																					$('.saddress').html($(this).attr('data-s_address'));
            																																					$('.semail').html($(this).attr('data-s_email'));
            																																					$('.smobile').html($(this).attr('data-s_mobile'));
            																																					$('.sregion').html($(this).attr('data-s_region'));
            																																					$('.rfname').html($(this).attr('data-r_fullname'));
            																																					$('.raddress').html($(this).attr('data-r_address'));
            																																					$('.remail').html($(this).attr('data-r_email'));
            																																					$('.rmobile').html($(this).attr('data-r_mobile'));
            																																					$('.rregion').html($(this).attr('data-r_region'));
            																																					$('.operator').html($(this).attr('data-operator'));
            																																					$('#myModal1').modal();

            																																					});
            																																					});
            																																					</script>
            																																					<script type='text/javascript'>
            																																					$(document).ready(function() {
            																																						$('#checkAll3').change(function() {
            																																							if (this.checked) {
            																																								$('.checkSingle3').each(function() {
            																																									this.checked=true;
            																																									});
            																																									} else {
            																																										$('.checkSingle3').each(function() {
            																																											this.checked=false;
            																																											});
            																																										}
            																																										});

            																																										$('.checkSingle3').click(function () {
            																																											if ($(this).is(':checked')) {
            																																												var isAllChecked = 0;

            																																												$('.checkSingle3').each(function() {
            																																													if (!this.checked)
            																																													isAllChecked = 1;
            																																													});

            																																													if (isAllChecked == 0) {
            																																														$('#checkAll3').prop('checked', true);
            																																													}
            																																												}
            																																												else {
            																																													$('#checkAll3').prop('checked', false);
            																																												}
            																																												});
            																																												});
            																																												</script>
            																																												<script>
            																																												$(document).ready(function(){
            																																													$('.myBtn').click(function(){

            																																														var text1 = $(this).attr('data-sender_id');
            																																														$('#comid').val(text1);
            																																														$('#myModal').modal();
            																																														});
            																																														});
            																																														</script>
            																																														";

            																																													}
            																																													else{
            																																														redirect(base_url());
            																																													}
            																																												}

            																																												public function Get_EMSDate2()
            																																												{
            																																													if ($this->session->userdata('user_login_access') != false)
            																																													{
            																																														$date = $this->input->post('date_time');
            																																														$emid = $this->session->userdata('user_login_id');
            																																														$year = date('Y',strtotime($date));
            																																														$month = date('m',strtotime($date));
            																																														$day = date('d',strtotime($date));

            																																														if ($this->session->userdata('user_type') == "SUPERVISOR" || $this->session->userdata('user_type') == "EMPLOYEE") {
            																																															@$getInfo = $this->Box_Application_model->get_ems_per_date_by_emid($year,$month,$day,$emid);
            																																														} else {
            																																															@$getInfo = $this->Box_Application_model->get_ems_per_date($year,$month,$day);
            																																														}
            																																														echo"<form method='POST' action='send_to_back_office'>
            																																														<table id='fromServer' class='display nowrap table table-hover table-striped table-bordered searchResult' cellspacing='0' width='100%'>
            																																														<thead>

            																																														<tr>
            																																														<th>Sender Name</th>
            																																														<th>Registered Date</th>
            																																														<th>Amount (Tsh.)</th>
            																																														<th>Region Origin</th>
            																																														<th>Destination</th>
            																																														<th>Bill Number</th>
            																																														<th>Tracking Number</th>
            																																														<th>Transfer Status</th>
            																																														<th style='text-align: right;''>Payment Status</th>
            																																														<th>
            																																														action
            																																														</th>
            																																														</tr>
            																																														</thead>

            																																														<tbody>";
            																																														foreach ($getInfo as $value) {
            																																															echo "<tr>
            																																															<td><a href='#' class='myBtn' data-sender_id='$value->sender_id'>$value->s_fullname</a></td>
            																																															<td>$value->date_registered</td>
            																																															<td>".number_format($value->paidamount,2)."</td>
            																																															<td>$value->s_region</td>
            																																															<td>$value->r_region</td>
            																																															<td>";
            																																															if ($value->status == "Bill") {
            																																																echo strtoupper($value->s_pay_type);
            																																															} else {
            																																																echo $value->billid;
            																																															}

            																																															echo "</td>
            																																															<td>$value->track_number</td>
            																																															<td>";
            																																															if ($value->office_name == 'Received' || $value->office_name == 'Despatch') {
            																																																echo "<button type='button' class='btn btn-sm btn-success' disabled='disabled'>Successfully Transfer</button>";
            																																															}else{
            																																																echo "<button type='button' class='btn btn-sm btn-danger' disabled='disabled'> Pending To Transfer</button>";
            																																															}
            																																															echo"</td>";
            																																															echo "<td style='text-align: right;'>";
            																																															if($value->status == 'NotPaid'){
            																																																echo "<button class='btn btn-danger btn-sm'>Not Paid</button>";
            																																															}else{
            																																																echo "<button class='btn btn-success btn-sm'>Paid</button>";
            																																															}
            																																															"</td>";
            																																															echo " <td style = 'text-align:center;'>";
            																																															echo" <div class='form-check'>";
            																																															if ($value->status == 'Paid' && $value->office_name == 'Counter'){
            																																																echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
            																																																<label class='form-check-label' for='remember-me'></label>";
            																																															}elseif($value->status == 'Bill' && $value->office_name == 'Counter'){
            																																																echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
            																																																<label class='form-check-label' for='remember-me'></label>";
            																																															}else{
            																																																echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;'>
            																																																<label class='form-check-label' for='remember-me'></label>";
            																																															}
            																																															echo "</div>
            																																															</td>";

            																																															echo "<td style = 'text-align:center;'>";
            																																															if ($value->bill_status == 'PENDING' && $value->status == 'NotPaid') {

            																																																echo "<input type='hidden' class='pid' value='$value->id'><a href='#' class='btn btn-info btn-sm getDetails1'>Cancel</a>";
            																																															} else {
            																																																echo "<a href='#' class='btn btn-info btn-sm getDetails' data-sender_id='$value->sender_id ' data-receiver_id='$value->receiver_id ' data-s_fullname='$value->s_fullname ' data-s_address='$value->s_address' data-s_email='$value->s_email' data-s_mobile='$value->s_mobile' data-s_region='$value->s_region ' data-r_fullname='$value->fullname' data-s_address=' $value->address' data-r_email='$value->email' data-r_mobile='$value->mobile' data-r_branch='$value->branch ' data-s_branch='$value->s_district' data-billid='$value->billid ' data-channel='$value->paychannel  data-r_region='$value->r_region ?>' data-operator='";
            																																																$id = $value->operator;
            																																																$info = $this->employee_model->GetBasic($id);
            																																																echo" @$info->em_code.'  '.@$info->first_name.'  '.@$info->middle_name.'  '.@$info->last_name'>Details</a>";
            																																															}


            																																															echo "</td>
            																																															</tr>";
            																																														}
            																																														echo "</tbody>
            																																														</table>

            																																														<script>
            																																														$('#fromServer').DataTable( {

            																																															order: [[3,'desc' ]],

            																																															fixedHeader: false,
            																																															dom: 'Bfrtip',
            																																															buttons: [
            																																															'copy', 'csv', 'excel', 'pdf', 'print'
            																																															]
            																																															} );
            																																															</script>

            																																															";

            																																														}else{
            																																															redirect(base_url());
            																																														}
            																																													}
            																																													public function updateStatus(){
            																																														if ($this->session->userdata('user_login_access') != false){

            																																															$id = $this->input->post('id');
            																																															$data1 = array();
            																																															$data1 = array('status'=>'Cancel','bill_status'=>'SUCCESS');
            																																															$this->Box_Application_model->update_old_transactions($data1,$id);
            																																															echo "Successfully Canceled";

            																																														}
            																																														else{
            																																															redirect(base_url());
            																																														}

            																																													}
            																																													public function Get_EMSRegionBranch()
            																																													{
            																																														if ($this->session->userdata('user_login_access') != false)
            																																														{
            																																															$region = $this->input->post('region');
            																																															$branch = $this->input->post('branch');
            																																															$emid = $this->input->post('emid');
            																																															$date = $this->input->post('date');


            																																															@$getInfo = $this->Box_Application_model->get_ems_region_branch($region,$branch);

            																																															echo
            																																															"<form method='POST' action='send_to_back_office'>
            																																															<table id='fromServer' class='display nowrap table table-hover table-striped table-bordered searchResult' cellspacing='0' width='100%'>
            																																															<thead>
            																																															<tr><th colspan='11'></th><th colspan=''><div class='form-check' style='padding-left:60px;' id='showCheck3'>
            																																															<input type='checkbox'  class='form-check-input' id='checkAll3' style=''>
            																																															<label class='form-check-label' for='remember-me'>All</label>
            																																															</div></th>
            																																															<th></th>
            																																															</tr>
            																																															<tr>
            																																															<th>Sender Name</th>
            																																															<th>Registered Date</th>
            																																															<th>Amount (Tsh.)</th>
            																																															<th>Region Origin</th>
            																																															<th>Branch Origin</th>
            																																															<th>Destination</th>
            																																															<th>Destination Branch</th>
            																																															<th>Bill Number</th>
            																																															<th>Tracking Number</th>
            																																															<th>Transfer Status</th>
            																																															<th style='text-align: right;''>Payment Status</th>
            																																															<th>
            																																															Item Status
            																																															</th>
            																																															<th>
            																																															action
            																																															</th>
            																																															</tr>
            																																															</thead>

            																																															<tbody>";
            																																															if (!empty($getInfo)) {

            																																																foreach ($getInfo as $value) {
            																																																	echo "<tr>
            																																																	<td><a href='#' class='myBtn' data-sender_id='$value->sender_id'>$value->s_fullname</a></td>
            																																																	<td>$value->date_registered</td>
            																																																	<td>".number_format($value->paidamount,2)."</td>
            																																																	<td>$value->s_region</td>
            																																																	<td>$value->s_district</td>
            																																																	<td>$value->r_region</td>
            																																																	<td>$value->branch</td>
            																																																	<td>";
            																																																	if ($value->status == "Bill") {
            																																																		echo strtoupper($value->s_pay_type);
            																																																	} else {
            																																																		echo $value->billid;
            																																																	}

            																																																	echo "</td>
            																																																	<td>$value->track_number</td>
            																																																	<td>";
            																																																	if ($value->office_name == 'Received' || $value->office_name == 'Despatch') {
            																																																		echo "<button type='button' class='btn btn-sm btn-success' disabled='disabled'>Successfully Transfer</button>";
            																																																	}else{
            																																																		echo "<button type='button' class='btn btn-sm btn-danger' disabled='disabled'> Pending To Transfer</button>";
            																																																	}
            																																																	echo"</td>
            																																																	<td style='text-align: right;'>";
            																																																	if($value->status == 'NotPaid'){
            																																																		echo "<button class='btn btn-danger btn-sm'>Not Paid</button>";
            																																																	}else{
            																																																		echo "<button class='btn btn-success btn-sm'>Paid</button>";
            																																																	}
            																																																	"</td></td>";
            																																																	echo "<td style = 'text-align:center;'>";
            																																																	echo "<div class='form-check'>";
            																																																	if (($value->status == 'Paid' || $value->status == 'Bill') && $value->office_name == 'Counter'){

            																																																		echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle3' id='remember-me' value='$value->id'>
            																																																		<label class='form-check-label' for='remember-me'></label>";

            																																																	}else{

            																																																		echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;' checked>
            																																																		<label class='form-check-label' for='remember-me'></label>";
            																																																	}
            																																																	echo"</div>
            																																																	</td>
            																																																	<td style = 'text-align:center;'>
            																																																	<a href='#' class='btn btn-info btn-sm getDetails1' data-sender_id='$value->sender_id' data-receiver_id='$value->receiver_id' data-s_fullname='$value->s_fullname' data-s_address='$value->s_address' data-s_email='$value->s_email' data-s_mobile='$value->s_mobile' data-s_region='$value->s_region' data-r_fullname='$value->fullname' data-s_address='$value->address' data-r_email='$value->email' data-r_mobile='$value->mobile' data-r_region='$value->r_region'
            																																																	data-operator='"; $id = $value->operator;
            																																																	@$info = $this->employee_model->GetBasic($id);
            																																																	echo @$info->em_code.'  '.@$info->first_name.'  '.@$info->middle_name.'  '.@$info->last_name;  echo "'>Details</a>
            																																																	</td>
            																																																	</tr>";
            																																																}
            																																															}else{
            																																																echo "<tr>
            																																																<td colspan='15' style='color:red;text-align:center;'>No Data Found</td></tr>";
            																																															}
            																																															echo" </tbody>

            																																															</table>
            																																															<input type='hidden' name='type' value='EMS'>
            																																															<input type='hidden' class='id' name='emid' id='emid' value='@$emid'>
            																																															<br><br>
            																																															<table style='width: 100%;'>
            																																															<tr>
            																																															<td colspan='' style='text-align: right;'></td>
            																																															<td colspan=''></td>
            																																															<td colspan=''>

            																																															</td>

            																																															<td colspan='11' style='text-align: right;'><button type='submit' class='btn btn-info'>Back Office >>> </button></td>
            																																															</tr>
            																																															</table>
            																																															</form>

            																																															<div id='myModal1' class='modal fade' role='dialog' style='padding-top:200px; font-size:24px;'>
            																																															<div class='modal-dialog'>
            																																															<div class='modal-content'>
            																																															<div class='modal-header'>
            																																															<button type='button' class='close' data-dismiss='modal'>&times;</button>
            																																															<h2 class='modal-title'>EMS Information</h2>
            																																															</div>
            																																															<div class='modal-body'>
            																																															<div class='row'><div class='col-md-12'><b>Sender Information</b></div></div>
            																																															<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='sfname'></span></div></div>
            																																															<div class='row'><div class='col-md-12'>address: &nbsp;&nbsp;<span class='saddress'></span></div></div>
            																																															<div class='row'><div class='col-md-12'>Email: &nbsp;&nbsp;<span class='semail'></span></div></div>
            																																															<div class='row'><div class='col-md-12'>Mobile: &nbsp;&nbsp;<span class='smobile'></span></div></div>
            																																															<div class='row'><div class='col-md-12'>Region: &nbsp;&nbsp;<span class='sregion'></span></div></div>
            																																															<br>
            																																															<div class='row'><div class='col-md-12'><b>Receiver Information</b></div></div>
            																																															<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='rfname'></span></div></div>
            																																															<div class='row'><div class='col-md-12'>address: &nbsp;&nbsp;<span class='raddress'></span></div></div>
            																																															<div class='row'><div class='col-md-12'>Email: &nbsp;&nbsp;<span class='remail'></span></div></div>
            																																															<div class='row'><div class='col-md-12'>Mobile: &nbsp;&nbsp;<span class='rmobile'></span></div></div>
            																																															<div class='row'><div class='col-md-12'>Region: &nbsp;&nbsp;<span class='rregion'></span></div></div>
            																																															<br>
            																																															<div class='row'><div class='col-md-12'><b>Service Operator</b></div></div>
            																																															<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='operator'></span></div></div>
            																																															</div>
            																																															</div>
            																																															</div>
            																																															</div>
            																																															</div>
            																																															<div class='modal fade' id='myModal' role='dialog' style='padding-top: 100px;'>
            																																															<div class='modal-dialog modal-lg'>

            																																															<!-- Modal content-->
            																																															<div class='modal-content'>
            																																															<div class='modal-header'>
            																																															<button type='button' class='close' data-dismiss='modal'>&times;</button>
            																																															</div>
            																																															<form role='form' action='ems_action_receiver' method='post' onsubmit='disableButton()'>
            																																															<div class='modal-body'>
            																																															<div class='row'>
            																																															<div class='col-md-12'>
            																																															<h3>Step 3 of 4  - Reciever Personal Details</h3>
            																																															</div>

            																																															<div class='col-md-6'>
            																																															<label>Full Name:</label>
            																																															<input type='text' name='r_fname' id='r_fname' class='form-control' onkeyup='myFunction()' required='required'>
            																																															</div>
            																																															<div class='col-md-6'>
            																																															<label>Address:</label>
            																																															<input type='text' name='r_address' id='r_address' class='form-control' onkeyup='myFunction()' required='required'>
            																																															</div>
            																																															<div class='col-md-6'>
            																																															<label>Email:</label>
            																																															<input type='email' name='r_email' id='r_email' class='form-control' onkeyup='myFunction()'>
            																																															</div>
            																																															<div class='col-md-6'>
            																																															<label>Mobile Number</label>
            																																															<input type='mobile' name='r_mobile' id='r_mobile' class='form-control' onkeyup='myFunction()' required='required'>
            																																															</div>
            																																															<div class='col-md-6'>
            																																															<label class='control-label'>Region</label>
            																																															<select name='region_to' value='' class='form-control custom-select' required id='rec_region' onChange='getRecDistrict();' required='required'>
            																																															<option value=''>--Select Region--</option>";
            																																															$regionlist = $this->employee_model->regselect();
            																																															foreach($regionlist as $value){
            																																																echo "<option value='$value->region_name'>$value->region_name</option>";
            																																															}
            																																															echo "</select>
            																																															</div>
            																																															<div class='col-md-6'>
            																																															<label>Reciever Branch</label>
            																																															<select name='district' value='' class='form-control custom-select'  id='rec_dropp' required='required'>
            																																															<option>--Select Branch--</option>
            																																															</select>

            																																															</div>

            																																															</div>
            																																															</div>
            																																															<div class='' style='float: right;padding-right: 30px;padding-bottom: 10px;'>

            																																															<input type='hidden' name='id' id='comid'>
            																																															<button type='submit' class='btn btn-info pull-left'><span class='glyphicon glyphicon-remove'></span>Save Information</button>
            																																															<button type='submit' class='btn btn-warning pull-left' data-dismiss='modal'>Cancel</button>
            																																															</div>
            																																															</form>
            																																															</div>
            																																															<div class='modal-footer'>

            																																															</div>

            																																															</div>
            																																															</div>
            																																															<script>
            																																															$(document).ready(function(){
            																																																$('.getDetails1').click(function(){

            																																																	$('.sfname').html($(this).attr('data-s_fullname'));
            																																																	$('.saddress').html($(this).attr('data-s_address'));
            																																																	$('.semail').html($(this).attr('data-s_email'));
            																																																	$('.smobile').html($(this).attr('data-s_mobile'));
            																																																	$('.sregion').html($(this).attr('data-s_region'));
            																																																	$('.rfname').html($(this).attr('data-r_fullname'));
            																																																	$('.raddress').html($(this).attr('data-r_address'));
            																																																	$('.remail').html($(this).attr('data-r_email'));
            																																																	$('.rmobile').html($(this).attr('data-r_mobile'));
            																																																	$('.rregion').html($(this).attr('data-r_region'));
            																																																	$('.operator').html($(this).attr('data-operator'));
            																																																	$('#myModal1').modal();

            																																																	});
            																																																	});
            																																																	</script>
            																																																	<script type='text/javascript'>
            																																																	$(document).ready(function() {
            																																																		$('#checkAll3').change(function() {
            																																																			if (this.checked) {
            																																																				$('.checkSingle3').each(function() {
            																																																					this.checked=true;
            																																																					});
            																																																					} else {
            																																																						$('.checkSingle3').each(function() {
            																																																							this.checked=false;
            																																																							});
            																																																						}
            																																																						});

            																																																						$('.checkSingle3').click(function () {
            																																																							if ($(this).is(':checked')) {
            																																																								var isAllChecked = 0;

            																																																								$('.checkSingle3').each(function() {
            																																																									if (!this.checked)
            																																																									isAllChecked = 1;
            																																																									});

            																																																									if (isAllChecked == 0) {
            																																																										$('#checkAll3').prop('checked', true);
            																																																									}
            																																																								}
            																																																								else {
            																																																									$('#checkAll3').prop('checked', false);
            																																																								}
            																																																								});
            																																																								});
            																																																								</script>
            																																																								<script>
            																																																								$(document).ready(function(){
            																																																									$('.myBtn').click(function(){

            																																																										var text1 = $(this).attr('data-sender_id');
            																																																										$('#comid').val(text1);
            																																																										$('#myModal').modal();
            																																																										});
            																																																										});
            																																																										</script>
            																																																										";

            																																																									}
            																																																									else{
            																																																										redirect(base_url());
            																																																									}
            																																																								}
            																																																								public function Get_EMSReport(){
            																																																									if ($this->session->userdata('user_login_access') != false){
            																																																										$date = $this->input->post('date_time');
            																																																										$first = $this->input->post('first');
            																																																										$second = $this->input->post('second');
            																																																										$type = $this->input->post('type');
            																																																										$cate = $this->input->post('cat');
            																																																										$season = $this->input->post('sreport');

            																																																										$Dayfirst = $this->input->post('Dayfirst');
            																																																										$Daysecond = $this->input->post('Daysecond');

            																																																										echo $Dayfirst.'  '.$Daysecond;
            																																																										if ($season == 'Day') {

            																																																											$year = date('Y',strtotime($date));
            																																																											$month = date('m',strtotime($date));
            																																																											$day = date('d',strtotime($date));

            																																																											$getReport = $this->Box_Application_model->get_ems_report_Document_Days($year,$month,$day,$cate);

            																																																										}elseif ($season == 'DayBtn') 
            																																																										{
            																																																											$year = date('Y',strtotime($Dayfirst));
            																																																											$month = date('m',strtotime($Dayfirst));
            																																																											$day = date('d',strtotime($Dayfirst));



            																																																											$year1 = date('Y',strtotime($Daysecond));
            																																																											$month1 = date('m',strtotime($Daysecond));
            																																																											$day1 = date('d',strtotime($Daysecond));

            																																																											$getReport = $this->Box_Application_model->get_ems_report_Document_DaysBtns1($Dayfirst,$Daysecond,$cate);


											// $getReport = $this->Box_Application_model->get_ems_report_Document_DaysBtns($year,$month,$day,$cate,$year1,$month1,$day1);



            																																																										}elseif ($season == 'Year') {
	//$year = $date;
            																																																											$year = date('Y',strtotime($date));
            																																																											$getReport = $this->Box_Application_model->get_ems_report_Document_Years($year,$cate);													
            																																																										}elseif ($season == 'MonthBtn') {

//$year = date('Y',strtotime($first));
            																																																											$monthf = date('m',strtotime($first));
//$months = date('m',strtotime($second));

            																																																											$date = explode('-', $second);
            																																																											$months  = @$date[0];
            																																																											$year = @$date[1];

            																																																											$getReport = $this->Box_Application_model->get_ems_report_Document_MonthBtns($year,$monthf,$months,$cate);

            																																																										}else{

            																																																											$date = explode('-', $date);
            																																																											$day  = @$date[0];
            																																																											$year = @$date[1];

            																																																											$getReport = $this->Box_Application_model->get_ems_report_Document_Months($year,$day,$cate);
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

            																																																								public function Get_Despatch_Out_ByDate()
            																																																								{
            																																																									if ($this->session->userdata('user_login_access') != false)
            																																																									{
            																																																										$date = $this->input->post('date_time');
            																																																										$year = date('Y',strtotime($date));
            																																																										$month = date('m',strtotime($date));
            																																																										$day = date('d',strtotime($date));


            																																																										$getInfo = $this->Box_Application_model->get_despatch_out_per_date($year,$month,$day);

            																																																										echo "
            																																																										<table id='fromServer1' class='display nowrap table table-hover table-striped table-bordered fromServer2' cellspacing='0' width='100%'>
            																																																										<thead>
            																																																										<tr>
            																																																										<th>S/No</th>
            																																																										<th>Despatch Number</th>
            																																																										<th>Number Of Bags</th>
            																																																										<th>Destination Region</th>
            																																																										<th>Destination Branch</th>
            																																																										<th>Despatch Date</th>
            																																																										<th>Transport Type</th>
            																																																										<th>Transport Name</th>
            																																																										<th>Registration Number</th>
            																																																										<th>Despatch Status</th>
            																																																										<th>Received By</th>
            																																																										</tr>
            																																																										</thead>

            																																																										<tbody class=''>

            																																																										";
            																																																										if (!empty($getInfo)) {$no=0;
            																																																											foreach ($getInfo as $value) {$no=$no+1;
            																																																												echo "
            																																																												<tr>
            																																																												<td>".$no."</td>
            																																																												<td>
            																																																												<a href='bags_list_despatch?despno=$value->desp_no' data-despno = '$value->desp_no' class='bagsList12'>
            																																																												$value->desp_no 
            																																																												</a>

            																																																												<td>";
            																																																												$bagno = $value->desp_no;
            																																																												$db2 = $this->load->database('otherdb', TRUE);
            																																																												$db2->where('despatch_no',$bagno);
            																																																												$db2->from("bags");
            																																																												echo $db2->count_all_results();
            																																																												echo"</td>
            																																																												<td>$value->region_to</td>
            																																																												<td>$value->branch_to</td>
            																																																												<td>$value->datetime</td>
            																																																												<td>$value->transport_type</td>
            																																																												<td>$value->transport_name</td>
            																																																												<td>$value->registration_number</td>
            																																																												<td>$value->despatch_status</td>
            																																																												<td>";
            																																																												$id = $value->received_by;
            																																																												@$basicinfo = $this->employee_model->GetBasic($id); echo 'PF'.@$basicinfo->em_code.' '. @$basicinfo->first_name.' '.@$basicinfo->last_name;
            																																																												echo"</td>
            																																																												</tr>
            																																																												";
            																																																											}

            																																																										} else {
            																																																											echo "<tr>
            																																																											<td colspan='8'>No data available in table</td>
            																																																											</tr>";
            																																																										}
            																																																										echo "</tbody>
            																																																										</table>
            																																																										<script type='text/javascript'>
            																																																										$('.fromServer2').DataTable( {
            																																																											retrieve:true,

            																																																											fixedHeader: false,
            																																																											dom: 'Bfrtip',
            																																																											buttons: [
            																																																											'copy', 'csv', 'excel', 'pdf', 'print'
            																																																											]
            																																																											} );
            																																																											</script>

            																																																											";
            																																																										}
            																																																										else{
            																																																											redirect(base_url());
            																																																										}
            																																																									}


            																																																									public function Get_delivery_bills_In_ByDate()
            																																																									{
            																																																										if ($this->session->userdata('user_login_access') != false)
            																																																										{
            																																																											$date = $this->input->post('date_time');
            																																																											$year = date('Y',strtotime($date));
            																																																											$month = date('m',strtotime($date));
            																																																											$day = date('d',strtotime($date));
            																																																											$regionfrom = $this->session->userdata('user_region');
            																																																											$getInfo = $this->Box_Application_model->get_despatch_way_in_per_date($year,$month,$day);

            																																																											echo "
            																																																											<form method='POST' action='despatch_action'>
            																																																											<table id='fromServer1' class='display nowrap table table-hover table-striped table-bordered fromServer2' cellspacing='0' width='100%'>
            																																																											<thead>
            																																																											<tr>
            																																																											<th>Despatch Number</th>
            																																																											<th>Number Of Bags</th>
            																																																											<th>Despatch Region Source</th>
            																																																											<th>Despatch Branch Source</th>
            																																																											<th>Despatch Date</th>
            																																																											<th>Transport Type</th>
            																																																											<th>Transport Name</th>
            																																																											<th>Registration Number</th>
            																																																											<th>Despatch Status</th>
            																																																											<th>Received By</th>
            																																																											<th>Action</th>
            																																																											</tr>
            																																																											</thead>

            																																																											<tbody class=''>

            																																																											";
            																																																											if (!empty($getInfo)) {
            																																																												foreach ($getInfo as $value) {
            																																																													echo "
            																																																													<tr>
            																																																													<td>
            																																																													<a href='list_delivery_bills_despatched?despno=$value->desp_no' data-despno = '$value->desp_no' class='bagsList12'>
            																																																													$value->desp_no
            																																																													</a>

            																																																													<td>";
            																																																													$bagno = $value->desp_no;
            																																																													$db2 = $this->load->database('otherdb', TRUE);
            																																																													$db2->where('despatch_no',$bagno);
            																																																													$db2->from("bags");
            																																																													echo $db2->count_all_results();
            																																																													echo"</td>
            																																																													<td>$value->region_to</td>
            																																																													<td>$value->branch_to</td>
            																																																													<td>$value->datetime</td>
            																																																													<td>$value->transport_type</td>
            																																																													<td>$value->transport_name</td>
            																																																													<td>$value->registration_number</td>
            																																																													<td>";
            																																																													if ($value->despatch_status == 'Sent') {

            																																																														echo "<button class='btn btn-danger btn-sm' type='button' disable>Pending Receive</button>";

            																																																													}else {

            																																																														echo "<button class='btn btn-success btn-sm' type='button' disable>Successfully Received</button>";

            																																																													}
            																																																													echo "</td>
            																																																													<td>";
            																																																													$id = $value->received_by;
            																																																													@$basicinfo = $this->employee_model->GetBasic($id); echo 'PF'.@$basicinfo->em_code.' '. @$basicinfo->first_name.' '.@$basicinfo->last_name;
            																																																													echo"</td>";
            																																																													echo "<td>";
            																																																													if ( $value->despatch_status == 'Sent' ) {
            																																																														echo "<div class='form-check' style='padding-left: 53px;'>
            																																																														<input type='checkbox' name='I' class='form-check-input checkSingle4 checkd' id='remember-me' value='$value->desp_no '>
            																																																														<label class='form-check-label' for='remember-me'></label>";
            																																																													}else{
            																																																														echo "<div class='form-check' style='padding-left: 53px;'>

            																																																														<input type='checkbox' class='form-check-input checkSingle4' id='remember-me' checked='checked' disabled='disabled'>
            																																																														<label class='form-check-label' for='remember-me'></label>

            																																																														</div>";
            																																																													}
            																																																													echo"</td>
            																																																													</tr>
            																																																													";
            																																																												}

            																																																											} else {
            																																																												echo "<tr>
            																																																												<td colspan='9'>No data available in table</td>
            																																																												</tr>";
            																																																											}
            																																																											echo "</tbody>
            																																																											</table>
            																																																											<br><br>
            																																																											<table class='table' style='width: 100%;'>
            																																																											<tr><td colspan='9'></td><td style='float: right;'><button type='submit' class='btn btn-info'>Receive Bag</button></td></tr>
            																																																											</table>
            																																																											<script type='text/javascript'>
            																																																											$('.fromServer2').DataTable( {
            																																																												retrieve:true,
            																																																												order: [[4,'desc' ]],
            																																																												fixedHeader: false,
            																																																												dom: 'Bfrtip',
            																																																												buttons: [
            																																																												'copy', 'csv', 'excel', 'pdf', 'print'
            																																																												]
            																																																												} );
            																																																												</script>

            																																																												";
            																																																											}
            																																																											else{
            																																																												redirect(base_url());
            																																																											}
            																																																										}

            																																																										public function Get_Despatch_In_ByDate(){


            																																																											if ($this->session->userdata('user_login_access') != false){
            																																																												$date = $this->input->post('date_time');
            																																																												$year = date('Y',strtotime($date));
            																																																												$month = date('m',strtotime($date));
            																																																												$day = date('d',strtotime($date));
            																																																												$regionfrom = $this->session->userdata('user_region');
            																																																												$getInfo = $this->Box_Application_model->get_despatch_in_per_date($year,$month,$day);

            																																																												echo "
            																																																												<form method='POST' action='despatch_action'>
            																																																												<table id='fromServer1' class='display nowrap table table-hover table-striped table-bordered fromServer2' cellspacing='0' width='100%'>
            																																																												<thead>
            																																																												<tr>
            																																																												<th>S/No</th>
            																																																												<th>Despatch Number</th>
            																																																												<th>Number Of Bags</th>
            																																																												<th>Despatch Branch Source</th>
            																																																												<th>Destination Branch</th>
            																																																												<th>Despatch Date</th>
            																																																												<th>Despatch Status</th>
            																																																												<th>Received By</th>
            																																																												<th>Action</th>
            																																																												</tr>
            																																																												</thead>

            																																																												<tbody class=''>

            																																																												";
            																																																												if (!empty($getInfo)) {$no=0;
            																																																													foreach ($getInfo as $value) {$no=$no+1;
            																																																														echo "
            																																																														<tr>
            																																																														<td>".$no."</td>
            																																																														<td>
            																																																														<a href='bags_list_despatch?despno=$value->desp_no' data-despno = '$value->desp_no' class='bagsList12'>$value->desp_no
            																																																														</a>
            																																																														<td>";
            																																																														$bagno = $value->desp_no;
            																																																														$db2 = $this->load->database('otherdb', TRUE);
            																																																														$db2->where('despatch_no',$bagno);
            																																																														$db2->from("bags");
            																																																														echo $db2->count_all_results();
            																																																														echo"</td>
            																																																														<td>$value->branch_from</td>
            																																																														<td>$value->branch_to</td>
            																																																														<td>$value->datetime</td>
            																																																														<td>";
            																																																														if ($value->despatch_status == 'Sent') {

            																																																															echo "<button class='btn btn-danger btn-sm' type='button' disable>Pending Receive</button>";

            																																																														}else {

            																																																															echo "<button class='btn btn-success btn-sm' type='button' disable>Successfully Received</button>";

            																																																														}
            																																																														echo "</td>
            																																																														<td>";
            																																																														$id = $value->received_by;
            																																																														@$basicinfo = $this->employee_model->GetBasic($id); echo 'PF'.@$basicinfo->em_code.' '. @$basicinfo->first_name.' '.@$basicinfo->last_name;
            																																																														echo"</td>";
            																																																														echo "<td>";
            																																																														if ( $value->despatch_status == 'Sent' ) {
            																																																															echo "<div class='form-check' style='padding-left: 53px;'>
            																																																															<input type='checkbox' name='I[]' class='form-check-input checkSingle ' id='remember-me' value='$value->desp_no '>
            																																																															<label class='form-check-label' for='remember-me'></label>";
            																																																														}else{
            																																																															echo "<div class='form-check' style='padding-left: 53px;'>

            																																																															<input type='checkbox' class='form-check-input checkSingle4' id='remember-me' checked='checked' disabled='disabled'>
            																																																															<label class='form-check-label' for='remember-me'></label>

            																																																															</div>";
            																																																														}
            																																																														echo"</td>
            																																																														</tr>
            																																																														";
            																																																													}

            																																																												} else {
            																																																													echo "<tr>
            																																																													<td colspan='11'>No data available in table</td>
            																																																													</tr>";
            																																																												}
            																																																												echo "</tbody>
            																																																												</table>
            																																																												<br><br>
            																																																												<table class='table' style='width: 100%;'>
            																																																												<tr>
            																																																												<td colspan='11'></td><td style='float: right;'>
            																																																												<!--<button type='submit' class='btn btn-info'>Receive Bag</button>-->
            																																																												<div class='btn btn-info receiveBags' onclick='receiveBags(this)'>Receive Bag
            																																																												</div>
            																																																												<div class='statusText'></div>

            																																																												</td>
            																																																												</tr>
            																																																												</table>
            																																																												<script type='text/javascript'>
            																																																												$('.fromServer2').DataTable( {
            																																																													retrieve:true,
            																																																													order: [[4,'desc' ]],
            																																																													fixedHeader: false,
            																																																													dom: 'Bfrtip',
            																																																													buttons: [
            																																																													'copy', 'csv', 'excel', 'pdf', 'print'
            																																																													]
            																																																													} );
            																																																													</script>";
            																																																												}
            																																																												else{
            																																																													redirect(base_url());
            																																																												}
            																																																											}

										/*public function Get_Despatch_In_ByDate()
										{
											// <div class='form-check' style='padding-left: 53px;' id='showCheck'>
					      //                             <input type='checkbox'  class='form-check-input' id='checkAll'>
					      //                                <label class='form-check-label' for='remember-me'>Select All</label>
					      //                              </div>
					                                   
											if ($this->session->userdata('user_login_access') != false)
											{
												$date = $this->input->post('date_time');
												$year = date('Y',strtotime($date));
												$month = date('m',strtotime($date));
												$day = date('d',strtotime($date));
												$regionfrom = $this->session->userdata('user_region');
												$getInfo = $this->Box_Application_model->get_despatch_in_per_date($year,$month,$day);

												echo "
												<form method='POST' action='despatch_action'>
												<table id='fromServer1' class='display nowrap table table-hover table-striped table-bordered fromServer2' cellspacing='0' width='100%'>
												<thead>
												<tr>
												<th>Despatch Number</th>
												<th>Number Of Bags</th>
												<th>Despatch Region Source</th>
												<th>Despatch Branch Source</th>
												<th>Destination Region</th>
												<th>Destination Branch</th>
												<th>Despatch Date</th>
												<th>Transport Type</th>
												<th>Transport Name</th>
												<th>Registration Number</th>
												<th>Despatch Status</th>
												<th>Received By</th>
												<th>Action
												
					                                   </th>
												</tr>
												</thead>

												<tbody class=''>

												";
												if (!empty($getInfo)) {
													foreach ($getInfo as $value) {
														echo "
														<tr>
														<td>
														<a href='bags_list_despatch?despno=$value->desp_no' data-despno = '$value->desp_no' class='bagsList12'>$value->desp_no
                                                         </a>
														<td>";
														$bagno = $value->desp_no;
														$db2 = $this->load->database('otherdb', TRUE);
														$db2->where('despatch_no',$bagno);
														$db2->from("bags");
														echo $db2->count_all_results();
														echo"</td>
														<td>$value->region_from</td>
														<td>$value->branch_from</td>
														<td>$value->region_to</td>
														<td>$value->branch_to</td>
														<td>$value->datetime</td>
														<td>$value->transport_type</td>
														<td>$value->transport_name</td>
														<td>$value->registration_number</td>
														<td>";
														if ($value->despatch_status == 'Sent') {

															echo "<button class='btn btn-danger btn-sm' type='button' disable>Pending Receive</button>";

														}else {

															echo "<button class='btn btn-success btn-sm' type='button' disable>Successfully Received</button>";

														}
														echo "</td>
														<td>";
														$id = $value->received_by;
														@$basicinfo = $this->employee_model->GetBasic($id); echo 'PF'.@$basicinfo->em_code.' '. @$basicinfo->first_name.' '.@$basicinfo->last_name;
														echo"</td>";
														echo "<td>";
														if ( $value->despatch_status == 'Sent' ) {
															echo "<div class='form-check' style='padding-left: 53px;'>
															<input type='checkbox' name='I[]' class='form-check-input checkSingle ' id='remember-me' value='$value->desp_no '>
															<label class='form-check-label' for='remember-me'></label>";
														}else{
															echo "<div class='form-check' style='padding-left: 53px;'>

															<input type='checkbox' class='form-check-input checkSingle4' id='remember-me' checked='checked' disabled='disabled'>
															<label class='form-check-label' for='remember-me'></label>

															</div>";
														}
														echo"</td>
														</tr>
														";
													}

												} else {
													echo "<tr>
													<td colspan='11'>No data available in table</td>
													</tr>";
												}
												echo "</tbody>
												</table>
												<br><br>
												<table class='table' style='width: 100%;'>
												<tr><td colspan='11'></td><td style='float: right;'><button type='submit' class='btn btn-info'>Receive Bag</button></td></tr>
												</table>
												<script type='text/javascript'>
												$('.fromServer2').DataTable( {
													retrieve:true,
													order: [[4,'desc' ]],
													fixedHeader: false,
													dom: 'Bfrtip',
													buttons: [
													'copy', 'csv', 'excel', 'pdf', 'print'
													]
													} );
													</script>

													";
												}
												else{
													redirect(base_url());
												}
											}*/

											public function Get_Despatch_Out_ByMonth()
											{
												if ($this->session->userdata('user_login_access') != false)
												{
													$month1 = $this->input->post('month1');
													$month2 = $this->input->post('month2');
													$date = $this->input->post('date_time');
													$year = date('Y',strtotime($date));
													$month = date('m',strtotime($date));
													$day = date('d',strtotime($date));

													$date = explode('-', $month1);
													$date2 = explode('-', $month2);
													$month1  = @$date[0];
													$month2  = @$date2[0];
													$year = @$date[1];

													$getInfo = $this->Box_Application_model->get_despatch_out_per_month($year,$month1,$month2);

													echo "
													<table id='fromServer1' class='display nowrap table table-hover table-striped table-bordered fromServer2' cellspacing='0' width='100%'>
													<thead>
													<tr>
													<th>Despatch Number</th>
													<th>Number Of Bags</th>
													<th>Despatch Region Source</th>
													<th>Despatch Branch Source</th>
													<th>Destination Region</th>
													<th>Destination Branch</th>
													<th>Despatch Date</th>
													<th>Transport Type</th>
													<th>Transport Name</th>
													<th>Registration Number</th>
													<th>Despatch Status</th>
													<th>Received By</th>
													</tr>
													</thead>

													<tbody class=''>

													";
													if (!empty($getInfo)) {
														foreach ($getInfo as $value) {
															echo "
															<tr>
															<td><a href='#' data-despno = '$value->desp_no' class='bagsList12'>$value->desp_no</a></td>
															<td>";
															$bagno = $value->desp_no;
															$db2 = $this->load->database('otherdb', TRUE);
															$db2->where('despatch_no',$bagno);
															$db2->from("bags");
															echo $db2->count_all_results();
															echo"</td>
															<td>$value->region_from</td>
															<td>$value->branch_from</td>
															<td>$value->region_to</td>
															<td>$value->branch_to</td>
															<td>$value->datetime</td>
															<td>$value->transport_type</td>
															<td>$value->transport_name</td>
															<td>$value->registration_number</td>
															<td>$value->despatch_status</td>
															<td>";
															$id = $value->received_by;
															@$basicinfo = $this->employee_model->GetBasic($id); echo 'PF'.@$basicinfo->em_code.' '. @$basicinfo->first_name.' '.@$basicinfo->last_name;
															echo"</td>
															</tr>
															";
														}

													} else {
														echo "<tr>
														<td colspan='12'>No data available in table</td>
														</tr>";
													}
													echo "</tbody>
													</table>
													<script type='text/javascript'>
													$('.fromServer2').DataTable( {
														retrieve:true,
														order: [[4,'desc' ]],
														fixedHeader: false,
														dom: 'Bfrtip',
														buttons: [
														'copy', 'csv', 'excel', 'pdf', 'print'
														]
														} );
														</script>

														";
													}
													else{
														redirect(base_url());
													}
												}
												public function Get_Despatch_In_ByMonth()
												{
													if ($this->session->userdata('user_login_access') != false)
													{
														$month1 = $this->input->post('month1');
														$month2 = $this->input->post('month2');
														$date = $this->input->post('date_time');
														$year = date('Y',strtotime($date));
														$month = date('m',strtotime($date));
														$day = date('d',strtotime($date));

														$date = explode('-', $month1);
														$date2 = explode('-', $month2);
														$month1  = @$date[0];
														$month2  = @$date2[0];
														$year = @$date[1];

														$getInfo = $this->Box_Application_model->get_despatch_in_per_month($year,$month1,$month2);

														echo "<div class='message'></div>
														<form method='POST' action='despatch_action'>
														<table id='fromServer1' class='display nowrap table table-hover table-striped table-bordered fromServer2' cellspacing='0' width='100%'>
														<thead>
														<tr>
														<th>Despatch Number</th>
														<th>Number Of Bags</th>
														<th>Despatch Region Source</th>
														<th>Despatch Branch Source</th>
														<th>Destination Region</th>
														<th>Destination Branch</th>
														<th>Despatch Date</th>
														<th>Transport Type</th>
														<th>Transport Name</th>
														<th>Registration Number</th>
														<th>Despatch Status</th>
														<th>Received By</th>
														<th>Action</th>
														</tr>
														</thead>

														<tbody class=''>

														";
														if (!empty($getInfo)) {
															foreach ($getInfo as $value) {
																echo "
																<tr>
																<td><a href='#' data-despno = '$value->desp_no' class='bagsList12'>$value->desp_no</a></td>
																<td>";
																$bagno = $value->desp_no;
																$db2 = $this->load->database('otherdb', TRUE);
																$db2->where('despatch_no',$bagno);
																$db2->from("bags");
																echo $db2->count_all_results();
																echo"</td>
																<td>$value->region_from</td>
																<td>$value->branch_from</td>
																<td>$value->region_to</td>
																<td>$value->branch_to</td>
																<td>$value->datetime</td>
																<td>$value->transport_type</td>
																<td>$value->transport_name</td>
																<td>$value->registration_number</td>
																<td>";
																if ($value->despatch_status == 'Sent') {

																	echo "<button class='btn btn-danger btn-sm' type='button' disable>Pending Receive</button>";

																}else {

																	echo "<button class='btn btn-success btn-sm' type='button' disable>Successfully Received</button>";

																}
																echo "</td>
																<td>";
																$id = $value->received_by;
																@$basicinfo = $this->employee_model->GetBasic($id); echo 'PF'.@$basicinfo->em_code.' '. @$basicinfo->first_name.' '.@$basicinfo->last_name;
																echo"</td>";
																echo "<td>";
																if ( $value->despatch_status == 'Sent' ) {
																	echo "<div class='form-check' style='padding-left: 53px;'>
																	<input type='checkbox' name='I' class='form-check-input checkSingle4 checkd' id='remember-me' value='$value->desp_no '>
																	<label class='form-check-label' for='remember-me'></label>";
																}else{
																	echo "<div class='form-check' style='padding-left: 53px;'>

																	<input type='checkbox' class='form-check-input checkSingle4' id='remember-me' checked='checked' disabled='disabled'>
																	<label class='form-check-label' for='remember-me'></label>

																	</div>";
																}
																echo"</td>
																</tr>
																";
															}

														} else {
															echo "<tr>
															<td colspan='11'>No data available in table</td>
															</tr>";
														}
														echo "</tbody>
														</table>
														<br><br>
														<table class='table' style='width: 100%;'>
														<tr><td colspan='11'></td><td style='float: right;'><button type='submit' class='btn btn-info'>Receive Bag</button></td></tr>
														</table>
														<script type='text/javascript'>
														$('.fromServer2').DataTable( {
															retrieve:true,
															order: [[4,'desc' ]],
															fixedHeader: false,
															dom: 'Bfrtip',
															buttons: [
															'copy', 'csv', 'excel', 'pdf', 'print'
															]
															} );
															</script>

															";
														}
														else{
															redirect(base_url());
														}
													}
													public function Credit_Customer(){
														if ($this->session->userdata('user_login_access') != false){
															$id = $this->session->userdata('user_login_id');
											 $pcum_id = base64_decode($this->input->get('I'));  //pcum_idsdsds
											 $data['basic'] = $this->employee_model->GetBasic($id);
											// $data['credit'] = $this->Box_Application_model->get_credit_customer();
											 $data['credit'] = $this->Pcum_model->get_pcum_bill_cust_details_info($pcum_id);
											 $this->load->view('pcum/bill-customer-register-form',$data);
											}
											else{
												redirect(base_url());
											}
										}
										public function Credit_Customer_List(){
											if ($this->session->userdata('user_login_access') != false){
												$data['emslist'] = $this->Box_Application_model->get_credit_customer_list();
												$this->load->view('ems/credit_customer_list',$data);
											}
											else{
												redirect(base_url());
											}

										}
										public function Credit_Customer_Prepare_Bill(){
											if ($this->session->userdata('user_login_access') != false){

												$I = base64_decode($this->input->get('I'));
												$data['askfor'] = $askfor = $this->input->get('AskFor');
												$month = 	$this->input->post('datetime');
												$date = 	$this->input->post('date');	
												$info = $this->Box_Application_model->get_customer_infos($I);
												$acc_no = $info->acc_no;
												$data['acc_no'] = $acc_no;
												if(!empty($date)){
													$data['date'] = $date;
													$data['month'] = $month;
												}else{$data['month'] = $month;$data['date'] = $date;}


												$data['credit_id'] = $I;
												$type   = $info->customer_type;
												$data['type1'] = $info->customer_type;
												$data['tinnumber'] = $info->tin_number;
												$data['emslist'] = $this->Box_Application_model->get_credit_customer_list_byAccnoMonth($acc_no,$month,$date);
												$data['sum'] = $this->Box_Application_model->get_credit_customer_sum_byAccnoMonth($acc_no,$month,$date);
												$this->load->view('inlandMails/bill_customer_list',$data);
											}
											else{
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

												$id = $this->session->userdata('user_login_id');
												$info = $this->employee_model->GetBasic($id);
												$operator = $info->em_id;
												$o_region = $info->em_region;
												$o_branch = $info->em_branch;
												$branch   = $this->input->post('branch');
												$category_type = $this->input->post('category_type');
	//$region   = $this->input->post('branch');

												if ($paytype == "PostPaid") {

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
					// if ($basic->em_region == "Dar es Salaam" && $basic->em_branch == "Post Head Office") {

													for ($i=0; $i <sizeof(@$branch) ; $i++)
													{
														$bra =  $branch[$i];
														$getregion = $this->employee_model->getRegion($bra);
														foreach ($getregion as $value) {


														}
														$data = array();
														$data = array('acc_no'=>$accnumber,'customer_name'=>$name,'customer_type'=>$paytype,'services_type'=>$service,'customer_region'=>$value->region_name,'customer_branch'=>$bra,'created_by'=>$operator,'cust_mobile'=>$mobile,'customer_address'=>$address,'category_type'=>$category_type,'price'=>$price);
														$this->Box_Application_model->Save_Customer_Info($data);

													}


													$data = array();
													$data = array('acc_no'=>$accnumber,'customer_name'=>$name,'customer_type'=>$paytype,'services_type'=>$service,'customer_region'=>$o_region,'customer_branch'=>$o_branch,'created_by'=>$operator,'cust_mobile'=>$mobile,'customer_address'=>$address,'category_type'=>$category_type,'price'=>$price);
													$this->Box_Application_model->Save_Customer_Info($data);

													echo "Successfully Customer Saved";
					// } else {
					// 	$data = array();
					// 	$data = array('acc_no'=>$accnumber,'customer_name'=>$name,'customer_type'=>$paytype,'services_type'=>$service,'customer_region'=>$o_region,'customer_branch'=>$o_branch,'created_by'=>$operator,'cust_mobile'=>$mobile,'tin_number'=>$tinnumber,'customer_address'=>$address,'category_type'=>'Regional','price'=>$price);
					// }
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

					// if ($basic->em_region == "Dar es Salaam" && $basic->em_branch == "Post Head Office") {

													for ($i=0; $i <sizeof(@$branch) ; $i++)
													{
														$bra =  $branch[$i];
														$getregion = $this->employee_model->getRegion($bra);
														foreach ($getregion as $value) {


														}
														$data = array();
														$data = array('acc_no'=>$accnumber,'customer_name'=>$name,'customer_type'=>$paytype,'services_type'=>$service,'customer_region'=>$value->region_name,'customer_branch'=>$bra,'created_by'=>$operator,'cust_mobile'=>$mobile,'customer_address'=>$address,'category_type'=>$category_type,'price'=>$price);

														$this->Box_Application_model->Save_Customer_Info($data);

													}


													$data = array();
													$data = array('acc_no'=>$accnumber,'customer_name'=>$name,'customer_type'=>$paytype,'services_type'=>$service,'customer_region'=>$o_region,'customer_branch'=>$o_branch,'created_by'=>$operator,'cust_mobile'=>$mobile,'customer_address'=>$address,'category_type'=>$category_type,'price'=>$price);
													$this->Box_Application_model->Save_Customer_Info($data);

													echo "Successfully Customer Saved";

					// } else {

					// 	$data = array();
					//     $data = array('acc_no'=>$accnumber,'customer_name'=>$name,'customer_type'=>$paytype,'services_type'=>$service,'customer_region'=>$o_region,'customer_branch'=>$o_branch,'created_by'=>$operator,'cust_mobile'=>$mobile,'tin_number'=>$tinnumber,'customer_address'=>$address,'category_type'=>'Regional','price'=>$price);
					//     echo "Successfully Customer Saved";
					// }

												}
											}else{
												redirect(base_url());
											}

										}

										public function Send_Action(){
											if ($this->session->userdata('user_login_access') != false)
											{
												$I = $this->input->post('I');
												$emsname   = $this->input->post('emsname');
												$Barcode   = $this->input->post('Barcode');
												$emsCat    = $this->input->post('emscattype');
												$weight    = $this->input->post('weight');
												$r_fname   = $this->input->post('fullname');
												$r_address = $this->input->post('address');
												$r_email   = $this->input->post('email');
												$r_mobile  = $this->input->post('mobile');
												$rec_region = $this->input->post('region');
												$rec_dropp = $this->input->post('branch');
		//$price1 = $this->input->post('price1');
												$vat = $this->input->post('vat');
		//$price2 = $this->input->post('price2');

												if($weight > 10){

													$weight10    = 10;
													$getPrice    = $this->Box_Application_model->ems_cat_price10($emsCat,$weight10);

													$vat       = $getPrice->vat;
													$price     = $getPrice->tariff_price;
													$totalprice10 = $vat + $price;

													$diff   =  $weight - $weight10;

													if ($diff <= 0.5) {

														if ($emsCat == 1) {
															$totalPrice = $totalprice10 + 2300;
														} else {
															$totalPrice = $totalprice10 + 3500;
														}

														$vat = $totalPrice * 0.18;
														$totalPrice = $totalPrice - ($totalPrice * 0.18);


													} else {

														$whole   = floor($diff);
														$decimal = fmod($diff,1);
														if ($decimal == 0) {

															if ($emsCat == 1) {
																$totalPrice = $totalprice10 + ($whole*1000/500)*2300;
															} else {
																$totalPrice = $totalprice10 + ($whole*1000/500)*3500;
															}

														} else {

															if ($decimal <= 0.5) {

																if ($emsCat == 1) {
																	$totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300;
																} else {
																	$totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500;
																}

															} else {

																if ($emsCat == 1) {
																	$totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300+2300;
																} else {
																	$totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500+3500;
																}
															}

														}
														$vat = $totalPrice * 0.18;
														$totalPrice = $totalPrice - ($totalPrice * 0.18);

													}


												}else{

													$price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);

													$vat = @$price->vat;
													$price = @$price->tariff_price;
													$totalPrice = $vat + $price;




												}

												$ids = $this->session->userdata('user_login_id');
												$infos = $this->employee_model->GetBasic($ids);
												$o_regions = $infos->em_region;
												$o_branchs = $infos->em_branch;
												$users = $infos->em_code.'  '.$infos->first_name.' '.$infos->middle_name.' '.$infos->last_name;



												$info = $this->Box_Application_model->get_customer_infos($I);
												$type = $info->acc_no;
												$getSum = $this->Box_Application_model->getSumPostPaid($type);
												$o_region = $info->customer_region;
												$o_branch = $info->customer_branch;
												$source = $this->employee_model->get_code_source($o_regions);
												$dest = $this->employee_model->get_code_dest($rec_region);
												$rondom = substr(date('dHis'), 1);
		$billcode = '4';//bill code in tracking number

		
		$number = $this->getnumber();
		$bagsNo = 'EE'.@$source->reg_code . @$dest->reg_code.$number.'TZ';
		$trackingno =$bagsNo;
		




		$id = $this->session->userdata('user_login_id');
		$i = $this->employee_model->GetBasic($id);
		$acc_no = $info->acc_no;
		if($info->customer_type == "PostPaid"){

			if($info->price < $totalPrice){

				echo 'Umefikia Kiwango Cha mwisho cha Kukopeshwa';

			}else{

				$diff = $info->price - $totalPrice;
				$up = array();
				$up = array('price'=>$diff);
				$this->Box_Application_model->update_price1($up,$acc_no);


				$sender = array();
				$sender = array('ems_type'=>$emsname,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$info->customer_name,'s_address'=>$info->customer_address,'s_email'=>$info->cust_email,'s_mobile'=>$info->cust_mobile,'s_region'=>$o_regions,'s_district'=>$o_branchs,'track_number'=>$trackingno,'s_pay_type'=>$info->customer_type,'bill_cust_acc'=>$info->acc_no,'operator'=>$i->em_id);

				$db2 = $this->load->database('otherdb', TRUE);
				$db2->insert('sender_info',$sender);
				$last_id = $db2->insert_id();


				$receiver = array();
				$receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp);

				$db2->insert('receiver_info',$receiver);

				$serial    = 'EMS'.date("YmdHis");

				$data = array();
				$data = array(

					'serial'=>$serial,
					'paidamount'=>$totalPrice,
					'CustomerID'=>$last_id,
					'Customer_mobile'=>$info->cust_mobile,
					'region'=>$o_regions,
					'district'=>$o_branchs,
					'Barcode'=>strtoupper($Barcode),
					'transactionstatus'=>'POSTED',
					'bill_status'=>'BILLING',
					'paymentFor'=>'EMS',
					'status'=>'Bill',
					'customer_acc'=>$info->acc_no,
					'item_vat'=>$vat,
					'item_price'=>$price

				);

				$this->Box_Application_model->save_transactions($data);
				echo "Successfully Saved";
				redirect(base_url('Bill_Customer/bill_customer_list?AskFor=EMS%20Postage'));


			}


		}else{


			if ($info->price <= 20000) {
				echo "Please Recharge Your Account";
			} else {

				$diff = $info->price - $price1;
				$up = array();
				$up = array('price'=>$diff);
				$this->Box_Application_model->update_price($up,$acc_no);

				$sender = array();
				$sender = array('ems_type'=>$emsname,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$info->customer_name,'s_address'=>$info->customer_address,'s_email'=>$info->cust_email,'s_mobile'=>$info->cust_mobile,'s_region'=>$o_regions,'s_district'=>$o_branchs,'track_number'=>$trackingno,'s_pay_type'=>$info->customer_type,'bill_cust_acc'=>$info->acc_no,'operator'=>$i->em_id);

				$db2 = $this->load->database('otherdb', TRUE);
				$db2->insert('sender_info',$sender);
				$last_id = $db2->insert_id();


				$receiver = array();
				$receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp);

				$db2->insert('receiver_info',$receiver);

				$serial    = 'EMS'.date("YmdHis");
				$data = array();
				$data = array(

					'serial'=>$serial,
					'paidamount'=>$price1,
					'CustomerID'=>$last_id,
					'Customer_mobile'=>$info->cust_mobile,
					'region'=>$o_regions,
					'district'=>$o_branchs,
					'transactionstatus'=>'POSTED',
					'bill_status'=>'BILLING',
					'paymentFor'=>'EMS',
					'status'=>'Bill',
					'customer_acc'=>$acc_no

				);

				$this->Box_Application_model->save_transactions($data);

				$info = $this->employee_model->GetBasic($id);
				$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
				$location= $info->em_region.' - '.$info->em_branch;
				$data = array();
				$data = array('track_no'=>$trackingno,'location'=>$location,'user'=>$user,'event'=>'Counter');

				$this->Box_Application_model->save_location($data);


				echo "Successfully Saved";

				redirect(base_url('Bill_Customer/bill_customer_list?AskFor=EMS%20Postage'));
		# code...
			}
		}


	}
	else{
		redirect(base_url());
	}
}

public function update_bill_amount(){
	if ($this->session->userdata('user_login_access') != false){
		$data['cId'] = base64_decode($this->input->get('I'));
		$this->load->view('ems/update_bill_amount',$data);
	}
	else{
		redirect(base_url());
	}

}

public function update_bill_action(){
	if ($this->session->userdata('user_login_access') != false){

		$amount = $this->input->post('amount');
		$cId = $this->input->post('commid');

		$info = $this->Box_Application_model->get_bill_com_info($cId);
		if (empty($info)) {
			echo "Ivalid Company Entries";
		} else {
			if ($info->customer_type == "Prepaid") {
				$serial    = 'EMS'.date("YmdHis");
				$data = array();
				$data = array(

					'transactiondate'=>date("Y-m-d h:s:i"),
					'serial'=>$serial,
					'paidamount'=>$amount,
					'CustomerID'=>$cId,
					'Customer_mobile'=>$info->cust_mobile,
					'region'=>$info->customer_region,
					'district'=>$info->customer_branch,
					'transactionstatus'=>'POSTED',
					'bill_status'=>'PENDING',
					'paymentFor'=>'EMS',
					'customer_acc'=>$info->acc_no

				);

				$this->Box_Application_model->save_transactions($data);

				$paidamount = $amount;
				$region = $info->customer_region;
				$district = $info->customer_branch;
				$renter   = $info->customer_type;
				$mobile   = $info->cust_mobile;
				$serviceId = 'EMS_POSTAGE';
				$trackno = 12;
				$transaction = $this->getBillGepgBillIdEMS($serial,$paidamount,$district,$region,$mobile,$renter,$serviceId,$trackno);
				@$serial1 = $transaction->billid;

				if (@$transaction->controlno != '') {
			# code...
					$update = array('billid'=>@$transaction->controlno,'bill_status'=>'SUCCESS');
					$this->billing_model->update_transactions($update,$serial1);

					$total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($amount,2);

					$this->Sms_model->send_sms_trick($mobile,$total);
				}


			} else {

			}

		}

	}
	else{
		redirect(base_url());
	}

}

public function received_item_from_out(){
	if ($this->session->userdata('user_login_access') != false){
		$data['emid'] = $this->session->userdata('user_login_id');
		$id = $this->session->userdata('user_login_id');
		$info = $this->Box_Application_model->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		$word1 = 'HPO';
		$word2 = 'GPO';

		if(strpos($o_branch, $word1) !== false || strpos($o_branch, $word2) !== false ){
			$emslists = array();

			$check_employe_region = $this->Box_Application_model->check_employe_region($id);

			if($check_employe_region == false){
				$frombranch = $this->Box_Application_model->get_item_received_from_outside_HPO_Region_list();
				foreach ($frombranch as $key => $value) {

					$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH', $value->Barcode, $value->fullname);

				}
			}
			else{

				$frombranch = $this->Box_Application_model->get_item_received_from_outside_Region_hpo_list();
				foreach ($frombranch as $key => $value) {

					$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH', $value->Barcode, $value->fullname);

				}

			}




 //$emslists[]=$fromcounter;

			$data['emslist1'] = $emslists;


		}
		else{
			$data['emslist1'] = $this->Box_Application_model->get_item_received_from_outside_Region_list();

		}




//$data['emslist1'] = $this->Box_Application_model->get_ems_back_list();
		$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
		$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
		$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
		$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
		$data['ems'] = $this->Box_Application_model->count_ems();
		$data['total'] = $this->Box_Application_model->get_backoffice_sum();

		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['bags'] = $this->Box_Application_model->count_bags();

		$this->load->view('ems/received_item_from_outside',$data);

	}
	else
	{
		redirect(base_url());
	}

}

public function received_item_from_outside_search(){
	if ($this->session->userdata('user_login_access') != false){


		$date = $this->input->post('date');
		$month = $this->input->post('month');   

		$region = $this->input->post('region');
  // $branch = $this->input->post('branch');

   //echo($date);
   //echo($month);

//$data['emslist1'] = $this->Box_Application_model->get_ems_back_list_Search($date,$month);

		$data['emid'] = $this->session->userdata('user_login_id');

		$id = $this->session->userdata('user_login_id');
		$info = $this->Box_Application_model->GetBasic($id);
		$o_region = $info->em_region;
				$o_branch = $info->em_branch;//SUPERVISOR_VIEWMODEL

				$word1 = 'HPO';
				$word2 = 'GPO';

				if(strpos($o_branch, $word1) !== false || strpos($o_branch, $word2) !== false ){
					$emslists = array();

					$check_employe_region = $this->Box_Application_model->check_employe_region($id);

					if($check_employe_region == false){
						$frombranch = $this->Box_Application_model->get_item_received_from_ouside_list_hpo_2search($date,$month,$region);

						foreach ($frombranch as $key => $value) {

							$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH', $value->Barcode, $value->fullname);

						}
					}
					else{

						$frombranch = $this->Box_Application_model->get_item_received_from_ouside_list_hpo_search($date,$month,$region);

						foreach ($frombranch as $key => $value) {

							$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH', $value->Barcode, $value->fullname);

						}

					}


 //$emslists[]=$fromcounter;
 //$emslists[]=$frombranch;

					$data['emslist1'] = $emslists;


				}
				else{
					$data['emslist1'] = $this->Box_Application_model->get_item_received_from_ouside_list_search($date,$month,$region);

				}

//$data['emslist1'] = $this->Box_Application_model->get_ems_back_list_search();

				$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
				$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
				$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
				$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
				$data['ems'] = $this->Box_Application_model->count_ems();
				$data['total'] = $this->Box_Application_model->get_backoffice_sum();

				$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
				$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
				$data['bags'] = $this->Box_Application_model->count_bags();

				$this->load->view('ems/received_item_from_outside',$data);

			}
			else
			{
				redirect(base_url());
			}

		}

		public function received_item_from_outside_search_list(){
			if ($this->session->userdata('user_login_access') != false){


				$date = $this->input->post('date');
				$month = $this->input->post('month');   

				$region = $this->input->post('region');
  // $branch = $this->input->post('branch');

   //echo($date);
   //echo($month);

//$data['emslist1'] = $this->Box_Application_model->get_ems_back_list_Search($date,$month);

				$data['emid'] = $this->session->userdata('user_login_id');

				$id = $this->session->userdata('user_login_id');
				$info = $this->Box_Application_model->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;//SUPERVISOR_VIEWMODEL

				$word1 = 'HPO';
				$word2 = 'GPO';

				if(strpos($o_branch, $word1) !== false || strpos($o_branch, $word2) !== false ){
					$emslists = array();

					$check_employe_region = $this->Box_Application_model->check_employe_region($id);

					if($check_employe_region == false){
						$frombranch = $this->Box_Application_model->get_item_received_from_ouside_list_hpo_2search($date,$month,$region);

						foreach ($frombranch as $key => $value) {

							$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH', $value->Barcode, $value->fullname);

						}
					}
					else{

						$frombranch = $this->Box_Application_model->get_item_received_from_ouside_list_hpo_search($date,$month,$region);

						foreach ($frombranch as $key => $value) {

							$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH', $value->Barcode, $value->fullname);

						}

					}


 //$emslists[]=$fromcounter;
 //$emslists[]=$frombranch;

					$data['emslist1'] = $emslists;


				}
				else{
					$data['emslist1'] = $this->Box_Application_model->get_item_received_from_ouside_list_search($date,$month,$region);

				}

				echo $data;

// $this->load->view('ems/received_item_from_outside',$data);

			}
			else
			{
				redirect(base_url());
			}

		}

		public function Sorted_item_from_out(){
			if ($this->session->userdata('user_login_access') != false){
				$data['emid'] = $this->session->userdata('user_login_id');
				$id = $this->session->userdata('user_login_id');
				$info = $this->Box_Application_model->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				$word1 = 'HPO';
				$word2 = 'GPO';

				if(strpos($o_branch, $word1) !== false || strpos($o_branch, $word2) !== false ){
					$emslists = array();

					$check_employe_region = $this->Box_Application_model->check_employe_region($id);

					if($check_employe_region == false){
						$frombranch = $this->Box_Application_model->get_item_sorted_from_outside_HPO_Region_list();
						foreach ($frombranch as $key => $value) {

							$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH', $value->Barcode, $value->fullname);

						}
					}
					else{

						$frombranch = $this->Box_Application_model->get_item_sorted_from_outside_Region_hpo_list();
						foreach ($frombranch as $key => $value) {

							$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH', $value->Barcode, $value->fullname);

						}

					}




 //$emslists[]=$fromcounter;

					$data['emslist1'] = $emslists;


				}
				else{
					$data['emslist1'] = $this->Box_Application_model->get_item_sorted_from_outside_Region_list();

				}




//$data['emslist1'] = $this->Box_Application_model->get_ems_back_list();
				$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
				$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
				$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
				$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
				$data['ems'] = $this->Box_Application_model->count_ems();
				$data['total'] = $this->Box_Application_model->get_backoffice_sum();

				$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
				$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
				$data['bags'] = $this->Box_Application_model->count_bags();
				$data['emselect'] = $this->employee_model->delivereselect();

				$this->load->view('ems/sorted_item_from_outside',$data);

			}
			else
			{
				redirect(base_url());
			}

		}

		public function Sorted_item_from_outside_search(){
			if ($this->session->userdata('user_login_access') != false){


				$date = $this->input->post('date');
				$month = $this->input->post('month');   

				$region = $this->input->post('region');
  // $branch = $this->input->post('branch');

   //echo($date);
   //echo($month);

//$data['emslist1'] = $this->Box_Application_model->get_ems_back_list_Search($date,$month);

				$data['emid'] = $this->session->userdata('user_login_id');

				$id = $this->session->userdata('user_login_id');
				$info = $this->Box_Application_model->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;//SUPERVISOR_VIEWMODEL

				$word1 = 'HPO';
				$word2 = 'GPO';

				if(strpos($o_branch, $word1) !== false || strpos($o_branch, $word2) !== false ){
					$emslists = array();

					$check_employe_region = $this->Box_Application_model->check_employe_region($id);

					if($check_employe_region == false){
						$frombranch = @$this->Box_Application_model->get_item_sorted_from_ouside_list_hpo_2search($date,$month,$region);

						foreach ($frombranch as $key => $value) {

							$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH', $value->Barcode, $value->fullname);

						}
					}
					else{

						$frombranch = $this->Box_Application_model->get_item_sorted_from_ouside_list_hpo_search($date,$month,$region);

						foreach ($frombranch as $key => $value) {

							$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH', $value->Barcode, $value->fullname);

						}

					}


 //$emslists[]=$fromcounter;
 //$emslists[]=$frombranch;

					$data['emslist1'] = $emslists;


				}
				else{
					$data['emslist1'] = $this->Box_Application_model->get_item_sorted_from_ouside_list_search($date,$month,$region);

				}

//$data['emslist1'] = $this->Box_Application_model->get_ems_back_list_search();

				$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
				$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
				$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
				$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
				$data['ems'] = $this->Box_Application_model->count_ems();
				$data['total'] = $this->Box_Application_model->get_backoffice_sum();

				$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
				$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
				$data['bags'] = $this->Box_Application_model->count_bags();
				$data['emselect'] = $this->employee_model->delivereselect();

				$this->load->view('ems/sorted_item_from_outside',$data);

			}
			else
			{
				redirect(base_url());
			}

		}



		public function received_item_from_counter(){
			if ($this->session->userdata('user_login_access') != false){
				$data['emid'] = $this->session->userdata('user_login_id');
				$id = $this->session->userdata('user_login_id');
				$info = $this->Box_Application_model->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				$word1 = 'HPO';
				$word2 = 'GPO';

				if(strpos($o_branch, $word1) !== false || strpos($o_branch, $word2) !== false ){
					$emslists = array();

					$check_employe_region = $this->Box_Application_model->check_employe_region($id);

					if($check_employe_region == false){

		$fromcounter = $this->Box_Application_model->get_item_received_list(); //LIST FROM COUNTER
		foreach ($fromcounter as $key => $value) {

			$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'COUNTER', $value->Barcode, $value->fullname);

		}
		$frombranch = $this->Box_Application_model->get_item_received_from_branch_list();
		foreach ($frombranch as $key => $value) {

			$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH', $value->Barcode, $value->fullname);

		}

	}else{  

		$fromcounter = $this->Box_Application_model->get_item_received_HPO_from_counter_list(); //LIST FROM COUNTER
		foreach ($fromcounter as $key => $value) {

			$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH', $value->Barcode, $value->fullname);

		}

	$fromBranch = $this->Box_Application_model->get_item_received_HPO_from_branch_list(); //LIST FROM COUNTER
	foreach ($fromBranch as $key => $value) {

		$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH', $value->Barcode, $value->fullname);

	}





}


 //$emslists[]=$fromcounter;

$data['emslist1'] = $emslists;


}
else{
	$data['emslist1'] = $this->Box_Application_model->get_item_received_list();

}




//$data['emslist1'] = $this->Box_Application_model->get_ems_back_list();
$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
$data['ems'] = $this->Box_Application_model->count_ems();
$data['total'] = $this->Box_Application_model->get_backoffice_sum();

$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
$data['bags'] = $this->Box_Application_model->count_bags();
$data['emselect'] = $this->employee_model->delivereselect();

$this->load->view('ems/received_item_from_counter',$data);

}
else
{
	redirect(base_url());
}

}



public function received_item_from_counter_search(){
	if ($this->session->userdata('user_login_access') != false){


		$date = $this->input->post('date');
		$month = $this->input->post('month');   

		$region = $this->input->post('region');
  // $branch = $this->input->post('branch');

   //echo($date);
   //echo($month);

//$data['emslist1'] = $this->Box_Application_model->get_ems_back_list_Search($date,$month);

		$data['emid'] = $this->session->userdata('user_login_id');

		$id = $this->session->userdata('user_login_id');
		$info = $this->Box_Application_model->GetBasic($id);
		$o_region = $info->em_region;
				$o_branch = $info->em_branch;//SUPERVISOR_VIEWMODEL

				$word1 = 'HPO';
				$word2 = 'GPO';

				if(strpos($o_branch, $word1) !== false || strpos($o_branch, $word2) !== false ){
					$emslists = array();

					$check_employe_region = $this->Box_Application_model->check_employe_region($id);

					if($check_employe_region == false){

$fromcounter = $this->Box_Application_model->get_item_received_list_search($date,$month,$region); //LIST FROM COUNTER
foreach ($fromcounter as $key => $value) {

	$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'COUNTER',$value->Barcode, $value->fullname);

}
$frombranch = $this->Box_Application_model->get_item_received_branch_list_search($date,$month,$region);

foreach ($frombranch as $key => $value) {

	$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH',$value->Barcode, $value->fullname);

}
}else{
	$fromcounterandBranch = $this->Box_Application_model->get_item_received_HPO_list_Search($date,$month,$region); //LIST FROM COUNTER
	foreach ($fromcounterandBranch as $key => $value) {

		$emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH',$value->Barcode, $value->fullname);

	}

}

 //$emslists[]=$fromcounter;
 //$emslists[]=$frombranch;

$data['emslist1'] = $emslists;


}
else{
	$data['emslist1'] = $this->Box_Application_model->get_item_received_list_search($date,$month,$region);

}

//$data['emslist1'] = $this->Box_Application_model->get_ems_back_list_search();

$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
$data['ems'] = $this->Box_Application_model->count_ems();
$data['total'] = $this->Box_Application_model->get_backoffice_sum();

$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
$data['bags'] = $this->Box_Application_model->count_bags();
$data['emselect'] = $this->employee_model->delivereselect();

$this->load->view('ems/received_item_from_counter',$data);

}
else
{
	redirect(base_url());
}

}

public function items_transfered(){
	if ($this->session->userdata('user_login_access') != false){
		$data['emid'] = $this->session->userdata('user_login_id');
		$data['emslist1'] = $this->Box_Application_model->get_ems_back_list();
		$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
		$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
		$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
		$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
		$data['ems'] = $this->Box_Application_model->count_ems();
		$data['total'] = $this->Box_Application_model->get_backoffice_sum();
		$data['emslist1'] = $this->Box_Application_model->get_item_received_list();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$data['bags'] = $this->Box_Application_model->count_bags();

		$this->load->view('ems/items_transfered',$data);

	}
	else
	{
		redirect(base_url());
	}

}





public function pending_item_from_counter(){

	if ($this->session->userdata('user_login_access') != false){

		$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
		$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
		$data['emslist1'] = $this->Box_Application_model->get_ems_back_list_pending();
		$data['ems'] = $this->Box_Application_model->count_ems();
		$data['bags'] = $this->Box_Application_model->count_bags();
		$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
		$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
		$this->load->view('ems/pending_item_from_counter',$data);

	}
	else{
		redirect(base_url());
	}

}

public function EndShift(){

	if ($this->session->userdata('user_login_access') != false){


		$emid = $this->input->post('emid');
		$id = $emid;
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		$id = $emid;

		$getCounter = $this->Box_Application_model->get_counter_byEmId($id);
		$cId = $getCounter->counter_id;
		$getPending = $this->Box_Application_model->get_pending_task($emid);
		$check = $this->Box_Application_model->getEndingDate($emid,$date);
		if (!empty($check)) {

			echo "Day already Ended";
		}

		if (!empty($getPending)) {

			$update = array();
			$update = array('assign_status'=>'NotEnded','date_assign'=>$date);
			$this->employee_model->Update_Jobassign($update,$emid);

			echo "Shift Not Ended,You Have Pending Item";

		} else {

			$csup = array();
			$csup = array('c_status'=>'NotAssign');
			$this->employee_model->Update_Counters($csup,$cId);

			$this->Box_Application_model->delete_servc_emp($id);
			$data = array();
			$data = array('supervisee_name'=>$emid,'sup_status'=>'ShiftEnd');
			$this->Box_Application_model->Save_SupervisorJob($data);

			$update = array();
			$update = array('assign_status'=>'ShiftEnd','date_assign'=>$date);
			$this->employee_model->Update_Jobassign($update,$emid);

			echo "Successfully Shift Ended";

		}


	}
	else{
		redirect(base_url());
	}

}
public function Get_Bill_Report(){

	if ($this->session->userdata('user_login_access') != false){

		$acc_no = $this->input->post('acc_no');
		$date_time = $this->input->post('date_time');
		$monthyr = $this->input->post('month');
		$type = $this->input->post('type');
		$tinnumber = $this->input->post('tinnumber');
		$date = explode('-', $monthyr);

		$month = @$date[0];
		$year  = @$date[1];

		if (empty($monthyr)) {

			$getInfo    = $this->Box_Application_model->getBillInformation($acc_no,$date_time,$type);
			$available = $date_time;
			$getSumVat   = $this->Box_Application_model->getSumVat($acc_no,$date_time,$type);
			$getSumPrice = $this->Box_Application_model->getSumPrice($acc_no,$date_time,$type);
			$getSumTotal = $this->Box_Application_model->getSumPriceTotal($acc_no,$date_time,$type);
			$checkIf     = $this->Box_Application_model->getControNumber($acc_no,$date_time);

		} else {

			$getInfo    = $this->Box_Application_model->getBillInformationMonth($acc_no,$month,$type,$year);
			$available  = $monthyr;
			$getSumVat   = $this->Box_Application_model->getSumVatMonth($acc_no,$type,$month,$year);
			$getSumPrice = $this->Box_Application_model->getSumPriceMonth($acc_no,$type,$month,$year);
			$getSumTotal = $this->Box_Application_model->getSumPriceTotalMonth($acc_no,$type,$month,$year);
			$checkIf     = $this->Box_Application_model->getControNumberMonth($acc_no,$month,$year);

		}

		$Info    = $this->Box_Application_model->getCustomerInformation($acc_no);


		if (empty($getInfo)) {
			echo
			"<br><br><table class='table table-bordered table-striped' style='widith:100%;'>
			<thead>
			<tr>
			<th>Tracking Number</th>
			<th>Receiver Name</th>
			<th>Region Origin</th>
			<th>Destination</th>
			<th>Registered Date</th>
			<th>Item Weight</th>
			<th>Price (Tsh.)</th>
			<th>Vat (Tsh.)</th>
			<th>Total (Tsh.)</th>
			</tr></thead><tbody>";
			echo "</td>
			</tr>
			<tr>
			<td colspan='9' style='color:red;text-align:center;'>No Information Yet</td>
			</tr>
			</tbody>
			</table>";

		} else {

			echo
			"<table class='table' style='widith:100%;'>
			<tr>
			<td style='text-align:center;'><img src='".base_url()."assets/images/TPC.png' width='100' height='100'></td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td style='padding-right:20px;text-align:center;'>
			<h2>TANZANIA POSTS CORPORATION</h2>
			<h3>Invoice Details for the period of   "  .$available.  "    To   " .$available."</h3>
			</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			</tr>";
			"</table>";
			echo
			"<table class='table table-bordered table-striped' style='widith:100%;'>
			<tr>
			<td><b>Account Address  &nbsp;&nbsp;&nbsp;&nbsp; ::&nbsp;&nbsp;".$Info->customer_address."</b></td>
			<td>Credit Limit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;::&nbsp;&nbsp;".number_format($Info->price,2)."Tsh.</td>
			</tr>
			<tr>
			<td><b>Customer Name  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ::&nbsp;&nbsp;".$Info->customer_name." [ ".$acc_no." ]</b></td>
			<td>Available Credit as on[".$available."]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;::&nbsp;&nbsp;".number_format($getSumTotal->paidamount,2)." Tsh.</td>
			</tr>
			<tr>
			<td><b>Customer Type  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ::&nbsp;&nbsp;".$type."&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
			&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
			&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
			&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
			&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
			&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
			&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
			&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
			&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp</b></td>
			<td>Un Adjasted Payments &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
			&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;:: &nbsp;&nbsp;0.00 Tsh. </td>
			</tr>
			<tr>
			<td><b>Customer Service  &nbsp;&nbsp;&nbsp;&nbsp; ::&nbsp;&nbsp;EMS</b></td>
			<td>Bill For The Period &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;::&nbsp;&nbsp;&nbsp;".$available.  "
			To   " .$available."</td>
			</tr>";

			"</table>";
			echo
			"<br><br><table class='table table-bordered table-striped' style='widith:100%;'>
			<thead>
			<tr>
			<th>Tracking Number</th>
			<th>Receiver Name</th>
			<th>Region Origin</th>
			<th>Destination</th>
			<th>Registered Date</th>
			<th>Item Weight</th>
			<th>Price (Tsh.)</th>
			<th>Vat (Tsh.)</th>
			<th>Total (Tsh.)</th>
			</tr></thead><tbody>";
			foreach ($getInfo as $value) {
				echo "<tr>
				<td>
				$value->track_number
				</td>
				<td>$value->fullname</td>
				<td>$value->r_region</td>
				<td>$value->s_district</td>
				<td>$value->date_registered</td>
				<td style='text-align:center;'>$value->weight</td>
				<td>".number_format($value->item_price,2)."</td>
				<td>".number_format($value->item_vat,2)."</td>
				<td>".number_format($value->paidamount,2)."</td>
				</tr>";
			}
			echo "<tr class='well'>
			<td colspan='5'></td>
			<td><b>Total ::</b></td>
			<td><b>".number_format($getSumPrice->item_price,2)."</b></td>
			<td><b>".number_format($getSumVat->item_vat,2)."</b></td>
			<td><b>".number_format($getSumTotal->paidamount,2)."</b></td>
			</tr>";
			echo "<tr class='well'>
			<td colspan='8'>";
			if (empty($checkIf)) {
				echo "<b>Control Number ::: </b> <span class='resultr'></span>";
			} else {
				echo "<b>Please Pay your bill through this control number :: </b>";
			}
			echo  "</td>";
			echo "<td>";
			if (empty($checkIf)) {
				echo "<button class='form-control btn btn-info cnumber' style='color:white;'>Issue Bill For Payment</button>";
			} else {
				if ($checkIf->status == "NotPaid" && $checkIf->billid != '') {
					echo "<b>". $checkIf->billid ."</b>";
				} else {
					echo "<button class='form-control btn btn-success' style='color:white;'>Bill Already Paid</button>";
				}
			}

			echo "</td>
			</tr></tbody></table>
			<input type='hidden' value='$acc_no' class='acc_no'>
			<input type='hidden' value='$getSumTotal->paidamount' class='total'>
			<input type='hidden' value='$date_time' class='date_time'>
			<input type='hidden' value='$monthyr' class='monthly'>
			<input type='hidden' value='$type' class='type'>

			<script>
			$(document).ready(function() {

				$('.cnumber').on('click', function(event) {

					event.preventDefault();

					var acc_no    = $('.acc_no').val();
					var total     = $('.total').val();
					var datetime = $('.date_time').val();
					var type      = $('.type').val();
					var monthly   = $('.monthly').val();

					$.ajax({
						type: 'POST',
						url: 'Generate_Control_Number',
						data:'date_time='+ datetime + '&acc_no='+ acc_no + '&type='+ type + '&total='+ total + '&monthly='+ monthly,
						success: function(response) {
							$('.resultr').html(response);
						}
						});
						});
						});
						</script>";
					}
				}
				else{
					redirect(base_url());
				}

			}

			public function Generate_Control_Number(){

				if ($this->session->userdata('user_login_access') != false){

					$acc_no = $this->input->post('acc_no');
					$date_time = $this->input->post('date_time');
					$type = $this->input->post('type');
					$total = $this->input->post('total');
					$monthly = $this->input->post('monthly');

					$date = explode('-', $monthly);

					$month = @$date[0];
					$year  = @$date[1];

					if (empty($monthly)) {
						$getInfo    = $this->Box_Application_model->getBillInformation($acc_no,$date_time,$type);
					} else {
						$getInfo    = $this->Box_Application_model->getBillInformationMonth($acc_no,$month,$type,$year);
					}



					$info = $this->Box_Application_model->get_customer_infos_new($acc_no);

					$o_region = $info->customer_region;
					$rec_region = $info->customer_branch;

					$source = $this->employee_model->get_code_source($o_region);
					$dest = $this->employee_model->get_code_dest($rec_region);

					$bagsNo = @$source->reg_code . @$dest->reg_code;
					$serial = 'EMS'.date("YmdHis").$source->reg_code;

					$data = array();
					$data = array(

		//'transactiondate'=>$date_time,
						'serial'=>$serial,
						'paidamount'=>$total,
						'CustomerID'=>$info->credit_id,
						'Customer_mobile'=>$info->cust_mobile,
						'region'=>$info->customer_region,
						'district'=>$info->customer_branch,
						'transactionstatus'=>'POSTED',
						'bill_status'=>'PENDING',
						'paymentFor'=>'EMSBILLING',
						'customer_acc'=>$acc_no

					);

					$this->Box_Application_model->save_transactions($data);

					$paidamount = $total;
					$district   = $info->customer_branch;
					$region     = $info->customer_region;
					$mobile     = $info->cust_mobile;
					$renter     = 'EmsBilling';
					$serviceId  = 'EMS_POSTAGE';
					$trackno    = 6;

					$transaction = $this->getBillGepgBillIdEMS($serial,$paidamount,$district,$region,$mobile,$renter,$serviceId,$trackno);
					@$serial1 = $transaction->billid;

					$update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
					$this->Box_Application_model->update_transactions($update,$serial1);

					if ($transaction->controlno == '') {

					} else {

						foreach ($getInfo as $value) {
							$serial2 = $value->id;
							$update = array('isBill_id'=>'Yes');
							$this->Box_Application_model->update_transactions_bill($update,$serial2);
						}

					}
					echo @$transaction->controlno;
				}	else{
					redirect(base_url());
				}

			}
			public function Generate_Control_Number2(){

				if ($this->session->userdata('user_login_access') != false){

					$acc_no = $this->input->post('acc_no');
					$total = $this->input->post('total');

					$info = $this->Box_Application_model->get_customer_infos_new($acc_no);

					$o_region = $info->customer_region;
					$rec_region = $info->customer_branch;

					$source = $this->employee_model->get_code_source($o_region);
					$dest = $this->employee_model->get_code_dest($rec_region);

					$bagsNo = @$source->reg_code . @$dest->reg_code;
					$serial = 'EMS'.date("YmdHis").$source->reg_code;

					$data = array();
					$data = array(

		//'transactiondate'=>$date_time,
						'serial'=>$serial,
						'paidamount'=>$total,
						'CustomerID'=>$info->credit_id,
						'Customer_mobile'=>$info->cust_mobile,
						'region'=>$info->customer_region,
						'district'=>$info->customer_branch,
						'transactionstatus'=>'POSTED',
						'bill_status'=>'PENDING',
						'paymentFor'=>'EMSBILLING',
						'customer_acc'=>$acc_no

					);

					$this->Box_Application_model->save_transactions($data);

					$paidamount = $total;
					$district   = $info->customer_branch;
					$region     = $info->customer_region;
					$mobile     = $info->cust_mobile;
					$renter     = 'EmsBilling';
					$serviceId  = 'EMS_POSTAGE';
					$trackno    = 6;

					$transaction = $this->getBillGepgBillIdEMS($serial,$paidamount,$district,$region,$mobile,$renter,$serviceId,$trackno);
					@$serial1 = $transaction->billid;


				}else{
					redirect(base_url());
				}
			}

			public function GetBoxes()
			{
        #Redirect to Admin dashboard after authentication
				if ($this->session->userdata('user_login_access') == 1)
				{

					$serial = $this->input->post('serial');
					$list = $this->Box_Application_model->get_Bulk_Boxes_list($serial);

					$items = array();
					foreach ($list as $key => $value) {
          	# code...
						array_push($items, $value->amount);

					}
					$total = array_sum($items);



					if (empty($list)) {
						echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
						<tr><th>Branch Name</th><th>Box Number </th><th>Amount (Tsh.)</th></tr>
						<tr><td colspan='3'>No Boxes available</td></tr>
						</table>";

					}else{
            	//echo json_encode($list);
						echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
						<tr><th>Branch Name</th><th>Box Number </th><th>Amount (Tsh.)</th></tr>";
						$rows ="";

						foreach ($list as $value) {

							$rows1 = "<tr><td>".$value->Box_name."</td><td>".$value->Box_number."</td><td>".$value->amount."</td></tr>";

							$rows =$rows.$rows1;
						}
						echo $rows;

						echo  "<tr><td></td><td></td><td></td></tr>
						<tr><td></td><td><b>Total:</b></td><td>".number_format($total,2)."</td></tr>
						</table> ";


					}
				}

			}

			public function Getprices()
			{
        #Redirect to Admin dashboard after authentication
				if ($this->session->userdata('user_login_access') == 1)
				{

					$tariffCat = $this->input->post('tariffCat');
					$price = $this->Box_Application_model->get_box_renter_price($tariffCat);
					$vat = round($price->price * 0.18,0);




					if (empty($price)) {
						echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
						<tr><th colspan='2'>Charges</th></tr>
						<tr><td><b>Price:</b></td><td>0</td></tr>
						<tr><td><b>Total Price:</b></td><td>0</td></tr>
						</table>";

					}else{


						$emsprice = $price->price + $vat;

						echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
						<tr><th>Description</th><th>Amount (Tsh.)</th></tr>
						<tr><td><b>Tariff:</b></td><td>".number_format($price->price,2)."</td></tr>
						<tr><td><b>Vat:</b></td><td>".number_format($vat,2)."</td></tr>
						<tr><td><b>Total Price:</b></td><td>".number_format($emsprice,2)."</td></tr>
						</table>
						<input type='hidden' name ='price1' value='$emsprice' class='price1'>
						";
					}
				}

			}

			public function Getprices1()
			{
        #Redirect to Admin dashboard after authentication
				if ($this->session->userdata('user_login_access') == 1)
				{

					$tariffCat = $this->input->post('tariffCat');
					$price = $this->Box_Application_model->get_box_renter_price($tariffCat);
					$vat =floor($price->price * 0.18) ;




					if (empty($price)) {
						echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
						<tr><th colspan='2'>Charges</th></tr>
						<tr><td><b>Price:</b></td><td>0</td></tr>
						<tr><td><b>Total Price:</b></td><td>0</td></tr>
						</table>";

					}else{


						$emsprice = $price->price + $vat;

						echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
						<tr><th>Description</th><th>Amount (Tsh.)</th></tr>
						<tr><td><b>Tariff:</b></td><td>".number_format($price->price,2)."</td></tr>
						<tr><td><b>Vat:</b></td><td>".number_format($vat,2)."</td></tr>
						<tr><td><b>Total Price:</b></td><td>".number_format($emsprice,2)."</td></tr>
						</table>
						<input type='hidden' name ='price1' value='$emsprice' class='price1'>
						";
					}
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

					redirect('https://smartposta.posta.co.tz/app/sso_auth?email='.$email.'&officeid='.$getBrId->branch_id.'&role='.$role);

				}else{
					redirect(base_url());
				}
			}


			public function invoice_sheet_last(){

				$acc_no = base64_decode($this->input->get('acc_no'));
				$month = $this->input->get('month');
				$data['cno'] = $controlno = $this->input->get('billid');
				$data['invoice'] = $this->input->get('invoiceno');

				$data['custinfo'] = $this->Box_Application_model->get_bill_cust_details($acc_no);
				$data['emslist'] = $this->Box_Application_model->get_credit_customer_list_byAccnoMonth2($acc_no,$month);
				$data['sum'] = $this->Box_Application_model->get_credit_customer_sum_byAccnoMonth2($acc_no,$month);

				$sign = array('controlno'=>$controlno,'idtype'=>'1','custid'=>@$data['custinfo']->tin_number,'custname'=>@$data['custinfo']->customer_name,'msisdn'=>@$data['custinfo']->cust_mobile,'service'=>'EFD');
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
			$html= $this->load->view('billing/invoice_sheet',$data,TRUE);
               // $html=$this->load->view('billing/invoice_sheet_test');
              // $this->load->library('Pdf');
			$this->dompdf->loadHtml($html);
			$this->dompdf->setPaper('A4','potrait');
			$this->dompdf->render();
			$this->dompdf->stream($acc_no, array("Attachment"=>0));

		}

		public function invoice_sheet_postaglobal(){

			$acc_no = $this->input->get('cun');
//$month = $this->input->get('month');
			$data['cno'] = $controlno = $this->input->get('cn');
			$data['invoice'] = $this->input->get('invoiceno');
			$data['invoiced'] = $this->input->get('invoiced');
			$data['amount'] = $this->input->get('amount');

			$data['custinfo'] =$custinfo= $this->Box_Application_model->get_bill_customer_details($acc_no);
//$data['emslist'] = $this->Box_Application_model->get_credit_customer_list_byAccnoMonth2($acc_no,$month);
//$data['sum'] = $this->Box_Application_model->get_credit_customer_sum_byAccnoMonth2($acc_no,$month);
			if(@$data['custinfo']->com_region =="Zanzibar"){$service="ZRB";}else{$service="EFD";}

			$sign = array('controlno'=>$controlno,'idtype'=>'1','custid'=>@$data['custinfo']->tin_number,'custname'=>@$data['custinfo']->com_name,'msisdn'=>@$data['custinfo']->com_phone,'service'=>$service);
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

			if(@$data['custinfo']->com_region =="Zanzibar"){
				$params['data'] = $signature->desc;
			}else{$params['data'] = 'https://verify.tra.go.tz/'.$signature->desc; }
			
			
			$params['level'] = 'H'; 
			$params['size'] = 10;
			$params['savename'] = FCPATH.$config['imagedir'].$image_name; 
			$this->ciqrcode->generate($params);

			//$html=$this->load->view('billing/invoice_sheet',$data);

			$this->load->library('Pdf');
               $html= "";//$this->load->view('billing/invoice_sheet_posta_global',$data,TRUE);
               if(@$data['custinfo']->com_region =="Zanzibar"){
               	$html= $this->load->view('billing/invoice_sheet_posta_global_znz',$data,TRUE);
               }else{ $html= $this->load->view('billing/invoice_sheet_posta_global',$data,TRUE);}
               // $html=$this->load->view('billing/invoice_sheet_test');
              // $this->load->library('Pdf');
               $this->dompdf->loadHtml($html);
               $this->dompdf->setPaper('A4','potrait');
               $this->dompdf->render();
               $this->dompdf->stream($acc_no, array("Attachment"=>0));

           }

           public function mails_invoice_sheet_postaglobal(){

           	$acc_no = $this->input->get('cun');
//$month = $this->input->get('month');
           	$data['cno'] = $controlno = $this->input->get('cn');
           	$data['invoice'] = $this->input->get('invoiceno');
           	$data['invoiced'] = $this->input->get('invoiced');
           	$data['amount'] = $this->input->get('amount');

           	$data['custinfo'] = $this->Box_Application_model->get_mails_bill_customer_details($acc_no);
//$data['emslist'] = $this->Box_Application_model->get_credit_customer_list_byAccnoMonth2($acc_no,$month);
//$data['sum'] = $this->Box_Application_model->get_credit_customer_sum_byAccnoMonth2($acc_no,$month);
           	if(@$data['custinfo']->com_region =="Zanzibar"){$service="ZRB";}else{$service="EFD";}
           	$sign = array('controlno'=>$controlno,'idtype'=>'1','custid'=>@$data['custinfo']->tin_number,'custname'=>@$data['custinfo']->com_name,'msisdn'=>@$data['custinfo']->com_phone,'service'=>$service);
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
			if(@$data['custinfo']->com_region =="Zanzibar"){
				$params['data'] = $signature->desc;
			}else{$params['data'] = 'https://verify.tra.go.tz/'.$signature->desc; }

			$params['level'] = 'H'; 
			$params['size'] = 10;
			$params['savename'] = FCPATH.$config['imagedir'].$image_name; 
			$this->ciqrcode->generate($params);

			//$this->load->view('billing/invoice_sheet',$data);

			$this->load->library('Pdf');
               $html= "";//$this->load->view('billing/mails_invoice_sheet_posta_global.php',$data,TRUE);

               if(@$data['custinfo']->com_region =="Zanzibar"){
               	$html= $this->load->view('billing/mails_invoice_sheet_posta_global_znz',$data,TRUE);
               }else{ $html= $this->load->view('billing/mails_invoice_sheet_posta_global',$data,TRUE);}

               $this->load->library('Pdf');
               $this->dompdf->loadHtml($html);
               $this->dompdf->setPaper('A4','potrait');
               $this->dompdf->render();
               $this->dompdf->stream($acc_no, array("Attachment"=>0));

           }


           public function invoice_sheet()
           {
           	if ($this->session->userdata('user_login_access') != false)
           	{
//$data['id'] = base64_decode($this->input->get('I'));
           		echo $acc_no = base64_decode($this->input->get('acc_no'));
           		$data['month'] = $month = $this->input->get('month');
//$cun = $this->input->get('cun');

           		$data['custinfo'] = $this->Box_Application_model->get_bill_cust_details($acc_no);
           		$data['emslist'] = $this->Box_Application_model->get_credit_customer_list_byAccnoMonth($acc_no,$month);
           		$data['sum'] = $this->Box_Application_model->get_credit_customer_sum_byAccnoMonth($acc_no,$month);
           		$data['invoice'] = rand(10000,20000);


           		foreach ($data['emslist'] as $value) {
           			$id = $value->id;
           			$update1 = array();
           			$update1 = array('isBill_Id'=>'Ye');
           			$this->billing_model->update_transactionsere($update1,$id);
           		}
           		$paidamountinclusive =  $data['sum']->paidamount;
           		$paidamountvat = ($data['sum']->paidamount*0.18);
           		$paidamountExclusive =$data['sum']->paidamount - ($data['sum']->paidamount*0.18) ;
           		$paidamount = $data['sum']->paidamount;
           		$credit_id = $data['custinfo']->credit_id;
           		$sender_branch = $this->session->userdata('user_branch');
           		$sender_region = $this->session->userdata('user_region');
           		$s_mobile = $data['custinfo']->cust_mobile;

           		$serial1 = $serial = "Ems_billing".date("YmdHis").$this->session->userdata('user_emid');


           		$renter   = 'Ems Postage';
           		$serviceId = 'EMS_POSTAGE';
           		$trackno = '009';
           		$postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);


           		$sign = array('controlno'=>$postbill->controlno,'idtype'=>'1','custid'=>$data['custinfo']->tin_number,'custname'=>$data['custinfo']->customer_name,'msisdn'=>$data['custinfo']->cust_mobile,'service'=>'EFD');
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



		$trans = array();
		$trans = array(

			'serial'=>$serial,
			'paidamount'=>$paidamount,
			'CustomerID'=>$credit_id,
			'transactionstatus'=>'POSTED',
			'bill_status'=>'PENDING',
			'customer_acc'=>$acc_no,
			'PaymentFor'=>$data['custinfo']->customer_name,
			'invoice_number'=>rand(10000,20000),
			'invoice_month'=>$month
		);

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('transactions',$trans);

		$update = array();
		$update = array('billid'=>@$postbill->controlno,'bill_status'=>'SUCCESS');
		$this->billing_model->update_transactions($update,$serial1);
		$data['cno'] = $controlno = @$postbill->controlno;

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
			$html= $this->load->view('billing/invoice_sheet',$data,TRUE);
			$this->load->library('Pdf');
			$this->dompdf->loadHtml($html);
			$this->dompdf->setPaper('A4','potrait');
			$this->dompdf->render();
			$this->dompdf->stream($acc_no, array("Attachment"=>0));

		}
		else{
			redirect(base_url());
		}
	}


	public function invoice_sheet_ems()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
//$data['id'] = base64_decode($this->input->get('I'));
			echo $acc_no = base64_decode($this->input->get('acc_no'));
			$data['month'] = $month = $this->input->get('month');
			$data['date'] = $date = $this->input->get('date');
//$cun = $this->input->get('cun');

			$data['custinfo'] = $this->Box_Application_model->get_bill_cust_details($acc_no);
			$data['extracustinfo'] = $this->Box_Application_model->extra_get_bill_cust_details($acc_no);
			$data['emslist'] = $list=$this->Bill_Customer_model->get_credit_customer_list_byAccnoMonth($acc_no,$month,$date);
			$data['sum'] = $this->Bill_Customer_model->get_credit_customer_sum_byAccnoMonth($acc_no,$month,$date);
			$data['invoice'] = rand(10000,20000);


			foreach ($data['emslist'] as $value) {
				$id = $value->id;
				$update1 = array();
				$update1 = array('isBill_Id'=>'Ye');
				$this->billing_model->update_transactionsere($update1,$id);
			}
			$paidamountinclusive =  $data['sum']->paidamount;
			$paidamountvat = ($data['sum']->paidamount*0.18);
			$paidamountExclusive =$data['sum']->paidamount - ($data['sum']->paidamount*0.18) ;
			$paidamount = $data['sum']->paidamount;
			$credit_id = $data['custinfo']->credit_id;
			$sender_branch = $this->session->userdata('user_branch');
			$sender_region = $this->session->userdata('user_region');
			$s_mobile = $data['custinfo']->cust_mobile;

// $this->load->view('billing/customer_ems_report',$data);

			$this->load->library('Pdf');
			$html= $this->load->view('billing/customer_ems_report',$data,TRUE);
 //$this->load->library('Pdf');
			$this->dompdf->loadHtml($html);
 // if(count($list) < 10){
 //       $this->dompdf->setPaper('A4','potrait');
 // }else{ $this->dompdf->setPaper('A4','landscape');}

			$this->dompdf->setPaper('A4','potrait');


			$this->dompdf->render();
			ob_end_clean();
			$this->dompdf->stream($acc_no, array("Attachment"=>0));

		}
		else{
			redirect(base_url());
		}
	}


	public function Mail_invoice_sheet()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
//$data['id'] = base64_decode($this->input->get('I'));
			echo $acc_no = base64_decode($this->input->get('acc_no'));
			$data['month'] = $month = $this->input->get('month');
//$cun = $this->input->get('cun');

			$data['custinfo'] = $this->Box_Application_model->get_bill_cust_details($acc_no);
			$data['emslist'] = $this->Box_Application_model->get_credit_customer_list_byAccnoMonth($acc_no,$month);
			$data['sum'] = $this->Box_Application_model->get_credit_customer_sum_byAccnoMonth($acc_no,$month);
			$data['invoice'] = rand(10000,20000);


			foreach ($data['emslist'] as $value) {
				$id = $value->id;
				$update1 = array();
				$update1 = array('isBill_Id'=>'Ye');
				$this->billing_model->update_transactionsere($update1,$id);
			}
			$paidamount = ($data['sum']->paidamount*0.18) + $data['sum']->paidamount;
			$credit_id = $data['custinfo']->credit_id;
			$sender_branch = $this->session->userdata('user_branch');
			$sender_region = $this->session->userdata('user_region');
			$s_mobile = $data['custinfo']->cust_mobile;

			$serial1 = $serial = "register_billing".date("YmdHis").$this->session->userdata('user_emid');


			$renter   = 'MAIL Postage';
			$serviceId = 'MAIL';
			$trackno = '009';
			$postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);


			$sign = array('controlno'=>$postbill->controlno,'idtype'=>'1','custid'=>$data['custinfo']->tin_number,'custname'=>$data['custinfo']->customer_name,'msisdn'=>$data['custinfo']->cust_mobile,'service'=>'EFD');
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



		$trans = array();
		$trans = array(

			'serial'=>$serial,
			'paidamount'=>$paidamount,
			'CustomerID'=>$credit_id,
			'transactionstatus'=>'POSTED',
			'bill_status'=>'PENDING',
			'customer_acc'=>$acc_no,
			'PaymentFor'=>'REGISTER BILLING',
			'invoice_number'=>rand(10000,20000),
			'invoice_month'=>$month
		);

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('transactions',$trans);

		$update = array();
		$update = array('billid'=>@$postbill->controlno,'bill_status'=>'SUCCESS');
		$this->billing_model->update_transactions($update,$serial1);
		$data['cno'] = $controlno = @$postbill->controlno;

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
			$html= $this->load->view('billing/invoice_sheet',$data,TRUE);
			$this->load->library('Pdf');
			$this->dompdf->loadHtml($html);
			$this->dompdf->setPaper('A4','potrait');
			$this->dompdf->render();
			$this->dompdf->stream($acc_no, array("Attachment"=>0));

		}
		else{
			redirect(base_url());
		}
	}


	public function Mail_bill_invoice_sheet()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
//$data['id'] = base64_decode($this->input->get('I'));
			echo $acc_no = base64_decode($this->input->get('acc_no'));
			$data['month'] = $month = $this->input->get('month');
			$data['date'] = $date = $this->input->get('date');
//$cun = $this->input->get('cun');

			$data['custinfo'] = $this->Box_Application_model->get_bill_cust_details($acc_no);
//$data['emslist'] = $this->Bill_Customer_model->get_credit_customer_MAIL_list_byAccnoMonth($acc_no,$month);
			$data['emslist'] = $this->Bill_Customer_model->get_credit_customer_MAIL_list_byAccnoMonth_bill($acc_no,$month,$date);
			$data['sum'] = $this->Bill_Customer_model->get_credit_MAIL_customer_sum_byAccnoMonth_bill($acc_no,$month,$date);
//$data['sum'] = $this->Bill_Customer_model->get_credit_MAIL_customer_sum_byAccnoMonth($acc_no,$month);

// $data['emslist'] = $this->Box_Application_model->get_credit_customer_list_byAccnoMonth($acc_no,$month);
// $data['sum'] = $this->Box_Application_model->get_credit_customer_sum_byAccnoMonth($acc_no,$month);
			$data['invoice'] = rand(10000,20000);


			foreach ($data['emslist'] as $value) {
				$id = $value->t_id;
				$update1 = array();
				$update1 = array('bill_status'=>'PAID');
				$this->billing_model->update_Regtransactions($update1,$id);
			}
// $paidamount = ($data['sum']->paidamount*0.18) + $data['sum']->paidamount;
			$credit_id = $data['custinfo']->credit_id;
			$sender_branch = $this->session->userdata('user_branch');
			$sender_region = $this->session->userdata('user_region');
			$s_mobile = $data['custinfo']->cust_mobile;


			$this->load->library('ciqrcode');

			$this->load->view('billing/customer_mail_report',$data);

			$this->load->library('Pdf');
			$html= $this->load->view('billing/customer_mail_report',$data,TRUE);
			$this->dompdf->loadHtml($html);
			$this->dompdf->setPaper('A4','potrait');
			$this->dompdf->render();
			ob_end_clean();
			$this->dompdf->stream($acc_no, array("Attachment"=>0));

		}
		else{
			redirect(base_url());
		}
	}

	public function save_deriver(){

		$deriver = $this->input->post('deriverer');
		$identity = $this->input->post('identity');
		$sid      = $this->input->post('sid');
		$idtype      = $this->input->post('idtype');

		$check = $this->Box_Application_model->check_derivery($sid);
		if (!empty($check)) {

			$this->session->set_flashdata('message','Item is Already Derivered');

		} else {

			$data = array();
			$data = array('deliverer_name'=>$deriver,'identity'=>$identity,'d_status'=>'Yes','sender_id'=>$sid,'idtype'=>$idtype);
			$this->Box_Application_model->Save_Derivery($data);
			$this->session->set_flashdata('message','Successfully Saved');

		}

		redirect(base_url('Box_Application/Incoming_Item'));
	}



	public function Keydeposity_List()
	{
		if ($this->session->userdata('user_login_access') != false) {

			$data['region'] = $this->employee_model->regselect();
			$date = $this->input->post('date');
			$month= $this->input->post('month');
			$region= $this->input->post('region');

			if (!empty($month) || !empty($date) ) {
				$data['list'] = $this->Box_Application_model->get_Keydeposity_list_search($date,$month,$region);


			} else 
			{

				$data['list'] = $this->Box_Application_model->get_Keydeposity_list();

			}



			$this->load->view('box/Keydeposity_List',$data);
		} else {
			redirect(base_url());
		}

	}


	public function Bulk_List()
	{
		if ($this->session->userdata('user_login_access') != false) {

			$data['region'] = $this->employee_model->regselect();
			$date = $this->input->post('date');
			$month= $this->input->post('month');
			$region= $this->input->post('region');

			if (!empty($month) || !empty($date) ) {
				$data['list'] = $this->Box_Application_model->get_Bulk_list_search($date,$month,$region);


			} else 
			{

				$data['list'] = $this->Box_Application_model->get_Bulk_list();

			}



			$this->load->view('box/Bulk_List',$data);
		} else {
			redirect(base_url());
		}

	}




	public function Keydeposity_form()
	{
		if ($this->session->userdata('user_login_access') != false) {

			$data['region'] = $this->employee_model->regselect();
			$date = $this->input->post('date');
			$month= $this->input->post('month');
			$region= $this->input->post('region');

          //$country = $this->organization_model->countryselect();
			$data['country'] = $this->organization_model->countryselect();
           //$country = $countries->country_name;

			$this->load->view('box/Keydeposity_form',$data);


		}






	}
	public function Save_Keydeposity()
	{
		if ($this->session->userdata('user_login_access') != false) {

			$KeydeposityDetails = $this->input->post('KeydeposityDetails');
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
			$serial    = 'KEYDEPOSITY'.date("YmdHis").$source->reg_code;


			$data = array();
			$data = array(

				'serial'=>$serial,
				'item'=>$KeydeposityDetails,
				'Customer_mobile'=>$mobile,
				'region'=>$o_region,
				'branch'=>$o_branch,
				'date_created'=>date("YmdHis"),
				'Operator'=> $user,
				'Created_byId'=>$info->em_code

			);

			$this->Box_Application_model->save_Keydepositys($data);

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
				'paymentFor'=>'Keydeposity'

			);

			$this->Box_Application_model->save_transactions($data1);



			$paidamount = $Amount;
			$region = $o_region;
			$district = $o_branch;

			$renter   = @$KeydeposityDetails;
			$serviceId = 'POSTSBOX';
			$trackno = '90'.$bagsNo;
			$transaction = $this->getBillGepgBillIdKeydeposity($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
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

				$data['result'] ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Keydeposity,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

				$total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Keydeposity,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

				$this->Sms_model->send_sms_trick($mobile,$total);

				$this->load->view('box/Keydeposity_control_number',$data);
			}else{
				redirect('Box_Application/Keydeposity_List');
			}


		} else {
			redirect(base_url());
		}    
	}


	public function Save_Bulk()
	{
		if ($this->session->userdata('user_login_access') != false) {

			$BulkDetails = $this->input->post('BulkDetails');
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
			$serial    = 'BULK'.date("YmdHis").$source->reg_code;


			$data = array();
			$data = array(

				'serial'=>$serial,
				'Cust_Name'=>$BulkDetails,
				'amount'=>$Amount,
				'item'=>'Bulk Boxes Payment',
				'Customer_mobile'=>$mobile,
				'region'=>$o_region,
				'branch'=>$o_branch,
				'date_created'=>date("YmdHis"),
				'Operator'=> $user,
				'Created_byId'=>$info->em_code

			);

			$this->Box_Application_model->save_Bulk($data);

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
				'paymentFor'=>'Bulk Boxes Payments'

			);

			$this->Box_Application_model->save_transactions($data1);



			$paidamount = $Amount;
			$region = $o_region;
			$district = $o_branch;

			$renter   = $BulkDetails;
			$serviceId = 'POSTSBOX';
			$trackno = '90'.$bagsNo;
			$transaction = $this->getBillGepgBillIdKeydeposity($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
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

				$data['result'] ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Bulk Payments,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

				$total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Bulk Payments,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

				$this->Sms_model->send_sms_trick($mobile,$total);

				$this->load->view('box/Bulk_control_number',$data);
			}else{
				redirect('Box_Application/Bulk_List');
			}


		} else {
			redirect(base_url());
		}    
	}


	public function getBillGepgBillIdKeydeposity($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno){

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


public function Box_accessories_dashboard(){
	if ($this->session->userdata('user_login_access') != false) {

		$data['cash'] = $this->dashboard_model->get_ems_international();
		$this->session->set_userdata('heading','Box Accessories Dashboard');
		$this->load->view('box/Box_accessories-dashboard',$data);

	} else {
		redirect(base_url());
	}

}

public function AuthorityCard_List()
{
	if ($this->session->userdata('user_login_access') != false) {

		$data['region'] = $this->employee_model->regselect();
		$date = $this->input->post('date');
		$month= $this->input->post('month');
		$region= $this->input->post('region');

		if (!empty($month) || !empty($date) ) {
			$data['list'] = $this->Box_Application_model->get_AuthorityCard_list_search($date,$month,$region);


		} else 
		{

			$data['list'] = $this->Box_Application_model->get_AuthorityCard_list();

		}



		$this->load->view('box/AuthorityCard_List',$data);
	} else {
		redirect(base_url());
	}

}




public function AuthorityCard_form()
{
	if ($this->session->userdata('user_login_access') != false) {

		$data['region'] = $this->employee_model->regselect();
		$date = $this->input->post('date');
		$month= $this->input->post('month');
		$region= $this->input->post('region');

          //$country = $this->organization_model->countryselect();
		$data['country'] = $this->organization_model->countryselect();
           //$country = $countries->country_name;

		$this->load->view('box/AuthorityCard_form',$data);


	}






}
public function Save_AuthorityCard()
{
	if ($this->session->userdata('user_login_access') != false) {

		$AuthorityCardDetails = $this->input->post('AuthorityCardDetails');
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
		$serial    = 'AuthorityCard'.date("YmdHis").$source->reg_code;


		$data = array();
		$data = array(

			'serial'=>$serial,
			'item'=>$AuthorityCardDetails,
			'Customer_mobile'=>$mobile,
			'region'=>$o_region,
			'branch'=>$o_branch,
			'date_created'=>date("YmdHis"),
			'Operator'=> $user,
			'Created_byId'=>$info->em_code

		);

		$this->Box_Application_model->save_AuthorityCards($data);

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
			'paymentFor'=>'AuthorityCard'

		);

		$this->Box_Application_model->save_transactions($data1);



		$paidamount = $Amount;
		$region = $o_region;
		$district = $o_branch;
		$renter   = @$AuthorityCardDetails;
		$serviceId = 'AuthorityCard';
		$trackno = '90'.$bagsNo;
		$transaction = $this->getBillGepgBillIdAuthorityCard($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
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

			$data['result'] ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya AuthorityCard,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

			$total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya AuthorityCard,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

			$this->Sms_model->send_sms_trick($mobile,$total);

			$this->load->view('box/AuthorityCard_control_number',$data);
		}else{
			redirect('Box_Application/AuthorityCard_List');
		}


	} else {
		redirect(base_url());
	}    
}


public function getBillGepgBillIdAuthorityCard($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno){

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


public function update_customer_box_information(){
	$cname = $this->input->post('cname');
	$fname = $this->input->post('fname');
	$mname = $this->input->post('mname');
	$lname = $this->input->post('lname');
	$idtype = $this->input->post('idtype');
	$idnumber = $this->input->post('idnumber');
	$cardnumber = $this->input->post('cardnumber');
	$boxnumber = $this->input->post('boxnumber');
	$phone = $this->input->post('phone');
	$mobile = $this->input->post('mobile');

    //ID Information
	$boxid = $this->input->post('boxid');
	$custid = $this->input->post('custid');
	$custaddid = $this->input->post('custaddressid');


	$dataBox = array();
	$dataBox = array('box_number'=>$boxnumber);
	$this->Box_Application_model->update_customer_box_info($dataBox,$boxid);

	$dataAddress = array();
	$dataAddress = array('phone'=>$phone,'mobile'=>$mobile);
	$this->Box_Application_model->update_customer_address_info($dataAddress,$custaddid);

	$dataCust = array();
	$dataCust = array('cust_name'=>$cname,'first_name'=>$fname,'middle_name'=>$mname,'last_name'=>$lname,'authority_card'=>$cardnumber,'iddescription'=>$idtype,'idnumber'=>$idnumber);
	$this->Box_Application_model->update_customer_details_info($dataCust,$custid);

	$this->session->set_flashdata('success',"Customer Inofrmation has been successfully updated");
	redirect($this->agent->referrer());

}


public function update_mct_trans(){
	$barcode = $this->input->post('barcode');
	$serial = $this->input->post('serial');

	$data = array();
	$data = array('Barcode'=>$barcode);
	$this->Box_Application_model->update_mct_transaction($data,$serial);

	$sender = $this->Box_Application_model->get_requestid_byserial($serial);



	$data = array();
	$Header = array();
	$Header = array('Name'=>'POSTA','Signature'=>'@%#GT#$%^@$%GGHDVGH@$%#&');
	$signature="@%#GT#$%^@$%GGHDVGH@$%#&";
	$data['Header']=$Header;

	$value = array();
	$value = array('requestID'=>$sender->requestid,'Status'=>'200','barcode'=>$barcode,'signature'=>$signature);
	$data['Request']=$value;

	$url = "http://196.192.79.24/oas/ems/getbarcode.php";
	$ch = curl_init($url);
	$json = json_encode($data);
	curl_setopt($ch, CURLOPT_URL, $url);
// For xml, change the content-type.
	curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
	curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

// Send to remote and return data to caller.
$response = curl_exec ($ch);
curl_close ($ch);
$result = json_decode($response);


$controlnumber=@$sender->billid;
$s_mobile=@$sender->Customer_mobile;
$sms ='KARIBU POSTA KIGANJANI, Ndugu mteja umepatiwa track-namba '. ' '.@$barcode.' Yenye control number'.$controlnumber.' Uliyolipia kwa huduma ya MCT';
$this->Sms_model->send_sms_trick($s_mobile,$sms);



$this->session->set_flashdata('message',"Transaction Inofrmation has been successfully updated");
redirect('Ems_Domestic/mct_trans_results');

}

/// EDIT CONTRACT ////
public function edit_contract_info()
{
	$empid = rand();
	$cont_id = $this->input->post('conid');
//$status = $this->input->post('status');
	$contract_year = $this->input->post('contract_year');
	$mode_payment = $this->input->post('mode_payment');
	$cont_price = $this->input->post('cont_price');
	$image_url = $this->input->post('image_url');
	$start_date = date("Y-m-d",strtotime($this->input->post('start_date')));
	$end_date = date("Y-m-d",strtotime($this->input->post('end_date')));
	$emrand1 = substr($empid,0,3).rand(1000,2000); 
	$emrand = str_replace("'", '', $emrand1);


	if($_FILES['image_url']['name']){

		$file_name = $_FILES['image_url']['name'];
		$fileSize = $_FILES["image_url"]["size"]/1024;
		$fileType = $_FILES["image_url"]["type"];
		$new_file_name='';
		$new_file_name .= @$emrand;

		$config = array(
			'file_name' => $new_file_name,
			'upload_path' => "./assets/images/users",
			'allowed_types' => "pdf",
			'overwrite' => False,
                'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "800",
                'max_width' => "800"
            );

		$this->load->library('Upload', $config);
		$this->upload->initialize($config);   

		if (!$this->upload->do_upload('image_url')) {
                //echo $this->upload->display_errors();
			$this->session->set_flashdata("feedback","Warning! Contract file must be PDF File and fill all necessary contract fields, Please try again..");
		} else {

			$path = $this->upload->data();
			$img_url = $path['file_name'];
			$dataUpdate = array();
			$dataUpdate = array('scann_docu'=>$img_url);
			$this->Box_Application_model->update_contract_item($dataUpdate,$cont_id);
		}
	}

	$data = array();
	$data = array(
		'start_date'=>$start_date,
		'contract_year'=>$contract_year,
		'end_date'=>$end_date,
		'mode_payment'=>$mode_payment,
		'cont_price'=>$cont_price,
		'status'=>'IsComplete'
	);
	$this->Box_Application_model->update_contract_item($data,$cont_id);

				//echo "Successfully Updated";
	$this->session->set_flashdata("success","Contract Information has been Successfully Updated");



	redirect($this->agent->referrer());
}

public function update_contract_information(){
	$cont_id = $this->input->post('conid');
	$conttype = $this->input->post('cont_type');
	$agtype = $this->input->post('agreement_type');
	$partiesname = $this->input->post('parties_name');
	$mobile = $this->input->post('mobile');
	$con_region = $this->input->post('con_region');


	$data = array();
	$data = array(
		'cont_type'=>$conttype,
		'agreement_type'=>$agtype,
		'parties_name'=>$partiesname,
		'mobile'=>$mobile,
		'region'=>$con_region
	);
	$this->Box_Application_model->update_contract_item($data,$cont_id);

				//echo "Successfully Updated";
	$this->session->set_flashdata("success","Contract Information has been Successfully Updated");
	redirect($this->agent->referrer());
}
//////////// END /////////////////////////////


}
