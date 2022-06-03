 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Officialuse extends CI_Controller {
	
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
        $this->load->model('OfficialuseModel');
		
		if ($this->session->userdata('user_login_access') == false){
			redirect(base_ur());
		}
    }

    public function dashboard(){
    $this->load->view('inventory/officialuse_dashboard');
    }

    public function store_dashboard(){
    $this->load->view('inventory/store_dashboard');
    }

    public function items(){
    $data['list'] = $this->OfficialuseModel->list_items();
    $this->load->view('inventory/officialuse_items_list',$data);
    }

    public function units(){
    $data['list'] = $this->OfficialuseModel->list_units();
    $this->load->view('inventory/officialuse_unit_list',$data);
    }

    public function track_store_request(){
    $this->load->view('inventory/store_track_requests');
    }

    public function track_store_request_results(){
    $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
    $todate =  date("Y-m-d",strtotime($this->input->post('todate')));
    $status =  $this->input->post('status');
    $data['list'] = $this->OfficialuseModel->track_store_request_list($fromdate,$todate,$status);
    $this->load->view('inventory/store_track_requests',$data);
    }

    public function stock(){
    $data['listitems'] = $this->OfficialuseModel->list_items();
    $data['listunits'] = $this->OfficialuseModel->list_units();
    $data['list'] = $this->OfficialuseModel->list_stock();
    $this->load->view('inventory/officialuse_stock',$data);
    }

    public function storestock(){
    $data['list'] = $this->OfficialuseModel->list_store_stock();
    $this->load->view('inventory/store_stock',$data);
    }

    public function addstock(){
    $data['listitems'] = $this->OfficialuseModel->list_items();
    $data['listunits'] = $this->OfficialuseModel->list_units();
    $this->load->view('inventory/officialuse_addstock',$data);
    }

    public function store_sendrequest(){
    $data['listitems'] = $this->OfficialuseModel->list_items();
    $data['listunits'] = $this->OfficialuseModel->list_units();
    $this->load->view('inventory/store_sendrequest',$data);
    }

    public function hod_store_sendrequest(){
    $data['listitems'] = $this->OfficialuseModel->list_items();
    $data['listunits'] = $this->OfficialuseModel->list_units();
    $this->load->view('inventory/store_hod_sendrequest',$data);
    }

    public function requests(){
    $data['list'] = $this->OfficialuseModel->list_my_requests();
    $this->load->view('inventory/officialuse_request',$data);
    }

    public function hod_requests(){
    $data['list'] = $this->OfficialuseModel->hod_list_my_requests();
    $this->load->view('inventory/store_hod_request',$data);
    }

    public function pending_requests(){
    $data['listitems'] = $this->OfficialuseModel->list_items();
    $data['list'] = $this->OfficialuseModel->list_pending_requests();
    $data['countpending'] = $this->OfficialuseModel->count_pending_requests();
    $this->load->view('inventory/officialuse_pending_request',$data);
    }

    public function store_pending_requests(){
    $data['listitems'] = $this->OfficialuseModel->list_items();
    $data['list'] = $this->OfficialuseModel->store_list_pending_requests();
    $data['countpending'] = $this->OfficialuseModel->store_count_pending_requests();
    $this->load->view('inventory/store_pending_request',$data);
    }

    public function store_requests(){
    $data['listitems'] = $this->OfficialuseModel->list_items();
    $data['list'] = $this->OfficialuseModel->list_pending_requests();
    $data['countpending'] = $this->OfficialuseModel->count_pending_requests();
    $this->load->view('inventory/officialuse_store_request',$data);
    }

    public function save_items(){
    $name = $this->input->post('name');
    foreach($name as $value){
             $data = array();
             $data = array('item_name'=>$value);
    $this->OfficialuseModel->save_items($data);
    }
    $this->session->set_flashdata('message','Item has been successfully added');
    redirect('Officialuse/items');
    }

    public function save_units(){
    $name = $this->input->post('name');
    foreach($name as $value){
             $data = array();
             $data = array('unit_name'=>$value);
    $this->OfficialuseModel->save_units($data);
    }
    $this->session->set_flashdata('message','Unit has been successfully added');
    redirect('Officialuse/units');
    }

    public function update_unit(){
    $name = $this->input->post('name');
    $unitid = $this->input->post('unitid');
             $data = array();
             $data = array('unit_name'=>$name);
    $this->OfficialuseModel->update_unit($data,$unitid);
    $this->session->set_flashdata('message','Unit has been successfully updated');
    redirect('Officialuse/units');
    }

    public function delete_unit(){
    $unitid = base64_decode($this->input->get('I'));
    $this->OfficialuseModel->delete_unit($unitid);
    $this->session->set_flashdata('message','Unit has been successfully deleted');
    redirect('Officialuse/units');
    }

    public function update_item(){
    $name = $this->input->post('name');
    $itemid = $this->input->post('itemid');
             $data = array();
             $data = array('item_name'=>$name);
    $this->OfficialuseModel->update_items($data,$itemid);
    $this->session->set_flashdata('message','Item has been successfully updated');
    redirect('Officialuse/items');
    }

    public function delete_item(){
    $itemid = base64_decode($this->input->get('I'));
    $this->OfficialuseModel->delete_item($itemid);
    $this->session->set_flashdata('message','Item has been successfully deleted');
    redirect('Officialuse/items');
    }

    public function delete_stock(){
    $stockid = base64_decode($this->input->get('I'));
    $this->OfficialuseModel->delete_stock($stockid);
    $this->session->set_flashdata('message','Item on the stock has been successfully deleted');
    redirect('Officialuse/stock');
    }

    public function save_stock(){
    $empid = $this->session->userdata('user_emid');
    $itemid = $this->input->post('itemid');
    $unitid = $this->input->post('unitid');
    $price = $this->input->post('price');
    $supplier = $this->input->post('supplier');
    $qty = $this->input->post('qty');
    foreach($itemid as $key=>$value){
             $data = array();
             $data = array(
            'itemid'=>$value,
            'unitid'=>$unitid[$key],
             'price'=>$price[$key],
             'supplier'=>$supplier[$key],
             'qty'=>$qty[$key],
             'balance_qty'=>$qty[$key],
              'created_by'=> $empid);
    $this->OfficialuseModel->save_stock($data);
    }
    $this->session->set_flashdata('message','Item has been successfully added on the Stock');
    redirect('Officialuse/addstock');
    }

    public function save_request(){
    $code = strtoupper(substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 6));
    $empid = $this->session->userdata('user_emid');
    $region  = $this->session->userdata('user_region');
    $branch  = $this->session->userdata('user_branch');
    $desc = $this->input->post('desc');
    $itemid = $this->input->post('itemid');
    $unitid = $this->input->post('unitid');
    $qty = $this->input->post('qty');
             $data = array();
             $data = array(
            'request_code'=>$code,
             'request_desc'=>$desc,
             'region'=>$region,
             'branch'=>$branch,
              'created_by'=> $empid);
    $this->OfficialuseModel->save_request($data);

    foreach($itemid as $key=>$value){
             $dataItem = array();
             $dataItem = array(
            'request_itemid'=>$value,
            'unitid'=>$unitid[$key],
             'item_qty'=>$qty[$key],
             'requestcode'=>$code);
    $this->OfficialuseModel->save_request_items($dataItem);
    }
    $this->session->set_flashdata('message','Request has been successfully sent, Please wait for confirmation');
    redirect('Officialuse/requests');
    }

    public function save_hod_request(){
    $code = strtoupper(substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 6));
    $empid = $this->session->userdata('user_emid');
    $region  = $this->session->userdata('user_region');
    $branch  = $this->session->userdata('user_branch');
    $desc = $this->input->post('desc');
    $itemid = $this->input->post('itemid');
    $unitid = $this->input->post('unitid');
    $qty = $this->input->post('qty');
             $data = array();
             $data = array(
            'request_code'=>$code,
             'request_desc'=>$desc,
             'region'=>$region,
             'branch'=>$branch,
             'request_send'=>'ToStore',
             'created_by'=> $empid);
    $this->OfficialuseModel->save_request($data);

    foreach($itemid as $key=>$value){
             $dataItem = array();
             $dataItem = array(
            'request_itemid'=>$value,
            'unitid'=>$unitid[$key],
             'item_qty'=>$qty[$key],
             'requestcode'=>$code);
    $this->OfficialuseModel->save_request_items($dataItem);
    }
    $this->session->set_flashdata('message','Request has been successfully sent, Please wait for confirmation from Store');
    redirect('Officialuse/hod_requests');
    }

    public function update_stock(){
    $stockid = $this->input->post('stockid');
    $price = $this->input->post('price');
    $itemid = $this->input->post('itemid');
    $unitid = $this->input->post('unitid');
    $qty = $this->input->post('qty');
    $supplier = $this->input->post('supplier');

             $data = array();
             $data = array(
             'price'=>$price,
             'itemid'=>$itemid,
             'unitid'=>$unitid,
             'qty'=>$qty,
             'supplier'=>$supplier);
    $this->OfficialuseModel->update_stock($data,$stockid);

    $this->session->set_flashdata('message','Item has been successfully updated on the Stock');
    redirect('Officialuse/stock');
    }

    
    public function approvedbyrm(){
    $empid = $this->session->userdata('user_emid');
    $requestcode = $this->input->post('requestcode');
    $status = $this->input->post('status');
             $data = array();
             $data = array('request_status'=>$status);
    $this->OfficialuseModel->update_requests($data,$requestcode);
    /////Save History
    $dataHistory = array();
    $dataHistory = array('approved_by'=>$empid,'approved_status'=>$status,'requestcode'=>$requestcode);
    $this->OfficialuseModel->save_approved_history($dataHistory);
    ////End History
    $this->session->set_flashdata('message','Request been successfully updated');
    redirect('Officialuse/pending_requests');
    }

    public function approvedbypmu(){
    $empid = $this->session->userdata('user_emid');
    $requestcode = $this->input->post('requestcode');
    $status = $this->input->post('status');
    $itemid = $this->input->post('itemid');
    $unitid = $this->input->post('unitid');
    $qty = $this->input->post('qty');
    $storeman = $this->input->post('createdby');

    /////Save History
    $dataHistory = array();
    $dataHistory = array('approved_by'=>$empid,'approved_status'=>$status,'requestcode'=>$requestcode);
    $this->OfficialuseModel->save_approved_history($dataHistory);
    ////End History
   
   if($status=="ReceivedByPMU"){
    //Save to the issued Items Table
    foreach($itemid as $key=>$value){
             $dataItem = array();
             $dataItem = array(
            'itemid'=>$value,
             'unitid'=>$unitid[$key],
             'itemqty'=>$qty[$key],
             'requestcode'=>$requestcode);
    $this->OfficialuseModel->save_issued_request_items($dataItem);
    }
    //Save to the Store Stock
    foreach($qty as $key=>$value){
    $row = $this->OfficialuseModel->item_qty_balance($itemid[$key]);

    //Update PMU Stock
    $balance = $row->balance_qty-$value;
             $dataUpdateStock = array();
             $dataUpdateStock = array('balance_qty'=>$balance);
    $this->OfficialuseModel->update_itemstock($dataUpdateStock,$itemid[$key]);
    //End of Updates

   $check = $this->OfficialuseModel->check_item_storestock($itemid[$key],$storeman);
   if($check>0){
             //UPDATE
             $cell = $this->OfficialuseModel->check_item_storestock_info($itemid[$key],$storeman);
             $newbalance = $cell->qty+$value;
             $dataStoreStock = array();
             $dataStoreStock = array(
             'qty'=>$newbalance,
             'unitid'=>$unitid[$key],
             'price'=>$row->price);
    $this->OfficialuseModel->storestock_update_items($dataStoreStock,$itemid[$key],$storeman);
   } else {
   /////////////////Save to the Store Stock
             $dataStoreStock = array();
             $dataStoreStock = array(
             'qty'=>$value,
             'itemid'=>$itemid[$key],
             'unitid'=>$unitid[$key],
             'price'=>$row->price,
             'storeman'=>$storeman);
    $this->OfficialuseModel->save_storestock_to_storeman($dataStoreStock);
     }
    /////////////////End of Save to the Store Stock
    }
    }

            $data = array();
             $data = array('request_status'=>$status);
    $this->OfficialuseModel->update_requests($data,$requestcode);
    $this->session->set_flashdata('message','Request been successfully updated');
    redirect('Officialuse/pending_requests');
    }

    public function approvedby_storeman(){
    $empid = $this->session->userdata('user_emid');
    $requestcode = $this->input->post('requestcode');
    $status = $this->input->post('status');
    $itemid = $this->input->post('itemid');
    $unitid = $this->input->post('unitid');
    $qty = $this->input->post('qty');

    /////Save History
    $dataHistory = array();
    $dataHistory = array('approved_by'=>$empid,'approved_status'=>$status,'requestcode'=>$requestcode);
    $this->OfficialuseModel->save_approved_history($dataHistory);
    ////End History
   
   if($status=="Completed"){
    //Save to the issued Items Table
    foreach($itemid as $key=>$value){
             $dataItem = array();
             $dataItem = array(
            'itemid'=>$value,
             'unitid'=>$unitid[$key],
             'itemqty'=>$qty[$key],
             'requestcode'=>$requestcode);
    $this->OfficialuseModel->save_issued_request_items($dataItem);
    }

    foreach($qty as $key=>$value){
    $row = $this->OfficialuseModel->store_item_qty_balance($itemid[$key]);
    $storestockid = $row->storestock_id;

    //Update PMU Stock
    $balance = $row->qty-$value;
             $dataUpdateStock = array();
             $dataUpdateStock = array('qty'=>$balance);
    $this->OfficialuseModel->update_itemstorestock($dataUpdateStock,$storestockid);
    //End of Updates
    }
    }

            $data = array();
             $data = array('request_status'=>$status,'store_user'=>$empid);
    $this->OfficialuseModel->update_requests($data,$requestcode);
    $this->session->set_flashdata('message','Request been successfully updated');
    redirect('Officialuse/store_pending_requests');
    }

    public function approvedbystore(){
    $empid = $this->session->userdata('user_emid');
    $requestcode = $this->input->post('requestcode');

    /////Save History
    $dataHistory = array();
    $dataHistory = array('approved_by'=>$empid,'approved_status'=>'Completed','requestcode'=>$requestcode);
    $this->OfficialuseModel->save_approved_history($dataHistory);
    ////End History

    $data = array();
    $data = array('request_status'=>'Completed','store_user'=>$empid);
    $this->OfficialuseModel->update_requests($data,$requestcode);
    $this->session->set_flashdata('message','Request been successfully updated');
    redirect('Officialuse/pending_requests');
    }

    public function print_store_combine(){
    $requestcode = base64_decode($this->input->get('I'));
    $rmdata = $this->OfficialuseModel->rm_requesthistory_information($requestcode);
    $pmudata = $this->OfficialuseModel->pmu_requesthistory_information($requestcode);
    //////////// Requested Name
    $data['infor'] = $this->OfficialuseModel->get_request_information($requestcode);
    $data['info'] = $this->ContractModel->get_employee_info($data['infor']->created_by);
    $data['rminfo'] = $this->ContractModel->get_employee_info($rmdata->approved_by);
    $data['pmuinfo'] = $this->ContractModel->get_employee_info($pmudata->approved_by);
    /////////// End of Requested Name
    $empid =  $this->session->userdata('user_emid');
    $data['list'] = $this->OfficialuseModel->get_issued_request_items($requestcode);
    $this->load->library('Pdf');
    $html= $this->load->view('inventory/officialuse_print_store_combine',$data,TRUE);
    $this->load->library('Pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('A4','potrait');
    $this->dompdf->render();
    ob_end_clean();
    $this->dompdf->stream('CRIN.pdf', array("Attachment"=>0)); 
    }

    public function print_hod_store_combine(){
    $requestcode = base64_decode($this->input->get('I'));
    //////////// Requested Name
    $data['infor'] = $this->OfficialuseModel->get_request_information($requestcode);
    $data['info'] = $this->ContractModel->get_employee_info($data['infor']->created_by);
    $data['storeinfo'] = $this->ContractModel->get_employee_info($data['infor']->store_user);
    /////////// End of Requested Name
    $empid =  $this->session->userdata('user_emid');
    $data['list'] = $this->OfficialuseModel->get_issued_request_items($requestcode);
    $this->load->library('Pdf');
    $html= $this->load->view('inventory/store_hod_print_store_combine',$data,TRUE);
    $this->load->library('Pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('A4','potrait');
    $this->dompdf->render();
    ob_end_clean();
    $this->dompdf->stream('CRIN.pdf', array("Attachment"=>0)); 
    }



    public function upload_items(){
          $file = $_FILES['file']['tmp_name'];
          $handle = fopen($file, "r");
          $c = 0;
          
          while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
          {
          $c = $c + 1;
          //skip first row    
          if($c == 1) continue;             
        
          if($filesop[0]){
              
             $name = $filesop[0];
             $data = array();
             $data = array('item_name'=>$name);
             $this->OfficialuseModel->save_items($data);
          }
          }
    }
    

}