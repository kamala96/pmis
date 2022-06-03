 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends CI_Controller {


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
		$this->load->model('Sms_model');
		$this->load->model('Box_Application_model');
    }
    
	public function index()
	{
		#Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            redirect('dashboard/Dashboard');
            $data=array();
            #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
			$this->load->view('login');
	}
	public function Mail()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$data['region'] = $this->employee_model->regselect();
			$data['category'] = $this->billing_model->getAllCategory();
			$data['listItem'] = $this->billing_model->getAllCategoryBill();
			$this->load->view('billing/ems_form',$data);
		}
		else{
			redirect(base_url());
		}
	}
	public function mailsPrices()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$measure = $this->input->post('measure');
			$sub_cat = $this->input->post('catlist');
			$pay_type = $this->input->post('pay_type');
			//$weight = $this->input->post('weight');
			$measure2 = $this->input->post('measure2');
			$measure1 = $this->input->post('measure1');
			
			if (!empty($measure)) {
				if ($measure == 'gms') {
					$weight = $this->input->post('weight');
					 $priceCheck = $this->billing_model->getItemPriceByWeight($weight,$sub_cat);
				}else{
					$weight = $this->input->post('weight') * 1000;
					 $priceCheck = $this->billing_model->getItemPriceByWeight($weight,$sub_cat);
				}
			}else{

				if ($measure1 == 'a1') {
					$weight = -1;
				}elseif ($measure1 == 'b2') {
					$weight = -2;
				}elseif ($measure1 == 'c3') {
					$weight = -3;
				}elseif ($measure1 == 'd4') {
					$weight = -4;
				}else{
					$weight = -5;
				}
				$priceCheck = $this->billing_model->getItemPriceByWeight1($weight,$sub_cat);
			}
			
				 if (!empty($priceCheck)) {
					
					if ($pay_type == 'Economy') {

					$price = $priceCheck->economy_price;
					
				 }else{
			 	    $price = $priceCheck->priority_price;
				 }

				 $vat = round($price * 0.18,0);
				 $totaprice = round(round(($vat + $price),1));

				 echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
				 	<tr><th colspan='2' style=''>Charges</th></tr>
				 	<tr><th>Description</th><th>Amount (Tsh.)</th></tr>
				 	<tr><td><b>Price:</b></td><td>".number_format($price)."</td></tr>
				 	<tr><td><b>Vat:</b></td><td>".number_format($vat)."</td></tr>
				 	<tr><td><b>Total Price:</b></td><td>".number_format($totaprice)."</td></tr>
			       </table>";

				 }else{

				 echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
				 	<tr><th colspan='2' style=''>Charges</th></tr>
				 	<tr><th>Description</th><th>Amount (Tsh.)</th></tr>
				 	<tr><td><b>Price:</b></td><td>0</td></tr>
				 	<tr><td><b>Vat:</b></td><td>0</td></tr>
				 	<tr><td><b>Total Price:</b></td><td>0</td></tr>
			       </table>";
				 }
		
		}
		else{
			redirect(base_url());
		}
	}
	public function Create_Inland_Ems(){
		if ($this->session->userdata('user_login_access') != false) {

			$step = $this->input->post('step');

				$sub_cat  = $this->input->post('sub_category');
				$pay_type  = $this->input->post('pay_type');

			if ($step == 'Step1') {

				$measure = $this->input->post('measure');
				
				if (!empty($measure)) {
				if ($measure == 'gms') {
					$weighted = $this->input->post('weight');
					 //$priceCheck = $this->billing_model->getItemPriceByWeight($weight,$sub_cat);
				}else{
					$weighted = $this->input->post('weight') * 1000;
					// $priceCheck = $this->billing_model->getItemPriceByWeight($weight,$sub_cat);
				}
			}else{

				$measure1 = $this->input->post('measure1');
				$measure2 = $this->input->post('measure2');

				if ($measure1 == 'a1') {
					$weighted = -1;
				}elseif ($measure1 == 'b2') {
					$weighted = -2;
				}elseif ($measure1 == 'c3') {
					$weighted = -3;
				}elseif ($measure1 == 'd4') {
					$weighted = -4;
				}else{
					$weighted = -5;
				}

				//$priceCheck = $this->billing_model->getItemPriceByWeight1($weight,$sub_cat);
			}

				
				$data = array(

					'item_category' => $this->input->post('category'),
					'sub_category' => $this->input->post('sub_category'),
					'item_weight' =>$weighted,
					'volume_weight' => $this->input->post('volume_weight'),
					'destination' => $this->input->post('destination'),
					'stamp' => $this->input->post('stamp'),
					'item_number' => $this->input->post('item_number'),
					'pay_type'=>$this->input->post('pay_type')
				);

				$this->billing_model->save_item_details($data);
				$item_id = $this->db->insert_id();
				$data = $item_id;

				echo json_encode($data);
			}elseif ($step == 'Step2'){

				$data = array(
					'fullname'  => $this->input->post('fullname'),
					'address'=> $this->input->post('address'),
					'email'=>$this->input->post('email'),
					'mobile'=>$this->input->post('mobile'),
					'item_id'=>$this->input->post('item_id')
				);
				$sender = $this->billing_model->save_sender_details($data);
				echo json_encode($sender);
			}else {

				    $data = array(
					'rec_name'  => $this->input->post('fullname'),
					'rec_address'=> $this->input->post('address'),
					'rec_email'=>$this->input->post('email'),
					'rec_mobile'=>$this->input->post('mobile'),
					'item_id'=>$this->input->post('item_id')
				);

				$this->billing_model->save_receiver_details($data);
				$senderId = $this->db->insert_id();


				$id = $this->input->post('item_id');
				$item_details = $this->billing_model->getItemDetailsById($id);
				$sub_cat = $item_details->sub_category;
				$weight = $item_details->item_weight;
				$pay_type1  = $item_details->pay_type;

				if ($sub_cat == 'Aerogramme&Post Cards' || $sub_cat == 'Advertising Mail') {

					$priceCheck = $this->billing_model->getItemPriceByWeight1($weight,$sub_cat);
				}else{
					$priceCheck = $this->billing_model->getItemPriceByWeight($weight,$sub_cat);
				}

			
				if ($pay_type1 == 'Economy') {

					$price = $priceCheck->economy_price;
					
				 }else{
			 	    $price = $priceCheck->priority_price;
				 }
				
				$vat = round($price * 0.18,0);


				//Create first transaction

				$sender_details = $this->billing_model->getSenderDetailsById($id);

				$sender_id = $sender_details->sender_id;
				$fullname = $sender_details->fullname;
				$mobile = $sender_details->mobile;
				$address = $sender_details->address;
				$serial    = 'MAILS'.date("YmdHis");
				$paidamount = doubleval(round(round(($vat + $price),1)));

				$y = date("Y");
				$m = date("m");
				$d = date("d");

				$Customer_mobile     = $sender_details->mobile;
				$region       = $sender_details->address;
				$district   = $sender_details->address;
				$penaltydate = date("Y-m-d",mktime(0,0,0,$m,$d+7,$y));
				$penalty = doubleval(0);

				$transactionstatus   = 'POSTED';
				$bill_status  = 'PENDING';
				$PaymentFor = 'MAILS';
				$transactiondate = date("Y-m-d");

				$data = array(

					'transactiondate'=>$transactiondate,
					'serial'=>$serial,
					'paidamount'=>$paidamount,
					'CustomerID'=>$sender_details->sender_id,
					'Customer_mobile'=>$Customer_mobile,
					'region'=>$region,
					'district'=>$district,
					'transactionstatus'=>$transactionstatus,
					'bill_status'=>$bill_status,
					'paymentFor'=>$PaymentFor

				);
				

				$this->Box_Application_model->save_transactions($data);

				$transaction = $this->getBillGepgBillId($serial, $paidamount,$fullname,$address,$mobile,$sub_cat);
				$serial1 = $transaction->billid;
				$update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
				$this->Box_Application_model->update_transactions($update,$serial1);

                $total1 ='The amount to be paid is '. ' '.$price.'  and VAT to be paid is'.' '. $vat.'  The TOTAL amount is ='.' '.round(round(($vat + $price),1)).
					' Pay through this control number'.' '.$transaction->controlno ;


				$total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya INLAND MAILS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);

				$this->Sms_model->send_sms_trick($Customer_mobile,$total);

				
				echo json_encode($total1);

			}
		}
		else{
			redirect(base_url());
		}
	}
	public function GetCatList(){

		if ($this->input->post('cat_name') != '') {

			echo $this->billing_model->GetCatListByName($this->input->post('cat_name'));
		}

	}
	public function getBillGepgBillId($serial, $paidamount,$address,$mobile,$sub_cat){


		$AppID = 'POSTAPORTAL';
		$BillAmt = $paidamount;
		$Region = $address;
		$District =$address;

		$data = array(
			'AppID'=>$AppID,
			'BillAmt'=>$BillAmt,
			'serial'=>$serial,
			'BillAmt'=>$BillAmt,
			'District'=>$District,
			'Region'=>$Region,
			'service'=>'MAILS',
			'item'=>$sub_cat,
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

		//print_r($response-);
		curl_close ($ch);
		$result = json_decode($response);
		//print_r($result->controlno);
		return $result;
	}

	public function sendsms($Customer_mobile,$total)
    {
        $url = 'http://192.168.33.2/modules/otsms/process.php?msisdn='.$Customer_mobile.'&message='.urlencode($total);
        $urloutput=file_get_contents($url);
        return $urloutput;
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
    
	public function update_mails_status()
	{
		if ($this->session->userdata('user_login_access') != false)
		{
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			if (empty($id)) {
				echo "Please Select Atleast One Box";
			}else{

			for ($i=0; $i <@sizeof($id) ; $i++) { 
				$item_id = $id[$i];
				if ($status[$i] == 'Pending') {
					
					$data = array();
					$data = array('item_status'=>'Ontransit');
					$this->billing_model->mails_status_update($data,$item_id);

					echo "Mails Transfer Successfully";

				}elseif ($status[$i] == 'Ontransit') {
					
					$data = array();
					$data = array('item_status'=>'Delivery');
					$this->billing_model->mails_status_update($data,$item_id);

					echo "Mails Delivery Successfully";
				}else{

					$data = array();
					$data = array('item_status'=>'Clear');
					$this->billing_model->mails_status_update($data,$item_id);

					echo "Mails Cleared Successfully";
				}

			}
		}
			
		}
		else{
			redirect(base_url());
		}
	}
	
	


}
