 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bureau extends CI_Controller {
	
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
        $this->load->model('BureauModel');
		
		if ($this->session->userdata('user_login_access') == false){
			redirect(base_url());
		}
    }

    public function selling(){
    $checkbcl = $this->BureauModel->get_branch_bclno();
    $branch = $checkbcl->bcl;
    $data['listcurrency'] = $this->BureauModel->get_stock_branch_opening_balance($branch);
    //$data['listcurrency'] = $this->BureauModel->get_currency();
    $data['listidentity'] = $this->BureauModel->get_identity();
    $data['listcountry'] = $this->BureauModel->get_country();
    $data['listpurpose'] = $this->BureauModel->get_purpose();
    $this->load->view('bureau/selling',$data);
    }

    ////////////////////////Reports
    public function buying_report(){
    $this->load->view('bureau/buying_report');
    }

    public function selling_report(){
    $this->load->view('bureau/selling_report');
    }

    public function strong_room_opening_report(){
    $this->load->view('bureau/account_dashboard');
    }

    public function movement_stock_report(){
    $this->load->view('bureau/account_dashboard');
    }
    ///////////////END of Reports

    public function bureau_accounts(){
    $this->load->view('bureau/account_dashboard');
    }

    public function stock_transaction(){
    $this->load->view('bureau/stock_transaction');
    }

    public function voucher_setting(){
    $this->load->view('bureau/setting_account_dashboard');
    }

    public function bureau_reports(){
    $this->load->view('bureau/report_dashboard');
    }

    public function payment_voucher(){
    $this->load->view('bureau/payment_voucher');
    }

    public function receipt_voucher(){
    $this->load->view('bureau/receipt_voucher');
    }

    public function journal_voucher(){
    $this->load->view('bureau/journal_voucher');
    }

    public function account_expenses(){
    $data['list'] = $this->BureauModel->get_bureau_account_expenses();
    $this->load->view('bureau/expenses_services',$data);
    }

    public function books_of_account(){
    $data['list'] = $this->BureauModel->get_bureau_account_list();
    $this->load->view('bureau/books_of_account',$data);
    }

    public function bank_accounts(){
    $data['list'] = $this->BureauModel->get_bureau_account_banks();
    $this->load->view('bureau/banks_accounts',$data);
    }


 public function delete_account_expenses(){
 $id = base64_decode($this->input->get('I'));
 $db2 = $this->load->database('otherdb', TRUE);
 $db2->query("DELETE FROM bureau_account_expenses WHERE bureau_account_list_id='$id'");
 $this->session->set_flashdata('message','Service has been successfully deleted');
 redirect($this->agent->referrer());
 }

 public function delete_books_of_accounts(){
 $id = base64_decode($this->input->get('I'));
 $db2 = $this->load->database('otherdb', TRUE);
 $db2->query("DELETE FROM bureau_account_list WHERE bureau_account_list_id='$id'");
 $this->session->set_flashdata('message','Books of account has been successfully deleted');
 redirect($this->agent->referrer());
 }

 public function delete_bank_accounts(){
 $id = base64_decode($this->input->get('I'));
 $db2 = $this->load->database('otherdb', TRUE);
 $db2->query("DELETE FROM bureau_bank_accounts WHERE bureau_bank_accounts_id='$id'");
 $this->session->set_flashdata('message','Bank account has been successfully deleted');
 redirect($this->agent->referrer());
 }

 public function update_expense(){
 $id = $this->input->post('id');
 $name = $this->input->post('name');
 $data = array('account_name'=>$name);
 $this->BureauModel->update_expense($data,$id);
 $this->session->set_flashdata('message','Service has been successfully updated');
 redirect($this->agent->referrer());
 }

public function update_books_of_account(){
 $id = $this->input->post('id');
 $name = $this->input->post('name');
 $data = array('account_name'=>$name);
 $this->BureauModel->update_books_of_account($data,$id);
 $this->session->set_flashdata('message','Books of account has been successfully updated');
 redirect($this->agent->referrer());
 }

 public function update_bank_accounts(){
 $id = $this->input->post('id');
 $name = $this->input->post('name');
 $accno = $this->input->post('accno');
 $data = array('account_name'=>$name,'account_no'=>$accno);
 $this->BureauModel->update_bank_accounts($data,$id);
 $this->session->set_flashdata('message','Bank account has been successfully updated');
 redirect($this->agent->referrer());
 }


 public function save_expenses(){
    $name = $this->input->post('name');
    $empid = $this->session->userdata('user_emid');
    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');

    foreach($name as $value){
    $data = array();
    $data = array(
        'account_name'=>$value,
        'region'=>$region,
        'branch'=>$branch,
        'operator'=>$empid);
    $this->BureauModel->save_expenses($data);
    }

    $this->session->set_flashdata('message','Service has been successfully added');
    redirect($this->agent->referrer());
    }

    public function save_bank_account(){
    $name = $this->input->post('name');
    $accno = $this->input->post('accno');
    $empid = $this->session->userdata('user_emid');
    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');

    foreach($name as $key => $value){
    $data = array();
    $data = array(
        'account_name'=>$value,
        'account_no'=>$accno[$key],
        'region'=>$region,
        'branch'=>$branch,
        'operator'=>$empid);
    $this->BureauModel->save_bank_account($data);
    }

    $this->session->set_flashdata('message','Bank account has been successfully added');
    redirect($this->agent->referrer());
    }

    public function save_books_of_account(){
    $name = $this->input->post('name');
    $empid = $this->session->userdata('user_emid');
    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');

    foreach($name as $value){
    $data = array();
    $data = array(
        'account_name'=>$value,
        'region'=>$region,
        'branch'=>$branch,
        'operator'=>$empid);
    $this->BureauModel->save_books_of_account($data);
    }

    $this->session->set_flashdata('message','Books of account has been successfully added');
    redirect($this->agent->referrer());
    }

    public function add_payment_voucher(){
    $data['debitlist'] = $this->BureauModel->get_bureau_account_expenses();
    $data['creditlist'] = $this->BureauModel->get_bureau_account_list();
    $data['listcurrency'] = $this->BureauModel->get_main_stock();
    $this->load->view('bureau/add_payment_voucher',$data);
    }

    public function add_receipt_voucher(){
    $data['debitlist'] =  $this->BureauModel->get_bureau_account_banks();
    $data['creditlist'] = $this->BureauModel->get_bureau_account_list();
    $data['listcurrency'] = $this->BureauModel->get_main_stock();
    $this->load->view('bureau/add_receipt_voucher',$data);
    }

    public function add_journal_voucher(){
    $data['debitlist'] = $this->BureauModel->get_bureau_account_list();
    $data['creditlist'] = $this->BureauModel->get_bureau_account_banks();
    $data['listcurrency'] = $this->BureauModel->get_main_stock();
    $this->load->view('bureau/add_journal_voucher',$data);
    }

    public function stock(){
    //$data['listcurrency'] = $this->BureauModel->get_currency();
    //$data['region'] = $this->BureauModel->get_regions();
    $data['list'] = $this->BureauModel->strong_room_opening_balance();
    $data['countpending'] = $this->BureauModel->count_stock_pending_request();
    $this->load->view('bureau/stock',$data);
    }

    public function currency_rates(){
    $data['list'] = $this->BureauModel->currency_rates();
    $this->load->view('bureau/exchange_rates',$data);
    }

    public function counter_currency_rates(){
    $data['list'] = $this->BureauModel->currency_rates();
    $this->load->view('bureau/currency_rates',$data);
    }

    public function add_strong_room_stock(){
    $data['listcurrency'] = $this->BureauModel->get_currency();
    $this->load->view('bureau/add_strong_room_stock',$data);
    }

    public function add_currency_rates(){
    $data['listcurrency'] = $this->BureauModel->get_currency();
    $this->load->view('bureau/add_currency_rates',$data);
    }

    public function strong_room_stock_balance(){
    $data['list'] = $this->BureauModel->strong_room_opening_balance();
    $this->load->view('bureau/strong_room_balance',$data);
    }

    public function stock_pending_request(){
    $data['list'] = $this->BureauModel->get_stock_pending_request();
    $data['listcurrency'] = $this->BureauModel->get_currency();
    $data['countpending'] = $this->BureauModel->count_stock_pending_request();
    $this->load->view('bureau/stock_pending_requests',$data);
    }

    public function branch_stock(){
    $data['region'] = $this->BureauModel->get_regions();
    $this->load->view('bureau/branch_stock',$data);
    }

    public function buying(){
    //$checkbcl = $this->BureauModel->get_branch_bclno();
    //$branch = $checkbcl->bcl;
    //$data['listcurrency'] = $this->BureauModel->get_stock_branch_balance_list($branch);
    $data['listcurrency'] = $this->BureauModel->get_currency();
    $data['listidentity'] = $this->BureauModel->get_identity();
    $data['listcountry'] = $this->BureauModel->get_country();
    $data['listpurpose'] = $this->BureauModel->get_purpose();
    $this->load->view('bureau/buying',$data);
    }

    public function selling_transaction(){
    $this->load->view('bureau/selling_transaction');
    }

    public function send_stock_request(){
    $data['listcurrency'] = $this->BureauModel->get_currency();
    $data['list'] = $this->BureauModel->get_stock_request();
    $this->load->view('bureau/send_stock_request',$data);
    }

    public function send_stock_branch_request(){
    $data['listcurrency'] = $this->BureauModel->get_currency();
    $data['list'] = $this->BureauModel->get_stock_branch_request();
    $data['region'] = $this->BureauModel->get_regions_restriction();
    $checkbcl = $this->BureauModel->get_branch_bclno();
    $bclno = $checkbcl->bcl;
    $data['pendingrequest'] = $this->BureauModel->count_stock_branch_request($bclno);
    $this->load->view('bureau/send_stock_branch_request',$data);
    }

    public function pending_stock_branch_request_list(){
    $data['listcurrency'] = $this->BureauModel->get_currency();
    $checkbcl = $this->BureauModel->get_branch_bclno();
    $bclno = $checkbcl->bcl;
    $data['pendingrequest'] = $this->BureauModel->count_stock_branch_request($bclno);
    $data['list'] = $this->BureauModel->list_pending_stock_branch_request($bclno);
    $this->load->view('bureau/stock_pending_branch_requests',$data);
    }



    public function buying_transaction(){
    $this->load->view('bureau/buying_transaction');
    }

    public function branch_stock_balance(){
    $branch = $this->input->post('branch');
    $data['region'] = $this->BureauModel->get_regions();
    $data['list'] = $this->BureauModel->get_stock_branch_opening_balance($branch);
    $this->load->view('bureau/branch_stock',$data);
    }

    public function branch_stock_currency_balance(){
    $checkbcl = $this->BureauModel->get_branch_bclno();
    $branch = $checkbcl->bcl;
    $data['list'] = $this->BureauModel->get_stock_branch_opening_balance($branch);
    $this->load->view('bureau/branch_stock_balance',$data);
    }

    public function branch_denominated_currency_balance(){
    $checkbcl = $this->BureauModel->get_branch_bclno();
    $branch = $checkbcl->bcl;
    $data['list'] = $this->BureauModel->list_denominated_currency_branch($branch);
    $this->load->view('bureau/branch_denomination_currency',$data);
    }

    public function list_transaction_results(){
    $fromdate = $this->input->get('fromdate');
    $todate =  $this->input->get('todate');
    $status = $this->input->get('status');

    $data['list'] = $this->BureauModel->list_transaction($fromdate,$todate,$status);
    if(!empty($data['list'])){
    if($status=="01"){
    $this->load->view('bureau/selling_transaction',$data);
    }
    else{
    $this->load->view('bureau/buying_transaction',$data);
    }
    }
    else{
    $this->session->set_flashdata('feedback','Transaction report not found!, Please try again');
    if($status=="01"){
    redirect('Bureau/selling_transaction');
    }else{
     redirect('Bureau/buying_transaction');
    }
    }
    }

    public function stock_transaction_results(){
    $fromdate = $this->input->post('fromdate');
    $todate =  $this->input->post('todate');
    $data['list'] = $this->BureauModel->stock_transaction_results($fromdate,$todate);
    if(!empty($data['list'])){
    $this->load->view('bureau/stock_transaction',$data);
    } else {
    $this->session->set_flashdata('feedback','Stock Transaction report not found!, Please try again');
    redirect('Bureau/stock_transaction');

    }
    }

    public function save_currency_rate(){
    $currency = $this->input->post('product_id');
    //$balance = $this->input->post('balance');

    $buyingrate = $this->input->post('buyingrate');
    $minbuying = $this->input->post('minbuying');
    $maxbuying = $this->input->post('maxbuying');
    $sellingrate = $this->input->post('sellingrate');
    $minselling = $this->input->post('minselling');
    $maxselling = $this->input->post('maxselling');

    $empid = $this->session->userdata('user_emid');
    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');

    foreach($currency as $key=>$value){

    $info = $this->BureauModel->Rate_checkCurrencyExist_StrongRoom($value);
    if(!empty($info)){

    $StockdHistory = array();
    $StockdHistory = array(
        'currencyid'=>$value,
        'buying_rate'=>$buyingrate[$key],
        'buy_min_price'=>$minbuying[$key],
        'buy_max_price'=>$maxbuying[$key],
        'selling_rate'=>$sellingrate[$key],
        'sell_min_price'=>$minselling[$key],
        'sell_max_price'=>$maxselling[$key],
        'stock_region'=>$region,
        'stock_branch'=>$branch,
        'stock_created_by'=>$empid);
    $this->BureauModel->update_currency_rate($StockdHistory,$info->bureau_currency_rates_id);

    //UPDATE
    } else { 

    $StockdHistory = array();
    $StockdHistory = array(
        'currencyid'=>$value,
        'buying_rate'=>$buyingrate[$key],
        'buy_min_price'=>$minbuying[$key],
        'buy_max_price'=>$maxbuying[$key],
        'selling_rate'=>$sellingrate[$key],
        'sell_min_price'=>$minselling[$key],
        'sell_max_price'=>$maxselling[$key],
        'stock_region'=>$region,
        'stock_branch'=>$branch,
        'stock_created_by'=>$empid);
    $this->BureauModel->Save_currency_rate($StockdHistory);

    }

    }


    $this->session->set_flashdata('success','Currency Rate has been successfully added');
    redirect('Bureau/add_currency_rates');
    }

    public function save_stock(){
    $currency = $this->input->post('product_id');
    $balance = $this->input->post('balance');

    $buyingrate = $this->input->post('buyingrate');
    $sellingrate = $this->input->post('sellingrate');

    $empid = $this->session->userdata('user_emid');
    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');


  foreach($currency as $key=>$value){


    $StockdHistory = array();
    $StockdHistory = array(
        'currencyid'=>$value,
        'stock_amount'=>$balance[$key],
        'buying_price'=>$buyingrate[$key],
        'selling_price'=>$sellingrate[$key],
        'stock_region'=>$region,
        'stock_branch'=>$branch,
        'stock_created_by'=>$empid);
    $this->BureauModel->Save_StockdHistory($StockdHistory);


  /* $check = $this->BureauModel->branch_stock_currency_qty_balance_strog_room($value);
   if(!empty($check)){
             //UPDATE
             $newbalance = $check->stock_amount+$balance[$key];
             $dataStoreStock = array();
             $dataStoreStock = array(
             'stock_amount'=>$newbalance
             );
    $this->BureauModel->update_stock_by_currenctvalue($dataStoreStock,$value);
   } else {
   /////////////////Save to the Store Stock
    $data = array();
    $data = array(
        'currencyid'=>$value,
        'stock_amount'=>$balance[$key],
        'stock_region'=>$region,
        'stock_branch'=>$branch,
        'stock_created_by'=>$empid);
    $this->BureauModel->save_stock($data);
     }
    //END
     */

    }

    $this->session->set_flashdata('success','New stock has been successfully added');
    redirect('Bureau/add_strong_room_stock');
    }

    public function save_branch_stock(){
    $empid = $this->session->userdata('user_emid');
    $currency = $this->input->post('currency');
    $balance = $this->input->post('balance');
    $region = $this->input->post('region');
    $branch = $this->input->post('branch');
    //check currency if exist on the stock
    $checkexist = $this->BureauModel->check_currency_stock($currency);
    if($checkexist>0){
    /////////////////
    ////Update current Stock
    $info =  $this->BureauModel->currency_stock_information($currency);
    $newbalance = $info->stock_amount-$balance;
    $UpdateStock = array(); $UpdateStock =  array('stock_amount'=>$newbalance);
    $this->BureauModel->update_stock_by_currencyID($UpdateStock,$currency);
    /////////////////
    $check = $this->BureauModel->check_branch_bcl_currency_stock($currency,$branch);
    if($check>0){
    $sinfo =  $this->BureauModel->currency_stock_branch_information($currency,$branch);
    $snbalance = $sinfo->stock_balance+$balance;
    //Update Branch Stock
    $UpdateBranchStock = array();
    $UpdateBranchStock = array('stock_balance'=>$snbalance,'transfered_by'=>$empid);
    $this->BureauModel->update_branch_stock_by_currencyID($UpdateBranchStock,$currency,$branch);
    }
    else{
    $data = array();
    $data = array('currencyid'=>$currency,'stock_balance'=>$balance,'region'=>$region,'bclno'=>$branch,'transfered_by'=>$empid);
    $this->BureauModel->save_branch_stock($data);
    }
    $this->session->set_flashdata('message','Currency has been successfully added on Branch Stock');
    } else {
    $this->session->set_flashdata('feedback','Currency does not exist on Bureau De Change Stock, Please update your stock');
    }
    redirect('Bureau/stock');
    }

    public function return_balance(){
    $empid = $this->session->userdata('user_emid');
    $checkbcl = $this->BureauModel->get_branch_bclno();
    $branch = $checkbcl->bcl;
    $list = $this->BureauModel->get_stock_branch_balance_list($branch);

    if(!empty($list)){

    foreach($list as $data){
    $info =  $this->BureauModel->stock_currency_qty_balance($data->currencyid);
    $newbalance = $data->stock_balance+$info->stock_amount;
    $UpdateStock = array(); $UpdateStock =  array('stock_amount'=>$newbalance);
    $this->BureauModel->update_stock_by_currenctvalue($UpdateStock,$data->currencyid);

    ///////////////INSERT Logs
    $dataLogs = array();
    $dataLogs = array('currencyid'=>$data->currencyid,'stock_balance'=>$data->stock_balance,'region'=>$data->region,'bclno'=>$data->bclno,' operator'=>$empid,' logs_status'=>'Return Balance','requestcode'=>$data->requestcode);
    $this->BureauModel->save_branch_stock_logs($dataLogs);

    ///REMOVE BRANCH BALANCE
    $this->BureauModel->delete_branch_stock($data->bureau_branch_stock_id);
    }
    $this->session->set_flashdata('message','Stock balance has been successfully returned');
    } else {
    $this->session->set_flashdata('feedback','You have no stock balance, You cant use this operation');
    }
    redirect('Bureau/branch_stock_currency_balance');
    }

    public function update_stock(){
    $stockid = $this->input->post('stockid');
    $currency = $this->input->post('currency');
    $balance = $this->input->post('balance');
    $data = array();
    $data = array('currencyid'=>$currency,'stock_amount'=>$balance);
    $this->BureauModel->update_stock($data,$stockid);
    $this->session->set_flashdata('message','Stock has been successfully updated');
    redirect('Bureau/stock');
    }

    public function delete_stock(){
    $deleteid =  base64_decode($this->input->get('I'));
    $this->BureauModel->delete_stock($deleteid);
    $this->session->set_flashdata('message','Currency on the stock has been successfully deleted');
    redirect('Bureau/stock');
    }

    public function delete_currency_rate(){
    $deleteid =  base64_decode($this->input->get('I'));
    $db2 = $this->load->database('otherdb', TRUE);
    $db2->query("DELETE FROM bureau_currency_rates WHERE bureau_currency_rates_id='$deleteid'");
    $this->session->set_flashdata('message','Currency rate has been successfully deleted');
    redirect('Bureau/currency_rates');
    }

    public function update__trans_stock(){
    $id =  base64_decode($this->input->get('I'));
    $data = array('stock_status'=>'CANCELLED');
    echo $id;
    $this->BureauModel->update_stock_strongroom_transaction($data,$id);
    $this->session->set_flashdata('success','Stock Transaction has been successfully cancelled');
    redirect('Bureau/stock_transaction');
    }

    public function delete_branch_stock(){
    $deleteid =  base64_decode($this->input->get('I'));
    $this->BureauModel->delete_branch_stock($deleteid);
    $this->session->set_flashdata('message','Currency on the branch stock has been successfully deleted');
    redirect('Bureau/stock');
    }

    public function delete_denominated_stock(){
    $deleteid =  base64_decode($this->input->get('I'));
    $this->BureauModel->delete_denominated_stock($deleteid);
    $this->session->set_flashdata('message','Currency on the denomination has been successfully deleted');
    redirect($this->agent->referrer());
    }

    public function save_stock_request(){
    $checkbcl = $this->BureauModel->get_branch_bclno();
    $bclno = $checkbcl->bcl;
    $branch = $this->session->userdata('user_branch');
    $empid = $this->session->userdata('user_emid');
    $region = $this->session->userdata('user_region');
    $requestcode = $bclno.''.date('YmdHis').''.$empid;
    $dataRequest = array();
    $dataRequest = array('requested_by'=>$empid,'region'=>$region,'branch'=>$branch,'request_code'=>$requestcode,'bclno'=>$bclno);
    $this->BureauModel->save_stock_request_currency_info($dataRequest);

    /////////////
    $currency = $this->input->post('currency');
    $balance = $this->input->post('balance');
    foreach($currency as $key=>$value){
    $data = array();
    $data = array('currencyid'=>$value,'amount'=>$balance[$key],'requestcode'=>$requestcode);
    $this->BureauModel->save_stock_request_currency_list($data);
    }
    ///////////////////////////
    $this->session->set_flashdata('message','Stock Request has been successfully sent, Please wait for confirmation');
    redirect('Bureau/send_stock_request');
    }

    public function save_stock_branch_request(){
    $checkbcl = $this->BureauModel->get_branch_bclno();
    $frombclno = $checkbcl->bcl;
    $tobclno = $this->input->post('branch');
    $branch = $this->session->userdata('user_branch');
    $empid = $this->session->userdata('user_emid');
    $region = $this->session->userdata('user_region');
    $requestcode = $frombclno.''.date('YmdHis').''.$empid;
    $dataRequest = array();
    $dataRequest = array('requested_by'=>$empid,'region'=>$region,'branch'=>$branch,'request_code'=>$requestcode,'frombclno'=>$frombclno,'tobclno'=>$tobclno);
    $this->BureauModel->save_stock_branch_request_currency_info($dataRequest);

    /////////////
    $currency = $this->input->post('currency');
    $balance = $this->input->post('balance');
    foreach($currency as $key=>$value){
    $data = array();
    $data = array('currencyid'=>$value,'amount'=>$balance[$key],'requestcode'=>$requestcode);
    $this->BureauModel->save_stock_request_currency_list($data);
    }
    ///////////////////////////
    $this->session->set_flashdata('message','Stock Request has been successfully received, Please wait for confirmation');
    redirect('Bureau/send_stock_branch_request');
    }


    public function save_denomination(){
    ///Denomination Currency
    $empid = $this->session->userdata('user_emid');
    $currency = $this->input->post('dcurrency');
    $currencyvalue = $this->input->post('dvalue');
    $balance = $this->input->post('dbalance');
    $requestcode = $this->input->post('requestcode');
    $checkbcl = $this->BureauModel->get_branch_bclno();
    $branch = $checkbcl->bcl;

        ///////Save Denomination
    foreach($currency as $key=>$value){
             $data = array();
             $data = array(
            'currencyid'=>$value,
             'qty'=>$balance[$key],
             'currencyvalue'=>$currencyvalue[$key],
             'requestcode'=>$requestcode,
             'issuedby'=>$empid,
             'bclno'=>$branch
         );
    $this->BureauModel->save_denomination_branch_stock($data);
    }
    ///End of Save Denomination
    $this->session->set_flashdata('message','Denomination been successfully added');
    redirect($this->agent->referrer());
    }

    public function save_approved_request(){
    $empid = $this->session->userdata('user_emid');
    $getcurrencyid = $this->input->post('currencyid');
    $qty = $this->input->post('qty');
    $requestcode = $this->input->post('requestcode');
    $status = $this->input->post('status');

    $branch = $this->session->userdata('user_branch');
    $empid = $this->session->userdata('user_emid');
    $region = $this->session->userdata('user_region');
    $info = $this->BureauModel->stock_send_get_info($requestcode);



    if($status=="approved"){
    //////////Request Information
    foreach($getcurrencyid as $key=>$value){
    $qtyAmount = $qty[$key];
    $currencyid = $value;
    $getfifo_info = $this->BureauModel->get_fifo_currency_stock_by_id($currencyid);//fifo info
    echo "<pre>";
    print_r($getfifo_info);


    if(!empty($qtyAmount) && $qtyAmount > 0 && !empty($getfifo_info)){


           $requiredAmount = $qtyAmount;
           do{
            //hii ya mwisho itatusaidia kupata current selling rate ya currency na tutaitumia kujua faida baada ya kuuza
            //$fifocurrencyinfo = $this->BureauModel->get_fifo_currency_stock_by_id($currencyid);//fifo info
            $currencyinfoyamwisho = $this->BureauModel->get_fifo_currency_stock_by_id_latest($currencyid);//fifo info

            //////////FIFO Concept
            //get stronngroom  fifo  
            //status ya fifo hizi zisiwe complete na remain isiwe ni zero
            $fifocurrencyinfo = $this->BureauModel->get_fifo_currency_stock_by_id($currencyid);//fifo info

            $currencyinfofifoquantity=$fifocurrencyinfo->Quantityoffifo;//Quantity za kwenye fifo
             $currencyinfofifoquantitystock_amount_out=$fifocurrencyinfo->stock_amount_out;//Quantity za kwenye fifo
            $fifoQuantityremain=0;//this will remain baada ya kupunguza  kutoka kwenye quantity tunazotaka
            $StockQuantitytaken=0;//quantity zilizopatikana kwa counter
            $StockQuantityout=0;//quantity zilizopatikana kwa counter
            if($currencyinfofifoquantity > $requiredAmount) //ikiwa fifo quantity ni kubwa
            {
                $StockQuantityout=  $requiredAmount + $currencyinfofifoquantitystock_amount_out ; //fifo ina nyingi so hapa itapata zote iombazo
                //$fifoQuantityremain= $currencyinfofifoquantity-$requiredAmount ;
                
                $StockQuantitytaken= $requiredAmount;
                $requiredAmount=0; //required zimeisha hii haitaloop
               
                  //update table ya strongroom with -new remain quantity na -status incomplete bado zipo
                  $UpdateStrongRoom = array('stock_amount_out'=>$StockQuantityout);
                  $this->BureauModel->UpdateStrongRoom(@$UpdateStrongRoom,@$fifocurrencyinfo->bureau_strong_room_stock_id);

                  ///haijamaliza quantity zote za kwenye hiyo transaction
                  //////Angalia kama bado zipo au bado
                  $CheckExistBalance = $this->BureauModel->get_fifo_currency_stock_by_id($currencyid);
                  if($CheckExistBalance->Quantityoffifo==0.00){
                  ///////Change Status
                  $UpdateStrongRoom = array('stock_status'=>'COMPLETE');
                  $this->BureauModel->UpdateStrongRoom(@$UpdateStrongRoom,@$CheckExistBalance->bureau_strong_room_stock_id);
                  }
                

                
                

            }
             else //fifo quantity ni ndogo kwa hiyo itaendelea na loop mbaka imalize required Amount ifike zero
             {

                $StockQuantityout= $currencyinfofifoquantity + $currencyinfofifoquantitystock_amount_out; //fifo ina ndogo so hapa itapata  zile za kutoka kwenye fifo tu
                 $requiredAmount=$requiredAmount-$currencyinfofifoquantity;
                 $fifoQuantityremain= 0;
                  $StockQuantitytaken= $currencyinfofifoquantity;
                   //update table ya stronngroom with new remain quantity na status complete
                  $UpdateStrongRoom = array('stock_amount_out'=>$StockQuantityout);
                  $this->BureauModel->UpdateStrongRoom(@$UpdateStrongRoom,@$fifocurrencyinfo->bureau_strong_room_stock_id);


                   $CheckExistBalance = $this->BureauModel->get_fifo_currency_stock_by_id($currencyid);
                  if($CheckExistBalance->Quantityoffifo==0.00){
                  ///////Change Status
                  $UpdateStrongRoom = array('stock_status'=>'COMPLETE');
                  $this->BureauModel->UpdateStrongRoom(@$UpdateStrongRoom,@$CheckExistBalance->bureau_strong_room_stock_id);
                  } 

             }

             //update tables
            //tengeneza counter transaction row inayochukua hizo quantity
            //ionyeshe idadi ya quantity iliyochukua ambayo ni sawa na StockQuantitytaken
            //ionyeshe selling price from $currencyinfoyamwisho

               /////////Insert Transactions
            
                $latestsellingprice=$currencyinfoyamwisho->selling_price;
                $fifosellingprice=$fifocurrencyinfo->selling_price;
                $pricetakeninstock=0;
                //check ipi kubwa kati ya selling price ya fifo na ile ya mwisho ili kuepuka hasala na chukua kubwa
                 if($latestsellingprice > $fifosellingprice){
                $pricetakeninstock=$latestsellingprice; }
                else { $pricetakeninstock=$fifosellingprice; }
                

             $dataBranch = array(
             'currencyid'=>$currencyid,
             'stock_balance'=>$StockQuantitytaken,
             'region'=>@$info->region,
             'bclno'=>@$info->bclno,
             'transfered_by'=>@$empid,
             'requestcode'=>@$requestcode,
             'stock_balance_buying_price'=>@$fifocurrencyinfo->buying_price,
             'stock_balance_selling_price'=>@$pricetakeninstock,
             'shopper'=>@$info->requested_by,
             'strongroomstockid'=>@$fifocurrencyinfo->bureau_strong_room_stock_id);
             $this->BureauModel->save_branch_stock($dataBranch);


             ////////////
             $saveissued = array();
             $saveissued = array(
             'currencyid'=>$currencyid,
             'amount'=>$StockQuantitytaken,
             'issuedby'=>@$empid,
             'requestcode'=>@$requestcode,
             'stock_balance_buying_price'=>@$fifocurrencyinfo->buying_price,
             'stock_balance_selling_price'=>@$pricetakeninstock,
             'strongroomstockid'=>@$fifocurrencyinfo->bureau_strong_room_stock_id
             );
             $this->BureauModel->save_issued_branch_stock($saveissued);
            
            
          } while($requiredAmount > 0);

        }

    }

    }


    $Approveddata = array();
    $Approveddata = array('request_status'=>$status,'received_by'=>$empid);
    $this->BureauModel->update_stock_send_requests($Approveddata,$requestcode);
    $this->session->set_flashdata('message','Request been successfully updated');
    redirect('Bureau/stock_pending_request');

    //$this->load->view('bureau/stock_pending_requests',$data);
    }

    public function strong_room_stock_summary(){
    $currencyid = base64_decode($this->input->get('I'));
    $data['list'] =$this->BureauModel->strong_room_opening_balance_summary_by_ID($currencyid);
    $this->load->view('bureau/stock_transaction_currenct_summary',$data);
    }


    public function save_approved_branch_request_transfer_money(){
    $empid = $this->session->userdata('user_emid');
    $currencyid = $this->input->post('currencyid');
    $qty = $this->input->post('qty');
    $requestcode = $this->input->post('requestcode');
    $status = $this->input->post('status');


    if($status=="confirmed"){

    //////////Request Information
    $info = $this->BureauModel->stock_send_get_branch_info($requestcode);
    ///////// Save to Issued & Stock Branch /////////
    foreach($currencyid as $key=>$value){
             if(!empty($qty[$key])){
             $dataIssued = array();
             $dataIssued = array(
            'currencyid'=>$value,
             'amount'=>$qty[$key],
             'requestcode'=>$requestcode,
             'issuedby'=>$empid);
    $this->BureauModel->save_issued_branch_stock($dataIssued);
               }
    }
    /////////////////////
    /////Save Stock Branch
    foreach($currencyid as $key=>$value){
             if(!empty($qty[$key])){
             $dataBranch = array();
             $dataBranch = array(
            'currencyid'=>$value,
             'stock_balance'=>$qty[$key],
             'region'=>$info->region,
             'bclno'=>$info->frombclno,
             'transfered_by'=>$empid,
             'requestcode'=>$requestcode);
    $this->BureauModel->save_branch_stock($dataBranch);
            }
    }
    ////Update Current Stock -------- STRONGROOM
    $checkbcl = $this->BureauModel->get_branch_bclno();
    $bclno = $checkbcl->bcl;
    foreach($currencyid as $key=>$value){
    if(!empty($qty[$key])){
    $row = $this->BureauModel->branch_stock_currency_qty_balance($value,$bclno);
    $balance = $row->stock_balance-$qty[$key];
    $UpdateStock= array();
    $UpdateStock = array('stock_balance'=>$balance);
    $this->BureauModel->update_stock_by_currenctvalue_branch_stock_balance($UpdateStock,$value,$bclno);
    }
    }
    //////END
    }

    
    $data = array();
    $data = array('request_status'=>$status);
    $this->BureauModel->update_stock_send_branch_requests($data,$requestcode);
    $this->session->set_flashdata('message','Request been successfully updated');
    redirect('Bureau/pending_stock_branch_request_list');
    }


    public function save_supervisor_approved_branch_request(){
    $empid = $this->session->userdata('user_emid');
    $requestcode = $this->input->post('requestcode');
    $status = $this->input->post('status');
    
    $data = array();
    $data = array('request_status'=>$status,'approved_by'=>$empid);
    $this->BureauModel->update_stock_send_branch_requests($data,$requestcode);
    $this->session->set_flashdata('message','Request been successfully updated');
    redirect('Bureau/pending_stock_branch_request_list');
    }


    public function save_accounts_information(){
    $empid = $this->session->userdata('user_emid');
    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');

        //Transaction
        $amount = $this->input->post('qty');
        $debit = $this->input->post('payingto');
        $credit = $this->input->post('payingfrom');
        $currency = $this->input->post('product_id');
        $desc = $this->input->post('desc');
        $status = $this->input->post('status');

    if($status=="payment_voucher"){
    $trans = "Payment Voucher";
    } elseif($status=="receipt_voucher"){
    $trans = "Receipt Voucher";
    } else {
    $trans = "Journal Voucher";
    }

    foreach($amount as $key=>$value){

    $currencyinfo = $this->BureauModel->get_strong_room_balance_information($currency[$key]);
    $data = array(
    'debit'=>@$debit[$key],
    'credit'=>@$credit[$key],
    'currency'=>@$currencyinfo->currency_desc,
    'amount'=>@$value,
    'description'=>@$desc[$key],
    'account_type'=>@$status,
    'operator'=>@$empid,
    'branch'=>@$branch,
    'region'=>@$region
    );
    $this->BureauModel->save_accounts_information($data);

   
    if($status=="payment_voucher"){
    ////////////UPDATE BRANCH STOCK
    $snbalance = $currencyinfo->stock_amount-$value;
    //Update Branch Stock
    $UpdateBranchStock = array();
    $UpdateBranchStock = array('stock_amount'=>$snbalance);
    $this->BureauModel->update_stock_by_currenctvalue($UpdateBranchStock,$currency[$key]);
    /////END OF UPDATE BRANCH STOCK
    }

    }


    $this->session->set_flashdata('success',''.$trans.' has been successfully saved');
    redirect($this->agent->referrer());

    }



public function print_account_voucher(){
    $data['fromdate'] = $this->input->get('fromdate');
    $data['todate'] = $this->input->get('todate');
    $status = $this->input->get('status');
    $empid = $this->session->userdata('user_emid');
    $todaydate = date("Y-m-dHis");

   $info = $this->employee_model->GetBasic($empid);
   $data['preparedby']= 'PF'.' '.$info->em_code.' '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;

    if($status=="payment_voucher"){
    $data['vouchertype'] = "Payment Voucher";
    $data['debit'] = "Paying To (Dr)";
    $data['credit'] = "Paying From (Cr)";
    } elseif($status=="receipt_voucher"){
    $data['vouchertype'] = "Receipt Voucher";
    $data['debit'] = "Going To (Dr)";
    $data['credit'] = "Received From (Cr)";
    } else {
    $data['vouchertype'] = "Journal Voucher";
    $data['debit'] = "Debit To (Dr)";
    $data['credit'] = "Credit To (Cr)";
    }




    $data['list'] = $this->BureauModel->get_voucher_information($data['fromdate'],$data['todate'],$status);

    if(!empty($data['list'])){   
    $this->load->library('Pdf');
    $html= $this->load->view('bureau/voucher',$data,TRUE);
    $this->load->library('Pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('A4','potrait');
    $this->dompdf->render();
    ob_end_clean();
    $this->dompdf->stream($status.'-'.$todaydate.'-'.$empid, array("Attachment"=>0)); 

    } else {
 
    $this->session->set_flashdata('feedback',''.$data['vouchertype'].' Not Found, Please try again');
    redirect($this->agent->referrer());

    }

 }


    public function save_sell_transaction(){
        //customer information
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $id = $this->input->post('id');
        $purpose = $this->input->post('purpose');
        $country = $this->input->post('country');
        $idno = $this->input->post('idno');
        $serial = strtoupper(substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 9));
        $receipt = substr(str_shuffle("0123456789"), 0, 6);
        $appno =  substr(str_shuffle("0123456789"), 0, 6);

        ////////////OTHER INPUTS
        $iddesc = $this->input->post('iddesc');
        $purposedesc = $this->input->post('purposedesc');

        $empid = $this->session->userdata('user_emid');
        $region = $this->session->userdata('user_region');
        $branch = $this->session->userdata('user_branch');


        //Transaction
        $rate = $this->input->post('qty');
        $amount = $this->input->post('price');
        $vat = $this->input->post('vat');
        $currency = $this->input->post('product_id');

      foreach($rate as $key=>$value){
        $tamount = $amount[$key];
        $tvat = $vat[$key];
        $tcurrency = $currency[$key];

      $SaveTransaction = array(
      'customer_name'=>@$name,
      'customer_mobile'=>@$phone,
      'customer_identity'=>@$id,
      'customer_identity_no'=>@$idno,
      'currencyid'=>@$tcurrency,
      'currency_rate'=>@$value,
      'exchange_amount'=>@$tamount,
      'vat'=>@$tvat,
      'operator'=>@$empid,
      'region'=>@$region,
      'branch'=>@$branch,
      'transaction_type'=>'01',
      'serial'=>@$serial,
      'purposeid'=>@$purpose,
      'receipt'=>@$receipt,
      'appno'=>@$appno,
      'country'=>@$country,
      'iddesc'=>@$iddesc,
      'purposedesc'=>@$purposedesc
      );
      $this->BureauModel->save_transactions($SaveTransaction);
        }


    ///////////////////////SELLING FIFO TECHNIQUES
    //////////Request Information
    $checkbcl = $this->BureauModel->get_branch_bclno();
    $blcnobranch = $checkbcl->bcl;
    $getcurrencyid = $this->input->post('product_id');

    foreach($getcurrencyid as $key=>$value){
    $qtyAmount = $amount[$key];
    $currencyid = $value;


    $getfifo_info = $this->BureauModel->FIFO_COUNTER_BALANCE_get_stock_branch_opening_balance($blcnobranch,$currencyid);//fifo info
   //echo "<pre>";
    //print_r($getfifo_info);


    if(!empty($qtyAmount) && $qtyAmount > 0 && !empty($getfifo_info)){


           $requiredAmount = $qtyAmount;
           do{
            //hii ya mwisho itatusaidia kupata current selling rate ya currency na tutaitumia kujua faida baada ya kuuza
            //$fifocurrencyinfo = $this->BureauModel->get_fifo_currency_stock_by_id($currencyid);//fifo info
        $currencyinfoyamwisho = $this->BureauModel->COUNTER_CURRENCY_FIFO_LATEST_PRICE_get_stock_branch_opening_balance($blcnobranch,$currencyid);//fifo info

            //////////FIFO Concept
            //get stronngroom  fifo  
            //status ya fifo hizi zisiwe complete na remain isiwe ni zero
            $fifocurrencyinfo = $this->BureauModel->FIFO_COUNTER_BALANCE_get_stock_branch_opening_balance($blcnobranch,$currencyid);//fifo info

            $currencyinfofifoquantity=$fifocurrencyinfo->Quantityoffifo;//Quantity za kwenye fifo
            $currencyinfofifoquantitystock_amount_out=$fifocurrencyinfo->stock_balance_out;//Quantity za kwenye fifo
            $fifoQuantityremain=0;//this will remain baada ya kupunguza  kutoka kwenye quantity tunazotaka
            $StockQuantitytaken=0;//quantity zilizopatikana kwa counter
            $StockQuantityout=0;//quantity zilizopatikana kwa counter
            if($currencyinfofifoquantity > $requiredAmount) //ikiwa fifo quantity ni kubwa
            {
                $StockQuantityout=  $requiredAmount + $currencyinfofifoquantitystock_amount_out; //fifo ina nyingi so hapa itapata zote iombazo
                //$fifoQuantityremain= $currencyinfofifoquantity-$requiredAmount ;
                
                $StockQuantitytaken= $requiredAmount;
                $requiredAmount=0; //required zimeisha hii haitaloop
               
                  //update table ya strongroom with -new remain quantity na -status incomplete bado zipo
                  $UpdateStrongRoom = array('stock_balance_out'=>$StockQuantityout);
                  $this->BureauModel->Counter_UpdateStrongRoom(@$UpdateStrongRoom,@$fifocurrencyinfo->bureau_branch_stock_id);

                  ///haijamaliza quantity zote za kwenye hiyo transaction
                  //////Angalia kama bado zipo au bado
                  $CheckExistBalance = $this->BureauModel->FIFO_COUNTER_BALANCE_get_stock_branch_opening_balance($blcnobranch,$currencyid);
                  if($CheckExistBalance->Quantityoffifo==0.00){
                  ///////Change Status
                  $UpdateStrongRoom = array('bureau_branch_stock_status'=>'COMPLETE');
                  $this->BureauModel->Counter_UpdateStrongRoom(@$UpdateStrongRoom,@$CheckExistBalance->bureau_branch_stock_id);
                  }

            }
             else //fifo quantity ni ndogo kwa hiyo itaendelea na loop mbaka imalize required Amount ifike zero
             {

                $StockQuantityout= $currencyinfofifoquantity + $currencyinfofifoquantitystock_amount_out; //fifo ina ndogo so hapa itapata  zile za kutoka kwenye fifo tu
                 $requiredAmount=$requiredAmount-$currencyinfofifoquantity;
                 $fifoQuantityremain= 0;
                  $StockQuantitytaken= $currencyinfofifoquantity;
                   //update table ya stronngroom with new remain quantity na status complete
                  
                  $UpdateStrongRoom = array('stock_balance_out'=>$StockQuantityout);
                  $this->BureauModel->Counter_UpdateStrongRoom(@$UpdateStrongRoom,@$fifocurrencyinfo->bureau_branch_stock_id);

                 $CheckExistBalance = $this->BureauModel->FIFO_COUNTER_BALANCE_get_stock_branch_opening_balance($blcnobranch,$currencyid);
                  if($CheckExistBalance->Quantityoffifo==0.00){
                  ///////Change Status
                  $UpdateStrongRoom = array('bureau_branch_stock_status'=>'COMPLETE');
                  $this->BureauModel->Counter_UpdateStrongRoom(@$UpdateStrongRoom,@$CheckExistBalance->bureau_branch_stock_id);
                  }

             }

             //update tables
            //tengeneza counter transaction row inayochukua hizo quantity
            //ionyeshe idadi ya quantity iliyochukua ambayo ni sawa na StockQuantitytaken
            //ionyeshe selling price from $currencyinfoyamwisho

               /////////Insert Transactions
            
               /* $latestsellingprice=$currencyinfoyamwisho->selling_price;
                $fifosellingprice=$fifocurrencyinfo->selling_price;
                $pricetakeninstock=0;
                //check ipi kubwa kati ya selling price ya fifo na ile ya mwisho ili kuepuka hasala na chukua kubwa
                 if($latestsellingprice > $fifosellingprice){
                $pricetakeninstock=$latestsellingprice; }
                else { $pricetakeninstock=$fifosellingprice; }*/
                
             $savesoldout = array();
             $savesoldout = array(
             'currencyid'=>$currencyid,
             'exchange_amount'=>$StockQuantitytaken,
             'region'=>@$region,
             'branch'=>@$branch,
             'bclno'=>@$blcnobranch,
             'operator'=>@$empid,
             'serial'=>@$serial,
             'receipt'=>@$receipt,
             'counter_id'=>@$fifocurrencyinfo->bureau_branch_stock_id,
             'strongroom_id'=>@$fifocurrencyinfo->strongroomstockid);
             $this->BureauModel->bureau_currency_sold_out($savesoldout);

            
          } while($requiredAmount > 0);

        }

    }

    ///////////////END OF FIFO

       
        //GENERATE XML FILE
        $this->generate_xml($serial);
        //END OF FILE GENERATED
        //SEND SMS
        //Total Amount of Transaction
        $value = $this->BureauModel->sum_customer_transaction($serial);
        $amount = $value->totalamount;
        $sms ='KARIBU POSTA KIGANJANI umepokea kiasi cha '. ' '.number_format($amount,2).', Risiti Namba '.$receipt.' Kwenye huduma ya Posta Bureau De Change '.'';
        $this->send_sms($phone,$sms);

    //////////////////UPDATE TANZANIA SHILLINGS
    /*$tzinfo =  $this->BureauModel->tz_currency_stock_branch_information($branch);
    $tzbalance = $tzinfo->stock_balance+$amount;
    //Update Branch Stock
    $TZUpdateBranchStock = array();
    $TZUpdateBranchStock = array('stock_balance'=>$tzbalance);
    $this->BureauModel->tz_update_branch_stock_by_currencyID($TZUpdateBranchStock,$branch);
        //////////END OF TANZANIA SHILLINGS*/

               ////////INSERT TANZANIA SHILLINGS CURRENCY ON THE STOCK
             ///////////Save Stock as Counter
             $dataBranch = array(
             'currencyid'=>55,
             'stock_balance'=>$amount,
             'region'=>@$region,
             'bclno'=>@$blcnobranch,
             'transfered_by'=>@$empid,
             'requestcode'=>@$requestcode,
             'stock_balance_buying_price'=>0,
             'stock_balance_selling_price'=>0,
             'shopper'=>@$empid,
             'stock_request'=>'COUNTER',
             'strongroomstockid'=>@$receipt,
             'requestcode'=>$serial
              );
             $this->BureauModel->save_branch_stock($dataBranch);
             //////////Save Stock as Counter

            //////////Issued to Branch Stock History
             $saveissued = array();
             $saveissued = array(
             'currencyid'=>55,
             'amount'=>$amount,
             'issuedby'=>@$empid,
             'requestcode'=>@$serial,
             'stock_balance_buying_price'=>0,
             'stock_balance_selling_price'=>0,
             'strongroomstockid'=>@$receipt,
             'issued_by'=>'COUNTER'
             );
             $this->BureauModel->save_issued_branch_stock($saveissued);
             ///////////End of Issued Currenct
             ///////////////UPDATE TANZANIA SHILLINGS



    $this->session->set_flashdata('success','Transaction has been successfully');
    redirect($this->agent->referrer());

    }

    public function save_buy_transaction(){
        //customer information
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $id = $this->input->post('id');
        $purpose = $this->input->post('purpose');
        $country = $this->input->post('country');
        $idno = $this->input->post('idno');
        $serial = strtoupper(substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 9));
        $receipt = substr(str_shuffle("0123456789"), 0, 6);
        $appno =  substr(str_shuffle("0123456789"), 0, 6);

        ////////////OTHER INPUTS
        $iddesc = $this->input->post('iddesc');
        $purposedesc = $this->input->post('purposedesc');

        $empid = $this->session->userdata('user_emid');
        $region = $this->session->userdata('user_region');
        $branch = $this->session->userdata('user_branch');

        $checkbcl = $this->BureauModel->get_branch_bclno();
        $blcnobranch = $checkbcl->bcl;

        //Transaction
        $rate = $this->input->post('qty');
        $amount = $this->input->post('price');
        $vat = $this->input->post('vat');
        $currency = $this->input->post('product_id');

        foreach($rate as $key=>$value){
        $tamount = $amount[$key];
        $tvat = $vat[$key];
        $tcurrency = $currency[$key];
        

      $SaveTransaction = array(
      'customer_name'=>@$name,
      'customer_mobile'=>@$phone,
      'customer_identity'=>@$id,
      'customer_identity_no'=>@$idno,
      'currencyid'=>@$tcurrency,
      'currency_rate'=>@$value,
      'exchange_amount'=>@$tamount,
      'vat'=>@$tvat,
      'operator'=>@$empid,
      'region'=>@$region,
      'branch'=>@$branch,
      'transaction_type'=>'02',
      'serial'=>@$serial,
      'purposeid'=>@$purpose,
      'receipt'=>@$receipt,
      'appno'=>@$appno,
      'country'=>@$country,
      'iddesc'=>@$iddesc,
      'purposedesc'=>@$purposedesc
      );
      $this->BureauModel->save_transactions($SaveTransaction);

            $priceinfo = $this->BureauModel->get_ciunter_buying_rates($tcurrency);
             
             ///////////Save Stock as Counter
             $dataBranch = array(
             'currencyid'=>$tcurrency,
             'stock_balance'=>$tamount,
             'region'=>@$region,
             'bclno'=>@$blcnobranch,
             'transfered_by'=>@$empid,
             'requestcode'=>@$requestcode,
             'stock_balance_buying_price'=>@$value,
             'stock_balance_selling_price'=>@$priceinfo->sell_min_price,
             'shopper'=>@$empid,
             'stock_request'=>'COUNTER',
             'strongroomstockid'=>@$receipt,
             'requestcode'=>$serial
              );
             $this->BureauModel->save_branch_stock($dataBranch);
             //////////Save Stock as Counter

            //////////Issued to Branch Stock History
             $saveissued = array();
             $saveissued = array(
             'currencyid'=>$tcurrency,
             'amount'=>$tamount,
             'issuedby'=>@$empid,
             'requestcode'=>@$serial,
             'stock_balance_buying_price'=>@$value,
             'stock_balance_selling_price'=>@$priceinfo->sell_min_price,
             'strongroomstockid'=>@$receipt,
             'issued_by'=>'COUNTER'
             );
             $this->BureauModel->save_issued_branch_stock($saveissued);
             ///////////End of Issued Currenct
        }



    ////////////////FIFO TO UPDATE TANZANIA SHILLINGS
   // $rate = $this->input->post('qty');
    //$amount = $this->input->post('price');

    $getcurrencyid = $this->input->post('product_id');
    foreach($getcurrencyid as $key=>$value){
    $qtyAmount = $amount[$key]*$rate[$key];
    $currencyid = 55;

    $getfifo_info = $this->BureauModel->FIFO_COUNTER_BALANCE_get_stock_branch_opening_balance($blcnobranch,$currencyid);//fifo info
   //echo "<pre>";
    //print_r($getfifo_info);


    if(!empty($qtyAmount) && $qtyAmount > 0 && !empty($getfifo_info)){


           $requiredAmount = $qtyAmount;
           do{
            //hii ya mwisho itatusaidia kupata current selling rate ya currency na tutaitumia kujua faida baada ya kuuza
            //$fifocurrencyinfo = $this->BureauModel->get_fifo_currency_stock_by_id($currencyid);//fifo info
        $currencyinfoyamwisho = $this->BureauModel->COUNTER_CURRENCY_FIFO_LATEST_PRICE_get_stock_branch_opening_balance($blcnobranch,$currencyid);//fifo info

            //////////FIFO Concept
            //get stronngroom  fifo  
            //status ya fifo hizi zisiwe complete na remain isiwe ni zero
            $fifocurrencyinfo = $this->BureauModel->FIFO_COUNTER_BALANCE_get_stock_branch_opening_balance($blcnobranch,$currencyid);//fifo info

            $currencyinfofifoquantity=$fifocurrencyinfo->Quantityoffifo;//Quantity za kwenye fifo
            $currencyinfofifoquantitystock_amount_out=$fifocurrencyinfo->stock_balance_out;//Quantity za kwenye fifo
            $fifoQuantityremain=0;//this will remain baada ya kupunguza  kutoka kwenye quantity tunazotaka
            $StockQuantitytaken=0;//quantity zilizopatikana kwa counter
            $StockQuantityout=0;//quantity zilizopatikana kwa counter
            if($currencyinfofifoquantity > $requiredAmount) //ikiwa fifo quantity ni kubwa
            {
                $StockQuantityout=  $requiredAmount + $currencyinfofifoquantitystock_amount_out; //fifo ina nyingi so hapa itapata zote iombazo
                //$fifoQuantityremain= $currencyinfofifoquantity-$requiredAmount ;
                
                $StockQuantitytaken= $requiredAmount;
                $requiredAmount=0; //required zimeisha hii haitaloop
               
                  //update table ya strongroom with -new remain quantity na -status incomplete bado zipo
                  $UpdateStrongRoom = array('stock_balance_out'=>$StockQuantityout);
                  $this->BureauModel->Counter_UpdateStrongRoom(@$UpdateStrongRoom,@$fifocurrencyinfo->bureau_branch_stock_id);

                  ///haijamaliza quantity zote za kwenye hiyo transaction
                  //////Angalia kama bado zipo au bado
                  $CheckExistBalance = $this->BureauModel->FIFO_COUNTER_BALANCE_get_stock_branch_opening_balance($blcnobranch,$currencyid);
                  if($CheckExistBalance->Quantityoffifo==0.00){
                  ///////Change Status
                  $UpdateStrongRoom = array('bureau_branch_stock_status'=>'COMPLETE');
                  $this->BureauModel->Counter_UpdateStrongRoom(@$UpdateStrongRoom,@$CheckExistBalance->bureau_branch_stock_id);
                  }

            }
             else //fifo quantity ni ndogo kwa hiyo itaendelea na loop mbaka imalize required Amount ifike zero
             {

                $StockQuantityout= $currencyinfofifoquantity + $currencyinfofifoquantitystock_amount_out; //fifo ina ndogo so hapa itapata  zile za kutoka kwenye fifo tu
                 $requiredAmount=$requiredAmount-$currencyinfofifoquantity;
                 $fifoQuantityremain= 0;
                  $StockQuantitytaken= $currencyinfofifoquantity;
                   //update table ya stronngroom with new remain quantity na status complete
                  
                  $UpdateStrongRoom = array('stock_balance_out'=>$StockQuantityout);
                  $this->BureauModel->Counter_UpdateStrongRoom(@$UpdateStrongRoom,@$fifocurrencyinfo->bureau_branch_stock_id);

                 $CheckExistBalance = $this->BureauModel->FIFO_COUNTER_BALANCE_get_stock_branch_opening_balance($blcnobranch,$currencyid);
                  if($CheckExistBalance->Quantityoffifo==0.00){
                  ///////Change Status
                  $UpdateStrongRoom = array('bureau_branch_stock_status'=>'COMPLETE');
                  $this->BureauModel->Counter_UpdateStrongRoom(@$UpdateStrongRoom,@$CheckExistBalance->bureau_branch_stock_id);
                  }

             }

             //update tables
            //tengeneza counter transaction row inayochukua hizo quantity
            //ionyeshe idadi ya quantity iliyochukua ambayo ni sawa na StockQuantitytaken
            //ionyeshe selling price from $currencyinfoyamwisho

               /////////Insert Transactions
            
               /* $latestsellingprice=$currencyinfoyamwisho->selling_price;
                $fifosellingprice=$fifocurrencyinfo->selling_price;
                $pricetakeninstock=0;
                //check ipi kubwa kati ya selling price ya fifo na ile ya mwisho ili kuepuka hasala na chukua kubwa
                 if($latestsellingprice > $fifosellingprice){
                $pricetakeninstock=$latestsellingprice; }
                else { $pricetakeninstock=$fifosellingprice; }*/
                
             $savesoldout = array();
             $savesoldout = array(
             'currencyid'=>$currencyid,
             'exchange_amount'=>$StockQuantitytaken,
             'region'=>@$region,
             'branch'=>@$branch,
             'bclno'=>@$blcnobranch,
             'operator'=>@$empid,
             'serial'=>@$serial,
             'receipt'=>@$receipt,
             'counter_id'=>@$fifocurrencyinfo->bureau_branch_stock_id,
             'strongroom_id'=>@$fifocurrencyinfo->strongroomstockid);
             $this->BureauModel->bureau_currency_sold_out($savesoldout);

            
          } while($requiredAmount > 0);

        }

    }

    ///////////////END OF FIFO
    /////////////END OF TANZANIA SHILLINGS

      
        //GENERATE XML FILE
        $this->generate_xml($serial);
        //END OF FILE GENERATED
        //SEND SMS
        //Total Amount of Transaction
        $value = $this->BureauModel->sum_customer_transaction($serial);
        $amount = $value->totalamount;
        $sms ='KARIBU POSTA KIGANJANI Umepokea kiasi cha '. ' '.number_format($amount,2).', Risiti Namba '.$receipt.' Kwenye huduma ya Posta Bureau De Change '.'';
        $this->send_sms($phone,$sms);


    //////////////////UPDATE TANZANIA SHILLINGS
    /*$tzinfo =  $this->BureauModel->tz_currency_stock_branch_information($branch);
    $tzbalance = $tzinfo->stock_balance-$amount;
    //Update Branch Stock
    $TZUpdateBranchStock = array();
    $TZUpdateBranchStock = array('stock_balance'=>$tzbalance);
    $this->BureauModel->tz_update_branch_stock_by_currencyID($TZUpdateBranchStock,$branch);
    //////////END OF TANZANIA SHILLINGS*/

    $this->session->set_flashdata('success','Transaction has been successfully');
    redirect($this->agent->referrer());

    }

public function RepostBureauReceipt(){
$serial = base64_decode($this->input->get('I'));
$this->generate_xml($serial);
$this->session->set_flashdata('success','Transaction has been successfully reposted, Please check BOT status for confirmation');
redirect($this->agent->referrer());
}


    //XML Generator
function generate_xml($serial){

//Customer Information
$info = $this->BureauModel->get_customer_info($serial);
//Transaction Information 
$listtransaction = $this->BureauModel->get_customer_transaction($serial);
//BCL NUMBER
$value = $this->BureauModel->get_branch_bclno();

//create dom xml object
$xml = new DOMDocument();


//set essential xml properties for this document
$xml->xmlVersion = "1.0";
$xml->encoding = "UTF-8";
$xml->preserveWhiteSpace = TRUE;
$xml->formatOutput = TRUE;

// Create XML elements.
$root = $xml->createElement("EJRECEIPT" );
$body = $xml->createElement("RECEIPT");


$file_name = $value->bcl."_03TZ".$info->serial."_".date("Ymd",strtotime($info->transaction_created_at))."_".date("His",strtotime($info->transaction_created_at))."_REC.xml";

$BCLNO = $xml->createElement("BCLNO",$value->bcl);
$body->appendChild($BCLNO);

$EFDSERIAL = $xml->createElement("EFDSERIAL","3TZ".str_replace('-','', $info->serial));
$body->appendChild($EFDSERIAL);

$TRNTYPE = $xml->createElement("TRNTYPE",$info->transaction_type);//ASK 
$body->appendChild($TRNTYPE);

$RNO = $xml->createElement("RNO",$info->receipt);//ASK
$body->appendChild($RNO);

$ZNO = $xml->createElement("ZNO","0");//ASK
$body->appendChild($ZNO);

$APPDNO = $xml->createElement("APPDNO",$info->appno);//ASK
$body->appendChild($APPDNO);

$DATE = $xml->createElement("DATE",date("Y-m-d",strtotime($info->transaction_created_at)));
$body->appendChild($DATE);

$TIME = $xml->createElement("TIME",date("H:i:s",strtotime($info->transaction_created_at)));
$body->appendChild($TIME);

$CUSTNAME = $xml->createElement("CUSTNAME",$info->customer_name);
$body->appendChild($CUSTNAME);

$CUSTID = $xml->createElement("CUSTID",$info->customer_identity_no);//ASK
$body->appendChild($CUSTID);

$IDTYPE = $xml->createElement("IDTYPE",$info->idtype);//ASK
$body->appendChild($IDTYPE);

$ISSUER = $xml->createElement("ISSUER",$info->purpose);//ASK
$body->appendChild($ISSUER);

$SOURCE = $xml->createElement("PURPOSE",$info->purpose);//ASK
$body->appendChild($SOURCE);

$SOURCE_DES = $xml->createElement("PURPOSE_DES",$info->purpose_desc);//ASK
$body->appendChild($SOURCE_DES);

$INSTR = $xml->createElement("INSTR","CASH");//ASK
$body->appendChild($INSTR);

$TRANSACTIONS = $xml->createElement("TRANSACTIONS");//ASK

//transaction items list
foreach($listtransaction as $data) {

$TRANSACTION = $xml->createElement("TRANSACTION");
$CURRENCY = $xml->createElement("CURRENCY", $data->currency_name);
$AMOUNT = $xml->createElement("AMOUNT", number_format($data->exchange_amount,2,'.', ''));
$XR = $xml->createElement("XR", number_format($data->currency_rate,2,'.', ''));
$TOTAL = $xml->createElement("TOTAL",number_format($data->currency_rate*$data->exchange_amount,2,'.', ''));

$TRANSACTION->appendChild($CURRENCY);
$TRANSACTION->appendChild($AMOUNT);
$TRANSACTION->appendChild($XR);
$TRANSACTION->appendChild($TOTAL);

$TRANSACTIONS->appendChild($TRANSACTION);
}
/**************transaction list ends ***************/

$body->appendChild($TRANSACTIONS);
$root->appendChild($body);
$xml->appendChild($root);

$full_file_path = "./assets/xmlfiles/".$file_name;
$result = $xml->save($full_file_path);

//print $xml->saveXML();

if($result){
  echo "file $file_name created successfully !!<br>";
  //SEND XML FILE TO BANK OF TANZANIA
  $this->send_ftp_file($full_file_path,$file_name,$info->serial);
  //END TO SEND XML FILE TO BANK OF TANZANIA
}else{
  echo "file to create $file_name !!";
} 

}


//SEND XML FILE INTO BANK OF TANZANIA
function send_ftp_file($full_file_path,$file_name,$serial){
$info = $this->BureauModel->get_customer_info($serial);

//$ftp_server = "196.46.101.8";
$ftp_server = "196.46.101.8";
$port = 21;
$ftp_username = "ftp_user_test";
//$ftp_username = "ftpuser";
$ftp_userpass = "Efd73S7P@ssw0rd.@123x";
//$ftp_userpass = "B0T5623@r7tqU5";
$ftp_conn = ftp_connect($ftp_server, $port);

$source_file = $full_file_path;
$destination_file = $file_name;

if($ftp_conn){
  $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
  if(@$login){
    // upload file
    ftp_pasv($ftp_conn, true);

    if (ftp_put(@$ftp_conn, $destination_file, $source_file, FTP_BINARY )){
        echo "Successfully uploaded $destination_file.";

        //////////// POSTED
        $checkBOT = $this->BureauModel->check_serial_exist_bot($serial);
        if($checkBOT==0){

        $SaveBOTdata = array(
        'bot_serial'=>@$serial,
        'bot_receipt'=>@$info->receipt,
        'bot_status'=>'POSTED');
        $this->BureauModel->save_bureau_bot_status($SaveBOTdata);


        } else {

        //////////// POSTED
        $UpdateBOTdata = array('bot_status'=>'POSTED');
        $this->BureauModel->update_bureau_bot_status($UpdateBOTdata,$serial);

       }

      ///////////////

     } else {
        echo "Error uploading $destination_file.";

        //////////// PENDING
        $checkBOT = $this->BureauModel->check_serial_exist_bot($serial);
        if($checkBOT==0){

        $SaveBOTdata = array(
        'bot_serial'=>@$serial,
        'bot_receipt'=>@$info->receipt,
        'bot_status'=>'PENDING');
        $this->BureauModel->save_bureau_bot_status($SaveBOTdata);


        } else {

        //////////// PENDING
        $UpdateBOTdata = array('bot_status'=>'PENDING');
        $this->BureauModel->update_bureau_bot_status($UpdateBOTdata,$serial);

       }
      ///////////////

     }
  } else {
    echo "Invalid Username or Password !!";
  }
  // close connection
  ftp_close(@$ftp_conn);
}else{
  echo "Failed to Connect to $ftp_server";
}
}


public function transaction_report(){
$fromdate = $this->input->get('fromdate');
$todate =  $this->input->get('todate');
$status = $this->input->get('status');

$data['fromdate'] = $fromdate;
$data['todate'] = $todate;

if($status=="01"){
$data['transtype'] = "Sales";
} else {
$data['transtype'] = "Buying";
}

$id = $this->session->userdata('user_login_id');
$data['empinfo'] = $this->employee_model->GetBasic($id);
$data['preparedby']= 'PF'.' '.@$data['empinfo']->em_code.' '.@$data['empinfo']->first_name.' '.@$data['empinfo']->middle_name.' '.@$data['empinfo']->last_name;
//Extra Information

$data['list'] = $this->BureauModel->list_transaction($fromdate,$todate,$status);

if(!empty($data['list'])){
    $this->load->library('Pdf');
    $html= $this->load->view('bureau/reports/buying_selling_report',$data,TRUE);
    $this->load->library('Pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('A4','potrait');
    $this->dompdf->render();
    ob_end_clean();
    $this->dompdf->stream(@$data['transtype'].'Report-'.@$id.'-'.date("YmdHis"), array("Attachment"=>0)); 
} else {

   $this->session->set_flashdata('success',''.$data['transtype'].' Report Not Found, Please try again!');
    redirect($this->agent->referrer());

}

}


//TRA Verification Receipt
public function printReceipt(){
$serial = base64_decode($this->input->get('I'));
//Customer Information
$data['info'] = $this->BureauModel->get_customer_info($serial);
//Transaction Information 
$data['list'] = $this->BureauModel->get_customer_transaction($serial);
//Total Amount of Transaction
$value = $this->BureauModel->sum_customer_transaction($serial);
$amount = $value->totalamount;
//Convert Identity of Customer to meet TRA Verification
if($data['info']->identity_desc=="Passport"){
$idtype = 4;
} elseif($data['info']->identity_desc=="Driving Licence"){
$idtype = 2;
} elseif($data['info']->identity_desc=="Voters ID"){
$idtype = 3;
} elseif($data['info']->identity_desc=="National ID"){
$idtype = 5;
}
else{
//Nill
$idtype = 6;
}

if($data['info']->transaction_type=="01"){
$data['transtype'] = "Selling";
} else {
$data['transtype'] = "Buying";
}


$id = $this->session->userdata('user_login_id');
$data['empinfo'] = $this->employee_model->GetBasic($id);
$data['preparedby']= 'PF'.' '.@$data['empinfo']->em_code.' '.@$data['empinfo']->first_name.' '.@$data['empinfo']->middle_name.' '.@$data['empinfo']->last_name;
//Extra Information
$region = $this->session->userdata('user_region');

$sign = array('receiptno'=>@$data['info']->receipt,
  'idtype'=>@$idtype,
  'custid'=>@$data['info']->customer_identity_no,
  'custname'=>@$data['info']->customer_name,
  'mobile'=>@$data['info']->customer_mobile,
  'region'=>@$region,
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

      $image_name = $data['qrcodename'] = $data['info']->receipt .'.png'; 
      
      $params['data'] = 'https://verify.tra.go.tz/'.$signature->desc; 
      $params['level'] = 'H'; 
      $params['size'] = 10;
      $params['savename'] = FCPATH.$config['imagedir'].$image_name; 
      $this->ciqrcode->generate($params);
    



    $this->load->library('Pdf');
    $html= $this->load->view('bureau/receipt',$data,TRUE);
    $this->load->library('Pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('A4','potrait');
    $this->dompdf->render();
    ob_end_clean();
    $this->dompdf->stream(@$data['info']->receipt, array("Attachment"=>0)); 

 }


  /// ********* SEND SMS FUNCTION ************
   function send_sms($s_mobile,$sms)
    {
         $mobile = trim($s_mobile);
         $mobile = str_replace(array(' ','-'), '',  $mobile);
        $mobile = '255'.substr($mobile, -9);
        $url = 'http://192.168.33.2/modules/otsms/process.php?msisdn='.$mobile.'&message='.urlencode($sms);
      
                $urloutput=file_get_contents($url);
           
              
    }

    //////////GET BLC Branches
    public function get_bcl_branches(){
    echo $this->BureauModel->GetBCLById($this->input->post('region_id'));
    }
    /////////// END OF BCL


      public function get_strong_room_balance_information(){
            $id = $this->input->post('id');
            $checkdata = $this->BureauModel->get_strong_room_balance_information($id);
            if(!empty($checkdata)) {
                $res['status'] = 'available';
                $res['price'] = $checkdata->stock_amount;
            } else {
                 $res['status'] = 'un-available';
                 $res['message'] = 'Please Choose Currency';
            }
            //response
            print_r(json_encode($res));
}

public function get_counter_selling_product_information(){
            $id = $this->input->post('id');
            //$checkdata = $this->BureauModel->get_strong_room_balance_information($id);
            $checkbcl = $this->BureauModel->get_branch_bclno();
            $branch = $checkbcl->bcl;
            $balanceinfo = $this->BureauModel->COUNTER_BALANCE_get_stock_branch_opening_balance($branch,$id);
            $priceinfo = $this->BureauModel->COUNTER_CURRENCY_FIFO_get_stock_branch_opening_balance($branch,$id);

            if(!empty($balanceinfo) && !empty($priceinfo)) {
                $res['status'] = 'available';
                $res['balance'] = @$balanceinfo->totaldiff;
                $res['qty'] = @$priceinfo->stock_balance_selling_price;
            } else {
                 $res['status'] = 'un-available';
                 $res['message'] = 'Please Choose Currency';
            }
            //response
            print_r(json_encode($res));
}

public function get_counter_buying_product_information(){
            $id = $this->input->post('id');
            $rate = $this->input->post('rate');
            $info = $this->BureauModel->get_ciunter_buying_rates($id);

            if(!empty($info)) {
                $minbuying = @$info->buy_min_price;
                $maxbuying = @$info->buy_max_price;
                $res['status'] = 'available';
                $res['minprice'] = @$minbuying;
                $res['maxprice'] = @$maxbuying;
                $res['message'] = 'Currency Rate alert: Min Buying Price: '.number_format($minbuying,2).' and Max Buying Price: '.number_format($maxbuying,2);
                //$res['qty'] = @$priceinfo->stock_balance_selling_price;
            } else {
                 $res['status'] = 'un-available';
                 $res['message'] = 'You cannot proceed to buy currency because Currency Rates Not Found, Please! contact with Strong Room or Administrator for support. Thanks';
            }
            //response
            print_r(json_encode($res));
}


      public function get_strongrrom_information_verification(){
            $approved_amount = $this->input->post('id');
            $required_amount = $this->input->post('amount');
            $currency = $this->input->post('currency');

            $checkstronginfo = $this->BureauModel->strongroom_verification_information($currency);
            if($checkstronginfo->stock_amount>=$approved_amount){
            $res['status'] = 'available';
            } else {
            $res['status'] = 'un-available';
            $res['message'] = 'Your balance is: '.number_format(@$checkstronginfo->stock_amount,2).' on the currency of '.@$checkstronginfo->currency_desc.', and required amount must be less or equal to '.number_format(@$required_amount,2).' and note that you cannot approval request if your stock balance is less than requested stock. Please check your balance before proceed to approval request. Thanks';
            }

            print_r(json_encode($res));
           }


}