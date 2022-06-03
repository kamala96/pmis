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
$this->load->model('Sms_model');
$this->load->model('unregistered_model');
$this->load->model('Control_Number_model');
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
public function BoxRental()
{
if ($this->session->userdata('user_login_access') != False) {
	$id = $this->session->userdata('user_login_id');
				$info = $this->Box_Application_model->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

      
       if($this->session->userdata('user_type') == 'ADMIN')
		{
			$data['regionlist'] = $this->employee_model->regselect();
		}else
		{
			$data['regionlist'] = $this->Box_Application_model->regselect1($o_region);
		}

$data['box_renters'] = $this->Box_Application_model->get_box_renters();
$this->load->view('box/box_application_form',$data);
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
$total1 = round(round(($vat + $price),1))+ $TotalOutstandingamounts+ $TotalAccesoryamounts;
$paidamount = doubleval(round(round(($vat + $price),1))) + $TotalOutstandingamounts+ $TotalAccesoryamounts;

$cust = array();
$cust = array('cust_boxtype'=>$tariffcat,'boxnumber'=>$box,'cust_name'=>$custname,'iddescription'=>$iddescription,'idnumber'=>$idnumber,'first_name'=>$fname,'middle_name'=>$mname,'last_name'=>$lname,'authority_card'=>$authcard);

//$this->box_application_model->save_customer_details($cust);
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('customer_details',$cust);
$last_id = $db2->insert_id();

$add = array();
$add = array('add_cust_id'=>$last_id,'region'=>$region,'district'=>$district,'residence'=>$residence,'email'=>$email,'phone'=>$phone,'mobile'=>$mobile);

$this->Box_Application_model->save_address_details($add);

$Outstanding1 = array();
$Outstanding1 = array('amount'=>$priceVat,'year'=>date("Y"),'serial'=>$serial,'date_created'=>date("YmdHis"), 'Operator'=> $user,'Created_byId'=>$info->em_code);

$this->Box_Application_model->save_Outstanding($Outstanding1);





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
$renter = 'POSTSBOX';

	//$trackno = $bagsNo;
$this->Box_Application_model->save_transactions($data);

$transaction = $this->getBillGepgBillId($serial, $paidamount,$district,$region,$mobile,$renter,$serviceId);

$serial1 = $transaction->billid;
$update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
$this->Box_Application_model->update_transactions($update,$serial1);

$total ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya RENTER BOX,Kiasi unachotakiwa kulipia ni TSH.'.number_format($total1,2);

$total2 ='The amount to be paid for RENTER BOX is '. ' '.number_format($price,2).'  and VAT to be paid is'.' '. number_format($vat,2).'  The TOTAL amount is '.' '.number_format($total1,2).
'Pay through this control number'.' '.$transaction->controlno;
$this->Sms_model->send_sms_trick($mobile,$total);

echo json_encode($total2);

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

public function Box_Application_List()
{
if ($this->session->userdata('user_login_access') != False) {

	$id = $this->session->userdata('user_login_id');
				$info = $this->employee_model->GetBasic($id);
				$region =$info->em_region;
				$branch = $info->em_branch;
				$o_region = $this->session->userdata('user_region');

	   if($this->session->userdata('user_type') == 'ADMIN')
		{
			$data2['region'] = $this->employee_model->regselect();

			$data2['box_renters'] =$list = $this->Box_Application_model->get_box_listAdmin($region);


         /*  foreach ($list as $value)
           {
            $box =  $this->Box_Application_model->box_status($value->details_cust_id);
            $data2['boxlist'] = $box;

           }*/



		    $this->load->view('box/box_application_admin',$data2);
		}
		else
		{
			$data2['box_renters'] = $this->Box_Application_model->get_box_listt();
			$this->load->view('box/box_application_list',$data2);


		}
//$data['regionlist'] = $this->employee_model->regselect();

//$data['box_numbers'] = $this->Box_Application_model->get_box_numbers();

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
		$data2['box_renters'] = $this->Box_Application_model->get_box_listAdmin($region);
       } else 
       {
		$data2['box_renters'] = $this->Box_Application_model->get_box_listAdmin($region2);

		}
    $data2['region'] = $this->employee_model->regselect();

//$data['box_numbers'] = $this->Box_Application_model->get_box_numbers();
$this->load->view('box/box_application_admin',$data2);
}else{
redirect(base_url(), 'refresh');
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

$cust_id = base64_decode($this->input->get('I'));

$box = $this->Box_Application_model->get_customer_info($cust_id);
$serial    = 'PBOX'.date("YmdHis");
$price = $box->price;
$renter = $box->box_tariff_category;
$vat = round($price * 0.18,0);
$total1 = round(round(($vat + $price),1));

$data = array(

	'transactiondate'=>date("Y-m-d"),
	'serial'=>$serial,
	'paidamount'=>$total1,
	'CustomerID'=>$box->details_cust_id,
	'Customer_mobile'=>$box->mobile,
	'region'=>$box->region,
	'district'=>$box->district,
	'transactionstatus'=>'POSTED',
	'bill_status'=>'PENDING',
	'paymentFor'=>'POSTSBOX'

);

$this->Box_Application_model->save_transactions($data);

$id= $box->id;
$data1 = array();
$data1 = array(

	'status'=>'OldPaid'

);
$this->Box_Application_model->update_old_transactions($data1,$id);

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


$price = $box->price;
$renter = $box->box_tariff_category;
$vat = round($price * 0.18,0);
$total1 = round(round(($vat + $price),1));

$total ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya RENTER BOX,Kiasi unachotakiwa kulipia ni TSH.'.number_format($total1,2);

$this->Sms_model->send_sms_trick($mobile,$total);
$data['total'] ='The amount to be paid for RENTER BOX is '. ' '.number_format($price,2).'  and VAT to be paid is'.' '. number_format($vat,2).'  The TOTAL amount is '.' '.number_format($total1,2).
' Pay through this control number'.' '.$transaction->controlno ;
$this->load->view('box/renewalbox',$data);

}else{
redirect(base_url(), 'refresh');
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
$data['region'] = $this->employee_model->regselect();
$data['ems_cat'] = $this->Box_Application_model->ems_cat();
$data['I'] = base64_decode($this->input->get('I'));
$this->load->view('billing/ems_application_form_send',$data);
}
else{
redirect(base_url());
}
}
public function Ems_Application_List()
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

		$this->load->view('billing/ems_application_list',$data);

	}


} else {

	$data['total'] = $this->Box_Application_model->get_ems_sum();
	$data['emslist'] = $this->Box_Application_model->get_ems_list();
	$data['region'] = $this->employee_model->regselect();

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

$s_fname = $this->input->post('s_fname');
$s_address = $this->input->post('s_address');
$s_email = $this->input->post('s_email');
$mobile = $this->input->post('s_mobile');
$s_mobile = $mobile;
//$regionp = $this->input->post('regionp');
//$branchdropp = $this->input->post('branchdropp');
$r_fname = $this->input->post('r_fname');
$r_address = $this->input->post('r_address');
$r_mobile = $this->input->post('r_mobile');
$r_email = $this->input->post('r_email');
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

$emstype = '';
$emsCat = 0;
$weight = '';
	//$prc = $this->input->post('price');
	$sender = array();
	$sender = array('serial'=>$serial,'ems_type'=>$emstype,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$info->em_id);

	$db2 = $this->load->database('otherdb', TRUE);
	$db2->insert('sender_info',$sender);
	$last_id = $db2->insert_id();


	$receiver = array();
	$receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'address'=>$s_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp);

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
		'transactionstatus'=>'POSTED',
		'bill_status'=>'PENDING',
		'paymentFor'=>$PaymentFor

	);

   //echo json_encode($data22) ;

	$this->Box_Application_model->save_transactions($data22);

	$paidamount = $prc;
	$region = $o_region;
	$district = $o_branch;
	$renter   = 'Post Cargo';
	$serviceId = 'MAIL';
	$trackno = $bagsNo;

 $sender_region = $this->session->userdata('user_region');
  $sender_branch = $this->session->userdata('user_branch');

$postbill = $this->getBillGepgBillId($serial, $paidamount,$district,$region,$mobile,$renter,$serviceId);

	if (!empty($postbill->controlno)  ) {

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($o_region);
                $bagsNo = $source->reg_code . $dest->reg_code;

                $first4 = substr($postbill->controlno, 4);
                $trackNo = $bagsNo.$first4;

                $trackno = array();
                $trackno = array('track_number'=>$trackNo);
                $info = $this->employee_model->GetBasic($id);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                $this->unregistered_model->update_sender_info($last_id,$trackno);
                //$serial = $postbill->billid;

                $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
                $this->billing_model->update_transactions($update,$serial);

                // $update = array();

                // $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
                // $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Post Cargo  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
           
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

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($o_region);
                $bagsNo = $source->reg_code . $dest->reg_code;

                
                $first4 = substr($repostbill->controlno, 4);
                $trackNo = $bagsNo.$first4;
                $trackno = array();
                $trackno = array('track_number'=>$trackNo);
                $info = $this->employee_model->GetBasic($id);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                $this->unregistered_model->update_sender_info($last_id,$trackno);

                //@$serial = $repostbill->billid;
                $update = array();
                $update = array('billid'=>$repostbill->controlno,'bill_status'=>'SUCCESS');
               $this->billing_model->update_transactions($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya Post Cargo  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
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
$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
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
$data['emslist'] = $this->Box_Application_model->get_ems_back_list();
$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
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
$data['emslist'] = $this->Box_Application_model->get_ems_back_list();
$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
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
public function ems_bags_list(){

if ($this->session->userdata('user_login_access') != false)
{
$data['emslist'] = $this->Box_Application_model->get_ems_back_list_per_date();
$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
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
$renter   = 'PostaGilo';
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
$renter   = 'EmsBilling';
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
$renter   = 'MailsBilling-ZERORATE';
$serviceId = 'MAIL';
$mobile = $data['company']->com_phone;
$PaymentFor = 'MAILSBILLING';
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
$renter   = 'Commission';
$serviceId = 'COMMISSION';
$mobile = $data['company']->com_phone;
$PaymentFor = 'COMMISSION';


$data = array(

	//'transactiondate'=>date("Y-m-d"),
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

if ($this->session->userdata('user_type') == "SUPERVISOR") {
//check if user as a pending task
$getPending = $this->Box_Application_model->get_pending_task($emid);
$check = $this->Box_Application_model->getEndingDate1($emid);
echo $check->supervisor_name;
// 		if (!empty($check->supervisor_name)) {

// 			echo "Day already Ended";
// 		} else{

// if (!empty($getPending)) {


// 	$data = array();
// 	$data = array('supervisor_name'=>$id,'sup_status'=>'NotEnded');
// 	$this->Box_Application_model->Update_SupervisorJob($data,$emid);

// 	$update = array();
// 	$update = array('assign_status'=>'NotEnded','date_assign'=>$date);
// 	$this->employee_model->Update_Jobassign($update,$emid);

// 	echo "Shift Not Ended";
// } else {

// 	$data = array();
// 	$data = array('supervisor_name'=>$id,'supervisee_name'=>$emid,'sup_status'=>'Ended');
// 	$this->Box_Application_model->Save_SupervisorJob($data);

// 	$update = array();
// 	$update = array('assign_status'=>'Ended','date_assign'=>$date);
// 	$this->employee_model->Update_Jobassign($update,$emid);

// 	echo "Shift Ended Successfully";

// }

// }

} else {

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
//echo $weight;
if (empty($select)) {
echo "Please Select Atleast One Item";
} else {

for ($i=0; $i <@sizeof($select) ; $i++) {

	$id = $select[$i];
	$data = array();
	$data = array('office_name'=>'Received','created_by'=>$emid);
	$this->Box_Application_model->update_back_office($id,$data);
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
	$select = $this->input->post('I');
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
	$rondom = substr(date('dHis'), 1);
	$billcode = '5';//bag code in tracking number
	@$bagsNo = $source->reg_code . $dest->reg_code.$billcode.$rondom;

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

		$checkRegion = $this->Box_Application_model->get_region($id,$type);

		if($checkRegion->r_region == $region &&  $checkRegion->branch == $district){

			$bag = array();
			$bag = array('bag_region'=>$region,'bag_branch'=>$district);
			$this->Box_Application_model->update_bag($bag,$bagsNo);

			$data = array();
			$data = array('isBagNo'=>$bagsNo,'bag_status'=>'isBag');
			$this->Box_Application_model->update_back_office($id,$data);

		}else{

			//$this->Box_Application_model->delete_bag($bagsNo);

			echo "This Item Is Not Corresponding To this Bag";

		}
	}
	echo "Successfully Bag Close";

		}
	}else{
		echo "Please Select Atleast One Item To close";
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
$despno = base64_decode($this->input->get('despno'));
$data['emslist'] = $this->Box_Application_model->get_ems_back_list();
$data['emslist2'] = $this->Box_Application_model->get_ems_back_list2();
$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
$data['ems'] = $this->Box_Application_model->count_ems();
$data['bags'] = $this->Box_Application_model->count_bags();
$data['itemlist'] = $this->Box_Application_model->take_bags_desp_list($type,$despno);
$this->load->view('ems/bags_list_despatched',$data);
}
else{
redirect(base_url());
}
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
$bagregfrom = $this->session->userdata('user_region');
$bagreg     = $this->input->post('region');
$id = $this->session->userdata('user_login_id');
$info = $this->Box_Application_model->GetBasic($id);
$o_region = $info->em_region;
$o_branch = $info->em_branch;
if (!empty($select)) {

$tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$desno = 'DES'.rand(10,100);
$serial = '';
for ($i = 0; $i < 3; $i++) {
	for ($j = 0; $j < 5; $j++) {
		$serial .= $tokens[rand(0, 35)];
	}

	if ($i < 2) {
		$serial .= '-';
	}
}

$despatchNo = $desno.'-'.$serial;

$data = array();
$data = array('desp_no'=>$despatchNo,'region_from'=>$o_region,'branch_from'=>$o_branch,'transport_type'=>$transtype,'transport_name'=>$transname,'registration_number'=>$reg_no,'transport_cost'=>$transcost,'despatch_status'=>'Sent','region_to'=>$region,'branch_to'=>$district);
$this->Box_Application_model->save_despatch_info($data);

for ($i=0; $i <@sizeof($select) ; $i++) {

	$id = $select[$i];
	$checkRegion = $this->Box_Application_model->get_region_bag($id);
	if($region == $checkRegion->bag_region && $district == $checkRegion->bag_branch){
		$update = array('bags_status'=>'isDespatch','despatch_no'=>$despatchNo);
		$this->Box_Application_model->update_bags_list($id,$update);
		echo "Successfully Bags Despatched";
	}else{
		$this->Box_Application_model->delete_despatch($despatchNo);
	}

}
}else{
echo "Please Select Atleast One";
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
$emid = $this->session->userdata('user_emid');
if (!empty($select)) {

$id = $select;

$update = array();
$update = array('despatch_status'=>'Received','received_by'=>$emid);
$this->Box_Application_model->update_despatch_list($id,$update);


$update1 = array();
$update1 = array('bags_status'=>'isReceived','bag_received_by'=>$emid);
$this->Box_Application_model->update_bags_list1($id,$update1);

$getBagNo = $this->Box_Application_model->get_bag_number($id);
foreach ($getBagNo as $value) {

	$id = $value->bag_number;
	$update2 = array();
	$update2 = array('item_received_by'=>$emid);
	$this->Box_Application_model->update_list($id,$update2);
}
echo "Successfully Despatch Received";
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

$data['emslist'] = $this->Box_Application_model->get_ems_back_list();
$data['emsbags'] = $this->Box_Application_model->get_ems_bags_list();
$data['despatch'] = $this->Box_Application_model->get_despatch_out_list();
$data['despatchIn'] = $this->Box_Application_model->get_despatch_in_list();
$data['bagslist'] = $this->Box_Application_model->get_item_from_bags_list($bagno);
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

		$total ='KARIBU POSTA KINGANJANI,mzigo wako wenye namba hizi hapa'.'  '.$getDetails->track_number.''.' umewasili kwenye ofisi zetu za mokoa wa'.' '.$region.' tawi la '.$getDetails->branch;
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

if ($this->session->userdata('user_login_access') != false)
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

	if (empty($cont_id)) {

		$this->Box_Application_model->save_contract($data);
		echo "Successfully Added";

	}else{

		$this->Box_Application_model->update_contract($data,$cont_id);
		echo "Successfully Updated";

	}
}else{
redirect(base_url());
}
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
if ($this->session->userdata('user_login_access') != false)
{

$cont_id = $this->input->post('conid');
$status = $this->input->post('status');
$start_date = $this->input->post('start_date');
$contract_year = $this->input->post('contract_year');
$mode_payment = $this->input->post('mode_payment');
$cont_price = $this->input->post('cont_price');
$image_url = $this->input->post('image_url');

$year=date('Y', strtotime($start_date)) + $contract_year;
$month=date('m', strtotime($start_date));
$day=date('d', strtotime($start_date))-1;
$end_date = $year.'-'.$month.'-'.$day;

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
                echo $this->upload->display_errors();
			}
   
			else {

				$path = $this->upload->data();
                $img_url = $path['file_name'];

				$data = array();
				$data = array('start_date'=>$start_date,'contract_year'=>$contract_year,'end_date'=>$end_date,'mode_payment'=>$mode_payment,'cont_price'=>$cont_price,'scann_docu'=>$img_url,'status'=>$status);
				$this->Box_Application_model->update_contract_item($data,$cont_id);

				echo "Successfully Updated";

				}
				 } else {
				 	$data = array();
				$data = array('status'=>$status);
				$this->Box_Application_model->update_contract_item($data,$cont_id);

				echo "Successfully Updated";
				 }

}
else{
redirect(base_url());
}
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

$total ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($total1,2);

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
public function Get_EMSDate1()
{
if ($this->session->userdata('user_login_access') != false)
{
$date = $this->input->post('date_time');
$emid = $this->input->post('emid');
$year = date('Y',strtotime($date));
$month = date('m',strtotime($date));
$day = date('d',strtotime($date));

if ($this->session->userdata('user_type') == "SUPERVISOR") {
@$getInfo = $this->Box_Application_model->get_ems_per_date_by_emid($year,$month,$day,$emid);
} else {
@$getInfo = $this->Box_Application_model->get_ems_per_date($year,$month,$day);
}

$data['total'] = $this->Box_Application_model->get_ems_sum1($year,$month,$day);
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


										if ($season == 'Day') {

											$year = date('Y',strtotime($date));
											$month = date('m',strtotime($date));
											$day = date('d',strtotime($date));

											$getReport = $this->Box_Application_model->get_ems_report_Document_Day($year,$month,$day,$cate);

										}elseif ($season == 'Year') {
	//$year = $date;
											$year = date('Y',strtotime($date));
											$getReport = $this->Box_Application_model->get_ems_report_Document_Year($year,$cate);													}elseif ($season == 'MonthBtn') {

//$year = date('Y',strtotime($first));
												$monthf = date('m',strtotime($first));
//$months = date('m',strtotime($second));

												$date = explode('-', $second);
												$months  = @$date[0];
												$year = @$date[1];

												$getReport = $this->Box_Application_model->get_ems_report_Document_MonthBtn($year,$monthf,$months,$cate);

											}else{

												$date = explode('-', $date);
												$day  = @$date[0];
												$year = @$date[1];

												$getReport = $this->Box_Application_model->get_ems_report_Document_Month($year,$day,$cate);
											}



											$rr = array();
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
										public function Get_Despatch_In_ByDate()
										{
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
														<td colspan='10'>No data available in table</td>
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
													public function Credit_Customer(){
														if ($this->session->userdata('user_login_access') != false){
															$id = $this->session->userdata('user_login_id');
															$data['basic'] = $this->employee_model->GetBasic($id);
															$data['credit'] = $this->Box_Application_model->get_credit_customer();
															$this->load->view('ems/credit_customer_register_form',$data);
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
			$info = $this->Box_Application_model->get_customer_infos($I);
			$acc_no = $info->acc_no;
			$data['acc_no'] = $acc_no;
			$data['month'] = $month;
			$data['credit_id'] = $I;
			$type   = $info->customer_type;
			$data['type1'] = $info->customer_type;
			$data['tinnumber'] = $info->tin_number;
			$data['emslist'] = $this->Box_Application_model->get_credit_customer_list_byAccnoMonth($acc_no,$month);
		$data['sum'] = $this->Box_Application_model->get_credit_customer_sum_byAccnoMonth($acc_no,$month,$askfor);
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
		$emsCat    = $this->input->post('emscattype');
		$weight    = $this->input->post('weight');
		$r_fname   = $this->input->post('fullname');
		$r_address = $this->input->post('address');
		$r_email   = $this->input->post('email');
		$r_mobile  = $this->input->post('mobile');
		$rec_region = $this->input->post('region');
		$rec_dropp = $this->input->post('branch');
		$price1 = $this->input->post('price1');
		$vat = $this->input->post('vat');
		$price2 = $this->input->post('price2');

		$info = $this->Box_Application_model->get_customer_infos($I);
		$type = $info->acc_no;
		$getSum = $this->Box_Application_model->getSumPostPaid($type);
		$o_region = $info->customer_region;
		$source = $this->employee_model->get_code_source($o_region);
		$dest = $this->employee_model->get_code_dest($rec_region);
		$rondom = substr(date('dHis'), 1);
		$billcode = '4';//bill code in tracking number
		$trackingno = $source->reg_code . $dest->reg_code.$billcode.$rondom;
		$id = $this->session->userdata('user_login_id');
		$i = $this->employee_model->GetBasic($id);
		$acc_no = $info->acc_no;
		if($info->customer_type == "PostPaid"){

		if($info->price <= 20000){
			
			echo 'Umefikia Kiwango Cha mwisho cha Kukopeshwa';

		}else{

			$diff = $info->price - $price1;
		$up = array();
		$up = array('price'=>$diff);
		$this->Box_Application_model->update_price($up,$acc_no);

		
		$sender = array();
		$sender = array('ems_type'=>$emsname,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$info->customer_name,'s_address'=>$info->customer_address,'s_email'=>$info->cust_email,'s_mobile'=>$info->cust_mobile,'s_region'=>$info->customer_region,'s_district'=>$info->customer_branch,'track_number'=>$trackingno,'s_pay_type'=>$info->customer_type,'bill_cust_acc'=>$info->acc_no,'operator'=>$i->em_id);

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
			'region'=>$o_region,
			'district'=>$info->customer_branch,
			'transactionstatus'=>'POSTED',
			'bill_status'=>'BILLING',
			'paymentFor'=>'EMS',
			'status'=>'Bill',
			'customer_acc'=>$info->acc_no,
			'item_vat'=>$vat,
			'item_price'=>$price2

		);

		$this->Box_Application_model->save_transactions($data);
		echo "Successfully Saved";
			
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
		$sender = array('ems_type'=>$emsname,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$info->customer_name,'s_address'=>$info->customer_address,'s_email'=>$info->cust_email,'s_mobile'=>$info->cust_mobile,'s_region'=>$info->customer_region,'s_district'=>$info->customer_branch,'track_number'=>$trackingno,'s_pay_type'=>$info->customer_type,'bill_cust_acc'=>$info->acc_no,'operator'=>$i->em_id);

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
			'region'=>$o_region,
			'district'=>$info->customer_branch,
			'transactionstatus'=>'POSTED',
			'bill_status'=>'BILLING',
			'paymentFor'=>'EMS',
			'status'=>'Bill',
			'customer_acc'=>$acc_no

		);

		$this->Box_Application_model->save_transactions($data);


		echo "Successfully Saved";
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

		$total ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($amount,2);

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

public function received_item_from_counter(){
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

$this->load->view('ems/received_item_from_counter',$data);

}
else{
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

	$update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
	$this->Box_Application_model->update_transactions($update,$serial1);

	 echo @$transaction->controlno;
	}	else{
		redirect(base_url());
	}

}
public function received_date_region_branch(){

		if ($this->session->userdata('user_login_access') != false){

			$date = $this->input->post('date');
			$region = $this->input->post('region');
			$branch = $this->input->post('branch');

			$info = $this->Box_Application_model->get_received_date_region_branch($date,$region,$branch);

			if (empty($info)) {
				 echo "string1";
			} else {
				echo "string2";
			}

		}else{
			redirect(base_url());
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
              $this->load->library('Pdf');
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

$data['custinfo'] = $this->Box_Application_model->get_bill_customer_details($acc_no);
//$data['emslist'] = $this->Box_Application_model->get_credit_customer_list_byAccnoMonth2($acc_no,$month);
//$data['sum'] = $this->Box_Application_model->get_credit_customer_sum_byAccnoMonth2($acc_no,$month);
 
$sign = array('controlno'=>$controlno,'idtype'=>'1','custid'=>@$data['custinfo']->tin_number,'custname'=>@$data['custinfo']->com_name,'msisdn'=>@$data['custinfo']->com_phone,'service'=>'EFD');
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
               $html= $this->load->view('billing/invoice_sheet_posta_global',$data,TRUE);
              $this->load->library('Pdf');
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
 
$sign = array('controlno'=>$controlno,'idtype'=>'1','custid'=>@$data['custinfo']->tin_number,'custname'=>@$data['custinfo']->com_name,'msisdn'=>@$data['custinfo']->com_phone,'service'=>'EFD');
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
               $html= $this->load->view('billing/mails_invoice_sheet_posta_global.php',$data,TRUE);
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
$paidamount = ($data['sum']->paidamount*0.18) + $data['sum']->paidamount;
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
            'PaymentFor'=>'EMSBILLING',
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

            $renter   = 'Keydeposity';
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

                 $data['result'] ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Keydeposity,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                 $total ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Keydeposity,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                $this->Sms_model->send_sms_trick($mobile,$total);

                $this->load->view('box/Keydeposity_control_number',$data);
            }else{
                redirect('Keydeposity/Keydeposity_List');
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
            $renter   = 'AuthorityCard';
            $serviceId = 'POSTSBOX';
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

                 $data['result'] ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya AuthorityCard,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                 $total ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya AuthorityCard,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                $this->Sms_model->send_sms_trick($mobile,$total);

                $this->load->view('box/AuthorityCard_control_number',$data);
            }else{
                redirect('AuthorityCard/AuthorityCard_List');
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


}
