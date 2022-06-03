 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Dhaka');
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model');
        $this->load->model('settings_model');    
        $this->load->model('notice_model');    
        $this->load->model('project_model');    
        $this->load->model('leave_model');  
        $this->load->model('imprest_model');  
        $this->load->model('dashboard_model'); 
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
    function Dashboard(){
        if($this->session->userdata('user_login_access') != False) {
        $data['imprestno']  = $this->imprest_model->countimprest();
        $data['leaveno']  = $this->leave_model->leavecount();
        $data['activeemp'] = $this->dashboard_model->activestaffsummary();
        $data['retiredemp'] = $this->dashboard_model->retiredstaffsummary();
        $data['region'] = $this->dashboard_model->getregion();
        $data['graph']  = $this->dashboard_model->getgraphdata();
        $this->load->view('backend/dashboard',$data);
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
    public function test2(){
        $serial1 = 995120555284;
                $first4 = substr($serial1, 4);
                $trackNo = '2017'.$first4;
                echo $trackNo;
    }
    public function test()
    {
        $AppID = 'POSTAPORTAL';
        $paidamount = $serial= $district =$region = $serviceId = $renter = $mobile = 9;

        $data = array(
            'AppID'=>$AppID,
            'BillAmt'=>$paidamount,
            'serial'=>$serial,
            'District'=>$district,
            'Region'=>$region,
            'service'=>$serviceId,
            'item'=>$renter,
            'mobile'=>$mobile,
            'trackno'=>2457
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
        print_r($response.$error);
        curl_close ($ch);
        $result = json_decode($response);
        //print_r($result->controlno);
        return $result;

    }
    public function add_todo(){
        $userid = $this->input->post('userid');
        $tododata = $this->input->post('todo_data');
        $date = date("Y-m-d h:i:sa");
        $this->load->library('form_validation');
        //validating to do list data
        $this->form_validation->set_rules('todo_data', 'To-do Data', 'trim|required|min_length[5]|max_length[150]|xss_clean');        
        if($this->form_validation->run() == FALSE){
            echo validation_errors();
        } else {
        $data=array();
        $data = array(
        'user_id' => $userid,
        'to_dodata' =>$tododata,
        'value' =>'1',
        'date' =>$date    
        );
        $success = $this->dashboard_model->insert_tododata($data);
            #echo "successfully added";
            if($this->db->affected_rows()){
                echo "successfully added";
            } else {
                echo "validation Error";
            }
        }        
    }
	public function Update_Todo(){
        $id = $this->input->post('toid');
		$value = $this->input->post('tovalue');
			$data = array();
			$data = array(
				'value'=> $value
			);
        $update= $this->dashboard_model->UpdateTododata($id,$data);
        $inserted = $this->db->affected_rows();
		if($inserted){
			$message="Successfully Added";
			echo $message;
		} else {
			$message="Something went wrong";
			echo $message;			
		}
	}

    public function dashboard_backoffice()
    {
        if ($this->session->userdata('user_login_access') != false) {

            $this->load->view('backend/dashboard_backoffices');

        }else{
            redirect(base_url() , 'refresh');
        }
    }  

    public function testdemo(){
        

$target_url = "http://192.168.33.7/api/virtual_box/";

$post = array(
            'box'=>'0766095502'
            );



$curl = curl_init();
curl_setopt($curl, CURLOPT_URL,$target_url);
curl_setopt($curl, CURLOPT_POST,1);
//curl_setopt($curl, CURLOPT_POST, count($post));
curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
//curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
//curl_setopt($curl, CURLOPT_VERBOSE,true);
$result = curl_exec($curl);
// if(!$result){
//     die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
// }
curl_close($curl);
print_r($result);

    }  

public function Update()
    {
        if ($this->session->userdata('user_login_access') != false) {

          $this->box_post();
          $this->box_update_number();
          $this->box_update_payments();


          $this->realestate_post();
          $this->realestate_tenants_update_payments();
           
        
    }
}





public function box_post(){
     // $url = 'http://192.168.33.3/Posta_Api/box_post';
       
    ///$getValue = json_decode( file_get_contents( 'php://input' ), true );

    //$mobile      = $getValue['mobile'];

    $Boxlist = $this->Box_Application_model->get_box_listWeb();

    foreach ($Boxlist as $key => $value) {
        # code...

        $id = $value->details_cust_id;
        $inforperson = $this->Box_Application_model->get_box_list_perperson($id);

          $ipo = $this->Box_Application_model->get_box_customer_details($id); 
            if(empty($ipo->customer_id)  )
            {

                $paymentlist = $this->Box_Application_model->get_box_payment_list_perperson($id);
        foreach ($paymentlist as $key => $pay) {
            # code...
                $Date= $pay->transactiondate;

            $year=date('Y', strtotime($Date)) + 1;
            $month=date('m', strtotime($Date));
            $day=date('d', strtotime($Date));
            $RenewDate = $year.'-'.$month.'-'.$day;

          
                $add = array();
             $add = array(

            'controlnumber'=>$pay->billid,
            'paidamount'=>$pay->paidamount,
            'CustomerID'=>$id,
            'Customer_mobile'=>$pay->Customer_mobile,
            'transactionstatus'=>$pay->status,
            'receipt'=>$pay->receipt,
            'RenewDate'=>$RenewDate,
             'paymentdate'=>$pay->transactiondate

            );

          $this->Box_Application_model->save_box_payment_details($add);

        }
        //$Outstanding= $this->Box_Application_model->get_box_outstanding_list_perperson($id);

        $repname=$value->first_name.' '.$value->middle_name.' '.$value->last_name;
        $info = array();
        $info = array('customer_id'=>$id,'region'=>$value->region,'Branch'=>$value->district,'cust_boxtype'=>$value->cust_boxtype,
            'cust_name'=>$value->cust_name,'repesentative_name'=>$repname,'authority_card'=>$value->authority_card,'boxnumber'=>$inforperson->box_number,'mobile'=>$value->Customer_mobile);

        $this->Box_Application_model->save_box_cust_details($info);


            }
        

    }

  
     echo 'Successfully';
    
    //header('Content-Type: application/json');
    //echo json_encode($data);
    
  }



public function box_update_number(){
     // $url = 'http://192.168.33.3/Posta_Api/box_post';
       
    ///$getValue = json_decode( file_get_contents( 'php://input' ), true );

    //$mobile      = $getValue['mobile'];

    $Boxlist = $this->Box_Application_model->get_box_customer_details_list();

    foreach ($Boxlist as $key => $value) {
        # code...
        $id = $value->customer_id;
        $inforperson = $this->Box_Application_model->get_box_list_perperson($id);

         $boxupdate = array();
        $boxupdate = array('boxnumber'=>$inforperson->box_number);
        $this->Box_Application_model->update_box_number_details00($boxupdate,$id);

            }
        

     echo 'Successfully';
    
    //header('Content-Type: application/json');
    //echo json_encode($data);
    
  }



public function box_update_payments(){
     // $url = 'http://192.168.33.3/Posta_Api/box_post';
       
    ///$getValue = json_decode( file_get_contents( 'php://input' ), true );

    //$mobile      = $getValue['mobile'];

    $Boxlist = $this->Box_Application_model->get_box_customer_payments_details_list();

    foreach ($Boxlist as $key => $value) {
        # code...
        $id = $value->customer_id;



        $paymentlist = $this->Box_Application_model->get_box_payment_paid_list_perperson($id);
        foreach ($paymentlist as $key => $pay) {
            # code...
                $Date= $pay->transactiondate;

            $year=date('Y', strtotime($Date)) + 1;
            $month=date('m', strtotime($Date));
            $day=date('d', strtotime($Date));
            $RenewDate = $year.'-'.$month.'-'.$day;

          
                $boxupdate = array();
             $boxupdate = array(
            'transactionstatus'=>$pay->status,
            'receipt'=>$pay->receipt,
             'paymentdate'=>$pay->transactiondate

            );

          $this->Box_Application_model->update_box_payments_details($boxupdate,$id);



            }
    
  }
   echo 'Successfully';

}

public function realestate_post(){


   $tenantlist = $this->dashboard_model->get_tenant_informationss();

    foreach ($tenantlist as $key => $value) {
        # code...

        $id = $value->tenant_id;
        

          $ipo = $this->dashboard_model->get_tenants_customer_details($id); 
            if(empty($ipo->tenant_id)  )
            {

                $paymentlist = $this->dashboard_model->get_tenants_payment_details($id);
        foreach ($paymentlist as $key => $pay) {
            # code...
                $Date= $pay->transactiondate;

            $year=date('Y', strtotime($Date)) + 1;
            $month=date('m', strtotime($Date));
            $day=date('d', strtotime($Date));
            $RenewDate = $year.'-'.$month.'-'.$day;

          
                $add = array();
             $add = array(

            'controlnumber'=>$pay->billid,
            'paidamount'=>$pay->paidamount,
            'tenantid'=>$pay->tenant_id,
            'tenant_mobile'=>$value->mobile_number,
            'transactionstatus'=>$pay->status,
            'receipt'=>$pay->receipt,
            //'RenewDate'=>$RenewDate,
             'realestate_type'=>$value->estate_type,
             'paymentdate'=>$pay->transactiondate

            );

          $this->dashboard_model->save_tenant_payment_details($add);

        }
        //$Outstanding= $this->Box_Application_model->get_box_outstanding_list_perperson($id);

        $regid = $value->region;
         $reg = $this->dashboard_model->getRegion_ById($regid); 

         $disid =$value->district; 
         $dis = $this->dashboard_model->getDistrict_ById($disid);

         $contract_end=date('Y-m-d',strtotime($value->end_date));

        $info = array();
        $info = array('tenant_id'=>$id,'region'=>$reg->region_name,'Branch'=>$dis->district_name,'tenant_name'=>$value->customer_name,
            'estate_name'=>$value->estate_name,'contractnumber'=>$value->contract_number,'contract_end'=>$contract_end,'status'=>$value->estate_status,'mobile'=>$value->mobile_number);

        $this->dashboard_model->save_tenant_customer_details($info);


            }
        

    }

  
     echo 'Successfully';
    
    //header('Content-Type: application/json');
    //echo json_encode($data);
    
  }

  public function realestate_tenants_update_payments(){
    

    $Realestatelist = $this->dashboard_model->get_realestate_tenants_payments_details_list();

    foreach ($Realestatelist as $key => $value) {
        # code...

       $controlno = $value->controlnumber;
            $paystatus ='';
         $sum = $this->dashboard_model->getsumPayments($controlno);
           $diff = $value->paidamount-$sum->sum_amount;
           if ($diff <=0) {
              $paystatus ='Paid';

               $update = array();
             $update = array(
           
            'transactionstatus'=>$paystatus,
            'receipt'=>$sum->receipt,
             'paymentdate'=>$sum->date_created

            );

          $this->dashboard_model->update_realestate_tenants_payments_details($update,$id);


               } else {
                 $paystatus ='NotPaid';
               }
                               
            
          
            





        //$id = $value->tenantid;

        //$paymentlist = $this->dashboard_model->get_tenants_updated_payment_details($id);


        // foreach ($paymentlist as $key => $pay) {
        //  $controlno = $pay->billid;
        //  $paystatus ='';
        //  $sum = $this->dashboard_model->getsumPayments($controlno);
  //          $diff = $pay->paidamount-$sum->sum_amount;
  //          if ($diff <=0) {
  //             $paystatus ='Paid';
  //              } else {
  //                $paystatus ='NotPaid';
  //              }
                               
            
          
        //   $update = array();
  //            $update = array(
           
  //           'transactionstatus'=>$paystatus,
  //           'receipt'=>$sum->receipt,
  //            'paymentdate'=>$sum->date_created

  //           );

  //         $this->dashboard_model->update_realestate_tenants_payments_details($update,$id);

        // }
    }
   echo 'Successfully';

}










    
}