 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostaStamp extends CI_Controller {
    
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
        $this->load->model('unregistered_model');
        $this->load->model('job_assign_model');
        $this->load->model('Sms_model');
        $this->load->model('billing_model');
        $this->load->model('Box_Application_model');
        $this->load->model('Control_Number_model');
        $this->load->model('PostaStampModel');
        $this->load->helper('url');
        
        if ($this->session->userdata('user_login_access') == false){
            redirect(base_url());
        }
    }


public function dashboard(){
$data['countpending'] = $this->PostaStampModel->count_pending_stock_request();
$this->load->view('PostaStamp/dashboard',$data);
}

public function products_dashboard(){
$this->load->view('PostaStamp/products_dashboard');
}

public function sales_transaction(){
$this->load->view('PostaStamp/selling_transaction');
}

public function payment_transaction(){
$this->load->view('PostaStamp/payment_transaction');
}

public function branch_balance(){
$data['listbranch'] = $this->PostaStampModel->get_branch_stock_balance();
$this->load->view('PostaStamp/track_branch_stock',$data);
}

public function find_branch_stock_balance(){
$branch = $this->input->post('branch');
$data['list'] = $this->PostaStampModel->list_stock_balance_of_branch($branch);
if(!empty($data['list'])){
$this->load->view('PostaStamp/track_branch_stock',$data);
} else{
$this->session->set_flashdata('feedback','Stock Balance Not Found, Please try again!');
redirect('PostaStamp/branch_balance');
}
}

public function find_sale_transaction(){
$fromdate = $this->input->post('fromdate');
$todate = $this->input->post('todate');
$data['list'] = $this->PostaStampModel->get_sales_transaction($fromdate,$todate);
if(!empty($data['list'])){
$this->load->view('PostaStamp/selling_transaction',$data);
} else{
$this->session->set_flashdata('feedback','Transaction Not Found, Please try again!');
redirect('PostaStamp/sales_transaction');
}
}

public function find_payment_transaction(){
$fromdate = $this->input->post('fromdate');
$todate = $this->input->post('todate');
$data['list']  = $this->PostaStampModel->payment_transaction_list($fromdate,$todate);
if(!empty($data['list'])){
$this->load->view('PostaStamp/payment_transaction',$data);
} else{
$this->session->set_flashdata('feedback','Payment Not Found, Please try again!');
redirect('PostaStamp/payment_transaction');
}
}

public function main_stock(){
$categoryid =  base64_decode($this->input->get('I'));
$data['categoryid'] = $categoryid;
if($categoryid==1){ $data['productcode']="Stamp"; } elseif ($categoryid==2){ $data['productcode']="Locks"; } else { $data['productcode']="Authority Card"; }
$this->load->view('PostaStamp/add_stock',$data);
}

public function stock_list(){
$categoryid =  base64_decode($this->input->get('I'));
$data['categoryid'] = $categoryid;
if($categoryid==1){ $data['productcode']="Stamp"; } elseif ($categoryid==2){ $data['productcode']="Locks"; } else { $data['productcode']="Authority Card"; }
$data['list'] = $this->PostaStampModel->stock_list($categoryid);
$this->load->view('PostaStamp/list_stock',$data);
}

public function stock(){
if($this->session->userdata('sub_user_type')=="COUNTER" ||  $this->session->userdata('sub_user_type')=="BRANCH" || $this->session->userdata('sub_user_type')=="STRONGROOM"){
/////////////////////
if($this->session->userdata('sub_user_type')=="COUNTER"){
$data['list'] = $this->PostaStampModel->get_counter_stock();
$this->load->view('PostaStamp/counter_stock',$data);
} elseif($this->session->userdata('sub_user_type')=="BRANCH"){
$data['list'] = $this->PostaStampModel->get_branch_stock();
$this->load->view('PostaStamp/branch_stock',$data);
} else {
$data['list'] = $this->PostaStampModel->get_strongroom_stock();
$this->load->view('PostaStamp/strongroom_stock',$data);
}
////////////////////
} else {
 redirect($this->agent->referrer());
}
}

public function stock_request(){
if($this->session->userdata('sub_user_type')=="COUNTER" ||  $this->session->userdata('sub_user_type')=="BRANCH" || $this->session->userdata('sub_user_type')=="STRONGROOM"){
/////////////////////
$data['countpending'] = $this->PostaStampModel->count_pending_stock_request();
$data['list'] = $this->PostaStampModel->request_stock_list();
$this->load->view('PostaStamp/stock_request',$data);
////////////////////
} else {
 redirect($this->agent->referrer());
}
}

public function send_stock_request(){
if($this->session->userdata('sub_user_type')=="COUNTER" ||  $this->session->userdata('sub_user_type')=="BRANCH" || $this->session->userdata('sub_user_type')=="STRONGROOM"){
/////////////////////
$data['list'] = $this->PostaStampModel->list_available_stock_items();
$this->load->view('PostaStamp/send_stock_request',$data);
////////////////////
} else {
 redirect($this->agent->referrer());
}
}


public function pending_stock_request(){
if($this->session->userdata('sub_user_type')=="PMU" ||  $this->session->userdata('sub_user_type')=="STORE" || $this->session->userdata('user_type')=="SUPERVISOR" || $this->session->userdata('user_type')=="RM"){
$data['list'] =$this->PostaStampModel->pending_stock_request();
$data['countpending'] = $this->PostaStampModel->count_pending_stock_request();
$this->load->view('PostaStamp/pending_stock_request_store',$data);
} else {
redirect($this->agent->referrer());
}
}

public function pending_stock_request_branch(){
$data['list'] =$this->PostaStampModel->pending_stock_request();
$this->load->view('PostaStamp/pending_stock_request_branch',$data);
}

public function pending_stock_request_strongroom(){
$data['list'] =$this->PostaStampModel->pending_stock_request();
$this->load->view('PostaStamp/pending_stock_request_strongroom',$data);
}

public function main_stock_approved_request(){
    $empid = $this->session->userdata('user_emid');
    $branch = $this->session->userdata('user_branch');
    $region = $this->session->userdata('user_region');
    $requestcode = $this->input->post('requestcode');
    $status = $this->input->post('status');

    $product = $this->input->post('product');
    $qty = $this->input->post('qty');

    ////////////////Get Request Information
    $requestinfo =  $this->PostaStampModel->get_request_full_information($requestcode);


    /////Save History
    $dataHistory = array();
    $dataHistory = array('taken_by'=>$empid,'status'=>$status,'requestcode'=>$requestcode);
    $this->PostaStampModel->save_approved_history($dataHistory);
    ////End History
   
   if($status=="Completed"){

    //Save to the issued Items Table
    foreach($product as $key=>$value){
    $info = $this->PostaStampModel->main_stock_details($value);
    if(!empty($qty[$key])){
             $dataItem = array();
             $dataItem = array(
            'stock_price'=>$info->price,
            'stock_qty'=>$qty[$key],
            'stock_productid'=>$value,
            'stock_categoryid'=>@$info->categoryid,
            'stock_product_name'=>@$info->product_name,
            'stock_operator'=>@$empid,
            'stock_region'=>@$region,
            'stock_branch'=>$branch,
            'request_code'=>$requestcode
             );
    $this->PostaStampModel->save_issued_request_items($dataItem);
    }
    }


    //Save to the Store Stock
    foreach($product as $key=>$value){
    if(!empty($qty[$key])){
   
    $row = $this->PostaStampModel->main_stock_details($value);

    //Update PMU Stock
    $balance = $row->qty-$qty[$key];
             $dataUpdateStock = array();
             $dataUpdateStock = array('qty'=>$balance);
    $this->PostaStampModel->update_stock($dataUpdateStock,$value);
    //End of Updates

   $check = $this->PostaStampModel->check_item_strong_room_stock($value,$requestinfo->region);
   if(!empty($check)){
             //UPDATE
             $newbalance = $check->stock_qty+$qty[$key];
             $dataStoreStock = array();
             $dataStoreStock = array(
             'stock_qty'=>$newbalance,
             'stock_price'=>$row->price,
             'stock_product_name'=>$row->product_name);
    $this->PostaStampModel->update_strongroomstock($dataStoreStock,$value,$requestinfo->region);
   } else {
   /////////////////Save to the Store Stock
             $dataStoreStockTwo = array();
             $dataStoreStockTwo = array(
            'stock_price'=>$row->price,
            'stock_qty'=>$qty[$key],
            'stock_productid'=>$value,
            'stock_categoryid'=>$row->categoryid,
            'stock_product_name'=>$row->product_name,
            'stock_operator'=>$requestinfo->created_by,
            'stock_region'=>$requestinfo->region,
            'stock_branch'=>$requestinfo->branch);
    $this->PostaStampModel->save_strongroom_stock($dataStoreStockTwo);
     }
    /////////////////End of Save to the Store Stock

    //print_r($dataStoreStockTwo);
    }
    }
    }


    $UpdateRequestCode = array();
    $UpdateRequestCode = array('request_status'=>$status);
    $this->PostaStampModel->update_request_stock_info($UpdateRequestCode,$requestcode);
    $this->session->set_flashdata('message','Request been successfully updated');
    redirect('PostaStamp/pending_stock_request');
}


public function transfer_stock_to_branch_stock(){
    $empid = $this->session->userdata('user_emid');
    $branch = $this->session->userdata('user_branch');
    $region = $this->session->userdata('user_region');
    $requestcode = $this->input->post('requestcode');
    $status = $this->input->post('status');

    $product = $this->input->post('product');
    $qty = $this->input->post('qty');

    ////////////////Get Request Information
    $requestinfo =  $this->PostaStampModel->get_request_full_information($requestcode);


    /////Save History
    $dataHistory = array();
    $dataHistory = array('taken_by'=>$empid,'status'=>$status,'requestcode'=>$requestcode);
    $this->PostaStampModel->save_approved_history($dataHistory);
    ////End History
   
   if($status=="Completed"){

    //Save to the issued Items Table
    foreach($product as $key=>$value){
    $info = $this->PostaStampModel->strongroom_stock_details($value);
    if(!empty($qty[$key])){
             $dataItem = array();
             $dataItem = array(
            'stock_price'=>@$info->stock_price,
            'stock_qty'=>$qty[$key],
            'stock_productid'=>$value,
            'stock_categoryid'=>@$info->stock_categoryid,
            'stock_product_name'=>@$info->stock_product_name,
            'stock_operator'=>@$empid,
            'stock_region'=>@$region,
            'stock_branch'=>$branch,
            'request_code'=>$requestcode
             );
    $this->PostaStampModel->save_issued_request_items($dataItem);
    }
    }


    //Save to the Store Stock
    foreach($product as $key=>$value){
    if(!empty($qty[$key])){
   
    $row = $this->PostaStampModel->strongroom_stock_details($value);

    //Update PMU Stock
    $balance = $row->stock_qty-$qty[$key];
             $dataUpdateStock = array();
             $dataUpdateStock = array('stock_qty'=>$balance);
    $this->PostaStampModel->update_strongroomstock($dataUpdateStock,$value,$region);
    //End of Updates

   $check = $this->PostaStampModel->check_item_branch_stock($value,$region,$branch);
   if(!empty($check)){
             //UPDATE
             $newbalance = $check->stock_qty+$qty[$key];
             $dataStoreStock = array();
             $dataStoreStock = array(
             'stock_qty'=>$newbalance,
             'stock_price'=>$row->price,
             'stock_product_name'=>$row->product_name);
    $this->PostaStampModel->update_branchstock($dataStoreStock,$value,$region,$branch);
   } else {
   /////////////////Save to the Store Stock
             $dataStoreStockTwo = array();
             $dataStoreStockTwo = array(
            'stock_price'=>$row->stock_price,
            'stock_qty'=>$qty[$key],
            'stock_productid'=>$value,
            'stock_categoryid'=>$row->stock_categoryid,
            'stock_product_name'=>$row->stock_product_name,
            'stock_operator'=>$requestinfo->created_by,
            'stock_region'=>$requestinfo->region,
            'stock_branch'=>$requestinfo->branch);
    $this->PostaStampModel->save_branch_stock($dataStoreStockTwo);
     }
    /////////////////End of Save to the Store Stock

    //print_r($dataStoreStockTwo);
    }
    }
    }


    $UpdateRequestCode = array();
    $UpdateRequestCode = array('request_status'=>$status);
    $this->PostaStampModel->update_request_stock_info($UpdateRequestCode,$requestcode);
    $this->session->set_flashdata('message','Request been successfully updated');
    redirect('PostaStamp/pending_stock_request_strongroom');
}


public function transfer_stock_to_counter_stock(){
    $empid = $this->session->userdata('user_emid');
    $branch = $this->session->userdata('user_branch');
    $region = $this->session->userdata('user_region');
    $requestcode = $this->input->post('requestcode');
    $status = $this->input->post('status');

    $product = $this->input->post('product');
    $qty = $this->input->post('qty');

    ////////////////Get Request Information
    $requestinfo =  $this->PostaStampModel->get_request_full_information($requestcode);


    /////Save History
    $dataHistory = array();
    $dataHistory = array('taken_by'=>$empid,'status'=>$status,'requestcode'=>$requestcode);
    $this->PostaStampModel->save_approved_history($dataHistory);
    ////End History
   
   if($status=="Completed"){

    //Save to the issued Items Table
    foreach($product as $key=>$value){
    $info = $this->PostaStampModel->branch_stock_details($value);
    if(!empty($qty[$key])){
             $dataItem = array();
             $dataItem = array(
            'stock_price'=>@$info->stock_price,
            'stock_qty'=>$qty[$key],
            'stock_productid'=>$value,
            'stock_categoryid'=>@$info->stock_categoryid,
            'stock_product_name'=>@$info->stock_product_name,
            'stock_operator'=>@$empid,
            'stock_region'=>@$region,
            'stock_branch'=>$branch,
            'request_code'=>$requestcode
             );
    $this->PostaStampModel->save_issued_request_items($dataItem);
    }
    }


    //Save to the Store Stock
    foreach($product as $key=>$value){
    if(!empty($qty[$key])){
   
    $row = $this->PostaStampModel->branch_stock_details($value);

    //Update PMU Stock
    $balance = $row->stock_qty-$qty[$key];
             $dataUpdateStock = array();
             $dataUpdateStock = array('stock_qty'=>$balance);
    $this->PostaStampModel->update_branchstock($dataUpdateStock,$value,$region,$branch);
    //End of Updates

   $check = $this->PostaStampModel->check_item_counter_stock($value,$requestinfo->created_by);
   if(!empty($check)){
             //UPDATE
             $newbalance = $check->stock_qty+$qty[$key];
             $dataStoreStock = array();
             $dataStoreStock = array(
             'stock_qty'=>$newbalance,
             'stock_price'=>$row->price,
             'stock_product_name'=>$row->product_name);
    $this->PostaStampModel->update_counterstock($dataStoreStock,$value,$requestinfo->created_by);
   } else {
   /////////////////Save to the Store Stock
             $dataStoreStockTwo = array();
             $dataStoreStockTwo = array(
            'stock_price'=>$row->stock_price,
            'stock_qty'=>$qty[$key],
            'stock_productid'=>$value,
            'stock_categoryid'=>$row->stock_categoryid,
            'stock_product_name'=>$row->stock_product_name,
            'stock_operator'=>$requestinfo->created_by,
            'stock_region'=>$requestinfo->region,
            'stock_branch'=>$requestinfo->branch);
    $this->PostaStampModel->save_counter_stock($dataStoreStockTwo);
     }
    /////////////////End of Save to the Store Stock

    //print_r($dataStoreStockTwo);
    }
    }
    }


    $UpdateRequestCode = array();
    $UpdateRequestCode = array('request_status'=>$status);
    $this->PostaStampModel->update_request_stock_info($UpdateRequestCode,$requestcode);
    $this->session->set_flashdata('message','Request been successfully updated');
    redirect('PostaStamp/pending_stock_request_branch');
}

public function confirm_request(){
$requestcode = base64_decode($this->input->get('I'));
$status = base64_decode($this->input->get('status'));
$empid = $this->session->userdata('user_emid');


    /////Save History
    $dataHistory = array();
    $dataHistory = array('taken_by'=>$empid,'status'=>$status,'requestcode'=>$requestcode);
    $this->PostaStampModel->save_approved_history($dataHistory);
    ////End History

    $UpdateRequestCode = array();
    $UpdateRequestCode = array('request_status'=>$status);
    $this->PostaStampModel->update_request_stock_info($UpdateRequestCode,$requestcode);
    $this->session->set_flashdata('message','Request been successfully updated');
    redirect('PostaStamp/pending_stock_request');
}

public function salestamp(){
$data['list'] = $this->PostaStampModel->get_counter_stock();
$this->load->view('PostaStamp/selling',$data);
}

////////////////////Products Stock
    public function save_stock(){
    $empid = $this->session->userdata('user_emid');
    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
    $product = $this->input->post('product');
    $qty = $this->input->post('qty');
    $price = $this->input->post('price');
    $categoryid = $this->input->post('categoryid');
    
    foreach($product as $key=>$value){
             $data = array();
             $data = array(
            'product_name'=>$value,
             'price'=>$price[$key],
             'qty'=>$qty[$key],
             'operator'=> $empid,
             'region'=>$region,
             'branch'=>$branch,
             'categoryid'=>$categoryid
             );
    $this->PostaStampModel->save_stock($data);
    }
    $this->session->set_flashdata('message','Items has been successfully added on Stock');
    redirect($this->agent->referrer());
    }

    public function delete_stock(){
    $itemid = base64_decode($this->input->get('I'));
    $this->PostaStampModel->delete_stock($itemid);
    $this->session->set_flashdata('message','Item has been successfully deleted on Stock');
     redirect($this->agent->referrer());
    }

    public function update_stock(){
    $itemid = $this->input->post('productstockid');
    $product = $this->input->post('product');
    $qty = $this->input->post('qty');
    $price = $this->input->post('price');

    $data = array();
    $data = array(
    'product_name'=>$product,
    'price'=>$price,
    'qty'=>$qty
    );
    $this->PostaStampModel->update_stock($data,$itemid);
    $this->session->set_flashdata('message','Item has been successfully updated on Stock');
     redirect($this->agent->referrer());
    }
///////////////////End of Products Stock


public function save_stock_request(){
$branch = $this->session->userdata('user_branch');
$region = $this->session->userdata('user_region');
$empid = $this->session->userdata('user_emid');

//////////Generate request code
$requestcode = date('Ymdhis').''.rand().''.$empid;

$product = $this->input->post('product_id');///Product required Code
$price = $this->input->post('price');///Price of product
$qty = $this->input->post('qty');///Required Quantity

/////////Idenity of RequEster
if($this->session->userdata('sub_user_type')=="COUNTER"){
$requester ="ToBranch";
} elseif($this->session->userdata('sub_user_type')=="BRANCH"){
$requester ="ToStrongRoom";
} else {
///////STRONGROOM
$requester ="ToPMU";
}

////////Save Request Information
$RequestData = array('created_by'=>$empid,'region'=>$region,'branch'=>$branch,'request_code'=>$requestcode,'request_send'=>$requester);
$this->PostaStampModel->save_request_information($RequestData);

        foreach($product as $key=>$value){
            $info =  $this->PostaStampModel->get_stamp_information($value);
            $data = array();
            $data = array(
            'stock_price'=>$price[$key],
            'stock_qty'=>$qty[$key],
            'stock_productid'=> $value,
            'stock_categoryid'=>@$info->stock_categoryid,
            'stock_product_name'=>@$info->stock_product_name,
            'stock_operator'=>@$empid,
            'stock_region'=>@$region,
            'stock_branch'=>$branch,
            'request_code'=>$requestcode
             );
    $this->PostaStampModel->save_request_items($data);
            }

$this->session->set_flashdata('success','Request has been successfully Submitted');
redirect($this->agent->referrer());
  }


/////////////Transaction
public function save_selling(){
        //customer information
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $tin = $this->input->post('tin');
        $vrn = $this->input->post('vrn');
        $address = $this->input->post('address');
        $empid = $this->session->userdata('user_emid');
        $region = $this->session->userdata('user_region');
        $branch = $this->session->userdata('user_branch');

        //////////Generate serial Numbers
        $serial = date('Ymdhis').''.rand().''.$empid;
        $receipt = substr(str_shuffle("0123456789"), 0, 6);

        //Transaction
        $product = $this->input->post('product_id');
        $price = $this->input->post('price');
        $qty = $this->input->post('qty');
       

        foreach($product as $key=>$value){
            $productinfo = $this->PostaStampModel->counter_stock_availability_list($value);

            $data = array();
            $data = array(
            'sale_productid'=>$value,
            'sale_price'=>$price[$key],
            'sale_qty'=>$qty[$key],
            'product_name'=>@$productinfo->stock_product_name,
            'sale_category_id'=>@$productinfo->stock_categoryid,
            'operator'=> $empid,
            'region'=>$region,
            'branch'=>$branch,
            'customer'=>@$name,
            'phone'=>@$phone,
            'tin'=>@$tin,
            'vrn'=>@$vrn,
            'address'=>@$address,
            'serial'=>$serial,
            'receipt'=>$receipt
             );
    $this->PostaStampModel->save_selling_transaction($data);


   //Update PMU Stock
    $balance = $productinfo->stock_qty-$qty[$key];
    $dataUpdateStock = array();
    $dataUpdateStock = array('stock_qty'=>$balance);
    $this->PostaStampModel-> update_counterstock($dataUpdateStock,$value,$empid);
    //End of Updates
        }

        $this->session->set_flashdata('success','Transaction has been successfully, Payment Receipt Number: '.$receipt.'');
        redirect($this->agent->referrer());
    }

//////////////End of Transaction

public function get_stamp_information(){
            $id = $this->input->post('id');
            $checkdata = $this->PostaStampModel->get_stamp_information($id);
            if(!empty($checkdata)) {
                $res['status'] = 'available';
                $res['price'] = $checkdata->stock_price;
            } else {
                 $res['status'] = 'un-available';
                 $res['message'] = 'Please Choose Product';
            }
            //response
            print_r(json_encode($res));
}


public function get_counter_stock_information(){
            $id = $this->input->post('id');
            $checkdata = $this->PostaStampModel->counter_stock_availability_list($id);
            if(!empty($checkdata)) {
                $res['status'] = 'available';
                $res['price'] = $checkdata->stock_price;
                $res['qty'] = $checkdata->stock_qty;
            } else {
                 $res['status'] = 'un-available';
                 $res['message'] = 'Please Choose Product';
            }
            //response
            print_r(json_encode($res));
}



public function generate_sales_transaction_control_number(){

            //$Amount = $this->input->post('Amount');
            //$price = $Amount;
            //$mobile = $this->input->post('s_mobile');

             $transinfo = $this->PostaStampModel->generate_control_number_today_transactions();
             if(!empty($transinfo)){

            
            ////////COUNTER INFORMATION
            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
            $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
            $location= $info->em_region.' - '.$info->em_branch;
            $source = $this->employee_model->get_code_source($o_region);
            $bagsNo = $source->reg_code;
            $serial    = 'STAMP'.date("YmdHis").$source->reg_code;

            ///////////COUNTER OTHER INFORMATION
            $mobile = @$info->em_phone;
            ///////////GET TODAY TRANSACTION
            $price = $transinfo->total;
            $Amount = $transinfo->total;
            $StampDetails = "SALES OF STAMP";
            $Currency = "TZS";

             ////SAVE STAMP DETAILS
             $data = array();
             $data = array(
            'serial'=>$serial,
            'StampDetails'=>$StampDetails,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'branch'=>$o_branch,
            'date_created'=>date("YmdHis"),
            'Operator'=> $user,
            'Created_byId'=>$info->em_code
            );
            $this->PostaStampModel->save_stamps($data);
             ////////SAVE TRANSACTIONS
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
            'paymentFor'=>'STAMP'
            );
            $this->PostaStampModel->save_transactions($data1);


            $paidamount = $Amount;
            $region = $o_region;
            $district = $o_branch;
            $renter   = 'Sales Of Stamp';
            $serviceId = 'STAMP';
            $trackno = '90'.$bagsNo;
            $transaction = $this->getBillGepgBillIdStamp($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
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

                 //$result ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya STAMP,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                 $message ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya STAMP,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                $this->Sms_model->send_sms_trick($mobile,$message);

                ///$this->load->view('stamp/Stamp_control_number',$data);

$this->session->set_flashdata('success',$message.'');
redirect($this->agent->referrer());

} else {
/////////////NOT ANY TRANSACTION YOU HAVE
$this->session->set_flashdata('feedback','You cannot generate control number because you dont have any sales transaction, please sale any item to generate control number');
redirect($this->agent->referrer());
}
}
}



/////////////////Generate Control Number
public function getBillGepgBillIdStamp($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno){

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

//create logs
       $value = array();
       $value = array('trackno'=>$trackno,'serviceid'=>$serviceId,'item'=>$renter,'serial'=>$serial);
       $log=json_encode($value);
       $lg = array(
       'response'=>$log
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

}