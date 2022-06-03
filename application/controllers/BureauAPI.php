 <?php

defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');
 
class BureauAPI extends REST_Controller {

public function __construct(){
parent::__construct();
$this->load->model('BureauModel');
}


public function customer_info_post(){
$getValue = json_decode( file_get_contents( 'php://input' ), true );
$receiptid= $getValue['receiptno'];
$value = $this->BureauModel->get_receipt_info($receiptid);

if(!empty($value)){
$serial = $value->serial;
//Customer Information
$info = $this->BureauModel->get_customer_info($serial);


//retrieve Transactions
$listtransaction = $this->BureauModel->get_customer_transaction($serial);
$itemdata = array();
foreach ($listtransaction as $data) {
$itemdata[]=array(
    'currency'=>$data->currency_desc,
    'rate'=>number_format($data->currency_rate,2),
    'amount'=>number_format($data->exchange_amount,2),
    'total'=>number_format($data->currency_rate*$data->exchange_amount,2)
);
}

$transactiondata=@$itemdata;


//TRA Verification Code
//Total Amount of Transaction
$valuea = $this->BureauModel->sum_customer_transaction($serial);
$amount = $valuea->totalamount;
//Convert Identity of Customer to meet TRA Verification
if($info->identity_desc=="Passport"){
$idtype = 4;
} elseif($info->identity_desc=="Driving Licence"){
$idtype = 2;
} elseif($info->identity_desc=="Voters ID"){
$idtype = 3;
} elseif($info->identity_desc=="National ID"){
$idtype = 5;
}
else{
//Nill
$idtype = 6;
}

if($info->transaction_type=="01"){
$transtype = "SELLING";
} else {
$transtype = "BUYING";
}


$sign = array('receiptno'=>@$info->receipt,
  'idtype'=>@$idtype,
  'custid'=>@$info->customer_identity_no,
  'custname'=>@$info->customer_name,
  'mobile'=>@$info->customer_mobile,
  'region'=>@$info->region,
  'service'=>'BOT_SERVICE',
  'amount'=>@$amount,
 );

    $url = "http://192.168.33.2/api/vfd/extvfdsig.php";
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
    $signature = json_decode($response);

//End of TRA Verification Code

$arr = array(array(
    'message'=>'Successful',
    'status'=>'200',
    'name'=>@$info->customer_name,
    'phone'=>@$info->customer_mobile,
    'idtype'=>@$info->identity_desc,
    'idnumber'=>@$info->customer_identity_no,
    'region'=>@$info->region,
    'branch'=>@$info->branch,
    'receiptno'=>@$info->receipt,
    'transtype'=>@$transtype,
    'total'=>number_format(@$amount,2),
    'transactiondata'=>@$transactiondata,
    'transactiondate'=>date("d/m/Y",strtotime(@$info->transaction_created_at)),
    'verificationcode'=>@$signature->desc
));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);


}
else{
$arr = array(array('message'=>'Not Found','status'=>'404'));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);
}
}

}
?>