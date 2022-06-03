 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

 //require(APPPATH.'/libraries/REST_Controller.php');

  require(APPPATH.'/libraries/REST_Controller.php');

 
 
class Tracking_Api extends REST_Controller {


    function __construct() {
        parent::__construct();
        //$this->load->database();
        $this->load->model('employee_model');
        $this->load->model('unregistered_model');
        $this->load->model('billing_model');
        $this->load->model('Box_Application_model');
        $this->load->model('login_model');
        $this->load->model('parcel_model');
        $this->load->model('dashboard_model');
        $this->load->model('parking_model');
        $this->load->model('Control_Number_model');
        $this->load->model('Necta_model');
        $this->load->model('Ems_Cargo_model');
        $this->load->model('Pcum_model');
        $this->load->model('Bill_Customer_model');
          $this->load->model('Sms_model');
        $this->load->model('Reports_model');
        $this->load->model('Received_ViewModel');
         $this->load->model('Stamp_model');
         $this->load->model('FGN_Application_model');
          $this->load->model('payroll_model');
        $this->load->model('PostaShopModel');
        $this->load->model('PostaStampModel');
        $this->load->model('TrackingApiModel');
        $this->load->model('Posta_Cash_Model');
    
    }

public function tracing_barcode_post(){
$getValue = json_decode( file_get_contents( 'php://input' ), true );
$barcode= $getValue['barcode'];

if(!empty($barcode)){

//////////////
$senderinfo = $this->TrackingApiModel->get_ems_barcode_full_details($barcode);
if(!empty($senderinfo)){
///////
$transinfo = $this->TrackingApiModel->get_ems_barcode_full_details_transactions($barcode);
$tracinglist  = $this->TrackingApiModel->get_full_barcode_tracing_information($transinfo->id);

$itemdata = array();
foreach ($tracinglist as $data) {
@$emid = $data->emid;
$status = $data->status;
$fromdata = $this->TrackingApiModel->get_em_details_id(@$emid);

                if ($status == 'Acceptance') {

                $description = @$data->status.' '.@$fromdata->em_branch.', '.@$fromdata->em_region;

                } else if ($data->office_name == 'Counter' && $status == 'IN') {

                    $description = @$data->description.' '.@$fromdata->em_branch.', '.@$fromdata->em_region;

                } else if ($data->office_name == 'Back Office' && $status == 'Received counter') {

                    $description = 'Acceptance '.@$fromdata->em_branch.', '.@$fromdata->em_region;

                }else if ($data->office_name == 'Despatch' && $status == 'RECEIVE') {

                    $description = 'Received sorting facility '.@$fromdata->em_branch;

                }else if ($data->office_name == 'Despatch' && $status== 'BAG') {

        
                    $description = @$data->description;
   

                }else if ($data->office_name == 'InWard' && $status == 'RECEIVE') {

                    $description = 'Received sorting facility '.@$fromdata->em_branch.', '.@$fromdata->em_region;

                }else if ($data->office_name == 'InWard' && $status == 'BAG receive') {

                    $description = 'Received sorting facility '.@$fromdata->em_branch.', '.@$fromdata->em_region;

                }else if ($data->office_name == 'DELIVERY' && $status == 'Delivery') {

                    $description = 'On delivery';
                }else if ($data->office_name == 'DELIVERY' && $status == 'Delivered') {

                    $description = @$data->description;

                } else {
                    ////////////Despatch and Bag Closed
                    $description = @$data->description;
                }

$itemdata[]=array(
    'description'=>$description,
    'tracing_date'=>@$data->doc
);

}

$tracing_details = @$itemdata;

$delivery_details = $this->TrackingApiModel->get_ems_barcode_delivery_full_information($senderinfo->sender_id);
$delivery_info = array(
'name'=>@$delivery_details->deliverer_name,
'phone'=>@$delivery_details->phone,
'identity'=>@$delivery_details->identity,
'identityno'=>@$delivery_details->identityno,
'deliverydate'=>@$delivery_details->deriveryDate);


$barcode_details = array(
        'barcode'=>@$senderinfo->Barcode,
        'sendername'=>@$senderinfo->s_fullname,
        'weight'=>@$senderinfo->weight,
        'paidamount'=>@$senderinfo->paidamount,
        'controlnumber'=>@$senderinfo->billid,
        'receivername'=>@$senderinfo->fullname,
        'senderregion'=>@$senderinfo->s_region, 
        'senderbranch'=>@$senderinfo->s_district,
        'receiverregion'=>$senderinfo->r_region, 
        'receiverbranch'=>$senderinfo->branch,
        'receivestatus'=>@$senderinfo->s_status
            );

$list = array('http_status'=>'200','description'=>'Successful','status'=>'Success','Barcodeinfo'=>@$barcode_details,'tracinginfo'=>@$tracing_details,'deliveryinfo'=>@$delivery_info); 
header('Content-Type: application/json');
echo json_encode($list);

} else {

$value = array('http_status'=>'404','description'=>'Barcode Not Found, Please try again!','status'=>'Error');
header('Content-Type: application/json');
echo json_encode($value);

}

} else {

 $value = array('http_status'=>'404','description'=>'Barcode Cannot be empty, Please try again!','status'=>'Error');
 header('Content-Type: application/json');
 echo json_encode($value);
}


}




}