 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

 //require(APPPATH.'/libraries/REST_Controller.php');

  require(APPPATH.'/libraries/REST_Controller.php');

 
 
class Posta_Api extends REST_Controller {


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

  // public function index_get()
  //   {
  //       echo 'check';PostaShopModel
  //   }
   
  public function checkConn_post()
  {
	  $response = array('code'=>'100','desc'=>'connected');

	  echo json_encode($response);
  }

public function box_post2(){
     // $url = 'http://192.168.33.3/Posta_Api/box_post';
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );

    $mobile      = $getValue['mobile'];

  $id = base64_decode($this->input->get('I'));
$data['inforperson'] = $this->Box_Application_model->get_box_list_perperson($id);
$data['paymentlist'] = $this->Box_Application_model->get_box_payment_list_perperson($id);
$data['Outstanding'] = $this->Box_Application_model->get_box_outstanding_list_perperson($id);
     
    
    header('Content-Type: application/json');
    echo json_encode($data);
    
  }

	public function posta_get()
	{
		echo 'Posta Mpya';
	}
	public function post_posta_post(){
       // $url = 'http://192.168.33.3/Posta_Api/post_posta';

		$update1 = json_decode( file_get_contents( 'php://input' ), true );

		if ($update1['amount'] > 0 && $update1['controlno'] != ''){

			$amount = $update1['amount'];
			$controlno = $update1['controlno'];
			$receiptno = $update1['receiptno'];
			$channel   = $update1['channel'];
			$date = $update1['date'];
			//$date      = date("Y-m-d h:i:sa");

			 $check = $this->billing_model->checkValue($controlno);//Barcode
             $check2 = $this->unregistered_model->checkValueRegister($controlno);//Barcode
             $check3 = $this->unregistered_model->checkValueDerivery($controlno);
             $check4 = $this->parcel_model->checkValueParcInter($controlno);
             $check5 = $this->dashboard_model->checkValue_real_estate($controlno);
             $check6 = $this->parking_model->checkValue_parking($controlno);
             $check7 = $this->parking_model->checkValue_parking_wallet($controlno);
	if (!empty(@$check) || !empty(@$check2) || !empty(@$check3) || !empty(@$check4) || !empty(@$check6) || !empty(@$check7) ){

				if (@$check->receipt == $receiptno || @$check2->receipt == $receiptno || @$check3->receipt == $receiptno || @$check4->receipt == $receiptno || @$check6->receipt == $receiptno || @$check7->receipt == $receiptno){

					$data = array('status'=>'102','description'=>"DUPLICATE Entry",'controlno'=>$update1['controlno'],'receiptno'=>$update1['receiptno']);

					$this->billing_model->insert_logs($data);
					header('Content-Type: application/json');
					echo json_encode($data);

			   }else{

			   	//Send message
			
            
					$data = array('status'=>'100','description'=>"Successful",'controlno'=>$update1['controlno']);

					// $update = array('paymentdate'=>$update1['date'],'receipt'=>$update1['receiptno'],'paidamount'=>$update1['amount'],'status'=>'Paid','paychannel'=>$channel);

						$update = array('paymentdate'=>$update1['date'],'receipt'=>$update1['receiptno'],'status'=>'Paid','paychannel'=>$channel);

					$serial = $update1['controlno'];
					//$this->billing_model->update_transactions2($update,$serial);
					$this->billing_model->update_transactions2($update,$serial);
					$this->unregistered_model->update_register_transactions($update,$serial);
					$this->unregistered_model->update_delivery_transactions1($update,$serial);
					$this->parcel_model->update_parcel_international_transactions1($update,$serial);
					$this->parking_model->update_parking_transactions1($update,$serial);
					$this->parking_model->update_parking_wallet_transaction($update,$serial);
					$this->billing_model->insert_logs($data);


		   //	 $controlno = '995120554924';

             // @$check = $this->billing_model->checkValue($controlno);
             // @$check2 = $this->unregistered_model->checkValueRegister($controlno);
             // @$check3 = $this->unregistered_model->checkValueDerivery($controlno);
             // @$check4 = $this->parcel_model->checkValueParcInter($controlno);

					 if(@$check->PaymentFor == "VIRTUEBOX"){

					 	$updatevirtual = array('virtuebox_status'=>'ACTIVE');

					 	$virtuebox_id=@$check->CustomerID;
					 	//$virtuebox_status = 'ACTIVE';
					 	$this->Box_Application_model->update_virtual($virtuebox_id,$updatevirtual);

			  	$value = array();
				$value = array('controlno'=>$update1['controlno'],'paymentdate'=>$update1['date'],'receipt'=>$update1['receiptno'],'paychannel'=>$channel);

			

			$url = 'http://192.168.33.5:81/api/index.php/PmisApi/update_trans';
			$ch = curl_init($url);
			$json = json_encode($value);
			curl_setopt($ch, CURLOPT_URL, $url);
			// For xml, change the content-type.
			curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
			curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

			// Send to remote and return data to caller.
			$response = curl_exec ($ch);
			//$error    = curl_error($ch);
			//$errno    = curl_errno($ch);
			curl_close ($ch);
			$result = json_decode($response);
           //create logs
            $value = array();
            $value = array('result'=>$result,'serviceid'=>"delivery.posta.co.tz",'controlno'=>$update1['controlno']);
            $log=json_encode($value);
            $lg = array(
            'response'=>$log
            );
               $this->Box_Application_model->save_logs($lg);
        }
        
		$PrePaid='%PrePaid%';
		if($this->Reports_model->like_match($PrePaid, @$check->serial)){
			//UPDATE AMOUNT TO CUSTOMERBILLINFO
			$crdtid=@$check->CustomerID;
          $info = $this->Bill_Customer_model->get_customer_bill_credit_by_id($crdtid);
		  if(@$info->customer_type == 'PrePaid'){
			$sumamount=$info->price + $amount;
			$save = array();
		    $save = array('price'=>$sumamount);
		    $this->Bill_Customer_model->update_credit_bill_customer($save,$crdtid);
		  }
          
		}

             $pattern='%EMS%';
             $loanbord='%LOAN BOARD%'; 
             $NECTA='%NECTA%';
             $PCUM='%PCUM%';
             $CARGO='%CARGO%';
             $MAIL='%MAIL%';
			 $POSTACASH='%CASH%';
             if($this->Reports_model->like_match($pattern, @$check->PaymentFor) OR $this->Reports_model->like_match($MAIL, @$check->serial)  OR $this->Reports_model->like_match($loanbord, @$check->PaymentFor) OR $this->Reports_model->like_match($NECTA, @$check->serial) OR $this->Reports_model->like_match($PCUM, @$check->serial) OR $this->Reports_model->like_match($CARGO, @$check->serial)  )
             {
              //gett track number
              
              if(!empty(@$check->serial))
              {
                $id = $check->CustomerID;
                $Barcode =  $check->Barcode;

              }
              if(!empty(@$check2->serial) OR !empty(@$check3->serial) OR !empty(@$check4->serial))
              {
                $id = $check2->register_id;
                 $Barcode =  $check2->Barcode;

              }
              
                $db='sender_info';
               $sender = $this->Reports_model->get_senderINFObyID($db,$id);
				$smobile =$sender->s_mobile;
				$trackno = $sender->track_number ;

        if($sender->s_fullname == "MCT"){

        $data = array();
		$Header = array();
		$Header = array('Name'=>'POSTA','Signature'=>'@%#GT#$%^@$%GGHDVGH@$%#&');
		$signature="@%#GT#$%^@$%GGHDVGH@$%#&";
    
       $data['Header']=$Header;
		//$this->employee_model->save_login_log2($data);

		$value = array();
		$value = array('requestID'=>$sender->requestid,'Status'=>'200','paymentdate'=>$update1['date'],'receipt'=>$update1['receiptno'],'paidamount'=>$update1['amount'],'status'=>'Paid','paychannel'=>$channel,'signature'=>$signature);

		$data['Request']=$value;

		$url = "http://196.192.79.24/oas/ems/getPaymentInfo.php";
		$ch = curl_init($url);
		$json = json_encode($data);
		curl_setopt($ch, CURLOPT_URL, $url);
		// For xml, change the content-type.
		curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
		curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

		// Send to remote and return data to caller.
		$response = curl_exec ($ch);
		//$error    = curl_error($ch);
		//$errno    = curl_errno($ch);

		curl_close ($ch);


		$result = json_encode($value);
		$result = json_decode($result);
 		//create logs
            $value = array();
            $value = array('Paymentresult'=>$result,'serviceid'=>"MCT",'requestid'=>$sender->requestid);
            $log=json_encode($value);
            $lg = array(
            'response'=>$log
            );
               $this->Box_Application_model->save_logs($lg);


$result = json_decode($response);
 //create logs
            $value = array();
            $value = array('Paymentresult'=>$result,'serviceid'=>"MCT",'requestid'=>$sender->requestid);
            $log=json_encode($value);
            $lg = array(
            'response'=>$log
            );
               $this->Box_Application_model->save_logs($lg);


//check if success
// if($result->status){

// }//MESSAGE  MCT CLIENT
if(!empty(@$check->serial) OR !empty(@$check2->serial)){

	$stotal ='KARIBU POSTA KIGANJANI, ndugu mteja malipo yako yamepokelewa Posta, yenye controlnumber '.$controlno.' Kwa huduma ya MCT';

	$db2 ='receiver_info';
	$sender_id =  $sender->sender_id;
$receiver = $this->Reports_model->get_receiverINFO($db2,$sender_id);
$rmobile =$receiver->mobile;

$rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja malipo yako yamepokelewa Posta, yenye controlnumber '.$controlno.' Kwa huduma ya MCT';

	   $this->Sms_model->send_sms_trick($smobile,$stotal);
	   $this->Sms_model->send_sms_trick($rmobile,$rtotal);
}
        }

         // echo 'trackno '.$trackno;
       // echo 'smobile '.$smobile;

        if((!empty(@$check->serial) OR !empty(@$check2->serial)) AND ($sender->s_fullname != "MCT")){

        	 $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako  umepokelewa Counter,umepatiwa Track number '.$Barcode. ' yenye controlnumber '.$controlno;

             $db2 ='receiver_info';
             $sender_id =  $sender->sender_id;
        $receiver = $this->Reports_model->get_receiverINFO($db2,$sender_id);
         $rmobile =$receiver->mobile;


         // echo 'trackno '.$trackno;
        // echo 'rmobile '.$rmobile;

        $rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako  umepokelewa Counter,umepatiwa Track number '.$Barcode. ' yenye controlnumber '.$controlno;

                $this->Sms_model->send_sms_trick($smobile,$stotal);
                $this->Sms_model->send_sms_trick($rmobile,$rtotal);
        }else{

			if(($sender->s_fullname != "MCT")){


        $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako  umepokelewa Counter,umepatiwa Track number '.$trackno. ' yenye controlnumber '.$controlno;



             $db2 ='receiver_info';
             $sender_id =  $sender->sender_id;
        $receiver = $this->Reports_model->get_receiverINFO($db2,$sender_id);
         $rmobile =$receiver->mobile;


         // echo 'trackno '.$trackno;
        // echo 'rmobile '.$rmobile;

        $rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako  umepokelewa Counter,umepatiwa Track number '.$trackno. ' yenye controlnumber '.$controlno;

                $this->Sms_model->send_sms_trick($smobile,$stotal);
                $this->Sms_model->send_sms_trick($rmobile,$rtotal);

		}
            }

             }
             //mails
             $Register='%Register%';
             $register_billing='%register_billing%';
              $Parcel='%Parcel%';
             $PInter='%PInter%'; 
             $DSmallPackets='%DSmallPackets%';
             if($this->Reports_model->like_match($Register, @$check2->serial) OR $this->Reports_model->like_match($register_billing, @$check->serial) OR
             $this->Reports_model->like_match($Parcel, @$check2->serial) OR $this->Reports_model->like_match($PInter, @$check4->serial) OR $this->Reports_model->like_match($DSmallPackets, @$check2->serial)  )
             {
               //gett track number
              
              if(!empty(@$check->serial))
              {
                $id = $check->CustomerID;
                  $Barcode =  $check->Barcode;

              }
              if(!empty(@$check2->serial) OR !empty(@$check3->serial) OR !empty(@$check4->serial))
              {
                $id = $check2->register_id;
                  $Barcode =  $check2->Barcode;

              }

              if(!empty(@$check->serial) OR !empty(@$check2->serial)){

              	$db='sender_person_info';
              $sender = $this->Reports_model->get_senderbyID($db,$id);
              $smobile =$sender->sender_mobile;
              $trackno = $sender->track_number ;
              $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako  umepokelewa Counter,umepatiwa Track number '.$Barcode. ' yenye controlnumber '.$controlno;


             $db2 ='receiver_register_info';
             $sender_id = $sender->senderp_id;
              $receiver = $this->Reports_model->get_receiver($db2,$sender_id);
               $rmobile = $receiver->receiver_mobile;
               //ho ''.$smobile.' smoble2';


             $rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako  umepokelewa Counter,umepatiwa Track number '.$Barcode. ' yenye controlnumber '.$controlno;

                $this->Sms_model->send_sms_trick($smobile,$stotal);
                $this->Sms_model->send_sms_trick($rmobile,$rtotal);

              }else{

                $db='sender_person_info';
              $sender = $this->Reports_model->get_senderbyID($db,$id);
              $smobile =$sender->sender_mobile;
              $trackno = $sender->track_number ;
              $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako  umepokelewa Counter,umepatiwa Track number '.$trackno. ' yenye controlnumber '.$controlno;


             $db2 ='receiver_register_info';
             $sender_id = $sender->senderp_id;
              $receiver = $this->Reports_model->get_receiver($db2,$sender_id);
               $rmobile = $receiver->receiver_mobile;
               //ho ''.$smobile.' smoble2';


             $rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako  umepokelewa Counter,umepatiwa Track number '.$trackno. ' yenye controlnumber '.$controlno;

                $this->Sms_model->send_sms_trick($smobile,$stotal);
                $this->Sms_model->send_sms_trick($rmobile,$rtotal);
            }

             }
			 $POSTACASH='%CASH%';
             if($this->Reports_model->like_match($POSTACASH, @$check->PaymentFor))
             {

				$agentno=@$check->CustomerID;
				$agentcontrolno=@$check->billid;
				$agent=$this->Posta_Cash_Model->agent_detailsby_agentno($agentno);
				$mobile=@$agent->agent_phone;
				$FullName=@$agent->agent_fname. " ".@$agent->agent_lname ." ";

				//update wallet
				$updatedAmount=0;
				if($agent->agent_wallet != null){
					$updatedAmount=@$agent->agent_wallet + $amount;
				}else{$updatedAmount=$amount;}
				$Updatedata= array('agent_wallet'=>@$updatedAmount);
				$this->Posta_Cash_Model->update_agent($Updatedata,@$agent->agent_id);

				//Update transfer
				$agentTransferid=$this->Posta_Cash_Model->agent_Deposite_detailsby_controlnumb($agentcontrolno);
				$transfered_id=@$agentTransferid->transfered_id;
				//update
				$Updatedata2= array('transfered_status'=>'Success');
				$this->Posta_Cash_Model->update_postacash_transfer($Updatedata2,@$transfered_id);
				//send sms
				
				$servicename='POSTA CASH';
				$mtotal ='KARIBU POSTA KIGANJANI, ndugu '.@$FullName.' Umeweka '.@$amount.' kupitia '.@$channel.'.Salio jipya '.@$updatedAmount.' Risiti No: '.@$receiptno;
                $this->Sms_model->send_sms_trick2($mobile,$mtotal,$servicename);

				
				//save logs
				$SaveLogs =  array('status'=>'Wallet','created_by'=>'PAYMENT API','agentno'=>@$agentno,'description'=>$amount);
                $this->Posta_Cash_Model->Save_logs($SaveLogs);
            }


					header('Content-Type: application/json');
					echo json_encode($data);
				
		}
			}elseif(!empty($check5)){

			   		$partial = array();
			   		$partial = array(

			   			'controlno'=>$controlno,
			   			'amount'=>$amount,
			   			'receipt'=>$receiptno,
			   			'pay_channel'=>$channel,
			   			'date_created'=>$date

			   			);

			   		$db2 = $this->load->database('otherdb', TRUE);
			   		$db2->insert('partial_payment',$partial);
					   //insert to postakiganjani api
					   //check if its fro posta kiganjani

				 $postakiganjani=$this->Posta_Cash_Model->postakiganyanirealestate_controlnumbercheck($controlno);
				 $postakiganjanicontrolno=@$postakiganjani->billid;
				 $kiganjani='%postakiganjani%';
             if($this->Reports_model->like_match($kiganjani, @$postakiganjani->serial))
             {
				//send update to postakiganjani realestate portal
				$value = array();
				$value = array('controlno'=>$controlno,'amount'=>$amount,'pay_channel'=>$channel,'receipt'=>$receiptno);
		
				$url = "http://192.168.33.5:81/api/index.php/AppApi/partial_estate_payment";
				$ch = curl_init($url);
				$json = json_encode($value);
				curl_setopt($ch, CURLOPT_URL, $url);
				// For xml, change the content-type.
				curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
				curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned
		
				// Send to remote and return data to caller.
				$response = curl_exec ($ch);
				//$error    = curl_error($ch);
				//$errno    = curl_errno($ch);
		
				curl_close ($ch);
				//$Request = json_encode($value);
				$result = json_decode($response);
				 //create logs
					$value = array();
					$value = array('Paymentresult'=>$result,'serviceid'=>"POSTAKIGANJANI",'request'=>$json);
					$log=json_encode($value);
					$lg = array(
					'response'=>$log
					);
					   $this->Box_Application_model->save_logs($lg);
		


			 }



			   }else{

				$data = array('status'=>'101','description'=>"Control Number Not Found",'controlno'=>$update1['controlno']);
				$this->billing_model->insert_logs($data);
				header('Content-Type: application/json');
				echo json_encode($data);
			}

		}else{

			$data = array('status'=>'105','description'=>"UnSuccessful",'controlno'=>$update1['controlno']);
			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}

    


			


    public function post_login_post(){
       // $url = 'http://192.168.33.2/Posta_Api/post_posta';

		$getValue = json_decode( file_get_contents( 'php://input' ), true );
		$email1 = $getValue['email'];
		$password1 = $getValue['password'];
		$data = array();
		$data = array('email'=>$email1,'password'=>$password1);
		$this->employee_model->save_login_log($data);

		$email = $getValue['email'];
		$password = sha1($getValue['password']);

		$data = array();
		$data = array('email'=>$email,'password'=>$password);
		$this->employee_model->save_login_log($data);

		$authenticate = $this->login_model->getLoginDetails($email,$password);
		if (!empty($authenticate)) {
			
			$id = $authenticate->em_id;
			$info = $this->employee_model->GetBasic($id);

			$value = array('code'=>'100',
				'description'=>'Successful Loged In',
				'first_name'=>$authenticate->first_name,
				'last_name'=>$authenticate->last_name,
				'em_role'=>$authenticate->em_role,
				'em_subrole'=>$authenticate->em_sub_role,
				'emid'=>$authenticate->em_id,
				'em_image'=>$authenticate->em_image,
				'pfno'=>$authenticate->em_code,
				'phone'=>$authenticate->em_phone,
				'email'=>$authenticate->em_email,
				'region'=>$authenticate->em_region,
               'branch'=>$authenticate->em_branch);

			header('Content-Type: application/json');
            echo json_encode($value);
		}else{
			$value = array('code'=>'200','description'=>'Un Successful Loged In,Either Password Or Username is Incorrect');

			header('Content-Type: application/json');
            echo json_encode($value);
		}
	}

	 public function post_deliverylogin_post(){
       // $url = 'http://192.168.33.2/Posta_Api/post_posta';

		$getValue = json_decode( file_get_contents( 'php://input' ), true );
		$email1 = $getValue['email'];
		$password1 = $getValue['password'];
		$data = array();
		$data = array('email'=>$email1,'password'=>$password1);
		$this->employee_model->save_login_log($data);

		$email = $getValue['email'];
		$password = $getValue['password'];

		$data = array();
		$data = array('email'=>$email,'password'=>$password);
		$this->employee_model->save_login_log($data);

		$decryption_iv = '2354235322332234';
			// Store the decryption key
			$decryption_key = "Postapmis";
			$ciphering = "AES-128-CTR";
            $iv_length = openssl_cipher_iv_length($ciphering);
            $options = 0;
			  $authenticate ="";
			// Use openssl_decrypt() function to decrypt the data
			$decryption=openssl_decrypt ($password, $ciphering, 
			        $decryption_key, $options, $decryption_iv);
			if($email == $decryption){
				$authenticate = $this->login_model->getLoginDeliveryDetails($email);
			}

		
		if (!empty($authenticate)) {
			
			$id = $authenticate->em_id;
			$info = $this->employee_model->GetBasic($id);

			$value = array('code'=>'100',
				'description'=>'Successful Loged In',
				'first_name'=>$authenticate->first_name,
				'last_name'=>$authenticate->last_name,
				'em_role'=>$authenticate->em_role,
				'emid'=>$authenticate->em_id,
				'em_image'=>$authenticate->em_image,
				'pfno'=>$authenticate->em_code,
				'phone'=>$authenticate->em_phone,
				'email'=>$authenticate->em_email,
				'region'=>$authenticate->em_region);

			header('Content-Type: application/json');
            echo json_encode($value);
		}else{
			$value = array('code'=>'200','description'=>'Un Successful Loged In,Either Password Or Username is Incorrect');

			header('Content-Type: application/json');
            echo json_encode($value);
		}
	}

	public function post_entry_vehicle_post(){
       
	$getValue = json_decode( file_get_contents( 'php://input' ), true );

	$vehicle = $getValue['vehicle'];
	$id      = $getValue['emid'];

	$tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d H:i:s');

	if (empty($vehicle)) {
		$value = array('code'=>'400','description'=>'Invalid Vehicle');
	} else {
		$basicInfo = $this->employee_model->GetBasic($id);
	if (empty($basicInfo)) {
		$value = array('code'=>'400','description'=>'User Does Not Exist');
	} else {
		
		$exitFirst = $this->parking_model->exit_first($vehicle);

	if (!empty($exitFirst)) {
		 $value = array('code'=>'100','description'=>'Successful','vehicle_no'=>$getValue['vehicle'],'vehiclename'=>$exitFirst->vehicle_name,'parkingid'=>$exitFirst->parking_id,'entry_time'=>$exitFirst->entry_time,'owner'=>$exitFirst->vehicle_owner,'note'=>'DUPLICATE');
	} else {
	
		$checkWallet = $this->parking_model->check_vehicle_wallet_existance($vehicle);

	if (!empty($checkWallet)) {
       
		$parking = array();
        $parking = array(

            	'vehicle_regno'=>$checkWallet->vehicle_regno,
            	'vehicle_name'=>$checkWallet->vehicle_name,
            	'vehicle_owner'=>$checkWallet->vehicle_owner,
            	'tin_number'=>$checkWallet->tin_number,
            	'payment_type'=>'WALLET',
            	'entry_time'=>$date,
            	'operator_branch'=>$basicInfo->em_branch,
            	'operator_region'=>$basicInfo->em_region,
            	'operator_id'=>$id
            );

	} else {

		$checExist = $this->parking_model->check_vehicle_existance($vehicle);

		if (!empty($checExist)) {
			
			$parking = array();
            $parking = array(
            	'vehicle_regno'=>$checExist->vehicle_regno,
            	'vehicle_name'=>$checExist->vehicle_name,
            	'vehicle_owner'=>$checExist->vehicle_owner,
            	'tin_number'=>$checExist->tin_number,
            	'entry_time'=>$date,
            	'operator_branch'=>$basicInfo->em_branch,
            	'operator_region'=>$basicInfo->em_region,
            	'operator_id'=>$id
            );

		} else {

			$url = "http://154.118.230.75/tollbridge/getData.php?vehicle=$vehicle";
            $info = file_get_contents($url);
            $data = json_decode($info);

            if (empty($data->regno)){

            $value = array('code'=>'401','description'=>'Network Error, Try Again!!');

            } else {

            	$parking = array();
                $parking = array(
            	'vehicle_regno'=>$data->regno,
            	'vehicle_name'=>$data->vehicle,
            	'vehicle_owner'=>$data->owner,
            	'tin_number'=>$data->tin,
            	'entry_time'=>$date,
            	'operator_branch'=>$basicInfo->em_branch,
            	'operator_region'=>$basicInfo->em_region,
            	'operator_id'=>$id
                );

            }
		}
		
	}

     //$this->parking_model->save_vehicle_info($parking);
     $db2 = $this->load->database('otherdb', TRUE);
     $db2->insert('parking',$parking);
     $parkingid = $db2->insert_id();

     $value = array('code'=>'100','description'=>'Successful','vehicle_no'=>$getValue['vehicle'],'vehiclename'=>$data->vehicle,'parkingid'=>$parkingid,'entry_time'=>$date,'owner'=>$data->owner);
	}
}
	}
	
	header('Content-Type: application/json');
            echo json_encode($value);
	}


	public function post_exit_vehicle_post(){
       
	$getValue = json_decode( file_get_contents( 'php://input' ), true );

	$vehicle = $getValue['vehicle'];
    $tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$date = $today->format('Y-m-d H:i:s');
			$date1 = $today->format('Y-m-d');

	if (empty($vehicle)) {
		$value = array('code'=>'100','description'=>'Invalid Vehicle');
		header('Content-Type: application/json');
            echo json_encode($value);
	} else {

		$checExist1 = $this->parking_model->check_vehicle_existance1($vehicle);

	if (!empty($checExist1)) {

		    $min  = date('i',strtotime($date));
            $mine = date('i',strtotime($checExist1->entry_time));

            $hr  = date('H',strtotime($date));
            $hre = date('H',strtotime($checExist1->entry_time));

            $diff =  $hr-$hre;

             if($diff == 0){

                            if ($min-$mine >= 10) {
                                $cost = 400;
                            }else {
                                $cost = 0;
                            }

                        }elseif ($diff == 1) {

                        	if ($min-$mine >= 10) {
                                $cost = 400+400;
                            }else {
                                $cost = 400;
                            }

                        }elseif ($diff == 2) {

                        	if ($min-$mine >= 10) {
                                $cost = 400+400+400;
                            }else {
                                $cost = 400+400;
                            }

                        }elseif ($diff == 3) {

                        	if ($min-$mine >= 10) {
                                $cost = 400+400+400+400;
                            }else {
                                $cost = 400+400+400;
                            }

                        }elseif ($diff == 4) {

                        	if ($min-$mine >= 10) {
                                $cost = 400+400+400+400+400;
                            }else {
                                $cost = 400+400+400+400;
                            }

                        }elseif ($diff == 5) {

                        	if ($min-$mine >= 10) {
                                $cost = 400+400+400+400+400+400;
                            }else {
                                $cost = 400+400+400+400+400;
                            }

                        }elseif($diff == 6){

                            if ($min-$mine >= 10) {
                                $cost = 3000;
                            }else {
                                $cost = 400+400+400+400+400+400;
                            }

                        }else{

                        	$cost = 3000;
                        }

                        $id = $checExist1->parking_id;
                        $data = array();
                        $data = array(
                               'cost'=>$cost
                           );
            $this->parking_model->update_time_cash($id,$data);

            $checExist = $this->parking_model->check_vehicle_existance1($vehicle,$date1);
			if ($checExist->payment_type == "WALLET") {

				$checAmount = $this->parking_model->check_vehicle_existance1($vehicle,$date1);
				$amount = $checAmount->cost;
				$checkWallet1 = $this->parking_model->check_vehicle_wallet_existance1($vehicle);
				$paidamount = @$checkWallet1->paidamount;

				if ($amount >= $paidamount) {
					$value = array('code'=>'200','description'=>'Insufficient Wallet Balance');
			header('Content-Type: application/json');
            echo json_encode($value);
				} else {

					$diffAmount = $paidamount-$amount;
					$walletid   = $checkWallet1->wallet_id;
				    $cust = array();
                    $cust = array(
                	'paidamount'=>$diffAmount,
                    
                    );
                	$this->parking_model->update_wallet_cust_info($cust,$walletid);

                	$id = $checExist->parking_id;
				     $parking = array();
		             $parking = array(
		             	'status'=>'EXIT',
		             	'exit_time'=>$date
                  );

          $this->parking_model->update_vehicle_info($parking,$id);
          $value = array('code'=>'100','description'=>'Successfull Exit','vehicle_no'=>$getValue['vehicle'],'entry_time'=>$checExist->entry_time,'owner'=>$checExist->vehicle_owner,'vehiclename'=>$checExist->vehicle_name,'exit_time'=>$date,'cost'=>$checExist->cost,'parkingid'=>$checExist->parking_id);
			header('Content-Type: application/json');
            echo json_encode($value);
				}   
				
			}else{

				     $id = $checExist->parking_id;
				     $parking = array();
		             $parking = array(
		             	'status'=>'EXIT',
		             	'exit_time'=>$date
                  );

          $this->parking_model->update_vehicle_info($parking,$id);
          $value = array('code'=>'100','description'=>'Successfull Exit','vehicle_no'=>$getValue['vehicle'],'entry_time'=>$checExist->entry_time,'owner'=>$checExist->vehicle_owner,'vehiclename'=>$checExist->vehicle_name,'exit_time'=>$date,'cost'=>$checExist->cost,'parkingid'=>$checExist->parking_id);
			header('Content-Type: application/json');
            echo json_encode($value);
			}

	}else {
		$value = array('code'=>'103','description'=>'Gari Hili Limeshatoka','vehicle_no'=>$getValue['vehicle']);
			header('Content-Type: application/json');
            echo json_encode($value);
	}
	}
  }

	public function post_transaction_post(){
       
	$getValue = json_decode( file_get_contents( 'php://input' ), true );

	//$date = $getValue['date'];
	$id      = $getValue['emid'];
	$tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$date = $today->format('Y-m-d');
			$date1 = $today->format('Y-m-d H:i:s');

			if (!empty($id)) {

				$basicInfo = $this->employee_model->GetBasic($id);
				$checkExistPay = $this->parking_model->check_exit_vehicle($date);
				$vehicleCount = $this->parking_model->vehicle_count($date);

			if (!empty($checkExistPay->amount)) {
					
				$renter = 'CARPARKING';
				$serviceId = 'PARKING';
				$paidamount = $checkExistPay->amount;
				$sender_region = $basicInfo->em_region;
				$sender_branch = $basicInfo->em_branch;
				$s_mobile = $basicInfo->em_phone;
				$trackno = 00;
				$serial  = 'P'.rand(100,999).date('His');

				$trans = array();
	            $trans = array(

	            'serial'=>$serial,
	            'paidamount'=>$paidamount,
	            'transactiondate'=>$date1,
	            'transactionstatus'=>'POSTED',
	            'bill_status'=>'PENDING',
	            'emid'=>$id,
	            'vehicle'=>$vehicleCount->number
	            );


	            $db2 = $this->load->database('otherdb', TRUE);
	            $db2->insert('parking_transactions',$trans);

				$transactions =$this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

				$update = array();
	                $update = array('billid'=>@$transactions->controlno,'bill_status'=>'SUCCESS');
	                $this->parking_model->update_parking_transactions($update,$serial);

	                $krm = $this->parking_model->get_vehicle_out_info_exit($date);

					foreach ($krm as $exit) {
						
						$id = $exit->parking_id;
			                        $data = array();
			                        $data = array(
			                               'status'=>'PAID',
			                               'controlno'=>@$transactions->controlno
			                           );
			            $this->parking_model->update_parking_control_no($id,$data);
					}

					$value = array('code'=>'100','description'=>'Successful','cost'=>@$checkExistPay->amount,'controlno'=>@$transactions->controlno,'date'=>$date1,'vehicleCount'=>$vehicleCount->number);

				} else {

				$checkControln = $this->parking_model->check_controlno($date,$id);
				$value = array('code'=>'100','description'=>'Successful','cost'=>@$checkControln->paidamount,'controlno'=>@$checkControln->billid,'date'=>$checkControln->transactiondate,'vehicleCount'=>$checkControln->vehicle,'note'=>'DUPLICATE');

				}
				
			} else {
				$value = array('code'=>'400','description'=>'User Does Not Exist');
			}
			header('Content-Type: application/json');
            echo json_encode($value);

	
}

	public function post_barcode_post(){
       // $url = 'http://192.168.33.2/Posta_Api/post_posta';

		$getValue = json_decode( file_get_contents( 'php://input' ), true );
		$trackno = $getValue['trackno'];
		//$location = $getValue['location'];
		$pfno = $getValue['pfno'];
		$posid = $getValue['posid'];
		//$role = $getValue['role'];

         $response = 'KUtoka android'.$trackno.' '.$pfno.' '.$posid;
		$data1 = array();
		    $data1 = array('response'=>$response);

		 $this->Box_Application_model->save_logs($data1);
		
		
		$getInfo = $this->employee_model->GetBasic1($pfno);
		$user = $pfno . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
		$loc = $getInfo->em_region.' - '.$getInfo->em_branch;

		if ($getInfo->em_sub_role  == "SORTING") {

			$event = "Sorting Facility";
			$data = array();
		    $data = array('track_no'=>@$trackno,'location'=>$loc,'user'=>@$user,'pos_id'=>$posid,'event'=>$event);

		 $this->Box_Application_model->save_location($data);

            $db='sender_person_info';
		    $sender = $this->Reports_model->get_sender_person_barcode($db,$trackno);
		    $smobile =@$sender->sender_mobile;
		    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'Sorting ';
          
          if(empty($sender))
          {
          	 $db='sender_info';
		    $sender = $this->Reports_model->get_sender_barcode($db,$trackno);
		    $smobile =@$sender->s_mobile;
		    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'Sorting ';
          

             $db2 ='receiver_info';
             $sender_id =  @$sender->sender_id;
	        $receiver = $this->Reports_model->get_receiverINFO($db2,$sender_id);
	         $rmobile =@$receiver->mobile;
		    $rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'Sorting ';



          }else
          {
          	 $db2 ='receiver_register_info';
             $sender_id = @$sender->senderp_id;
		    $receiver = $this->Reports_model->get_receiver($db2,$sender_id);
		     $rmobile =@$receiver->receiver_mobile;
		    $rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'Sorting ';

          }
                $this->Sms_model->send_sms_trick($smobile,$stotal);
                $this->Sms_model->send_sms_trick($rmobile,$rtotal);

		 $value = "Successful Item Updated";

		}elseif($getInfo->em_sub_role  == "DRIVER") {

			//$get = $this->Box_Application_model->take_bags_item_list_scann($trackno);

			$event = "On Transit";
			$data = array();
		    $data = array('track_no'=>$trackno,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
		    $this->Box_Application_model->save_location($data);
		    $value = "Successful Item Updated";
 			// if (empty($get)) {
 			// 	$value = "No Such Bag Number";
 			// } else {
 			// 	foreach ($get as $value) {
 			// 		$trackno1 = $value->track_number;
			
			 //        $event = "On Transit";
			 //        $data = array();
			 //        $data = array('track_no'=>$trackno1,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
			 //        $this->Box_Application_model->save_location($data);

			 //        $value = "Successful Item Updated";
 			// 	}
 			// }


		    $db='sender_person_info';
		    $sender = $this->Reports_model->get_sender_person_barcode($db,$trackno);
		    $smobile =@$sender->sender_mobile;
		    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'On Transist ';
          
          if(empty($sender))
          {
          	 $db='sender_info';
		    $sender = $this->Reports_model->get_sender_barcode($db,$trackno);
		    $smobile =@$sender->s_mobile;
		    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'On Transist ';
          
          

             $db2 ='receiver_info';
             $sender_id =  $sender->sender_id;
	        $receiver = $this->Reports_model->get_receiverINFO($db2,$sender_id);
	         $rmobile =$receiver->mobile;
		    $rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'On Transist ';
          



          }else
          {
          	 $db2 ='receiver_register_info';
             $sender_id = $sender->senderp_id;
		    $receiver = $this->Reports_model->get_receiver($db2,$sender_id);
		     $rmobile =$receiver->receiver_mobile;
		    $rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'On Transist ';
          

          }
                $this->Sms_model->send_sms_trick($smobile,$stotal);
                $this->Sms_model->send_sms_trick($rmobile,$rtotal);







		 	
		}elseif($getInfo->em_sub_role  == "COUNTER"){
			$event = "Counter";
			$data = array();
		    $data = array('track_no'=>$trackno,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
		    $this->Box_Application_model->save_location($data);
		    $value = "Successful Item Updated";

		     $db='sender_person_info';
		    $sender = $this->Reports_model->get_sender_person_barcode($db,$trackno);
		    $smobile =@$sender->sender_mobile;
		    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. '  '.'Umepokelewa ';
          
          if(empty($sender))
          {
          	 $db='sender_info';
		    $sender = $this->Reports_model->get_sender_barcode($db,$trackno);
		    $smobile =@$sender->s_mobile;
		    $stotal ='Ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Upo Counter '.$loc.' KARIBU POSTA KIGANJANI';
          
          

             $db2 ='receiver_info';
             $sender_id =  $sender->sender_id;
	        $receiver = $this->Reports_model->get_receiverINFO($db2,$sender_id);
	         $rmobile =$receiver->mobile;
		    $rtotal  ='Ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Upo Counter '.$loc.' KARIBU POSTA KIGANJANI';
          



          }else
          {
          	 $db2 ='receiver_register_info';
             $sender_id = $sender->senderp_id;
		    $receiver = $this->Reports_model->get_receiver($db2,$sender_id);
		     $rmobile =$receiver->receiver_mobile;
		     $rtotal  ='Ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Upo Counter '.$loc.' KARIBU POSTA KIGANJANI';
          

          }
                $this->Sms_model->send_sms_trick($smobile,$stotal);
                $this->Sms_model->send_sms_trick($rmobile,$rtotal);



		}elseif ($getInfo->em_sub_role  == "DERIVERER") {
			//$get = $this->Box_Application_model->take_bags_item_list_scann($trackno);

			$event = "Delivery";
			$data = array();
		    $data = array('track_no'=>$trackno,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
		    $this->Box_Application_model->save_location($data);
		    $value = "Successful Item Updated";
 			// if (empty($get)) {
 			// 	$value = "No Such Bag Number";
 			// } else {
 			// 	foreach ($get as $value) {
 			// 		$trackno1 = $value->track_number;
			
			 //        $event = "Delivery";
			 //        $data = array();
			 //        $data = array('track_no'=>$trackno1,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
			 //        $this->Box_Application_model->save_location($data);

			 //        $value = "Successful Item Updated";
 			// 	}
 			// }



		    	 $db='sender_person_info';
		    $sender = $this->Reports_model->get_sender_person_barcode($db,$trackno);
		    $smobile =@$sender->sender_mobile;
		    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. '  '.'Umepokelewa ';
          
          if(empty($sender))
          {
          	 $db='sender_info';
		    $sender = $this->Reports_model->get_sender_barcode($db,$trackno);
		    $smobile =@$sender->s_mobile;
		    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Umepokelewa ';
          
          

             $db2 ='receiver_info';
             $sender_id =  $sender->sender_id;
	        $receiver = $this->Reports_model->get_receiverINFO($db2,$sender_id);
	         $rmobile =@$receiver->mobile;
		    $rtotal ='Asante mteja wetu  kwa kutumia huduma za Posta, KARIBU POSTA KIGANJANI. ';
          



          }else
          {
          	 $db2 ='receiver_register_info';
             $sender_id = $sender->senderp_id;
		    $receiver = $this->Reports_model->get_receiver($db2,$sender_id);
		     $rmobile =@$receiver->receiver_mobile;
		     $rtotal ='Asante mteja wetu  kwa kutumia huduma za Posta, KARIBU POSTA KIGANJANI. ';
          

          }
                $this->Sms_model->send_sms_trick($smobile,$stotal);
                $this->Sms_model->send_sms_trick($rmobile,$rtotal);


		}elseif ($getInfo->em_sub_role  == "RECEIVER") {
			//$get = $this->Box_Application_model->take_bags_item_list_scann($trackno);

			$event = "Arrive";
			$data = array();
		    $data = array('track_no'=>$trackno,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
		    $this->Box_Application_model->save_location($data);
		    $value = "Successful Item Updated";
 			// if (empty($get)) {
 			// 	$value = "No Such Bag Number";
 			// } else {
 			// 	foreach ($get as $value) {
 			// 		$trackno1 = $value->track_number;
			
			 //        $event = "Arrive";
			 //        $data = array();
			 //        $data = array('track_no'=>$trackno1,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
			 //        $this->Box_Application_model->save_location($data);

			 //        $value = "Successful Item Updated";
 			// 	}
 			// }

		    	 $db='sender_person_info';
		    $sender = $this->Reports_model->get_sender_person_barcode($db,$trackno);
		    $smobile =@$sender->sender_mobile;
		    $stotal ='Ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Umepokelewa '.$loc.' '.'KARIBU POSTA KIGANJANI';
          if(empty($sender))
          {
          	 $db='sender_info';
		    $sender = $this->Reports_model->get_sender_barcode($db,$trackno);
		    $smobile =@$sender->s_mobile;
		    $stotal ='Ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Umepokelewa '.$loc.' '.'KARIBU POSTA KIGANJANI';
          
          

             $db2 ='receiver_info';
             $sender_id =  $sender->sender_id;
	        $receiver = $this->Reports_model->get_receiverINFO($db2,$sender_id);
	         $rmobile =@$receiver->mobile;
		    $rtotal ='Ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Umepokelewa '.$loc.' '.'KARIBU POSTA KIGANJANI';



          }else
          {
          	 $db2 ='receiver_register_info';
             $sender_id = $sender->senderp_id;
		    $receiver = $this->Reports_model->get_receiver($db2,$sender_id);
		     $rmobile =@$receiver->receiver_mobile;
		     $rtotal ='Ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Umepokelewa '.$loc.' '.'KARIBU POSTA KIGANJANI';

          }
                $this->Sms_model->send_sms_trick($smobile,$stotal);
                $this->Sms_model->send_sms_trick($rmobile,$rtotal);


		}else{
			$value = "Your Not Authorised to Scan";
		}
		
		header('Content-Type: application/json');
            echo json_encode($value);
		
	}
	//public function post_derivery_list(){
    public function post_derivery_list_post(){
       
	$getValue = json_decode( file_get_contents( 'php://input' ), true );

	$id= $getValue['emid'];
    if(empty($id)){

        header('ontent-Type: application/json');
       echo "notworking";

    }

	$list["ems"]   = $this->Box_Application_model->get_derivery_list_by_id($id);
	$list["pcum"]  = $this->Box_Application_model->get_derivery_pcum_list_by_id($id);
	$list["mails"] = $this->Box_Application_model->get_derivery_list_mails_by_id($id);
	$list["pcum-client"] = $this->Pcum_model->get_bill_customer_list();
	$list["ems-client"] = $this->Bill_Customer_model->get_bill_customer();

		//$love["data"] = $list[0];
	//$love = array();
	//$love = $list[0];
	
	header('Content-Type: application/json');
    echo json_encode($list);
	
  }


public function post_track_post(){
       // $url = 'http://192.168.33.2/Posta_Api/post_posta';

		$getValue = json_decode( file_get_contents( 'php://input' ), true );
		$trackno = $getValue['trackno'];
		//$location = $getValue['location'];
		$pfno = $getValue['pfno'];
		$posid = $getValue['posid'];
		//$role = $getValue['role'];

         $response = 'KUtoka android'.$trackno.' '.$pfno.' '.$posid;
		$data1 = array();
		    $data1 = array('response'=>$response);

		 $this->Box_Application_model->save_logs($data1);

		 $db='sender_person_info';
		    $sender = $this->Reports_model->get_sender_person_barcode($db,$trackno);
		    $track_number =@$sender->track_number;
		     if(empty($sender))
          {
          	 $db='sender_info';
		    $sender = $this->Reports_model->get_sender_barcode($db,$trackno);
		    if(!empty($sender)){
		    	$track_number =@$sender->track_number;

		    }else{ $track_number= $trackno;}
		    
		  }


		 $trackno = $track_number;
		
		
		$getInfo = $this->employee_model->GetBasic1($pfno);
		$user = $pfno . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
		$loc = $getInfo->em_region.' - '.$getInfo->em_branch;

		if ($getInfo->em_sub_role  == "SORTING") {

			$event = "Sorting Facility";
			$data = array();
		    $data = array('track_no'=>@$trackno,'location'=>$loc,'user'=>@$user,'pos_id'=>$posid,'event'=>$event);

		 $this->Box_Application_model->save_location($data);

            $db='sender_person_info';
		    $sender = $this->Reports_model->get_sender($db,$trackno);
		    $smobile =@$sender->sender_mobile;
		    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'Sorting ';
          
          if(empty($sender))
          {
          	 $db='sender_info';
		    $sender = $this->Reports_model->get_sender($db,$trackno);
		    $smobile =@$sender->s_mobile;
		    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'Sorting ';
          

             $db2 ='receiver_info';
             $sender_id =  @$sender->sender_id;
	        $receiver = $this->Reports_model->get_receiverINFO($db2,$sender_id);
	         $rmobile =@$receiver->mobile;
		    $rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'Sorting ';



          }else
          {
          	 $db2 ='receiver_register_info';
             $sender_id = @$sender->senderp_id;
		    $receiver = $this->Reports_model->get_receiver($db2,$sender_id);
		     $rmobile =@$receiver->receiver_mobile;
		    $rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'Sorting ';

          }
                $this->Sms_model->send_sms_trick($smobile,$stotal);
                $this->Sms_model->send_sms_trick($rmobile,$rtotal);

		 $value = "Successful Item Updated";

		}elseif($getInfo->em_sub_role  == "DRIVER") {

			//$get = $this->Box_Application_model->take_bags_item_list_scann($trackno);

			$event = "On Transit";
			$data = array();
		    $data = array('track_no'=>$trackno,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
		    $this->Box_Application_model->save_location($data);
		    $value = "Successful Item Updated";
 			// if (empty($get)) {
 			// 	$value = "No Such Bag Number";
 			// } else {
 			// 	foreach ($get as $value) {
 			// 		$trackno1 = $value->track_number;
			
			 //        $event = "On Transit";
			 //        $data = array();
			 //        $data = array('track_no'=>$trackno1,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
			 //        $this->Box_Application_model->save_location($data);

			 //        $value = "Successful Item Updated";
 			// 	}
 			// }


		    $db='sender_person_info';
		    $sender = $this->Reports_model->get_sender($db,$trackno);
		    $smobile =@$sender->sender_mobile;
		    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'On Transist ';
          
          if(empty($sender))
          {
          	 $db='sender_info';
		    $sender = $this->Reports_model->get_sender($db,$trackno);
		    $smobile =@$sender->s_mobile;
		    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'On Transist ';
          
          

             $db2 ='receiver_info';
             $sender_id =  $sender->sender_id;
	        $receiver = $this->Reports_model->get_receiverINFO($db2,$sender_id);
	         $rmobile =$receiver->mobile;
		    $rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'On Transist ';
          



          }else
          {
          	 $db2 ='receiver_register_info';
             $sender_id = $sender->senderp_id;
		    $receiver = $this->Reports_model->get_receiver($db2,$sender_id);
		     $rmobile =$receiver->receiver_mobile;
		    $rtotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' upo '.'On Transist ';
          

          }
                $this->Sms_model->send_sms_trick($smobile,$stotal);
                $this->Sms_model->send_sms_trick($rmobile,$rtotal);







		 	
		}elseif($getInfo->em_sub_role  == "COUNTER"){
			$event = "Counter";
			$data = array();
		    $data = array('track_no'=>$trackno,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
		    $this->Box_Application_model->save_location($data);
		    $value = "Successful Item Updated";

		     $db='sender_person_info';
		    $sender = $this->Reports_model->get_sender($db,$trackno);
		    $smobile =@$sender->sender_mobile;
		    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. '  '.'Umepokelewa ';
          
          if(empty($sender))
          {
          	 $db='sender_info';
		    $sender = $this->Reports_model->get_sender($db,$trackno);
		    $smobile =@$sender->s_mobile;
		    $stotal ='Ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Upo Counter '.$loc.' KARIBU POSTA KIGANJANI';
          
          

             $db2 ='receiver_info';
             $sender_id =  $sender->sender_id;
	        $receiver = $this->Reports_model->get_receiverINFO($db2,$sender_id);
	         $rmobile =$receiver->mobile;
		    $rtotal  ='Ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Upo Counter '.$loc.' KARIBU POSTA KIGANJANI';
          



          }else
          {
          	 $db2 ='receiver_register_info';
             $sender_id = $sender->senderp_id;
		    $receiver = $this->Reports_model->get_receiver($db2,$sender_id);
		     $rmobile =$receiver->receiver_mobile;
		     $rtotal  ='Ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Upo Counter '.$loc.' KARIBU POSTA KIGANJANI';
          

          }
                $this->Sms_model->send_sms_trick($smobile,$stotal);
                $this->Sms_model->send_sms_trick($rmobile,$rtotal);



		}elseif ($getInfo->em_sub_role  == "DERIVERER") {
			//$get = $this->Box_Application_model->take_bags_item_list_scann($trackno);

			$event = "Delivery";
			$data = array();
		    $data = array('track_no'=>$trackno,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
		    $this->Box_Application_model->save_location($data);
		    $value = "Successful Item Updated";
 			// if (empty($get)) {
 			// 	$value = "No Such Bag Number";
 			// } else {
 			// 	foreach ($get as $value) {
 			// 		$trackno1 = $value->track_number;
			
			 //        $event = "Delivery";
			 //        $data = array();
			 //        $data = array('track_no'=>$trackno1,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
			 //        $this->Box_Application_model->save_location($data);

			 //        $value = "Successful Item Updated";
 			// 	}
 			// }



		    	 $db='sender_person_info';
		    $sender = $this->Reports_model->get_sender($db,$trackno);
		    $smobile =@$sender->sender_mobile;
		    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. '  '.'Umepokelewa ';
          
          if(empty($sender))
          {
          	 $db='sender_info';
		    $sender = $this->Reports_model->get_sender($db,$trackno);
		    $smobile =@$sender->s_mobile;
		    $stotal ='KARIBU POSTA KIGANJANI, ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Umepokelewa ';
          
          

             $db2 ='receiver_info';
             $sender_id =  $sender->sender_id;
	        $receiver = $this->Reports_model->get_receiverINFO($db2,$sender_id);
	         $rmobile =@$receiver->mobile;
		    $rtotal ='Asante mteja wetu  kwa kutumia huduma za Posta, KARIBU POSTA KIGANJANI. ';
          



          }else
          {
          	 $db2 ='receiver_register_info';
             $sender_id = $sender->senderp_id;
		    $receiver = $this->Reports_model->get_receiver($db2,$sender_id);
		     $rmobile =@$receiver->receiver_mobile;
		     $rtotal ='Asante mteja wetu  kwa kutumia huduma za Posta, KARIBU POSTA KIGANJANI. ';
          

          }
                $this->Sms_model->send_sms_trick($smobile,$stotal);
                $this->Sms_model->send_sms_trick($rmobile,$rtotal);


		}elseif ($getInfo->em_sub_role  == "RECEIVER") {
			//$get = $this->Box_Application_model->take_bags_item_list_scann($trackno);

			$event = "Arrive";
			$data = array();
		    $data = array('track_no'=>$trackno,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
		    $this->Box_Application_model->save_location($data);
		    $value = "Successful Item Updated";
 			// if (empty($get)) {
 			// 	$value = "No Such Bag Number";
 			// } else {
 			// 	foreach ($get as $value) {
 			// 		$trackno1 = $value->track_number;
			
			 //        $event = "Arrive";
			 //        $data = array();
			 //        $data = array('track_no'=>$trackno1,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
			 //        $this->Box_Application_model->save_location($data);

			 //        $value = "Successful Item Updated";
 			// 	}
 			// }

		    	 $db='sender_person_info';
		    $sender = $this->Reports_model->get_sender($db,$trackno);
		    $smobile =@$sender->sender_mobile;
		    $stotal ='Ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Umepokelewa '.$loc.' '.'KARIBU POSTA KIGANJANI';
          if(empty($sender))
          {
          	 $db='sender_info';
		    $sender = $this->Reports_model->get_sender($db,$trackno);
		    $smobile =@$sender->s_mobile;
		    $stotal ='Ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Umepokelewa '.$loc.' '.'KARIBU POSTA KIGANJANI';
          
          

             $db2 ='receiver_info';
             $sender_id =  $sender->sender_id;
	        $receiver = $this->Reports_model->get_receiverINFO($db2,$sender_id);
	         $rmobile =@$receiver->mobile;
		    $rtotal ='Ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Umepokelewa '.$loc.' '.'KARIBU POSTA KIGANJANI';



          }else
          {
          	 $db2 ='receiver_register_info';
             $sender_id = $sender->senderp_id;
		    $receiver = $this->Reports_model->get_receiver($db2,$sender_id);
		     $rmobile =@$receiver->receiver_mobile;
		     $rtotal ='Ndugu mteja mzigo wako wenye Track number '.$trackno. ' '.'Umepokelewa '.$loc.' '.'KARIBU POSTA KIGANJANI';

          }
                $this->Sms_model->send_sms_trick($smobile,$stotal);
                $this->Sms_model->send_sms_trick($rmobile,$rtotal);


		}else{
			$value = "Your Not Authorised to Scan";
		}
		
		header('Content-Type: application/json');
            echo json_encode($value);
		
	}

   public function post_derivery_ems_post(){
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );

   $id= $getValue['emid'];

   $getemid=$this->Box_Application_model->Getemidbymail($id);

   if(!empty($getemid)){
    
    $userid=$getemid->em_id;


    /*if(empty($id)){

        header('ontent-Type: application/json');
       echo "notworking";

    }*/

    $list["ems"]   = $this->Box_Application_model->get_derivery_list_by_id($userid);
    // $list["pcum"]  = $this->Box_Application_model->get_derivery_pcum_list_by_id($id);
    // $list["mails"] = $this->Box_Application_model->get_derivery_list_mails_by_id($id);
    // $list["pcum-client"] = $this->Pcum_model->get_bill_customer_list();
    // $list["ems-client"] = $this->Bill_Customer_model->get_bill_customer();

    if(!empty($list["ems"])){

        //$love["data"] = $list[0];
    //$love = array();
    //$love = $list[0];
    
    header('Content-Type: application/json');
    echo json_encode($list);
} else {

$arr = array(array('message'=>'Delivery Information Not Found','status'=>'404'));
$listE["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($listE);

}

} else {

$arr = array(array('message'=>'User Not Found','status'=>'404','idnotfound'=>$id));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);

}
    
  }

   public function post_derivery_pcum_post(){
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );

    $id= $getValue['emid'];

    $getemid=$this->Box_Application_model->Getemidbymail($id);

    $id=$getemid->em_id;
    if(empty($id)){

        header('ontent-Type: application/json');
       //echo "notworking";

    }

    //$list["ems"]   = $this->Box_Application_model->get_derivery_list_by_id($id);
    $list["pcum"]  = $this->Box_Application_model->get_derivery_pcum_list_by_id($id);
    // $list["mails"] = $this->Box_Application_model->get_derivery_list_mails_by_id($id);
    // $list["pcum-client"] = $this->Pcum_model->get_bill_customer_list();
    // $list["ems-client"] = $this->Bill_Customer_model->get_bill_customer();

        //$love["data"] = $list[0];
    //$love = array();
    //$love = $list[0];
    
    header('Content-Type: application/json');
    echo json_encode($list);
    
  }


   public function post_derivery_mails_post(){
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );

   $id= $getValue['emid'];

    $getemid=$this->Box_Application_model->Getemidbymail($id);
    
    $id=$getemid->em_id;
    if(empty($id)){

        header('ontent-Type: application/json');
       echo "notworking";

    }

    //$list["ems"]   = $this->Box_Application_model->get_derivery_list_by_id($id);
    //$list["pcum"]  = $this->Box_Application_model->get_derivery_pcum_list_by_id($id);
     $list["mails"] = $this->Box_Application_model->get_derivery_list_mails_by_id($id);
    // $list["pcum-client"] = $this->Pcum_model->get_bill_customer_list();
    // $list["ems-client"] = $this->Bill_Customer_model->get_bill_customer();

        //$love["data"] = $list[0];
    //$love = array();
    //$love = $list[0];
    
    header('Content-Type: application/json');
    echo json_encode($list);
    
  }

   public function post_derivery_parcel_post(){
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );

   $id= $getValue['emid'];

    $getemid=$this->Box_Application_model->Getemidbymail($id);
    
    $id=$getemid->em_id;
    if(empty($id)){

        header('ontent-Type: application/json');
       //echo "notworking";

    }
     $type ='Parcels-Post';
     $list["mails"] = $this->Box_Application_model->get_derivery_list_mails_by_emid($id,$type);
  
    
    header('Content-Type: application/json');
    echo json_encode($list);
    
  }

  public function post_derivery_Register_post(){
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );

   $id= $getValue['emid'];

    $getemid=$this->Box_Application_model->Getemidbymail($id);
    
    $id=$getemid->em_id;
    if(empty($id)){

        header('ontent-Type: application/json');
       //echo "notworking";

    }
     $type ='Register';
     $list["mails"] = $this->Box_Application_model->get_new_derivery_list_mails_by_emid($id);
  
    
    header('Content-Type: application/json');
    echo json_encode($list);
    
  }

   public function post_derivery_smallpackets_post(){
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );

   $id= $getValue['emid'];

    $getemid=$this->Box_Application_model->Getemidbymail($id);
    
    $id=$getemid->em_id;
    if(empty($id)){

        header('ontent-Type: application/json');
       //echo "notworking";

    }
     $type ='Small-Packets';
     $list["mails"] = $this->Box_Application_model->get_derivery_list_mails_by_emid($id,$type);
  
    
    header('Content-Type: application/json');
    echo json_encode($list);
    
  }

  public function post_derivery_postcargo_post(){
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );

   $id= $getValue['emid'];

    $getemid=$this->Box_Application_model->Getemidbymail($id);
    
    $id=$getemid->em_id;
    if(empty($id)){

        header('ontent-Type: application/json');
       //echo "notworking";

    }
     $type ='Posts-Cargo';
     $list["mails"] = $this->Box_Application_model->get_derivery_list_mails_by_emid($id,$type);
  
    
    header('Content-Type: application/json');
    echo json_encode($list);
    
  }

  public function post_derivery_private_post(){
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );

   $id= $getValue['emid'];

    $getemid=$this->Box_Application_model->Getemidbymail($id);
    
    $id=$getemid->em_id;
    if(empty($id)){

        header('ontent-Type: application/json');
       //echo "notworking";

    }
     $type ='Private-Bag';
     $list["mails"] = $this->Box_Application_model->get_derivery_list_mails_by_emid($id,$type);
  
    
    header('Content-Type: application/json');
    echo json_encode($list);
    
  }
   public function post_derivery_foreignparcel_post(){
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );

   $id= $getValue['emid'];

    $getemid=$this->Box_Application_model->Getemidbymail($id);
    
    $id=$getemid->em_id;
    if(empty($id)){

        header('ontent-Type: application/json');
       //echo "notworking";

    }
     $type ='Foreign-Parcel';
     $list["mails"] = $this->Box_Application_model->get_derivery_list_mails_by_emid($id,$type);
  
    
    header('Content-Type: application/json');
    echo json_encode($list);
    
  }


  public function post_tracknumber_post(){
       // $url = 'http://192.168.33.2/Posta_Api/post_posta';

		$getValue = json_decode( file_get_contents( 'php://input' ), true );
		$trackno = $getValue['tracknumber'];

		 $wixy = array();

		// $emslists[] = $this->ReceivedBranch_ViewModel->view_data($value->s_fullname,$value->s_region, $value->s_district, $value->date_registered, $value->track_number,$value->r_region, $value->branch,$value->id, $value->office_name,$value->bag_status, 'BRANCH');

		
		 $db='sender_info';
         $senderinfo = $this->unregistered_model->get_senderinfo_barcodes($db,$trackno);

         if(!empty($senderinfo)){
          $wixy[] = $this->Received_ViewModel->view_data($senderinfo->s_fullname,$senderinfo->s_mobile, $senderinfo->ems_type, '',
           $senderinfo->date_registered,'', $senderinfo->status,$senderinfo->s_region, $senderinfo->s_district,$senderinfo->r_region, 
           $senderinfo->branch,$senderinfo->billid,$senderinfo->track_number,'', '','transactions',$senderinfo->Barcode);
      }
         
          $db2='sender_person_info';
           $senderperson = $this->unregistered_model->get_senderperson_barcodes($db2,$trackno);
           if(!empty($senderperson)){

          	
          	   $wixy[] = $this->Received_ViewModel->view_data($senderperson->sender_fullname,$senderperson->sender_mobile, 
          	 	$senderperson->register_type, $senderperson->register_weght, $senderperson->sender_date_created,
          	 	$senderperson->register_price, $senderperson->status,$senderperson->sender_region, $senderperson->sender_branch,
          	 	$senderperson->receiver_region, $senderperson->reciver_branch,$senderperson->billid,$senderperson->track_number,
          	 	$senderperson->sender_status, $senderperson->senderp_id, 'register transaction',$senderperson->Barcode);;
          	}
         
          if(!empty($senderinfo) || !empty($senderperson) )//which table
          {
          	foreach ($wixy as $key => $value) {
          	 	// code...
          	 	$wixy = (object)$value;
          		 header('Content-Type: application/json');
		         $value = array();
		         $value = array('code'=>'100','description'=>'Available','tracknumber'=>$wixy->track_number,'barcode'=>$wixy->Barcode,
		         	'source'=>$wixy->sender_region,'destination'=>$wixy->receiver_region,'item'=>$wixy->register_type,
		         	'controlnumber'=>$wixy->billid,'mobile'=>$wixy->sender_date_created,'paymentstatus'=>$wixy->payment_type);
		         echo json_encode($value);


          	 } 
          	     
          	
         }else{
          	
          	 	 header('Content-Type: application/json');
         	        $value = array();
				     $value = array('code'=>'200','description'=>'Not Available ');
				    echo json_encode($value);
         

              }
		    



		}





  public function post_receive_post(){
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );

   $emid= $getValue['emid'];
   $trackno = $getValue['identifier'];

    $getemid=$this->Box_Application_model->Getemidbymail($emid);
    
    $emid=$getemid->em_id;


    if(empty($emid)){

                            $value = array();
						    $value = array('message'=>'Empty emid','status'=>'404');
						     $list["data"] = $value; 
		    
						    header('Content-Type: application/json');
						    echo json_encode($list);
       //echo "notworking";

    }else{
    $word = 'DS';
    if(strpos($trackno, $word) !== false ){

                         $updes = array(); //receive despatch
                         $updes = array('despatch_status'=>'Received','received_by'=>$emid);
                         $this->unregistered_model->update_despatch_info($updes,$trackno);

                          $listbags = $this->unregistered_model->get_Mail_bags_desp_list_BYNO($trackno);

                         foreach ($listbags as $key => $value) {
                           # code...
                          $id =$value->bag_id;

                           $update1 = array();
                            $update1 = array('bags_status'=>'isReceived','bag_received_by'=>$emid);
                            $this->unregistered_model->update_bags_info($update1,$id);


                            //update content za bags
                            $listitems = $this->unregistered_model->get_list_of_all_bags($id);
                              foreach ($listitems as $value) {

                                $last_id = $value->senderp_id;
                                $update2 = array();
                                $update2 = array('sender_status'=>'Back',);
                                $this->unregistered_model->update_sender_info($last_id,$update2);
                              }


                         }


                            // $data = array();//update to backoffice
                            // $data = array('sender_status'=>'BackReceive');//
                            // $this->unregistered_model->update_acceptance_sender_person_info($trackno,$data); //from counter

                            

						       $arr = array(array('message'=>'Successful Received','status'=>'200'));
                                $list["data"]=$arr; 
    
		    
						    header('Content-Type: application/json');
						    echo json_encode($list);



    }
    else{

        $info = $this->employee_model->GetBasic($emid);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;

    // $word = 'RD';
    // if(strpos($trackno, $word) !== false ){
        //ACCEPT 


    	 $db='sender_info';
         $senderinfo = $this->unregistered_model->get_senderinfo($db,$trackno);
         
          if(!empty($senderinfo))//which table
          {
          	//check payment
          	$sender_id=@$senderinfo->sender_id;
          	$serial=@$senderinfo->serial;
          	$DB='transactions';
         $transactions1 = $this->unregistered_model->Checkintransactions($DB,$sender_id);

         // $DB='register_transactions';
         // $transactions2 = $this->unregistered_model->Checkintransactions1($DB,$serial);
         // $DB='parcel_international_transactions';
         // $transactions4 = $this->unregistered_model->Checkintransactions3($DB,$serial);


         if(!empty($transactions1) ){

          	if($senderinfo->item_status != 'Received'){ //haijawa received?
                    $love = array();//from counter or region - receive item
                    $love = array(
                      'track_no'=>$trackno,
                      'event'=>$info->em_role,
                      'region'=>$info->em_region,
                      'branch'=>$info->em_branch,
                      'user'=>$emid,
                      'name'=>'Received',
                      'status'=>'Received',
                      'type'=>'qrscan'
                    );

                    $this->unregistered_model->save_event($love);


                    $data = array();//update sender status
                    $data = array('s_status'=>'Received','item_status'=>'Received');
                    $this->unregistered_model->update_acceptance_sender_info($trackno,$data); 

                    $sender_id=@$senderinfo->sender_id;
                    $data2 = array();//update transaction status
                    $data2 = array('office_name'=>'Received');
                    $this->unregistered_model->update_transactionsbyinfosender_id($sender_id,$data2); 




				       $arr = array(array('message'=>'Successful Received','status'=>'200'));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

          	 
          	}else{

          		

				       $arr = array(array('message'=>'Already Scanned','status'=>'404'));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

          	}
          	 }else{
          	 	


				     $arr = array(array('message'=>'Payment not Received','status'=>'404'));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);
         }
		    

		}else{

			$db='sender_person_info';
          	 $senderperson = $this->unregistered_model->get_senderperson($db,$trackno);
          	  
        if(!empty($senderperson))//which table
          {
          	 //check payment
          	$senderp_id=@$senderperson->senderp_id;
          	//$serial=@$senderperson->serial;
         //  	$DB='transactions';
         // $transactions1 = $this->unregistered_model->Checkintransactions($DB,$senderp_id);
         $DB='register_transactions';
         $transactions2 = $this->unregistered_model->CheckintransactionsBYSENDERPRS($DB,$senderp_id);
         $DB='parcel_international_transactions';
         $transactions4 = $this->unregistered_model->Checkintransactions3($DB,$senderp_id);

  if( !empty($transactions2) || !empty($transactions4)){

          	 if(!empty($senderperson)){

          	
		    if($senderperson->sender_status != 'BackReceive'){ //haijawa received?


                    $love = array();//from counter or region - receive item
                    $love = array(
                      'track_no'=>$trackno,
                      'event'=>$info->em_role,
                      'region'=>$info->em_region,
                      'branch'=>$info->em_branch,
                      'user'=>$emid,
                      'name'=>'BackReceive',
                      'status'=>'Received',
                      'type'=>'qrscan'
                    );

                    $this->unregistered_model->save_event($love);


                    $data = array();//update sender status
                    $data = array('sender_status'=>'BackReceive');
                    $this->unregistered_model->update_acceptance_sender_person_info($trackno,$data); 

				       $arr = array(array('message'=>'Successful Received','status'=>'200'));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

				    

          	 
          	}else{


				     $arr = array(array('message'=>'Already Scanned','status'=>'404'));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

          	}}
          	 }else{


				     $arr = array(array('message'=>'Payment not Received','status'=>'404'));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);
         }
		    



		}else{


    	 $db='sender_info';
         $senderinfo = $this->unregistered_model->get_senderinfo_barcode($db,$trackno);
         
          if(!empty($senderinfo))//which table
          {
          	//check payment
          	$sender_id=@$senderinfo->sender_id;
          	$serial=@$senderinfo->serial;
          	$trackno=@$senderinfo->track_number;
          	$DB='transactions';
         $transactions1 = $this->unregistered_model->Checkintransactions($DB,$sender_id);

         // $DB='register_transactions';
         // $transactions2 = $this->unregistered_model->Checkintransactions1($DB,$serial);
         // $DB='parcel_international_transactions';
         // $transactions4 = $this->unregistered_model->Checkintransactions3($DB,$serial);


         if(!empty($transactions1) ){

          	if($senderinfo->item_status != 'Received'){ //haijawa received?
                    $love = array();//from counter or region - receive item
                    $love = array(
                      'track_no'=>$trackno,
                      'event'=>$info->em_role,
                      'region'=>$info->em_region,
                      'branch'=>$info->em_branch,
                      'user'=>$emid,
                      'name'=>'Received',
                      'status'=>'Received',
                      'type'=>'qrscan'
                    );

                    $this->unregistered_model->save_event($love);


                    $data = array();//update sender status
                    $data = array('s_status'=>'Received','item_status'=>'Received');
                    $this->unregistered_model->update_acceptance_sender_info_barcode($sender_id,$data); 

                    $sender_id=@$senderinfo->sender_id;
                    $data2 = array();//update transaction status
                    $data2 = array('office_name'=>'Received');
                    $this->unregistered_model->update_transactionsbyinfosender_id($sender_id,$data2); 




				       $arr = array(array('message'=>'Successful Received','status'=>'200'));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

          	 
          	}else{

          		

				       $arr = array(array('message'=>'Already Scanned','status'=>'404'));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

          	}
          	 }else{
          	 	


				     $arr = array(array('message'=>'Payment not Received','status'=>'404'));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);
         }
		    

		}else{

			$db='sender_person_info';
          	 $senderperson = $this->unregistered_model->get_senderperson_barcode($db,$trackno);
          	  
        if(!empty($senderperson))//which table
          {
          	 //check payment
          	$senderp_id=@$senderperson->senderp_id;
          	$trackno=@$senderperson->track_number;
          	//$serial=@$senderperson->serial;
         //  	$DB='transactions';
         // $transactions1 = $this->unregistered_model->Checkintransactions($DB,$senderp_id);
         $DB='register_transactions';
         $transactions2 = $this->unregistered_model->CheckintransactionsBYSENDERPRS($DB,$senderp_id);
         $DB='parcel_international_transactions';
         $transactions4 = $this->unregistered_model->Checkintransactions3($DB,$senderp_id);

  if( !empty($transactions2) || !empty($transactions4)){

          	 if(!empty($senderperson)){

          	
		    if($senderperson->sender_status != 'BackReceive'){ //haijawa received?


                    $love = array();//from counter or region - receive item
                    $love = array(
                      'track_no'=>$trackno,
                      'event'=>$info->em_role,
                      'region'=>$info->em_region,
                      'branch'=>$info->em_branch,
                      'user'=>$emid,
                      'name'=>'BackReceive',
                      'status'=>'Received',
                      'type'=>'qrscan'
                    );

                    $this->unregistered_model->save_event($love);


                    $data = array();//update sender status
                    $data = array('sender_status'=>'BackReceive');
                    $this->unregistered_model->update_acceptance_sender_person_info_barcode($senderp_id,$data); 

				       $arr = array(array('message'=>'Successful Received','status'=>'200'));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

				    

          	 
          	}else{


				     $arr = array(array('message'=>'Already Scanned','status'=>'404'));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

          	}}
          	 }else{


				     $arr = array(array('message'=>'Payment not Received','status'=>'404'));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);
         }
		    



		}
	}
		}
	}


   

}
}
     
    
   
    
  }





 public function box_receipt_post(){
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );

     $emid= $getValue['emid'];
    $getemid=$this->Box_Application_model->Getemidbymail($emid);
    
    $emid=$getemid->em_id;
    $controlnumber = $getValue['identifier'];

            $info = $this->employee_model->GetBasic($emid);
              $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;


if(!empty($getemid))//which table
{	
         $box = $this->Box_Application_model->get_box_listt_bill($controlnumber);
         
          if(!empty($box))//which table
          {
          	$Outstanding = $this->Box_Application_model->get_box_outstanding_list_perperson(@$box->CustomerID);
          	 $maxyear=1;
          	  $payment = array();
          	if (!empty($Outstanding)) {
                foreach ($Outstanding as $value) {
                	$payment[]=array('year'=>$value->year,'amount'=>$value->amount);
                  if(date('Y', strtotime($box->paymentdate)) < $value->year){


                    if($value->year != 'Authority Card' AND $value->year != 'Key Deposity' ){
                    
                       $maxyear=$maxyear+1;

                  }


                  }
                  
                }
                
               
               }

          	 $yearOnly=date('Y', strtotime(@$box->paymentdate)) + $maxyear;
             $renew_date = '01-01-'.$yearOnly; 


         	$operator=@$user;
          	$customer_name=@$box->cust_name;
          	$identity_type=@$box->iddescription;
          	$identity_number=@$box->idnumber;
          	$box_number=@$box->boxnumbers;
          	$branch=@$box->branch;
          	
          	$box_payment_information='Payment For '.@$box->boxinfo;
          	$control_number=@$box->billid;
          	$receipt_number=@$box->receipt;
          	$region=@$box->region;
          	$paymentdata=@$payment;
          	$payment_date=@$box->paymentdate;
          	//$renew_date=@$box->s_mobile;
          	$total=@$box->paidamount;

         




				       $arr = array(array('message'=>'Successful','status'=>'200',
				                         'operator'=>$operator,'customer_name'=>$customer_name,'paymentdata'=>$paymentdata,
				                       'identity_type'=>$identity_type,'identity_number'=>$identity_number,
				                       'box_number'=>$box_number,'region'=>$region,
				               'branch'=>$branch,'box_payment_information'=>$box_payment_information,
				               'control_number'=>$control_number,'receipt_number'=>$receipt_number,
				               'payment_date'=>$payment_date,
				               'renew_date'=>$renew_date,'total'=>$total
				           ));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

          	 
          	
          	 
		    

		}else{

			
         	$operator=@$user;
          	$customer_name='';
          	$identity_type='';
          	$identity_number='';
          	$box_number='';
          	$branch='';
          	$box_payment_information='';
          	$control_number='';
          	$receipt_number='';
          	$payment_date='';
          	$renew_date='';
          	$total='';
          	$region='';
          	$paymentdata='';

				       $arr = array(array('message'=>'Not Successful','status'=>'404',
				                         'operator'=>$operator,'customer_name'=>$customer_name,
				                       'identity_type'=>$identity_type,'identity_number'=>$identity_number,
				                       'box_number'=>$box_number,'paymentdata'=>$paymentdata,'region'=>$region,
				               'branch'=>$branch,'box_payment_information'=>$box_payment_information,
				               'control_number'=>$control_number,'receipt_number'=>$receipt_number,
				               'payment_date'=>$payment_date,
				               'renew_date'=>$renew_date,'total'=>$total
				           ));
                      $list["data"]=$arr; 
    
    
				    header('Content-Type: application/json');
				    echo json_encode($list);
		}

	}else{

			$operator=@$emid;
          	$customer_name='';
          	$identity_type='';
          	$identity_number='';
          	$box_number='';
          	$branch='';
          	$box_payment_information='';
          	$control_number='';
          	$receipt_number='';
          	$payment_date='';
          	$renew_date='';
          	$total='';
          		$region='';
          	$paymentdata='';


				       $arr = array(array('message'=>'Invalid User','status'=>'404',
				                         'operator'=>$operator,'customer_name'=>$customer_name,
				                       'identity_type'=>$identity_type,'identity_number'=>$identity_number,
				                       'box_number'=>$box_number,'paymentdata'=>$paymentdata,'region'=>$region,
				               'branch'=>$branch,'box_payment_information'=>$box_payment_information,
				               'control_number'=>$control_number,'receipt_number'=>$receipt_number,
				               'payment_date'=>$payment_date,
				               'renew_date'=>$renew_date,'total'=>$total
				           ));
                      $list["data"]=$arr; 
    
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

	}
	
    
  }


public function post_receipt_post(){
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );

     $emid= $getValue['emid'];
    $getemid=$this->Box_Application_model->Getemidbymail($emid);
    
    $emid=$getemid->em_id;
    $trackno = $getValue['identifier'];

            $info = $this->employee_model->GetBasic($emid);
              $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;



    	 $db='sender_info';
         $senderinfo = $this->unregistered_model->get_senderinfo_barcode($db,$trackno);
         
          if(!empty($senderinfo))//which table
          {
          	

         	$operator=@$user;
          	$Destination=@$senderinfo->r_region;
          	$weight=@$senderinfo->weight;
          	$Amount=@$senderinfo->paidamount;
          	// $vat=@$senderinfo->item_vat;
          	$item=@$senderinfo->ems_type;
          	$total=@$senderinfo->paidamount;
          	$controlnumber=@$senderinfo->billid;
          	$barcode=@$senderinfo->Barcode;
          	$sender=@$senderinfo->s_fullname;
          	$senderbranch=@$senderinfo->s_district;
          	$address=@$senderinfo->s_address;
          	$phone=@$senderinfo->s_mobile;
          	$receiver=@$senderinfo->fullname;
          	$receiverphone=@$senderinfo->mobile;
          	$receiveraddress=@$senderinfo->address;

				       $arr = array(array('message'=>'Successful','status'=>'200',
				                         'operator'=>$operator,'Destination'=>$Destination,
				                       'weight'=>$weight,'Amount'=>$Amount,'item'=>$item,
				               'total'=>$total,'controlnumber'=>$controlnumber,'barcode'=>$barcode,
				               'sender'=>$sender,'senderbranch'=>$senderbranch,'address'=>$address,
				               'phone'=>$phone,'receiver'=>$receiver,
				               'receiverphone'=>$receiverphone,'receiveraddress'=>$receiveraddress,
				           ));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

          	 
          	
          	 
		    

		}else{

			$db='sender_person_info';
          	 $senderperson = $this->unregistered_model->get_new_senderperson_barcode($db,$trackno);
          	  
        if(!empty($senderperson))//which table
          {
                    
            $operator=@$user;
          	$Destination=@$senderperson->receiver_region;
          	$weight=@$senderperson->register_weght;
          	$Amount=@$senderperson->paidamount;
          	// $vat=@$senderperson->item_vat;
          	$item=@$senderperson->register_type;
          	$total=@$senderperson->paidamount;
          	$controlnumber=@$senderperson->billid;
          		$barcode=@$senderperson->Barcode;
          	$sender=@$senderperson->sender_fullname;
          	$senderbranch=@$senderperson->sender_branch;
          	$address=@$senderperson->sender_address;
          	$phone=@$senderperson->sender_mobile;
          	$receiver=@$senderperson->receiver_fullname;
          	$receiverphone=@$senderperson->receiver_mobile;
          	$receiveraddress=@$senderperson->r_address;


				      $arr = array(array('message'=>'Successful','status'=>'200',
				                         'operator'=>$operator,'Destination'=>$Destination,
				                       'weight'=>$weight,'Amount'=>$Amount,'item'=>$item,
				               'total'=>$total,'controlnumber'=>$controlnumber,'barcode'=>$barcode,
				               'sender'=>$sender,'senderbranch'=>$senderbranch,'address'=>$address,
				               'phone'=>$phone,'receiver'=>$receiver,
				               'receiverphone'=>$receiverphone,'receiveraddress'=>$receiveraddress,
				           ));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

				    

          	 
          
         
		    



		}else{
			//parcel international

			$db='sender_person_info';
          	 $senderperson = $this->FGN_Application_model->get_new_international_senderperson_barcode($db,$trackno);
          	  
        if(!empty($senderperson))//which table
          {
                    
            $operator=@$user;
          	$Destination=@$senderperson->receiver_region;
          	$weight=@$senderperson->register_weght;
          	$Amount=@$senderperson->paidamount;
          	// $vat=@$senderperson->item_vat;
          	$item='Parcel';
          	$total=@$senderperson->paidamount;
          	$controlnumber=@$senderperson->billid;
          		$barcode=@$senderperson->Barcode;
          	$sender=@$senderperson->sender_fullname;
          	$senderbranch=@$senderperson->sender_branch;
          	$address=@$senderperson->sender_address;
          	$phone=@$senderperson->sender_mobile;
          	$receiver=@$senderperson->receiver_fullname;
          	$receiverphone=@$senderperson->receiver_mobile;
          	$receiveraddress=@$senderperson->r_address;


				      $arr = array(array('message'=>'Successful','status'=>'200',
				                         'operator'=>$operator,'Destination'=>$Destination,
				                       'weight'=>$weight,'Amount'=>$Amount,'item'=>$item,
				               'total'=>$total,'controlnumber'=>$controlnumber,'barcode'=>$barcode,
				               'sender'=>$sender,'senderbranch'=>$senderbranch,'address'=>$address,
				               'phone'=>$phone,'receiver'=>$receiver,
				               'receiverphone'=>$receiverphone,'receiveraddress'=>$receiveraddress,
				           ));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);
			}else{

			$operator=@$user;
          	$Destination='';
          	$weight='';
          	$Amount='';
          	// $vat=@$senderperson->item_vat;
          	$item='';
          	$total='';
          	$controlnumber='';
          		$barcode='';
          	$sender='';
          	$senderbranch='';
          	$address='';
          	$phone='';
          	$receiver='';
          	$receiverphone='';
          	$receiveraddress='';


				       $arr = array(array('message'=>'Not found/Not Paid','status'=>'404',
				                         'operator'=>$operator,'Destination'=>$Destination,
				                       'weight'=>$weight,'Amount'=>$Amount,'item'=>$item,
				               'total'=>$total,'controlnumber'=>$controlnumber,'barcode'=>$barcode,
				               'sender'=>$sender,'senderbranch'=>$senderbranch,'address'=>$address,
				               'phone'=>$phone,'receiver'=>$receiver,
				               'receiverphone'=>$receiverphone,'receiveraddress'=>$receiveraddress,
				           ));
                      $list["data"]=$arr; 
    
    
				    header('Content-Type: application/json');
				    echo json_encode($list);
		}
	}

    }
  }


public function post_receipts_post(){
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );

     $emid= $getValue['emid'];
    $getemid=$this->Box_Application_model->Getemidbymail($emid);
    
    $emid=$getemid->em_id;
    $trackno = $getValue['identifier'];

            $info = $this->employee_model->GetBasic($emid);
              $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;



    	 $db='sender_info';
         $senderinfo = $this->unregistered_model->get_senderinfo_barcode($db,$trackno);
         
          if(!empty($senderinfo))//which table
          {
          	 $itemdata = array();
            

          	$controlnumber = @$senderinfo->billid;
          	 $senderinfolist = $this->unregistered_model->get_senderinfo_list_controlnumber($db,$controlnumber);
          	 foreach ($senderinfolist as $key => $value) {
          	 	// code...

          	 	 $itemdata[]=array(
          	 	 	'Destination'=>$value->r_region,
          	 	 	'weight'=>$value->weight,
          	 	 	'Amount'=>$value->paidamount,
          	 	 	'item'=>$value->ems_type,
          	 	 	'total'=>$value->paidamount,
          	 	 	'controlnumber'=>$value->billid,
          	 	 	'barcode'=>@$value->Barcode,
          	 	 	'sender'=>$value->s_fullname,
          	 	 	'senderbranch'=>$value->s_district,
          	 	 	'address'=>$value->s_address,
          	 	 	'phone'=>$value->s_mobile,
          	 	 	'receiver'=>$value->fullname,
          	 	 	'receiveraddress'=>$value->address,
          	 	 	'receiverphone'=>$value->mobile);
          	 }

         	$operator=@$user;
          	$total=@$senderinfo->paidamount;
          	$controlnumber=@$senderinfo->billid;
          	$itemdata=@$itemdata;
          	

				       $arr = array(array('message'=>'Successful','status'=>'200',
				                         'operator'=>$operator, 'total'=>$total,
				                         'controlnumber'=>$controlnumber,'itemdata'=>$itemdata,
				              
				           ));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

		}else{

			$db='sender_person_info';
          	 $senderperson = $this->unregistered_model->get_senderperson_barcode($db,$trackno);
          	  
        if(!empty($senderperson))//which table
          {
                       $itemdata = array();
            

          	$controlnumber = @$senderperson->billid;
          	 $senderinfolist = $this->unregistered_model->get_senderperson_bulk_controllnumber($db,$controlnumber);
          	 foreach ($senderinfolist as $key => $value) {
          	 	// code...

          	 	 $itemdata[]=array(
          	 	 	'Destination'=>$value->receiver_region,
          	 	 	'weight'=>$value->register_weght,
          	 	 	'Amount'=>$value->paidamount,
          	 	 	'item'=>$value->register_type,
          	 	 	'total'=>$value->paidamount,
          	 	 	'controlnumber'=>$value->billid,
          	 	 	'barcode'=>@$value->Barcode,
          	 	 	'sender'=>$value->sender_fullname,
          	 	 	'senderbranch'=>$value->sender_branch,
          	 	 	'address'=>$value->sender_address,
          	 	 	'phone'=>$value->sender_mobile,
          	 	 	'receiver'=>$value->receiver_fullname,
          	 	 	'receiveraddress'=>$value->r_address,
          	 	 	'receiverphone'=>$value->receiver_mobile);
          	 }

         	$operator=@$user;
          	$total=@$senderperson->paidamount;
          	$controlnumber=@$senderperson->billid;
          	$itemdata=@$itemdata;
          	

				       $arr = array(array('message'=>'Successful','status'=>'200',
				                         'operator'=>$operator, 'total'=>$total,
				                         'controlnumber'=>$controlnumber,'itemdata'=>$itemdata,
				              
				           ));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);



		}else{

			$operator=@$user;
          	$Destination='';
          	$weight='';
          	$Amount='';
          	// $vat=@$senderperson->item_vat;
          	$item='';
          	$total='';
          	$controlnumber='';
          	$barcode='';
          	$sender='';
          	$senderbranch='';
          	$address='';
          	$phone='';
          	$receiver='';
          	$receiverphone='';
          	$receiveraddress='';


				       $arr = array(array('message'=>'Not found/Not Paid','status'=>'404',
				                         'operator'=>$operator,'Destination'=>$Destination,
				                       'weight'=>$weight,'Amount'=>$Amount,'item'=>$item,
				               'total'=>$total,'controlnumber'=>$controlnumber,'barcode'=>$barcode,
				               'sender'=>$sender,'senderbranch'=>$senderbranch,'address'=>$address,
				               'phone'=>$phone,'receiver'=>$receiver,
				               'receiverphone'=>$receiverphone,'receiveraddress'=>$receiveraddress,
				           ));
                      $list["data"]=$arr; 
    
    
				    header('Content-Type: application/json');
				    echo json_encode($list);
		}
	}
    
  }

  

  public function sales_receipt_post(){ //qw
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );//invoice_number  stamp

     $emid= $getValue['emid'];
    $getemid=$this->Box_Application_model->Getemidbymail($emid);
    
    $emid=$getemid->em_id;
    $trackno = $getValue['identifier'];

            $info = $this->employee_model->GetBasic($emid);
              $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;



    	 $db='Stamp';
         $senderinfo = $this->Stamp_model->get_stamp_cash($db,$trackno);
         
          if(!empty($senderinfo))//which table
          {
          	 $itemdata = array();
            

          	 $senderinfolist = $this->Stamp_model->get_stamp_cashs($db,$trackno);
          	 $total = 0;
          	 foreach ($senderinfolist as $key => $value) {
          	 	// code...

          	 	 $total =  $total + ($value->stamp_number * $value->Customer_mobile);

          	 	 $itemdata[]=array(
          	 	 	'item'=>$value->StampDetails,
          	 	 	'quantity'=>$value->stamp_number,
          	 	 	'Amount'=>$value->Customer_mobile,
          	 	 	'Total'=>$value->stamp_number * $value->Customer_mobile,
          	 	 	'vat'=>($value->stamp_number * $value->Customer_mobile)*0.18 );
          	 }

         	$Operator=@$user;
          	$TOTAL=@$total;
          	$CASH=@$total;
          	$Payable_Amount=@$total;
          	$Customer_name=@$senderinfo->Operator;
          	$paymentdata=@$itemdata;
          	$branch=@$senderinfo->branch;
          	$Invoice_no=@$senderinfo->serial;
          	$Date=@$senderinfo->date_created;
          	

				       $arr = array(array('message'=>'Successful','status'=>'200',
				                         'Operator'=>$Operator, 'TOTAL'=>$TOTAL,
				                         'CASH'=>$CASH, 'total'=>$total,
				                         'Payable_Amount'=>$Payable_Amount, 'Customer_name'=>$Customer_name,
				                         'paymentdata'=>$paymentdata,'branch'=>$branch,
				                         'Invoice_no'=>$Invoice_no,'Date'=>$Date,
				              
				           ));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

		}else{

			$Operator=@$user;
          	$TOTAL="";
          	$CASH="";
          	$Payable_Amount="";
          	$Customer_name="";
          	$paymentdata="";
          	$branch="";
          	$Invoice_no="";
          	$Date="";
          	

				       $arr = array(array('message'=>'Not Found','status'=>'404',
				                         'Operator'=>$Operator, 'TOTAL'=>$TOTAL,
				                         'CASH'=>$CASH, 'total'=>$TOTAL,
				                         'Payable_Amount'=>$Payable_Amount, 'Customer_name'=>$Customer_name,
				                         'paymentdata'=>$paymentdata,'branch'=>$branch,
				                         'Invoice_no'=>$Invoice_no,'Date'=>$Date,
				              
				           ));
                      $list["data"]=$arr; 
    
    
				    header('Content-Type: application/json');
				    echo json_encode($list);
		
	}
    
  }


   public function sales_franking_post(){ //qw
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );//invoice_number  stamp

     $emid= $getValue['emid'];
    $getemid=$this->Box_Application_model->Getemidbymail($emid);
    
    $emid=$getemid->em_id;
    $controlnumber = $getValue['identifier'];

            $info = $this->employee_model->GetBasic($emid);
              $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;



    	 $db='Stamp';
         $senderinfo = $this->Stamp_model->get_stamp_Franking($db,$controlnumber);
         
          if(!empty($senderinfo))//which table
          {
         
	       $operator=@$user;
          	$customer_name=@$senderinfo->StampDetails;
          	$Customer_mobile=@$senderinfo->Customer_mobile;
          	$branch=@$senderinfo->branch;
          	
          	$payment_information='Payment For Franking Machine';
          	$control_number=@$senderinfo->billid;
          	$receipt_number=@$senderinfo->receipt;
          	$region=@$senderinfo->region;
          	$payment_date=@$senderinfo->paymentdate;
          	$total=@$senderinfo->paidamount;

				       $arr = array(array('message'=>'Successful','status'=>'200',
				                         'operator'=>$operator,'customer_name'=>$customer_name,'Customer_mobile'=>$Customer_mobile,
				                         'region'=>$region,
				               'branch'=>$branch,'payment_information'=>$payment_information,
				               'control_number'=>$control_number,'receipt_number'=>$receipt_number,
				               'payment_date'=>$payment_date,'total'=>$total
				           ));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

		}else{

			  $operator=@$user;
          	$customer_name='';
          	$Customer_mobile='';
          	$branch='';
          	
          	$payment_information='Payment For Franking Machine';
          	$control_number='';
          	$receipt_number='';
          	$region='';
          	$payment_date='';
          	$total='';
          	
				       $arr = array(array('message'=>'Not found','status'=>'404',
				                         'operator'=>$operator,'customer_name'=>$customer_name,'Customer_mobile'=>$Customer_mobile,
				                         'region'=>$region,
				               'branch'=>$branch,'payment_information'=>$payment_information,
				               'control_number'=>$control_number,'receipt_number'=>$receipt_number,
				               'payment_date'=>$payment_date,'total'=>$total
				           ));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);
		
	}
    
  }


public function sales_advertising_post(){ //qw
       
    $getValue = json_decode( file_get_contents( 'php://input' ), true );//invoice_number  stamp

     $emid= $getValue['emid'];
    $getemid=$this->Box_Application_model->Getemidbymail($emid);
    
    $emid=$getemid->em_id;
    $controlnumber = $getValue['identifier'];

            $info = $this->employee_model->GetBasic($emid);
              $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;



    	 $db='Stamp';
         $senderinfo = $this->parcel_model->get_advertising_mail_receipt($db,$controlnumber);
         
          if(!empty($senderinfo))//which table
          {
         
	       $operator=@$user;
          	$customer_name=@$senderinfo->Customer_name;
          	$Customer_mobile=@$senderinfo->Customer_mobile;
          	$branch=@$senderinfo->branch;
          	
          	$payment_information='Payment For Advertising Mail';
          	$control_number=@$senderinfo->billid;
          	$receipt_number=@$senderinfo->receipt;
          	$region=@$senderinfo->region;
          	$payment_date=@$senderinfo->paymentdate;
          	$total=@$senderinfo->paidamount;

				       $arr = array(array('message'=>'Successful','status'=>'200',
				                         'operator'=>$operator,'customer_name'=>$customer_name,'Customer_mobile'=>$Customer_mobile,
				                         'region'=>$region,
				               'branch'=>$branch,'payment_information'=>$payment_information,
				               'control_number'=>$control_number,'receipt_number'=>$receipt_number,
				               'payment_date'=>$payment_date,'total'=>$total
				           ));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);

		}else{

			  $operator=@$user;
          	$customer_name='';
          	$Customer_mobile='';
          	$branch='';
          	
          	$payment_information='Payment For Advertising Mail';
          	$control_number='';
          	$receipt_number='';
          	$region='';
          	$payment_date='';
          	$total='';
          	
				       $arr = array(array('message'=>'Not found','status'=>'404',
				                         'operator'=>$operator,'customer_name'=>$customer_name,'Customer_mobile'=>$Customer_mobile,
				                         'region'=>$region,
				               'branch'=>$branch,'payment_information'=>$payment_information,
				               'control_number'=>$control_number,'receipt_number'=>$receipt_number,
				               'payment_date'=>$payment_date,'total'=>$total
				           ));
                      $list["data"]=$arr; 
    
				    header('Content-Type: application/json');
				    echo json_encode($list);
		
	}
    
  }
  

  public function post_derivery_response_post(){
       
	$getValue = json_decode( file_get_contents( 'php://input' ), true );

	$id= $getValue['emid'];

    $getemid=$this->Box_Application_model->Getemidbymail($id);
    
    $id=$getemid->em_id;
	
	$trackno = $getValue['identifier'];
	$receiver = $getValue['receiver'];
	$phone = $getValue['phone'];
	$identity_type = $getValue['identity_type'];
	$identity_no = $getValue['identity_no'];
	//$date_printed = $getValue['date_printed'];
	//$image        = $getValue['image'];
	//$last_id = $getValue['sender_id'];
	$operator = $id;//emid
	$image = $getValue['image'];
    $location=$getValue['street'];
    $service=$getValue['service'];

    //create logs
            $value = array();
            $value = array('trackno'=>$trackno,'serviceid'=>$service,'item'=>'API '.$getValue['emid'],'serial'=>$receiver);
            $log=json_encode($value);
            $lg = array(
            'response'=>$log
            );
               $this->Box_Application_model->save_logs($lg);

     $word = 'ems';
     $word2 = 'pcum';
    if(strpos($service, $word) !== false || strpos($service, $word2) !== false ){

	//if ($getValue['service'] == "ems" ) {  //|| $getValue['service'] == "pcum" 

		//$data1 = array();
		//$data1 = array('item_status'=>'Derivered');
		
        $save = array();
    $save = array(
        'deliverer_name'=>$receiver,
        'phone'=>$phone,
        'identity'=>$identity_type,
        'identityno'=>$identity_no,
        'service_type'=>'POS',
        'd_status'=>'Yes',
        'operator'=>$operator,
        'image'=>$image,
        'location'=>$location

        );//deriveryDate

     //echo json_encode($save);
    $maneno=' '.$service;

    $Getserialof_assigned =$this->unregistered_model->check_events_barcode_serial($trackno);
    $check_bulk =$this->unregistered_model->check_events_barcode_bulk($Getserialof_assigned->name);
    if (!empty($check_bulk)) {
    	foreach ($check_bulk as $key => $value) {

    		  $this->unregistered_model->update_assign_derivery_info_pos_barcode($value->track_no,$phone,$receiver,$identity_type,$identity_no,$operator,$image,$location,$service);
    $update = $this->unregistered_model->update_sender_info_by_barcode($trackno);
    		// code...
    	}

    }else{

    	    $this->unregistered_model->update_assign_derivery_info_pos_barcode($trackno,$phone,$receiver,$identity_type,$identity_no,$operator,$image,$location,$service);
    $update = $this->unregistered_model->update_sender_info_by_barcode($trackno);


    }
    





	} else {

		//$data1 = array();
		//$data1 = array('sender_status'=>'Derivery');

		$maneno='  '.$service;

		 $save = array();
    $save = array(
        'deliverer_name'=>$receiver,
        'phone'=>$phone,
        'identity'=>$identity_type,
        'identityno'=>$identity_no,
        'service_type'=>'POS',
        'd_status'=>'Yes',
        'operator'=>$operator,
        'image'=>$image,
        'location'=>$location

        );//deriveryDate

     //echo json_encode($save);
    $maneno=' '.$service;

    $Getserialof_assigned =$this->unregistered_model->check_events_barcode_serial($trackno);
    $check_bulk =$this->unregistered_model->check_events_barcode_bulk($Getserialof_assigned->name);
    if (!empty($check_bulk)) {
    	foreach ($check_bulk as $key => $value) {

    		 $this->unregistered_model->update_assign_derivery_Person_info_pos_barcode($value->track_no,$phone,$receiver,$identity_type,$identity_no,$operator,$image,$location,$service);
    $update = $this->unregistered_model->update_sender_person_info_mails_barcode($trackno);

    		// code...
    	}

    }else{

    	   $this->unregistered_model->update_assign_derivery_Person_info_pos_barcode($trackno,$phone,$receiver,$identity_type,$identity_no,$operator,$image,$location,$service);
    $update = $this->unregistered_model->update_sender_person_info_mails_barcode($trackno);


    }



          
          //    $save = array();
          //  $save = array('sender_status'=>'Derivery');
          // $this->Box_Application_model->update_sender_person_info_mail_info($save,$trackno);

          


	}

	
   header('Access-Control-Allow-Origin: *');
	header("Cache-Control: no-cache");
	header('Content-Type: application/json');
	$data = array();
    $data = array('response'=>json_encode($getValue));
	$this->employee_model->save_login_log2($data);

  	$value = array();
	$value = array('code'=>'200','description'=>'Successful delivered'.$maneno);

	$data['result']=$value;
	
	
    echo json_encode($data);
	
  }


  public function post_client_post(){
       
	$getValue = json_decode( file_get_contents( 'php://input' ), true );
	$target_url = "http://192.168.33.7/api/virtual_box/";

	$id          = $getValue['pcum_id'];
	$name        = $getValue['receiver_name'];
	$weight      = $getValue['weight'];
	$box         = $getValue['box_type'];
	


	$info = $this->Pcum_model->get_Pcum_Bill_Customer_by_id($id);

	$sender = array();
    $sender = array('ems_type'=>'Document','weight'=>$weight,'s_fullname'=>$info->cust_name,'s_address'=>$info->cust_address,'s_mobile'=>$info->cust_mobile,'s_region'=>$info->customer_region,'operator'=>$getValue['emid'],'add_type'=>$box,'s_pay_type'=>'Bill');

     $db2 = $this->load->database('otherdb', TRUE);
     $db2->insert('sender_info',$sender);
     $last_id = $db2->insert_id();


	if ($box == "virtual") {
		$mobile=@$info->cust_mobile;
	 $post = array( 'box'=>$mobile);

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL,$target_url);
      curl_setopt($curl, CURLOPT_POST,1);
      //curl_setopt($curl, CURLOPT_POST, count($post));
      curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
      curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
      //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
      curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
      $result = curl_exec($curl);
      $answer = json_decode($result);

        $name = $answer->full_name;
		$add = $answer->phone;
		$mobile = $answer->phone;
		$region = $answer->region;
		$branch = $answer->post_office;

      $receiver = array();
      $receiver = array('from_id'=>$last_id,'fullname'=>$name,'address'=>$add,'email'=>'','mobile'=>$mobile,'r_region'=>$region,'branch'=>$branch,'add_type'=>$box);

      $db2->insert('receiver_info',$receiver);

	} else {

	$add      = $getValue['receiver_address'];
	$mobile      = $getValue['receiver_mobile'];
	$region      = $getValue['region'];
	$branch      = $getValue['branch'];
	$name        =
		$receiver = array();
        $receiver = array('from_id'=>$last_id,'fullname'=>$name,'address'=>$add,'email'=>'','mobile'=>$mobile,'r_region'=>$region,'branch'=>$branch,'add_type'=>$box);

        $db2->insert('receiver_info',$receiver);
	}
	
	$data = array();
    $data = array('response'=>json_encode($getValue));
	$this->employee_model->save_login_log2($data);

  	$value = array();
	$value = array('code'=>'200','description'=>'Successful Open');
	
	header('Content-Type: application/json');
    echo json_encode($value);
	
  }

  public function post_region_post(){
       
	$getValue = json_decode( file_get_contents( 'php://input' ), true );

	$list["region"]   = $this->employee_model->regselect();

	header('Content-Type: application/json');
    echo json_encode($list);
	
  }


  public function post_branch_post(){
       
	$getValue = json_decode( file_get_contents( 'php://input' ), true );
	$regionresult =  $getValue['regionId'];
	$list["branch"]   = $this->employee_model->selectbranch1($regionresult);

	$data = array();
    $data = array('response'=>json_encode($getValue));
	$this->employee_model->save_login_log2($data);
	header('Content-Type: application/json');
    echo json_encode($list);
	
  }







public function getnumber(){

        $getuniquelastnumber= $this->Box_Application_model->get_last_number();

            //check length
            if(empty($getuniquelastnumber) || is_null($getuniquelastnumber)){
                $number = 1;
                 $nmbur = array();
                 $nmbur = array('number'=>$number);

                 $db2 = $this->load->database('otherdb', TRUE);
                 $db2->insert('tracknumber',$nmbur);
               
                $no_of_digit = 5;

            $length = strlen((string)$number);
            $numberk = '';
            for($i = $length;$i<$no_of_digit;$i++)
            {
                $numberk = '0'.$numberk;
            }

            $number=$numberk.$number;


            }else{
                $no_of_digit = 5;
                $numbers = @$getuniquelastnumber->number;
                $numbers=$numbers+1;
                $number = @$getuniquelastnumber->number;

            $length = strlen((string)$number);
             $numbera='';
            for($i = $length;$i<$no_of_digit;$i++)
            {
                $numbera = '0'.$numbera;
            }
              $number=$numbera.$numbers;

                
                 $nmbur = array();
                 $nmbur = array('number'=>$numbers);
                 $db2 = $this->load->database('otherdb', TRUE);
                 $db2->insert('tracknumber',$nmbur);
               

            }

            return $number;
    }

    public function ems_mct_request2_post(){
       
	$getValue = json_decode( file_get_contents( 'php://input' ), true );
     $header = $getValue['header']['name'];
	 //$r_fname = json_decode($header);
	  //$fname = $header['name'];;

	     // //create logs
      //       $value = array();
      //       $value = array('value'=>$getValue);
      //       $log=json_encode($value);
      //       $lg = array(
      //       'response'=>$log
      //       );
      //          $this->Box_Application_model->save_logs($lg);


		header('Access-Control-Allow-Origin: *');
	header("Cache-Control: no-cache");
	header('Content-Type: application/json');
	
	$Header = array();
	$Header = array('Name'=>'POSTA','Signature'=>'@%#GT#$%^@$%GGHDVGH@$%#&');
	$data = array();
    $data['Header']=$Header;
	//$this->employee_model->save_login_log2($data);

  	$value = array();
	$value = array('code'=>'400','description'=>'failed','name'=> $header);
	$data['result']=$value;
	
	
    echo json_encode($data);
}
 

  public function ems_mct_request_post(){
       
	$getValue = json_decode( file_get_contents( 'php://input' ), true );

	// $Header = array('Name'=>'POSTA','Signature'=>'@%#GT#$%^@$%GGHDVGH@$%#&');
    $emstype = "Document";
//$Barcode = $this->input->post('Barcode');
$emsCat = "2";
$weight = "0.20";
$signatureverify="@%#GT#$%^@$%GGHDVGH@$%#&";

//Address
$addressT = "physical";
 $addressR = "physical";
 $s_fname = "MCT";
 $s_address = "DODOMA";
 $s_email = "info@mct.go.tz";
 $s_mobile = "1";

$header = $getValue['header'];
$signature = $getValue['request']['signature'];
$request = $getValue['request'];

 $r_fname = $getValue['request']['name'];
 $r_address = $getValue['request']['district'];
 
 $r_mobile = $getValue['request']['phone'];
 $r_email = $getValue['request']['email'];
 $rec_region =$getValue['request']['region'];
 $rec_dropp = $getValue['request']['district'];
 //Addtion
 $paymentType = $getValue['request']['paymentType'];
 $requestid = $getValue['request']['requestID'];


 


$operator = "POSTA-MCT";
$o_region = "Dodoma";
$o_branch = "Dodoma HPO";

$transactionstatus   = 'POSTED';
$bill_status  = 'PENDING';
$PaymentFor = 'EMS';
$transactiondate = date("Y-m-d");
$fullname  = $s_fname;
$source = $this->employee_model->get_code_source($o_region);
$dest = $this->employee_model->get_code_dest($rec_region);

$number = $this->getnumber();
$bagsNo = 'EE'.@$source->reg_code . @$dest->reg_code.$number.'TZ';
$serial    = 'EMS'.date("YmdHis").$source->reg_code;
 $trackno = $bagsNo;

 if($signatureverify == $signature){



 //save

     $sender = array();
     $sender = array('ems_type'=>$emstype,'track_number'=>$trackno,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$s_mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$operator,'add_type'=>$addressT,'paymentType'=>$paymentType,'requestid'=>$requestid,'service_type'=>"MCT");

     $db2 = $this->load->database('otherdb', TRUE);
     $db2->insert('sender_info',$sender);
     $last_id = $db2->insert_id();



     $receiver = array();
     $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp,'add_type'=>$addressR);

     $db2->insert('receiver_info',$receiver);

     //price
     $price = 15000 - (15000*0.18);
     $vat = 15000*0.18;
     $totalPrice = $price + $vat;


     //save
      $mobile = $s_mobile;
    

     $data = array(

        'transactiondate'=>date("Y-m-d"),
        'serial'=>$serial,
        'paidamount'=>$totalPrice,
         'CustomerID'=>$last_id,
         'Customer_mobile'=>$s_mobile,
        'region'=>$o_region,
        'district'=>$o_branch,
        'transactionstatus'=>'POSTED',
        'bill_status'=>'PENDING',
        //'Barcode'=>strtoupper($Barcode),
        'paymentFor'=>$PaymentFor

     );

    $this->Box_Application_model->save_transactions($data);

     $paidamount = $totalPrice;
     $region = $o_region;
     $district = $o_branch;
     $renter   = $fullname;    //$emstype;
     $serviceId = 'EMS_POSTAGE';

     //check before send if saved
      $chck = $this->Box_Application_model->get_senderinfo_senderID($last_id);
      if(!empty($chck)){
     
     $transaction = $this->Control_Number_model->get_control_number($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

      	

    $trackNo=$trackno;

    if (!empty($transaction) ) {

        @$serial1 = $transaction->billid;
        $update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
        $this->billing_model->update_transactions($update,$serial1);

         $user =$operator ;
       $location= $region.' - '.$district;
       $data = array();
       $data = array('track_no'=>$trackno,'location'=>$location,'user'=>$user,'event'=>'Counter');

       $this->Box_Application_model->save_location($data);
       $data['sms'] = $total = $sms ='KARIBU POSTA KIGANJANI umepatiwa ankara namba'. ' '.@$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($totalPrice,2);

        $total2 ='The amount to be paid for EMS is The TOTAL amount is '.' '.number_format($totalPrice,2).' Pay through this control number'.' '.@$transaction->controlno ;

          $this->Sms_model->send_sms_trick($s_mobile,$sms);

        //create logs
            $value = array();
            $value = array('controlno'=>$transaction->controlno,'serviceid'=>"MCT",'item'=>'SUCCESS '.$r_fname,'serial'=>$requestid);
            $log=json_encode($value);
            $lg = array(
            'response'=>$log
            );
               $this->Box_Application_model->save_logs($lg);

               header('Access-Control-Allow-Origin: *');
	header("Cache-Control: no-cache");
	header('Content-Type: application/json');
	$data = array();
	$Header = array();
	$Header = array('Name'=>'POSTA','Signature'=>'@%#GT#$%^@$%GGHDVGH@$%#&');
	$data['Header']=$Header;
    //$data = array('Header'=>json_encode($Header));
	//$this->employee_model->save_login_log2($data);

 $value = array();
$value = array('code'=>'200','description'=>'Successful','controlno'=>$transaction->controlno,'requestID'=>$requestid,'amount'=>$totalPrice);
	$data['Response']=$value;
	
	
    echo json_encode($data);

    }else{

    	 //create logs
            $value = array();
            $value = array('trackno'=>$trackno,'serviceid'=>"MCT",'item'=>'failed'.$r_fname,'serial'=>$requestid);
            $log=json_encode($value);
            $lg = array(
            'response'=>$log
            );
               $this->Box_Application_model->save_logs($lg);

               header('Access-Control-Allow-Origin: *');
	header("Cache-Control: no-cache");
	header('Content-Type: application/json');
	$data = array();
	$Header = array();
	$Header = array('Name'=>'POSTA','Signature'=>'@%#GT#$%^@$%GGHDVGH@$%#&');
    
    $data['Header']=$Header;
	//$this->employee_model->save_login_log2($data);

  	$value = array();
	$value = array('code'=>'400','description'=>'Failed','requestID'=>$requestid);

	$data['Response']=$value;
	
	
    echo json_encode($data);

    }

	
   
  }else{

  	 //create logs
            $value = array();
            $value = array('trackno'=>$trackno,'serviceid'=>"MCT",'item'=>'failed no transaction created resend '.$r_fname,'serial'=>$requestid);
            $log=json_encode($value);
            $lg = array(
            'response'=>$log
            );
               $this->Box_Application_model->save_logs($lg);

               header('Access-Control-Allow-Origin: *');
	header("Cache-Control: no-cache");
	header('Content-Type: application/json');
	$data = array();
	$Header = array();
	$Header = array('Name'=>'POSTA','Signature'=>'@%#GT#$%^@$%GGHDVGH@$%#&');
    $data['Header']=$Header;
	//$this->employee_model->save_login_log2($data);

  	$value = array();
	$value = array('code'=>'400','description'=>'failed','requestID'=>$requestid);

	$data['result']=$value;
	
	
    echo json_encode($data);

  }
}else{

	header('Access-Control-Allow-Origin: *');
	header("Cache-Control: no-cache");
	header('Content-Type: application/json');
	$data = array();
	$Header = array();
	$Header = array('Name'=>'POSTA','Signature'=>'@%#GT#$%^@$%GGHDVGH@$%#&');
    $data['Header']=$Header;
	//$this->employee_model->save_login_log2($data);

  	$value = array();
	$value = array('code'=>'401','description'=>'failed Sig','requestID'=>$requestid);

	$data['result']=$value;
	
	
    echo json_encode($data);

}
}


public function save_kkportal_request_post(){
$getValue = json_decode( file_get_contents( 'php://input' ), true );
$pfno= $getValue['pfno'];
$loanproduct= $getValue['loanproduct'];
$principal= $getValue['principal'];
$interest = $getValue['interest'];
$insurance = $getValue['insurance'];
$loanperiod = $getValue['loanperiod'];
$datetaken = $getValue['datetaken'];
$accepteddate = $getValue['accepteddate'];
$type = $getValue['type'];

if(!empty($pfno) && !empty($loanproduct)){


//ifloan product == kk savings---

if($type == "cease"){//update payrol

$status ="Approved";
$approved_date = date('Y-m-d H:i:s');
	$dataRequest = array();
$dataRequest = array(
'pfno'=>$pfno,
'loan_product'=>$loanproduct,
'principal'=>$principal,
'interest'=>$interest,
'insurance'=>$insurance,
'loan_period'=>$loanperiod,
'date_taken'=>$datetaken,
'accepted_date'=>$accepteddate,
'type'=>$type,
'approved_date' => $approved_date,
'request_status' => $status,
'approved_by' => "SYSTEM UPDATE"
);//cease
$this->db->insert('loan_process',$dataRequest);

          //update payrol
            $month = date('m');
            $dateObj   = DateTime::createFromFormat('!m', $month);
            //$monthName = $dateObj->format('F');
             $monthName = date('M',strtotime("-1 month"));
            $year = date('Y');

           //Save for deduction
                 $basic = $this->employee_model->emselectByCode($pfno);//
                 $em_id = @$basic->em_id;
                 //get last salary id
                  $salaryvalue= $this->payroll_model->GetsalaryValue($em_id);
                  $salary_id = @$salaryvalue->id;

                $installmentName = $loanproduct;
                 $loan_amount = $principal+$interest+$insurance;
                //$lastInstallement = $this->payroll_model->Others_Employee_Deduction_Permonth($installmentName,$salary_id);//loan_deduction


                    $dedu = array();
                    $dedu = array(

                    'other_names'=>$loanproduct,
                    'others_amount'=>0,
                    'salary_id'=>$salary_id,
                    'loan_amount'=>$loan_amount,
                    'installment_Amount'=>0,
                    'status'=>'COMPLETE',
                    'month'=>$monthName,
                    'year'=>date('Y'),
                    'em_id'=>$em_id

                    );

                     $data = array();
                    $data = array('status'=>'COMPLETE');
                    $this->payroll_model->update_others_amountDed($data,$salary_id,$installmentName);//others_id

                    $this->payroll_model->insertOthersDeductionData($dedu);

}else{

	$dataRequest = array();
$dataRequest = array(
'pfno'=>$pfno,
'loan_product'=>$loanproduct,
'principal'=>$principal,
'interest'=>$interest,
'insurance'=>$insurance,
'loan_period'=>$loanperiod,
'date_taken'=>$datetaken,
'accepted_date'=>$accepteddate,
'type'=>$type
);//cease
$this->db->insert('loan_process',$dataRequest);

}

$arr = array(array('message'=>'Successful','status'=>'200'));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);

} else {
$arr = array(array('message'=>'Failed','status'=>'404'));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);
}




}


/////////////////////POSTASHOP API
public function postashop_receipt_post(){
$getValue = json_decode( file_get_contents( 'php://input' ), true );
$receiptid= $getValue['receiptno'];


$info = $this->PostaShopModel->get_postashop_receipt_information($receiptid);

if(!empty($info)){

//retrieve Transactions
$listtransaction = $this->PostaShopModel->get_postashop_receipt_transactions($receiptid);
$itemdata = array();
$sumtotal=0;
foreach ($listtransaction as $data) {
$itemdata[]=array(
    'product'=>$data->product_name,
    'price'=>number_format($data->sale_price,2),
    'qty'=>$data->sale_qty,
    'total'=>number_format($data->sale_qty*$data->sale_price,2)
);
$sumtotal+=$data->sale_qty*$data->sale_price;
}
$transactiondata=@$itemdata;

///////////////Operator Information
$operator = $this->ContractModel->get_employee_info($info->operator);


$arr = array(array(
    'message'=>'Successful',
    'status'=>'200',
    'name'=>@$info->customer,
    'phone'=>@$info->phone,
    'address'=>@$info->address,
    'tin'=>@$info->tin,
    'vrn'=>@$info->vrn,
    'serial'=>@$info->serial,
    'receiptno'=>@$info->receipt,
    'operator'=>@$operator->first_name.' '.@$operator->middle_name.' '.@$operator->last_name.', PF Number: '.@$operator->em_code,
    'postoffice'=>@$info->region.'-'.@$info->branch,
    'totaltran'=>number_format(@$sumtotal,2),
    'transactiondate'=>@$info->transaction_created_at,
    'transactiondata'=>@$transactiondata
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


/////////////////END OF POSTASHOP API


/////////////////////POSTA STAMP API
public function postastamp_receipt_post(){
$getValue = json_decode( file_get_contents( 'php://input' ), true );
$receiptid= $getValue['receiptno'];


$info = $this->PostaStampModel->get_stamp_receipt_information($receiptid);

if(!empty($info)){
//retrieve Transactions
$listtransaction = $this->PostaStampModel->get_stamp_receipt_transactions($receiptid);
$itemdata = array();
$sumtotal=0;
foreach ($listtransaction as $data) {
$itemdata[]=array(
    'product'=>$data->product_name,
    'price'=>number_format($data->sale_price,2),
    'qty'=>$data->sale_qty,
    'total'=>number_format($data->sale_qty*$data->sale_price,2)
);
$sumtotal+=$data->sale_qty*$data->sale_price;
}
$transactiondata=@$itemdata;

///////////////Operator Information
$operator = $this->ContractModel->get_employee_info($info->operator);


$arr = array(array(
    'message'=>'Successful',
    'status'=>'200',
    'name'=>@$info->customer,
    'phone'=>@$info->phone,
    'address'=>@$info->address,
    'tin'=>@$info->tin,
    'vrn'=>@$info->vrn,
    'serial'=>@$info->serial,
    'receiptno'=>@$info->receipt,
    'operator'=>@$operator->first_name.' '.@$operator->middle_name.' '.@$operator->last_name.', PF Number: '.@$operator->em_code,
    'postoffice'=>@$info->region.'-'.@$info->branch,
    'totaltran'=>number_format(@$sumtotal,2),
    'transactiondate'=>@$info->transaction_created_at,
    'transactiondata'=>@$transactiondata
));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);


}
else{
$arr = array(array('message'=>'Not Found','status'=>'404','result'=>$info));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);
}
}


/////////////////END OF STAMP API



////////////////DELIVERY TRACKING ITEMS
public function listdelivery_items_post(){
$getValue = json_decode( file_get_contents( 'php://input' ), true );
$username= $getValue['username'];

///Check if exist
$empinfo =  $this->TrackingApiModel->get_email_id($username);

if(!empty($empinfo)){

////Get deliverer ID
$empid = $empinfo->em_id;

///Check if you have a delivery items
$deliveryitems =  $this->TrackingApiModel->get_delivery_items($empid);

if(!empty($deliveryitems)){

//////List single delivery items
$singleitems = $this->TrackingApiModel->get_single_delivery_items($empid);

$itemdata = array();
foreach ($singleitems as $data) {

$barcode = $data->barcode;

////Check EMS information
$senderinfo = $this->TrackingApiModel->get_ems_virtuebox($barcode);
if(!empty($senderinfo)){
$itemdata[]=array(
'senderid'=>@$senderinfo->sender_id,
'barcode'=>@$senderinfo->Barcode,
'sendername'=>@$senderinfo->s_fullname,
'weight'=>@$senderinfo->weight,
'paidamount'=>@$senderinfo->paidamount,
'controlnumber'=>@$senderinfo->billid,
'status'=>@$senderinfo->status,
'itemstatus'=>@$senderinfo->item_status,
'receivername'=>@$senderinfo->fullname,
'senderregion'=>@$senderinfo->s_region, 
'senderbranch'=>@$senderinfo->s_district,
'receiverregion'=>$senderinfo->r_region, 
'receiverbranch'=>$senderinfo->branch,
'receivestatus'=>@$senderinfo->receive_status
);
} else {
$senderinfo = $this->TrackingApiModel->get_mail_virtuebox($barcode);
$itemdata[]=array(
'senderid'=>@$senderinfo->senderp_id,
'barcode'=>@$senderinfo->Barcode,
'sendername'=>@$senderinfo->sender_fullname,
'weight'=>@$senderinfo->register_weght,
'paidamount'=>@$senderinfo->paidamount,
'controlnumber'=>@$senderinfo->billid,
'status'=>@$senderinfo->status,
'itemstatus'=>@$senderinfo->sender_status,
'receivername'=>@$senderinfo->receiver_fullname,
'senderregion'=>@$senderinfo->sender_region, 
'senderbranch'=>@$senderinfo->sender_branch,
'receiverregion'=>@$senderinfo->receiver_region, 
'receiverbranch'=>@$senderinfo->reciver_branch,
'receivestatus'=>@$senderinfo->receive_status
);
}

}
$singleitems=@$itemdata;


////////Group Items

$groupitems = $this->TrackingApiModel->get_group_delivery_items($empid);
$itemgroupdata = array();
foreach ($groupitems as $data) {
$countitems = $this->TrackingApiModel->count_group_delivery_items($data->virtuedelivery_group_id);
$itemgroupdata[]=array(
'groupid'=>@$data->virtuedelivery_group_id,
'groupname'=>@$data->virtuedelivery_group_name, 
'totalitems'=>@$countitems
);

}
$groupdeliveryitems=@$itemgroupdata;


$arr = array(array(
    'message'=>'Successful',
    'status'=>'200',
    'singleitems'=>@$singleitems,
    'groupdeliveryitems'=>@$groupdeliveryitems
));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);


} else {
$arr = array(array('message'=>'No Delivery Items','status'=>'404'));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);
}
/////////User not found
} else {
$arr = array(array('message'=>'Username Not Found','status'=>'404','invalidusername'=>$username));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);
}
}

/////////////////END OF DELIVERY TRACKING ITEMS


////////////////////////UPDATE RECEIVE STATUS
public function update_barcode_receivedstatus_post(){
$getValue = json_decode( file_get_contents( 'php://input' ), true );
$barcode= $getValue['barcode'];
$username= $getValue['username'];

/////////check if this barcode
$empinfo =  $this->TrackingApiModel->get_email_id($username);

if(!empty($empinfo)){

$empid = $empinfo->em_id;

$checkverification = $this->TrackingApiModel->get_verification_barcode_user($barcode,$empid);

if(!empty($checkverification)){

$transtype = $checkverification->service_type;


//////////////update barcode
$updatedata = array('receive_status'=>'Received');
$this->TrackingApiModel->update_received_status_information($updatedata,$barcode);

if($transtype=="ems"){
$trans_type="";
} else {
$trans_type="mails";
}

//////////get Transaction
$getemstrans = $this->TrackingApiModel->get_transid_information($barcode,$transtype);


//////////////TRACING
$tracingData = array('trans_type'=>$trans_type,'emid'=>$empid,'status'=>'RECEIVE','office_name'=>'Delivery','description'=>'Received by Delivery Officer','type'=>0,'transid'=>$getemstrans->transid);
$this->TrackingApiModel->save_tracing($tracingData);

///Check if exist
$senderinfo = $this->TrackingApiModel->get_ems_virtuebox($barcode);
if(!empty($senderinfo)){
////////////////EMS INFORMATION
$itemlist = array(
'senderid'=>@$senderinfo->sender_id,
'barcode'=>@$senderinfo->Barcode,
'sendername'=>@$senderinfo->s_fullname,
'weight'=>@$senderinfo->weight,
'paidamount'=>@$senderinfo->paidamount,
'controlnumber'=>@$senderinfo->billid,
'status'=>@$senderinfo->status,
'itemstatus'=>@$senderinfo->item_status,
'receivername'=>@$senderinfo->fullname,
'senderregion'=>@$senderinfo->s_region, 
'senderbranch'=>@$senderinfo->s_district,
'receiverregion'=>$senderinfo->r_region, 
'receiverbranch'=>$senderinfo->branch,
'receivestatus'=>@$senderinfo->receive_status
);

$arr = array(array('message'=>'Successful','status'=>'200','itemlist'=>@$itemlist));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);

} else {
////////MAILS
$senderinfo = $this->TrackingApiModel->get_mail_virtuebox($barcode);
if(!empty($senderinfo)){
//////////SUCCESS
$itemlist = array(
'senderid'=>@$senderinfo->senderp_id,
'barcode'=>@$senderinfo->Barcode,
'sendername'=>$senderinfo->sender_fullname,
'weight'=>@$senderinfo->register_weght,
'paidamount'=>@$senderinfo->paidamount,
'controlnumber'=>@$senderinfo->billid,
'status'=>@$senderinfo->status,
'itemstatus'=>@$senderinfo->sender_status,
'receivername'=>@$senderinfo->receiver_fullname,
'senderregion'=>@$senderinfo->sender_region, 
'senderbranch'=>@$senderinfo->sender_branch,
'receiverregion'=>@$senderinfo->receiver_region, 
'receiverbranch'=>@$senderinfo->reciver_branch,
'receivestatus'=>@$senderinfo->receive_status
);

$arr = array(array('message'=>'Successful','status'=>'200','itemlist'=>@$itemlist));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);
} else {
$arr = array(array('message'=>'Barcode Not Found','status'=>'404'));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);
}
}

} else {
$arr = array(array('message'=>'Barcode Number Accepted','status'=>'404'));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);
}

} else {
$arr = array(array('message'=>'User Not Found!','status'=>'404'));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);
}
}
//////////////////////////END OF RECEIVE STATUS

////////////////////////RESET RECEIVE STATUS
public function reset_barcode_receivedstatus_post(){
$getValue = json_decode( file_get_contents( 'php://input' ), true );
$barcode= $getValue['barcode'];

//////////////update barcode
$updatedata = array('receive_status'=>'NotReceived');
$this->TrackingApiModel->update_received_status_information($updatedata,$barcode);

$arr = array(array('message'=>'Successful','status'=>'200'));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);

}
//////////////////////////END OF RECEIVE STATUS


////////////////////////PRINT TRACKING BARCODE
public function print_deliverybarcode_receipt_post(){
$getValue = json_decode( file_get_contents( 'php://input' ), true );
$barcode= $getValue['barcode'];
$username= $getValue['username'];

/////////check if this barcode
$empinfo =  $this->TrackingApiModel->get_email_id($username);

if(!empty($empinfo)){

$empid = $empinfo->em_id;

$checkverification = $this->TrackingApiModel->get_verification_barcode_user_received($barcode,$empid);

if(!empty($checkverification)){

///Check if exist
$senderinfo = $this->TrackingApiModel->get_ems_virtuebox($barcode);
if(!empty($senderinfo)){
////////////////EMS INFORMATION

if($senderinfo->wfd_type != "bulk"){
	$itemlist = array(
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
		'receivestatus'=>@$senderinfo->receive_status,
		'items'=>'1',
		'type'=>'Single',
		'id'=>@$senderinfo->wfd_id
		);

}else{
	$groupinfo = $this->TrackingApiModel->get_group_virtuebox($senderinfo->groupid);
	$itemlist = array(
		'barcode'=>'',
		'sendername'=>'',
		'weight'=>'',
		'paidamount'=>'',
		'controlnumber'=>'',
		'receivername'=>@$groupinfo->virtuedelivery_group_name,
		'senderregion'=>'',
		'senderbranch'=>'',
		'receiverregion'=>'',
		'receiverbranch'=>'',
		'receivestatus'=>'',
		'items'=>$groupinfo->items,
		'type'=>'group',
		'id'=>@$groupinfo->virtuedelivery_group_id
		);
}



$arr = array(array('message'=>'Successful','status'=>'200','itemlist'=>@$itemlist));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);

} else {
////////MAILS
$senderinfo = $this->TrackingApiModel->get_mail_virtuebox($barcode);
if(!empty($senderinfo)){
//////////SUCCESS
if($senderinfo->wfd_type != "bulk"){
	$itemlist = array(
		'barcode'=>@$senderinfo->Barcode,
		'sendername'=>@$senderinfo->sender_fullname,
		'weight'=>@$senderinfo->register_weght,
		'paidamount'=>@$senderinfo->paidamount,
		'controlnumber'=>@$senderinfo->billid,
		'receivername'=>@$senderinfo->receiver_fullname,
		'senderregion'=>@$senderinfo->sender_region, 
		'senderbranch'=>@$senderinfo->sender_branch,
		'receiverregion'=>$senderinfo->receiver_region, 
		'receiverbranch'=>$senderinfo->reciver_branch,
		'receivestatus'=>@$senderinfo->receive_status,
		'items'=>'1',
		'type'=>'Single',
		'id'=>@$senderinfo->wfd_id
		);

}else{
	$groupinfo = $this->TrackingApiModel->get_group_virtuebox($senderinfo->groupid);
	$itemlist = array(
		'barcode'=>'',
		'sendername'=>'',
		'weight'=>'',
		'paidamount'=>'',
		'controlnumber'=>'',
		'receivername'=>@$groupinfo->virtuedelivery_group_name,
		'senderregion'=>'',
		'senderbranch'=>'',
		'receiverregion'=>'',
		'receiverbranch'=>'',
		'receivestatus'=>'',
		'items'=>$groupinfo->items,
		'type'=>'group',
		'id'=>@$groupinfo->virtuedelivery_group_id
		);
}


$arr = array(array('message'=>'Successful','status'=>'200','itemlist'=>@$itemlist));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);
} else {
$arr = array(array('message'=>'Barcode Not Found','status'=>'404'));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);
}
}

} else {
$arr = array(array('message'=>'Barcode Number Not Accepted','status'=>'404'));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);
}

} else {
$arr = array(array('message'=>'User Not Found!','status'=>'404'));
$list["data"]=$arr; 
header('Content-Type: application/json');
echo json_encode($list);
}
}
//////////////////////////END OF PRINT RECEIPT

////SAve DELIVVER


public function post_Appderivery_response_post(){
       
	$getValue = json_decode( file_get_contents( 'php://input' ), true );

	$id= $getValue['username'];
    $getemid=$this->Box_Application_model->Getemidbymail($id);
    $id=$getemid->em_id;

	$deliveryID = $getValue['id'];
	$deliverytype = $getValue['type'];
	
	$trackno = $getValue['identifier'];
	$receiver = $getValue['receiver'];
	$phone = $getValue['phone'];
	$identity_type = $getValue['identity_type'];
	$identity_no = $getValue['identity_no'];
	//$date_printed = $getValue['date_printed'];
	//$image        = $getValue['image'];
	//$last_id = $getValue['sender_id'];
	$operator = $id;//emid
	$image = $getValue['image'];
    $location=$getValue['street'];
    $service=$getValue['service'];

    //create logs
            $value = array();
            $value = array('trackno'=>$trackno,'serviceid'=>$service,'item'=>'API '.$getValue['emid'],'serial'=>$receiver);
            $log=json_encode($value);
            $lg = array(
            'response'=>$log
            );
            $this->Box_Application_model->save_logs($lg);

     $word = 'ems';
     $word2 = 'pcum';
    if(strpos($service, $word) !== false || strpos($service, $word2) !== false ){
        $save = array();
    $save = array(
        'deliverer_name'=>$receiver,
        'phone'=>$phone,
        'identity'=>$identity_type,
        'identityno'=>$identity_no,
        'service_type'=>'POS',
        'd_status'=>'Yes',
        'operator'=>$operator,
        'image'=>$image,
        'location'=>$location

        );//deriveryDate

     //echo json_encode($save);
    $maneno=' '.$service;

    $Getserialof_assigned =$this->unregistered_model->check_events_barcode_serial($trackno);
    $check_bulk =$this->unregistered_model->check_events_barcode_bulk($Getserialof_assigned->name);
    if (!empty($check_bulk)) {
    	foreach ($check_bulk as $key => $value) {

    		  $this->unregistered_model->update_assign_derivery_info_pos_barcode($value->track_no,$phone,$receiver,$identity_type,$identity_no,$operator,$image,$location,$service);
    $update = $this->unregistered_model->update_sender_info_by_barcode($trackno);
    		// code...
    	}
    }else{
    	    $this->unregistered_model->update_assign_derivery_info_pos_barcode($trackno,$phone,$receiver,$identity_type,$identity_no,$operator,$image,$location,$service);
    $update = $this->unregistered_model->update_sender_info_by_barcode($trackno);

    }

	} else {
		$maneno='  '.$service;

		 $save = array();
    $save = array(
        'deliverer_name'=>$receiver,
        'phone'=>$phone,
        'identity'=>$identity_type,
        'identityno'=>$identity_no,
        'service_type'=>'POS',
        'd_status'=>'Yes',
        'operator'=>$operator,
        'image'=>$image,
        'location'=>$location

        );//deriveryDate

     //echo json_encode($save);
    $maneno=' '.$service;

    $Getserialof_assigned =$this->unregistered_model->check_events_barcode_serial($trackno);
    $check_bulk =$this->unregistered_model->check_events_barcode_bulk($Getserialof_assigned->name);
    if (!empty($check_bulk)) {
    	foreach ($check_bulk as $key => $value) {

    		 $this->unregistered_model->update_assign_derivery_Person_info_pos_barcode($value->track_no,$phone,$receiver,$identity_type,$identity_no,$operator,$image,$location,$service);
    $update = $this->unregistered_model->update_sender_person_info_mails_barcode($trackno);

    		// code...
    	}

    }else{

    	   $this->unregistered_model->update_assign_derivery_Person_info_pos_barcode($trackno,$phone,$receiver,$identity_type,$identity_no,$operator,$image,$location,$service);
    $update = $this->unregistered_model->update_sender_person_info_mails_barcode($trackno);

    }
	}
   header('Access-Control-Allow-Origin: *');
	header("Cache-Control: no-cache");
	header('Content-Type: application/json');
	$data = array();
    $data = array('response'=>json_encode($getValue));
	$this->employee_model->save_login_log2($data);

  	$value = array();
	$value = array('code'=>'200','description'=>'Successful delivered'.$maneno);

	$data['result']=$value;
	
	
    echo json_encode($data);
	
  }

  public function create_delivery_group_post(){
	$getValue = json_decode( file_get_contents( 'php://input' ), true );
	
	$groupname= $getValue['groupname'];
	$username= $getValue['username'];

	$itemlist= $getValue['itemlist'];
	$groupno= rand();
	
        // //create logs
		// $value = array();
		// $value = array('request'=>$getValue,'groupname'=>$groupname,'item'=>$itemlist,'barcode'=>$itemlist[0],'groupno'=>$groupno);
		// $log=json_encode($value);
		// $lg = array(
		// 'response'=>$log
		// );
		//    $this->Box_Application_model->save_logs($lg);
	
	/////////check if this barcode
	$empinfo =  $this->TrackingApiModel->get_email_id($username);
	$value = $this->TrackingApiModel->retrieve_delivery_group($groupno);
	
	if(!empty($empinfo) && empty($value)){
	
	$empid = $empinfo->em_id;
	//insert group
	$results = $this->TrackingApiModel->add_delivery_group($groupname,$empid,$groupno);



	if($results){
		//retrieve group ID		
		 $value = $this->TrackingApiModel->retrieve_delivery_group($groupno);
		 $groupid = $value->virtuedelivery_group_id;
		 foreach($itemlist as $item){
			$barcode= $item;
			$updatedata = array('groupid'=>$groupid,'wfd_type'=>'bulk');
			$value = $this->TrackingApiModel->update_barcode_status_information($updatedata,$barcode);
		 }
		 }

	$arr = array(array('message'=>'Successful Saved','status'=>'200'));
	$list["data"]=$arr; 
	header('Content-Type: application/json');
	echo json_encode($list);
	
	} else {
	$arr = array(array('message'=>'User Not Found/Group No Exist!','status'=>'404'));
	$list["data"]=$arr; 
	header('Content-Type: application/json');
	echo json_encode($list);
	}
	}


	
	public function assign_delivery_post(){
		$getValue = json_decode( file_get_contents( 'php://input' ), true );
		$phone= $getValue['phone'];
		$username= $getValue['username'];
		$name= $getValue['name'];
		$identity= $getValue['identity'];
		$identityno= $getValue['identityno'];
		$type= $getValue['type'];
		$image= $getValue['image'];
		$id= $getValue['id'];

		$deliverydate = date("Y-m-d");

		//create logs
		$value = array();
		$value = array('request'=>$getValue,'groupname'=>$name);
		$log=json_encode($value);
		$lg = array(
		'response'=>$log
		);
		   $this->Box_Application_model->save_logs($lg);
		
		/////////check if this barcode
		$empinfo =  $this->TrackingApiModel->get_email_id($username);
		
		if(!empty($empinfo)){
		
		$empid = $empinfo->em_id;
		if($type=="Single"){
			//get single wfd
			$item12=$this->TrackingApiModel->get_waiting_for_delivery($id);
			$stype= $item12->service_type;
			$senderid= $item12->senderid;
			if($stype=='ems'){
				$data = array('item_status'=>'Derivered');
				$this->TrackingApiModel->update_ems_sender_information($data,$senderid);
				}
				
				if($stype=='mail'){
					$data = array('sender_status'=>'Derivery');
				$this->TrackingApiModel->update_mail_sender_information($data,$senderid);
				}
				$result = $this->TrackingApiModel->add_delivery_info($senderid,$empid,$name,$phone,$identity,$identityno,$deliverydate,$image);
		
			
				
		}else{
			//get bulk list
			$item10=$this->TrackingApiModel->get_Group_waiting_for_delivery($id);
			foreach($item10 as $value){
				$stype= $value->service_type;
			    $senderid= $value->senderid;
				if($stype=='ems'){
					$data = array('item_status'=>'Derivered');
					$this->TrackingApiModel->update_ems_sender_information($data,$senderid);
					}
					
					if($stype=='mail'){
						$data = array('sender_status'=>'Derivery');
					$this->TrackingApiModel->update_mail_sender_information($data,$senderid);
					}

					$result = $this->TrackingApiModel->add_delivery_info($senderid,$empid,$name,$phone,$identity,$identityno,$deliverydate,$image);
		
			}
		}
			

		if($result)	
			{
				$arr = array(array('message'=>'Successful Saved','status'=>'200'));
				$list["data"]=$arr; 
				header('Content-Type: application/json');
				echo json_encode($list);
			}else{
				$arr = array(array('message'=>'Not saved','status'=>'404'));
				$list["data"]=$arr; 
				header('Content-Type: application/json');
				echo json_encode($list);
			}
		} else {
		$arr = array(array('message'=>'User Not Found!','status'=>'404'));
		$list["data"]=$arr; 
		header('Content-Type: application/json');
		echo json_encode($list);
		}
		}

}
