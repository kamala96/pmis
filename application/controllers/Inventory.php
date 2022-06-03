 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('notice_model');
        $this->load->model('billing_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('stock_model');
        $this->load->model('inventory_model');
        $this->load->model('Box_Application_model');
        $this->load->model('Sms_model');
    }
    
	public function Dashboard()
	{
		if ($this->session->userdata('user_login_access') != false)
            {
                $data['stocklist'] = $this->inventory_model->Stock_List();
                $data['stockno'] = $this->inventory_model->Count_Stock();
                $data['cashno'] = $this->inventory_model->Count_Cash();
                $data['locksno'] = $this->inventory_model->Count_Locks();
                $data['stampno'] = $this->inventory_model->Count_Stampbureau();
                $this->load->view('inlandMails/inventory-dashboard',$data);
            }
            else{
                redirect(base_url());
            }
	}

    public function returned_stock()
    {
        if ($this->session->userdata('user_login_access') != false)
            {
                $data['stocklist'] = $this->inventory_model->retured_Stock_List();
                $data['stockno'] = $this->inventory_model->Count_Stock();
                $data['cashno'] = $this->inventory_model->Count_Cash();
                $data['locksno'] = $this->inventory_model->Count_Locks();
                $data['stampno'] = $this->inventory_model->Count_Stampbureau();
                $this->load->view('inlandMails/returned_stock',$data);
            }
            else{
                redirect(base_url());
            }
    }

    public function Add_cash()
    {
        if($this->session->userdata('user_login_access') != False) 
        { 
            $data['region'] = $this->employee_model->regselect();
            $this->load->view('inlandMails/add-cash',$data);
        }
        else{
            redirect(base_url() , 'refresh');
        } 

    }

    public function Cash_list()
        {
            if ($this->session->userdata('user_login_access') != false)
            {
                $data1 = "8";
                
                $data['stock'] = $this->inventory_model->Stock_List($data1);
                $this->load->view('inlandMails/Cash-list',$data);
            }
            else{
                redirect(base_url());
            }
        }

    public function Add_Stock()
        {
            if ($this->session->userdata('user_login_access') != false)
            {
                $stid = base64_decode($this->input->get('stid'));
                $data['categorystock'] = $this->inventory_model->Stock_Category_List();
                $data['stocklist'] = $this->inventory_model->Stock_List_ById($stid);
                $this->load->view('inlandMails/add-Stock',$data);
            }
            else{
                redirect(base_url());
            }
        }

        public function Save_Stock()
        {
            if ($this->session->userdata('user_login_access') != false)
            {
                $issuedate = $this->input->post('issuedate');
                $enddate = $this->input->post('enddate');
                $stock_type = $this->input->post('stock_type');
                $stock_name = $this->input->post('stock_name');
                $quantity = $this->input->post('quantity');
                $price_mint = $this->input->post('price_mint');
                $price_sheet = $this->input->post('price_sheet');
                $price_cover = $this->input->post('price_cover');
                $stid        = $this->input->post('stid');

                $df = array();
                $df = array(

                            'Stock_Categoryid'=>$stock_type,
                            'issuedate'=>$issuedate,
                            'enddate'=>$enddate,
                            'stampname'=>$stock_name,
                            'quantity'=>$quantity,
                            'pricepermint'=>$price_mint,
                            'pricepersouverantsheet'=>$price_sheet,
                            'priceperfdcover'=>$price_cover
                    );

                if(!empty($stid)){

                    $this->inventory_model->Update_Stock_Values($df,$stid);
                    echo "Successfully Stock Updated";

                }else{

                    $this->inventory_model->Save_Stock_Values($df);
                    echo "Successfully Stock Saved";
                }
                
            }
            else{
                redirect(base_url());
            }
        }

        public function Stamps_List()
        {
            if ($this->session->userdata('user_login_access') != false)
            {
                $data['stocklist'] = $this->inventory_model->Stamps_List_View();
                $this->load->view('inlandMails/stamp-list',$data);
            }
            else{
                redirect(base_url());
            }
        }

        public function Strong_Room_Request()
        {
            if ($this->session->userdata('user_login_access') != false)
            {
                $data['categorystock'] = $this->inventory_model->Stock_Category_List();
                $this->load->view('inlandMails/inventory_request_form',$data);
            }
            else{
                redirect(base_url());
            }
        }

        public function getStockName(){

          if ($this->input->post('stid') != '') {
              
              echo $this->inventory_model->getStockNameById($this->input->post('stid'));
          }

        }

        public function Send_Request()
        {
            if ($this->session->userdata('user_login_access') != false)
            {
                $stock_type = $this->input->post('stock_type');
                $stock_name = $this->input->post('stock_name');
                $quantity = $this->input->post('quantity');

                $auth =  $this->session->userdata('sub_user_type');
                if($auth == "STRONGROOM"){
                    $region =  $this->session->userdata('user_region');
                    $branch = '';
                    $counter = '';
                    $exception = 'False';
                }elseif ($auth == "BRANCH") {
                    $region =  $this->session->userdata('user_region');
                    $branch =  $this->session->userdata('user_branch');
                    $counter = '';
                    $exception = 'False';
                }elseif ($auth == "COUNTER") {
                    $id = $this->session->userdata('user_emid');

                    $get = $this->employee_model->GetBasic($id);

                    if ($get->em_branch == "GPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Dodoma-HPO" || $get->em_branch == "Geita-HPO" || $get->em_branch == "Iringa-HPO" || $get->em_branch == "Kagera-HPO" || $get->em_branch == "Katavi-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Kigoma-HPO" || $get->em_branch == "Kilimanjaro-HPO" || $get->em_branch == "Lindi-HPO" || $get->em_branch == "Manyara-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Mara-HPO" || $get->em_branch == "Mbeya-HPO" || $get->em_branch == "Morogoro-HPO" || $get->em_branch == "Mtwara-HPO" || $get->em_branch == "Mwanza-HPO" || $get->em_branch == "Njombe-HPO" || $get->em_branch == "Rukwa-HPO"|| $get->em_branch == "Ruvuma-HPO"|| $get->em_branch == "Shinyanga-HPO"|| $get->em_branch == "Simiyu-HPO"|| $get->em_branch == "Singida-HPO"|| $get->em_branch == "Songwe-HPO"|| $get->em_branch == "Tabora-HPO"|| $get->em_branch == "Tanga-HPO") {

                        $region =  $this->session->userdata('user_region');
                        $branch =  $this->session->userdata('user_branch');
                        $counter = $id;
                        $exception = 'True';
                      
                    } else {

                        $region =  $this->session->userdata('user_region');
                        $branch =  $this->session->userdata('user_branch');
                        $counter = $id;
                        $exception = 'False';
                       
                    }
                    
                    
                    
                }

               for ($i=0; $i <@sizeof($stock_type) ; $i++) {
                    
                    $data = array();
                    $data = array(

                        'stock_type' =>$stock_type[$i],
                        'stock_name' =>$stock_name[$i],
                        'quantity_requested' =>$quantity[$i],
                        'requested_by' =>$auth,
                        'requested_region'=>$region,
                        'requested_branch'=>$branch,
                        'requested_counter'=>$counter,
                        'exception'=>$exception

                         );

                    $this->inventory_model->insert_stoct_request($data);
                    echo "Successfully Send";
               }
            }
            else{
                redirect(base_url());
            }
        }

        public function request_incomming(){

          if ($this->session->userdata('user_login_access') != false)
            {
                $data['stockrequest'] = $this->inventory_model->get_request_incomming();
                $this->load->view('inlandMails/incomming_request',$data);
            }else{
                redirect(base_url());
            }

        }

        public function request_to(){

          if ($this->session->userdata('user_login_access') != false)
            {
                $data['stockrequest'] = $this->inventory_model->get_request_to();
                $this->load->view('inlandMails/request_to',$data);
            }else{
                redirect(base_url());
            }

        }

        public function transaction_message(){

          if ($this->session->userdata('user_login_access') != false)
            {
                $data['message'] = $this->input->get('message');
                $this->load->view('inlandMails/transaction-message',$data);
            }else{
                redirect(base_url());
            }

        }

        public function status(){

          if ($this->session->userdata('user_login_access') != false)
            {
                $accept = $this->input->post('accept');
                $reject = $this->input->post('reject');
                $receive = $this->input->post('receive');
                $rid = $this->input->post('rid');
                $auth =  $this->session->userdata('sub_user_type');
                $reg =  $this->session->userdata('user_region');

                $gets = $this->inventory_model->get_request_by_Id($rid);
                    $stocktype = $gets->CategoryName;
                    $stockname = $gets->stock_name;

                
                if (!empty($accept)) {

                    if ($auth == "PMU") {
                    $stock1   = $this->inventory_model->take_stock($stocktype,$stockname);
                    if ($stock1->quantity <= $gets->quantity_requested) {
                        $status = "Not Enuought Stock To Issue";
                    } else {
                        $data = array();
                        $data = array('request_status'=>'isAccepted');
                        $this->inventory_model->Update_Request_status($data,$rid);
                        $status = "Successfully Issued";
                    }
                    
                    } else {
                        $isIssue1 = $this->inventory_model->check_issued($stocktype,$stockname);
                        if ($isIssue1->quantity <= $gets->quantity_requested) {
                        $status = "Not Enuought Stock To Issue";
                    } else {
                        $data = array();
                        $data = array('request_status'=>'isAccepted');
                        $this->inventory_model->Update_Request_status($data,$rid);
                        $status = "Successfully Issued";
                    }
                }

                } elseif(!empty($reject)) {
                    $data = array();
                    $data = array('request_status'=>'isRejected');
                    $status = "Successfully rejected";
                    $this->inventory_model->Update_Request_status($data,$rid);

                }elseif(!empty($receive)){

                    $isIssue = $this->inventory_model->check_issued($stocktype,$stockname);

                    if ($auth == "STRONGROOM") {
                        $stock   = $this->inventory_model->take_stock($stocktype,$stockname);
                        $stock_type =  $stock->CategoryName;
                    }else{
                        $stock   = $this->inventory_model->take_stock_issued($stocktype,$stockname);
                        $stock_type =  $stock->stock_type;
                    }
                    
                   
                    if ($auth == "STRONGROOM") {
                        $issuedby = 'PMU';
                        $branch = '';
                        $counter = '';
                    }elseif ($auth == "BRANCH") {
                        $issuedby = 'STRONGROOM';
                        $branch =  $this->session->userdata('user_branch');
                        $counter = '';
                    }elseif ($auth == "COUNTER") {
                        $id = $this->session->userdata('user_emid');

                        $get = $this->employee_model->GetBasic($id);

                        if ($get->em_branch == "GPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Dodoma-HPO" || $get->em_branch == "Geita-HPO" || $get->em_branch == "Iringa-HPO" || $get->em_branch == "Kagera-HPO" || $get->em_branch == "Katavi-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Kigoma-HPO" || $get->em_branch == "Kilimanjaro-HPO" || $get->em_branch == "Lindi-HPO" || $get->em_branch == "Manyara-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Mara-HPO" || $get->em_branch == "Mbeya-HPO" || $get->em_branch == "Morogoro-HPO" || $get->em_branch == "Mtwara-HPO" || $get->em_branch == "Mwanza-HPO" || $get->em_branch == "Njombe-HPO" || $get->em_branch == "Rukwa-HPO"|| $get->em_branch == "Ruvuma-HPO"|| $get->em_branch == "Shinyanga-HPO"|| $get->em_branch == "Simiyu-HPO"|| $get->em_branch == "Singida-HPO"|| $get->em_branch == "Songwe-HPO"|| $get->em_branch == "Tabora-HPO"|| $get->em_branch == "Tanga-HPO") {

                            $issuedby = 'STRONGROOM';
                            $branch =  $this->session->userdata('user_branch');
                            $counter = $id;
                            $exception = 'True';

                        }else{

                            $issuedby = 'BRANCH';
                            $branch =  $this->session->userdata('user_branch');
                            $counter = $this->session->userdata('user_login_id');
                            $exception = 'False';
                        }
                        
                    }

                    if (!empty($isIssue)) {

                        $data = array();
                        $data = array('request_status'=>'isReceived');

                        $is = array();
                        $is = array('quantity'=>$isIssue->quantity + $gets->quantity_requested);
                        $stids = $isIssue->id;

                        $df = array();
                        $df = array('quantity'=>$stock->quantity - $gets->quantity_requested);
                        $stid = $stock->id;

                        
                        if ($auth == "STRONGROOM") {
                        $this->inventory_model->Update_Stock_Values($df,$stid);
                        $this->inventory_model->Update_Stock_Issued($is,$stids);
                        }

                        $this->inventory_model->Update_Request_status($data,$rid);
                        $this->inventory_model->Update_Stock_Issued($is,$stids);
                        $status = "Successfully Issued";

                    }else{

                        $data = array();
                        $data = array('request_status'=>'isReceived');

                        $df = array();
                        $df = array('quantity'=>$stock->quantity - $gets->quantity_requested);
                        $stid = $stock->id;
                        
                        $addi = array();
                        $addi = array(

                                    'stock_type'=>$stock_type,
                                    'issuedate'=>$stock->issuedate,
                                    'enddate'=>$stock->enddate,
                                    'stampname'=>$stock->stampname,
                                    'quantity'=>$gets->quantity_requested,
                                    'pricepermint'=>$stock->pricepermint,
                                    'pricepersouverantsheet'=>$stock->pricepersouverantsheet,
                                    'priceperfdcover'=>$stock->priceperfdcover,
                                    'issuedby'=>$issuedby,
                                    'issued_region'=>$reg,
                                    'issued_branch'=>$branch,
                                    'issued_counter'=>$counter,
                                    'exception'=>$exception
                                     );

                        $success = $this->inventory_model->add_issue($addi);
                        if ($auth == "STRONGROOM") {
                        $this->inventory_model->Update_Stock_Values($df,$stid);
                        }else{
                        $this->inventory_model->Update_Stock_Issued_Values($df,$stid);
                        }
                        $this->inventory_model->Update_Request_status($data,$rid);
                        $status = 'Successfully  Issued';
                    }
                    
                }

                echo $status;
            }else{
                redirect(base_url());
            }

        }

        public function return_stock(){

          if ($this->session->userdata('user_login_access') != false)
            {
               $id = base64_decode($this->input->get('id'));

               if (empty($id)) {

                  $stid = $this->input->post('id');
                  $df = array();
                  $df = array('status'=>'Returned');
                  $this->inventory_model->Update_Stock_Issued_Values($df,$stid);

                  echo "Successfully Returned";

               } else {

                    $data['issued'] = $this->inventory_model->get_issued_stock($id);
                    $this->load->view('inlandMails/return-stock',$data);
               }
               
            }else{
                redirect(base_url());
            }

        }

        public function sold_stock(){

          if ($this->session->userdata('user_login_access') != false)
            {
                $data['stocklist'] = $this->inventory_model->Sold_Stock_List();
                $data['stockno'] = $this->inventory_model->Count_Stock();
                $data['cashno'] = $this->inventory_model->Count_Cash();
                $data['locksno'] = $this->inventory_model->Count_Locks();
                $data['stampno'] = $this->inventory_model->Count_Stampbureau();
                $this->load->view('inlandMails/sold-stock',$data);
            }else{
                redirect(base_url());
            }

        }
        public function sell_iterm(){

          if ($this->session->userdata('user_login_access') != false)
            {
               $data['id'] = base64_decode($this->input->get('id'));
               $id = $this->input->post('id');
               $fullname = $this->input->post('fullname');
               $mobile = $this->input->post('phone');
               $email = $this->input->post('email');
               $quantity = $this->input->post('quantity');
               $region = $this->session->userdata('user_region');
               $branch = $this->session->userdata('user_branch');

               
               $PaymentFor = 'SB';
               $transactiondate = date("Y-m-d");
               $serial    = 'PSB'.date("YmdHis").$id;
               
               $trackno     = 0000;

               if (empty($data['id'])) {
                
               $data['issued'] = $this->inventory_model->get_issued_stock($id);
               //$paidamount = $data['issued']->pricepermint * $quantity;
               if ($quantity >$data['issued']->quantity) {
                   echo "Quantity sale is higher than available quantity";
               } else {
                   $paidamount = 100;
               $renter     = $data['issued']->stampname;
               $serviceId   = $data['issued']->stock_type;

                $save = array();
                $save = array(
                          'fullname'=>$fullname,
                          'phone'=>$mobile,
                          'email'=>$email,
                          'stock_id'=>$id,
                          'quantity_sold'=>$quantity,
                          'sale_region'=>$region,
                          'sale_branch'=>$branch,
                          'operator'=>$this->session->userdata('user_emid')
                        );
                //$insertId = $this->inventory_model->sale_record_save($save);
                $this->db->insert('sale_record',$save);

                 $data = array();
                 $data = array(
                'serial'=>$serial,
                'paidamount'=>$paidamount,
                'CustomerID'=>$this->db->insert_id(),
                'Customer_mobile'=>$mobile,
                'region'=>$region,
                'district'=>$branch,
                'transactionstatus'=>'POSTED',
                'bill_status'=>'PENDING',
                'paymentFor'=>$PaymentFor
                 );

                $this->inventory_model->transactions_save($data);
                $transaction = $this->getBillGepgBillIdEMS($serial,$paidamount,$region,$branch,$mobile,$renter,$serviceId,$trackno);

                if (!empty($transaction)){

                    $serial1 = $transaction->billid;
                    $update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
                    $this->inventory_model->transactions_update($update,$serial1);

                    $total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya '.$serviceId.',Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);

                    $total2 ='The amount to be paid for '.$serviceId.' is The TOTAL amount is '.' '.number_format($paidamount,2).' Pay through this control number'.' '.$transaction->controlno ;

                    $this->Sms_model->send_sms_trick($mobile,$total);
                    redirect('inventory/transaction_message?message='.$total);

                }

               }
               
               } else {

                    $this->load->view('inlandMails/sell-stock',$data);
               }
               
            }else{
                redirect(base_url());
            }

        }


        public function getBillGepgBillIdEMS($serial, $paidamount,$region,$branch,$mobile,$renter,$serviceId,$trackno){

        $AppID = 'POSTAPORTAL';

        $data = array(
        'AppID'=>$AppID,
        'BillAmt'=>$paidamount,
        'serial'=>$serial,
        'District'=>$branch,
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

    public function sendsms($mobile,$total)
    {
    $url = 'http://192.168.33.2/modules/otsms/process.php?msisdn='.$mobile.'&message='.urlencode($total);
    $urloutput=file_get_contents($url);
    return $urloutput;
    }

}