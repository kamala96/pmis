<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
$this->load->model('Control_Number_model');
$this->load->model('unregistered_model');
$this->load->model('Stampbureau');
$this->load->model('Stock_model');
$this->load->helper('url');
//$this->load->model('Stampbureau');
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
public function GetTariffCategory(){

$bt_id = $this->input->post('bt_id',TRUE);
//run the query for the cities we specified earlier
echo $this->Box_Application_model->geTariffCategoryById($bt_id);
}

public function box_rental()
{
if ($this->session->userdata('user_login_access') != False) {
$data['regionlist'] = $this->employee_model->regselect();
$data['box_renters'] = $this->Box_Application_model->get_box_renters();
$this->load->view('box/box_application_form',$data);
}else{
redirect(base_url(), 'refresh');
}
}

public function Box_Application_List()
{
if ($this->session->userdata('user_login_access') != False) {
//$data['regionlist'] = $this->employee_model->regselect();
$data['box_renters'] = $this->Box_Application_model->get_box_list();
$data['box_numbers'] = $this->Box_Application_model->get_box_numbers();
$this->load->view('box/box_application_list',$data);
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

public function Box_Information()
{
if ($this->session->userdata('user_login_access') != False) {

$id = base64_decode($this->input->get('I'));
$data['inforperson'] = $this->Box_Application_model->get_box_list_perperson($id);
$data['paymentlist'] = $this->Box_Application_model->get_box_payment_list_perperson($id);
$this->load->view('box/box_information',$data);
}else{
redirect(base_url(), 'refresh');
}

}
public function Ems(){
	
	if ($this->session->userdata('user_login_access') != false){

		    $tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$date = $today->format('Y-m-d');

		    $data['region'] = $this->employee_model->regselect();
			$data['total'] = $this->Box_Application_model->get_ems_sum();
			$data['ems_cat'] = $this->Box_Application_model->ems_cat();
			$data['region'] = $this->employee_model->regselect();
			$this->load->view('billing/ems_application_form',$data);

	}else{
	redirect(base_url());
	}
}
public function Send()
{
if ($this->session->userdata('user_login_access') != false)
{
$data['region'] = $this->employee_model->regselect();
$data['ems_cat'] = $this->Box_Application_model->ems_cat();
$data['I'] = base64_decode($this->input->get('I'));
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
   $data['emslist'] = $this->Box_Application_model->get_ems_list_pending_supervisor($emid);
   $data['emselect'] = $this->employee_model->emselect();
   $data['agselect'] = $this->employee_model->emselectAgent();
   $this->load->view('billing/ems_application_list',$data);
}
else{
redirect(base_url());
}
}
public function Ems_Application_List()
{
if ($this->session->userdata('user_login_access') != false){

$emid = base64_decode($this->input->get('I'));
$data['region'] = $this->employee_model->regselect();
$data['emselect'] = $this->employee_model->emselect();
$data['agselect'] = $this->employee_model->agselect();
	
	if ($this->session->userdata('user_type') == "ACCOUNTANT-HQ" || $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP") {

		$date = $this->input->post('date');
		$date2 = $this->input->post('date2');
		$month = $this->input->post('month');
		$month = $this->input->post('month');
		$month2 = $this->input->post('month2');
		$year4 = $this->input->post('year');
		$region = $this->input->post('region');
		$type = $this->input->post('ems_type');

		$data['total'] = $this->Box_Application_model->get_ems_sumACC($region,$date,$date2,$month,$month2,$year4,$type);
		$data['emslist'] = $this->Box_Application_model->get_ems_listAcc($region,$date,$date2,$month,$month2,$year4,$type);

	} else {

		$date = $this->input->post('date');
		$month = $this->input->post('month');

		if (!empty($date) || !empty($month)) {
			$data['total'] = $this->Box_Application_model->get_ems_sumSearch($date,$month);
		    $data['emslist'] = $this->Box_Application_model->get_ems_listSearch($date,$month);
		} else {
			$data['total'] = $this->Box_Application_model->get_ems_sum();
			$data['emslist'] = $this->Box_Application_model->get_ems_list();
		}
	}	
	
	$this->load->view('domestic_ems/ems_application_list',$data);


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

public function Ems_price_vat()
{
if ($this->session->userdata('user_login_access') != false)
{
$emsCat = $this->input->post('tariffCat');
$weight = $this->input->post('weight');

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
		echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
		<tr><th colspan='2' style=''>Charges</th></tr>
		<tr><th>Description</th><th>Amount (Tsh.)</th></tr>
		<tr><td><b>Total Price:</b></td><td>".number_format(@$totalPrice)."</td></tr>
		</table>
			<input type='text' name ='price1' value='$totalPrice' class='price1'>
			<input type='text' name ='vat' value='$dvat' class='price1'>
			<input type='text' name ='price2' value='$dprice' class='price1'>";

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
			echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
			<tr><th colspan='2' style=''>Charges</th></tr>
			<tr><th>Description</th><th>Amount (Tsh.)</th></tr>
			<tr><td><b>Total Price:</b></td><td>".number_format(@$totalPrice)."</td></tr>
			</table>
			<input type='text' name ='price1' value='$totalPrice' class='price1'>
			<input type='text' name ='vat' value='$dvat' class='price1'>
			<input type='text' name ='price2' value='$dprice' class='price1'>
			";
	}


}else{

$price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);

if (empty($price)) {

	echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
	<tr><th colspan='2'>Charges</th></tr>
	<tr><td><b>Price:</b></td><td>0</td></tr>
	<tr><td><b>Vat:</b></td><td>0</td></tr>
	<tr><td><b>Total Price:</b></td><td>0</td></tr>
	</table>";

}else{

	$vat = $price->vat;
	$emsprice = $price->tariff_price;
	$totalPrice = $vat + $emsprice;

	echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
	<tr><th colspan='2' style=''>Charges</th></tr>
	<tr><th>Description</th><th>Amount (Tsh.)</th></tr>
	<tr><td><b>Price:</b></td><td>".$emsprice."</td></tr>
	<tr><td><b>Vat:</b></td><td>".$vat."</td></tr>
	<tr><td><b>Total Price:</b></td><td>".number_format($totalPrice)."</td></tr>
	</table>
		<input type='text' name ='price1' value='$totalPrice' class='price1'>
			<input type='text' name ='vat' value='$vat' class='price1'>
			<input type='text' name ='price2' value='$emsprice' class='price1'>";

}
}

}else{
redirect(base_url());
}
}

public function Register_Ems_Action()
{
if ($this->session->userdata('user_login_access') != false)
{
$emstype = $this->input->post('emsname');
$emsCat = $this->input->post('emscattype');
$weight = $this->input->post('weight');
$s_fname = $this->input->post('s_fname');
$s_address = $this->input->post('s_address');
$s_email = $this->input->post('s_email');
$mobile = $this->input->post('s_mobile');
//$regionp = $this->input->post('regionp');
//$branchdropp = $this->input->post('branchdropp');
$r_fname = $this->input->post('r_fname');
$r_address = $this->input->post('r_address');
$r_mobile = $this->input->post('r_mobile');
$r_email = $this->input->post('r_email');
$rec_region = $this->input->post('region_to');
$rec_dropp = $this->input->post('district');
//$prc = $this->input->post('price');

$id = $this->session->userdata('user_login_id');
$info = $this->employee_model->GetBasic($id);
$o_region = $info->em_region;
$o_branch = $info->em_branch;
//$operator = 'PF'. '  '.$info->em_code. '  '.$info->first_name.'  '.$info->middle_name. '  '.$info->last_name;

$transactionstatus   = 'POSTED';
$bill_status  = 'PENDING';
$PaymentFor = 'EMS';
$transactiondate = date("Y-m-d");
$fullname  = $s_fname;
$source = $this->employee_model->get_code_source($o_region);
$dest = $this->employee_model->get_code_dest($rec_region);

$bagsNo = @$source->reg_code . @$dest->reg_code;
$serial    = 'EMS'.date("YmdHis").$source->reg_code;

$getPending = $this->Box_Application_model->get_pending_task1($id);

if ( $getPending == 10) {

	$data['message'] = "You Have 10 Items ,Please Make Sure The Item is Paid And Transfer to Back Office";
	$this->load->view('ems/control-number-form',$data);

} else {

	$sender = array();
	$sender = array('ems_type'=>$emstype,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$info->em_id);

	$db2 = $this->load->database('otherdb', TRUE);
	$db2->insert('sender_info',$sender);
	$last_id = $db2->insert_id();



	$receiver = array();
	$receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'address'=>$s_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp);

	$db2->insert('receiver_info',$receiver);

	//get price by cat id and weight range;

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
	}

}else{

$price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
	$vat = $price->vat;
	$emsprice = $price->tariff_price;
	$totalPrice = $vat + $emsprice;
}

	$data = array(

		'transactiondate'=>date("Y-m-d"),
		'serial'=>$serial,
		'paidamount'=>$totalPrice,
		'CustomerID'=>$last_id,
		'Customer_mobile'=>$mobile,
		'region'=>$o_region,
		'district'=>$o_branch,
		'transactionstatus'=>'POSTED',
		'bill_status'=>'PENDING',
		'paymentFor'=>$PaymentFor

	);

	$this->Box_Application_model->save_transactions($data);

	$paidamount = $totalPrice;
	$region = $o_region;
	$district = $o_branch;
	$renter   = $emstype;
	$serviceId = 'EMS_POSTAGE';
	$trackno = $bagsNo;
	$transaction = $this->getBillGepgBillIdEMS($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
	

	if (!empty($transaction)) {

		@$serial1 = $transaction->billid;
		$update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
		$this->billing_model->update_transactions($update,$serial1);

		//$serial1 = '995120555284';

		$first4 = substr($transaction->controlno, 4);
		$trackNo = $bagsNo.$first4;
		$data1 = array();
		$data1 = array('track_number'=>$trackNo);

		$this->billing_model->update_sender_info($last_id,$data1);

	    $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
	    $location= $info->em_region.' - '.$info->em_branch;
		$data = array();
		$data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

		$this->Box_Application_model->save_location($data);

		$data['sms'] = $total ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($totalPrice,2);

		$total2 ='The amount to be paid for EMS is The TOTAL amount is '.' '.number_format($totalPrice,2).' Pay through this control number'.' '.$transaction->controlno ;

		$this->sendsms($mobile,$total);

		$this->load->view('ems/control-number-form',$data);

	}else{

		$transaction1 = $this->getBillGepgBillIdEMS($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

		@$serial1 = $transaction1->billid;
		$update = array('billid'=>$transaction1->controlno,'bill_status'=>'SUCCESS');
		$this->billing_model->update_transactions($update,$serial1);

		//$serial1 = '995120555284';

		$first4 = substr($transaction1->controlno, 4);
		$trackNo = $bagsNo.$first4;
		$data1 = array();
		$data1 = array('track_number'=>$trackNo);

		$this->billing_model->update_sender_info($last_id,$data1);

	    $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
	    $location= $info->em_region.' - '.$info->em_branch;
		$data = array();
		$data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

		$this->Box_Application_model->save_location($data);

		$data['sms'] = $total ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$transaction1->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($totalPrice,2);

		$total2 ='The amount to be paid for EMS is The TOTAL amount is '.' '.number_format($totalPrice,2).' Pay through this control number'.' '.$transaction1->controlno ;

		$this->sendsms($mobile,$total);

		$this->load->view('ems/control-number-form',$data);

	}
		# code...
   }


	}else{
	redirect(base_url());
	}
}
public function sendsms($mobile,$total)
    {
    $url = 'http://192.168.33.2/modules/otsms/process.php?msisdn='.$mobile.'&message='.urlencode($total);
    $urloutput=file_get_contents($url);
    return $urloutput;
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
public function EMS_Billing(){

if ($this->session->userdata('user_login_access') != false)
{

$acc_no  = base64_decode($this->input->get('I'));
$data['custinfo'] = $this->Box_Application_model->get_bill_customer_details($acc_no);
$data['region'] = $this->employee_model->regselect();
$this->load->view('billing/ems_companies_registration',$data);
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
public function despatch_out(){

if ($this->session->userdata('user_login_access') != false)
{
$data['emslist'] = $this->Box_Application_model->get_ems_back_list();
$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
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

$data['emslist'] = $this->Box_Application_model->get_ems_back_list();
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
public function ems_back_list(){

if ($this->session->userdata('user_login_access') != false)
{
//$data['emslist'] = $this->Box_Application_model->get_ems_back_list();
//$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
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
public function ems_bags_list(){

if ($this->session->userdata('user_login_access') != false)
{

$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
$data['ems'] = $this->Box_Application_model->count_ems();
$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
$data['bags'] = $this->Box_Application_model->count_bags();

$this->load->view('ems/ems_bags_list',$data);
}
else{
redirect(base_url());
}
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

//$trn = $this->input->get('trn');

//$data['getInfo'] = $this->Box_Application_model->get_item_from_bags($trn);

$this->load->view('ems/ems_item_list_bags',$data);
}
else{
redirect(base_url());
}

}

public function pending_bags_despatch_list(){

if ($this->session->userdata('user_login_access') != false)
{

$month = $this->input->post('month');
$date1 = $this->input->post('date');
$region = $this->input->post('region');
$data['region'] = $this->employee_model->regselect();

$data['emsbags'] = $this->Box_Application_model->get_pending_bags_list($date1,$month,$region);
$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
$data['ems'] = $this->Box_Application_model->count_ems();
$data['bags'] = $this->Box_Application_model->count_bags();

$this->load->view('ems/pending_bags_despatch_list',$data);
}
else{
redirect(base_url());
}

}
public function despatched_bags_list(){

if ($this->session->userdata('user_login_access') != false)
{

$data['region'] = $this->employee_model->regselect();

$data['emsbags'] = $this->Box_Application_model->get_despatched_bags_list();
$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
$data['ems'] = $this->Box_Application_model->count_ems();
$data['bags'] = $this->Box_Application_model->count_bags();

$this->load->view('ems/despatched_bags_list',$data);

}
else{
redirect(base_url());
}

}
public function despatched_bags_list_search(){

if ($this->session->userdata('user_login_access') != false)
{

$month = $this->input->post('month');
$date = $this->input->post('date');
$region = $this->input->post('region');
$data['region'] = $this->employee_model->regselect();

	$data['emsbags'] = $this->Box_Application_model->get_despatched_bags_list_wakubwa($date,$month,$region);

$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
$data['ems'] = $this->Box_Application_model->count_ems();
$data['bags'] = $this->Box_Application_model->count_bags();

$this->load->view('ems/despatched_bags_list',$data);

}
else{
redirect(base_url());
}

}
}

