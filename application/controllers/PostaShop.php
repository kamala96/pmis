 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostaShop extends CI_Controller {
    
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
        $this->load->model('Box_Application_model');
        $this->load->model('Control_Number_model');
        $this->load->model('E_reports_Model');
        $this->load->model('PostaShopModel');
        
        if ($this->session->userdata('user_login_access') == false){
            redirect(base_url());
        }
    }

public function postashop_dashboard(){
$data['countpending'] = $this->PostaShopModel->count_get_pending_requests();
$this->load->view('PostaShop/postshop_dashboard',$data);
}

public function report_dashbaord(){
$this->load->view('PostaShop/postshop_report_dashboard');
}

public function issued_stock_report(){
$data['regions'] = $this->E_reports_Model->get_user_regions();
$this->load->view('PostaShop/issued_stock_report',$data);
}

public function GetBranch(){
if ($this->input->post('region_id') != '') {
echo $this->PostaShopModel->GetBranchById($this->input->post('region_id'));
}
}

public function print_issued_stock_report(){
$fromdate = $this->input->post('fromdate');
$todate =  $this->input->post('todate');
$region =  $this->input->post('region');
$branch =  $this->input->post('branch');

$data['fromdate'] = $fromdate;
$data['todate'] = $todate;
$data['region'] = $region; $data['branch'] = $branch;

$data['list'] = $this->PostaShopModel->get_issued_stock_report($fromdate,$todate,$region,$branch);
if($data['list']){
 $this->load->library('Pdf');
 $html= $this->load->view('PostaShop/print_issied_stock_report',$data,TRUE);
 $this->dompdf->loadHtml($html);
 $this->dompdf->setPaper('A4','potrait');
 $this->dompdf->render();
 ob_end_clean();
 $this->dompdf->stream('issued-stock-PostaShop-report'.date('d-m-Y').'.pdf', array("Attachment"=>FALSE));
} else {
$this->session->set_flashdata('feedback','Report not found, Please try again..');
redirect($this->agent->referrer());
}

}


public function stock_request(){
$data['list'] = $this->PostaShopModel->my_list_pending_requests();
$this->load->view('PostaShop/stock_request',$data);
}

public function send_stock_request(){
$data['list'] = $this->PostaShopModel->list_counter_product_requested_lists();
$this->load->view('PostaShop/send_stock_request',$data);
}

public function list_pending_requests(){
$data['list'] = $this->PostaShopModel->list_pending_requests();
$this->load->view('PostaShop/pending_stock_request',$data);
}

public function get_issued_approved_stock_request(){
$data['list'] = $this->PostaShopModel->get_issued_approved_stock_request();
$this->load->view('PostaShop/issued_pending_stock_request',$data);
}

public function product_categories(){
$data['list'] = $this->PostaShopModel->list_productcategories();
$this->load->view('PostaShop/product_categories',$data);
}

public function list_productstock(){
$data['categories'] = $this->PostaShopModel->list_productcategories();
$data['list'] = $this->PostaShopModel->list_productstock();
$this->load->view('PostaShop/list_productstock',$data);
}

public function counter_list_productstock(){
$data['list'] = $this->PostaShopModel->counter_list_productstock();
$data['pendingstock'] = $this->PostaShopModel->count_pending_stock_issued_by_supervisor();
$this->load->view('PostaShop/counter_productstock',$data);
}

public function saleproducts(){
$data['list'] = $this->PostaShopModel->counter_list_productstock();
$this->load->view('PostaShop/selling',$data);
}

public function selling_transaction(){
$this->load->view('PostaShop/selling_transaction');
}

public function get_Product_information(){
            $id = $this->input->post('id');

            $checkdata = $this->PostaShopModel->get_product_information($id);

            if(!empty($checkdata)) {
                $res['status'] = 'available';
                $res['price'] = $checkdata->price;
                $res['qty'] = $checkdata->qty; 
            } else {
                 $res['status'] = 'un-available';
                 $res['message'] = 'Please Choose Product';

            }
            //response
            print_r(json_encode($res));

}

public function get_counter_Product_information(){
            $id = $this->input->post('id');

            $checkdata = $this->PostaShopModel->counter_get_product_information($id);

            if(!empty($checkdata)) {
                $res['status'] = 'available';
                $res['price'] = $checkdata->price;
                $res['qty'] = $checkdata->qty; 
            } else {
                 $res['status'] = 'un-available';
                 $res['message'] = 'Please Choose Product';

            }
            //response
            print_r(json_encode($res));

}

public function productstock(){
$data['categories'] = $this->PostaShopModel->list_productcategories();
$this->load->view('PostaShop/add_products_stock',$data);
}

/////////////////////////Product Categories
    public function save_category(){
    $name = $this->input->post('name');
    foreach($name as $value){
             $data = array();
             $data = array('category_name'=>$value);
    $this->PostaShopModel->save_category($data);
    }
    $this->session->set_flashdata('message','Category has been successfully added');
    redirect('PostaShop/product_categories');
    }

    public function update_category(){
    $name = $this->input->post('name');
    $itemid = $this->input->post('itemid');
             $data = array();
             $data = array('category_name'=>$name);
    $this->PostaShopModel->update_category($data,$itemid);
    $this->session->set_flashdata('message','Category has been successfully updated');
    redirect('PostaShop/product_categories');
    }

    public function delete_category(){
    $itemid = base64_decode($this->input->get('I'));
    $this->PostaShopModel->delete_category($itemid);
    $this->session->set_flashdata('message','Category has been successfully deleted');
    redirect('PostaShop/product_categories');
    }
/////////////////////End of Product Categories


////////////////////Products Stock
    public function save_stock(){
    $empid = $this->session->userdata('user_emid');
    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
    $categoryid = $this->input->post('categoryid');
    $product = $this->input->post('product');
    $qty = $this->input->post('qty');
    $purchaseprice = $this->input->post('purchaseprice');
    $price = $this->input->post('price');
    
    foreach($categoryid as $key=>$value){
             $data = array();
             $data = array(
            'categoryid'=>$value,
            'product_name'=>$product[$key],
             'price'=>$price[$key],
             'purchase_price'=>$purchaseprice[$key],
             'qty'=>$qty[$key],
             'operator'=> $empid,
             'region'=>$region,
             'branch'=>$branch
             );
    $this->PostaShopModel->save_stock($data);
    }
    $this->session->set_flashdata('message','Products has been successfully added on Stock');
    redirect('PostaShop/productstock');
    }

    public function delete_stock(){
    $itemid = base64_decode($this->input->get('I'));
    $this->PostaShopModel->delete_stock($itemid);
    $this->session->set_flashdata('message','Product has been successfully deleted on Stock');
     redirect('PostaShop/list_productstock');
    }

    public function update_stock(){
    $itemid = $this->input->post('productstockid');
    $categoryid = $this->input->post('categoryid');
    $product = $this->input->post('product');
    $qty = $this->input->post('qty');
    $purchaseprice = $this->input->post('purchaseprice');
    $price = $this->input->post('price');

    $data = array();
    $data = array(
    'categoryid'=>$categoryid,
    'product_name'=>$product,
    'price'=>$price,
    'purchase_price'=>$purchaseprice,
    'qty'=>$qty
    );
    $this->PostaShopModel->update_stock($data,$itemid);
    $this->session->set_flashdata('message','Product has been successfully updated on Stock');
    redirect('PostaShop/list_productstock');
    }
///////////////////End of Products Stock

/////////////Selling

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
        $serial = "POSTASHOP".''.date('Ymd').''.rand().''.$empid;
        $receipt = substr(str_shuffle("0123456789"), 0, 6);

        //Transaction
        $product = $this->input->post('product_id');
        $price = $this->input->post('price');
        $qty = $this->input->post('qty');
       

        foreach($product as $key=>$value){

        //$info = $this->PostaShopModel->product_stock_details($value);
        $sinfo =  $this->PostaShopModel->counter_get_product_information($value);

            $data = array();
            $data = array(
            'sale_productid'=>$value,
            'product_name'=>$sinfo->product_name,
            'purchase_price'=>@$sinfo->purchase_price,
            'sale_price'=>$price[$key],
            'sale_qty'=>$qty[$key],
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
    $this->PostaShopModel->save_selling_transaction($data);


    ////////////UPDATE STOCK
    
    $snbalance = $sinfo->qty-$qty[$key];
    //Update Branch Stock
    $UpdateStock = array();
    $UpdateStock = array('qty'=>$snbalance);
    $this->PostaShopModel->counter_update_stock($UpdateStock,$value);
    /////END OF UPDATE STOCK
        }

        $this->session->set_flashdata('success','Transaction has been successfully, Payment Receipt Number: '.$receipt.'');
        redirect($this->agent->referrer());
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
    $requestinfo =  $this->PostaShopModel->get_request_full_information($requestcode);

   
   if($status=="ApprovedBySupervisor"){

    //Save to the issued Items Table
    foreach($product as $key=>$value){
    $info = $this->PostaShopModel->product_stock_details($value);
    if(!empty($qty[$key])){
             $dataItem = array();
             $dataItem = array(
            'price'=>@$info->price,
            'qty'=>$qty[$key],
            'productid'=>$value,
            'categoryid'=>@$info->categoryid,
            'product_name'=>@$info->product_name,
            'purchase_price'=>@$info->purchase_price,
            'operator'=>@$empid,
            'region'=>@$region,
            'branch'=>$branch,
            'requestcode'=>$requestcode
             );
    $this->PostaShopModel->save_issued_request_items($dataItem);
    }
    }

    
    /*
    //Save to the Store Stock
    foreach($product as $key=>$value){
    if(!empty($qty[$key])){
   
    $row = $this->PostaShopModel->product_stock_details($value);

    //Update PMU Stock
    $balance = $row->qty-$qty[$key];
             $dataUpdateStock = array();
             $dataUpdateStock = array('qty'=>$balance);
    $this->PostaShopModel->update_branchstock($dataUpdateStock,$value);
    //End of Updates


    /////////////////
    //////////////////////////SAVE COUNTER STOCK
    /*
   $check = $this->PostaShopModel->check_item_counter_stock($value,$requestinfo->created_by);
   if(!empty($check)){
             //UPDATE
             $newbalance = $check->qty+$qty[$key];
             $dataStoreStock = array();
             $dataStoreStock = array(
             'qty'=>$newbalance,
             'price'=>$row->price,
             'product_name'=>$row->product_name);
    $this->PostaShopModel->update_counterstock($dataStoreStock,$value,$requestinfo->created_by);
   } else {
   /////////////////Save to the Store Stock
             $dataStoreStockTwo = array();
             $dataStoreStockTwo = array(
            'price'=>$row->price,
            'qty'=>$qty[$key],
            'productid'=>$value,
            'categoryid'=>$row->categoryid,
            'product_name'=>$row->product_name,
            'operator'=>$requestinfo->created_by,
            'region'=>$requestinfo->region,
            'branch'=>$requestinfo->branch);
    $this->PostaShopModel->save_counter_stock($dataStoreStockTwo);
     }
  
    /////////////////End of Save to the Store Stock
    }
    }*/


    }


    $UpdateRequestCode = array();
    $UpdateRequestCode = array('request_status'=>$status,'takenby'=>$empid);
    $this->PostaShopModel->update_request_stock_info($UpdateRequestCode,$requestcode);
    $this->session->set_flashdata('message','Request been successfully updated');
    redirect('PostaShop/list_pending_requests');
}

///////////End of selling


public function counter_transfer_stock_to_counter_stock(){
    $empid = $this->session->userdata('user_emid');
    $branch = $this->session->userdata('user_branch');
    $region = $this->session->userdata('user_region');
    $requestcode = $this->input->post('requestcode');
    $status = $this->input->post('status');
    $feedback = $this->input->post('feedback');

    ////////////////Get Request Information
    $requestinfo =  $this->PostaShopModel->get_request_full_information($requestcode);

   
   if($status=="ApprovedByShopper"){


    $listitems = $this->PostaShopModel->list_count_approved_issued_items($requestcode);
    //Save to the Store Stock
    foreach($listitems as $data){
    if(!empty($data->qty)){
   
    $row = $this->PostaShopModel->product_stock_details($data->productid);

    //Update PMU Stock
    $balance = $row->qty-$data->qty;
             $dataUpdateStock = array();
             $dataUpdateStock = array('qty'=>$balance);
    $this->PostaShopModel->update_branchstock($dataUpdateStock,$data->productid);
    //End of Updates


    /////////////////
    //////////////////////////SAVE COUNTER STOCK
   $check = $this->PostaShopModel->check_item_counter_stock($data->productid,$empid);
   if(!empty($check)){
             //UPDATE
             $newbalance = $check->qty+$data->qty;
             $dataStoreStock = array();
             $dataStoreStock = array(
             'qty'=>$newbalance,
             'price'=>$row->price,
             'product_name'=>$row->product_name,
             'purchase_price'=>@$row->purchase_price
              );
    $this->PostaShopModel->update_counterstock($dataStoreStock,$data->productid,$empid);
   } else {
   /////////////////Save to the Store Stock
             $dataStoreStockTwo = array();
             $dataStoreStockTwo = array(
            'price'=>$row->price,
            'qty'=>$data->qty,
            'productid'=>$data->productid,
            'categoryid'=>$row->categoryid,
            'product_name'=>$row->product_name,
            'purchase_price'=>@$row->purchase_price,
            'operator'=>$empid,
            'region'=>$region,
            'branch'=>$branch);
    $this->PostaShopModel->save_counter_stock($dataStoreStockTwo);
     }

    /////////////////End of Save to the Store Stock

    }
    }
    } else {
    $this->PostaShopModel->delete_issued_stock_information($requestcode);
    }

    $UpdateRequestCode = array();
    $UpdateRequestCode = array('request_status'=>$status,'feedback'=>@$feedback);
    $this->PostaShopModel->update_request_stock_info($UpdateRequestCode,$requestcode);
    $this->session->set_flashdata('message','Stock has been successfully updated');
    redirect('PostaShop/get_issued_approved_stock_request');

}


public function save_stock_request(){
$branch = $this->session->userdata('user_branch');
$region = $this->session->userdata('user_region');
$empid = $this->session->userdata('user_emid');

//////////Generate request code
$requestcode = date('Ymdhis').''.rand().''.$empid;

$product = $this->input->post('product_id');///Product required Code
$price = $this->input->post('price');///Price of product
$qty = $this->input->post('qty');///Required Quantity


////////Save Request Information
$RequestData = array('created_by'=>$empid,'region'=>$region,'branch'=>$branch,'request_code'=>$requestcode);
$this->PostaShopModel->save_request_information($RequestData);

        foreach($product as $key=>$value){
            $info =  $this->PostaShopModel->product_stock_details($value);
            $data = array();
            $data = array(
            'price'=>$price[$key],
            'qty'=>$qty[$key],
            'productid'=> $value,
            'categoryid'=>@$info->categoryid,
            'product_name'=>@$info->product_name,
            'purchase_price'=>@$info->purchase_price,
            'operator'=>@$empid,
            'region'=>@$region,
            'branch'=>$branch,
            'requestcode'=>$requestcode
             );
    $this->PostaShopModel->save_request_items($data);
            }

$this->session->set_flashdata('success','Request has been successfully Submitted');
redirect($this->agent->referrer());
  }


  public function get_stamp_information(){
            $id = $this->input->post('id');
            $checkdata = $this->PostaShopModel->product_stock_details($id);
            if(!empty($checkdata)) {
                $res['status'] = 'available';
                $res['price'] = $checkdata->price;
            } else {
                 $res['status'] = 'un-available';
                 $res['message'] = 'Please Choose Product';
            }
            //response
            print_r(json_encode($res));
}


///////////Search Transactions
public function find_transaction(){
$fromdate = $this->input->post('fromdate');
$todate = $this->input->post('todate');

$list = $this->PostaShopModel->get_transaction_list($fromdate,$todate);
if(!empty($list)){
$data['list'] = $this->PostaShopModel->get_transaction_list($fromdate,$todate);
$this->load->view('PostaShop/selling_transaction',$data);
} else {
$this->session->set_flashdata('feedback','Transaction not found');
redirect('PostaShop/selling_transaction');
}
}


///////////////End of Search Transactions


public function update_issueddata(){
$list = $this->PostaShopModel->list_administrator_issues();
foreach($list as $data){
$info =  $this->PostaShopModel->product_stock_details($data->sale_productid);
$dataUpdate = array('purchase_price'=>$info->purchase_price);
$this->PostaShopModel->update_adminstrator_stock($dataUpdate,$data->selling_id);
}
}



}