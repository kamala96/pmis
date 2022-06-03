 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
    
    }
    
	public function posta_get()
	{
		echo 'Mussa Johanes';
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

			 $check = $this->billing_model->checkValue($controlno);
             $check2 = $this->unregistered_model->checkValueRegister($controlno);
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

					$data = array('status'=>'100','description'=>"Successful",'controlno'=>$update1['controlno']);

					$update = array('paymentdate'=>$update1['date'],'receipt'=>$update1['receiptno'],'paidamount'=>$update1['amount'],'status'=>'Paid','paychannel'=>$channel);

					$serial = $update1['controlno'];
					//$this->billing_model->update_transactions2($update,$serial);
					$this->billing_model->update_transactions2($update,$serial);
					$this->unregistered_model->update_register_transactions($update,$serial);
					$this->unregistered_model->update_delivery_transactions1($update,$serial);
					$this->parcel_model->update_parcel_international_transactions1($update,$serial);
					$this->parking_model->update_parking_transactions1($update,$serial);
					$this->parking_model->update_parking_wallet_transaction($update,$serial);
					$this->billing_model->insert_logs($data);

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

			$value = array('code'=>'100','description'=>'Successful Loged In','first_name'=>$authenticate->first_name,'last_name'=>$authenticate->last_name,'em_role'=>$authenticate->em_role,'emid'=>$authenticate->em_id,'em_image'=>$authenticate->em_image,'pfno'=>$authenticate->em_code);

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
		
		
		$getInfo = $this->employee_model->GetBasic1($pfno);
		$user = $pfno . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
		$loc = $getInfo->em_region.' - '.$getInfo->em_branch;

		if ($getInfo->em_sub_role  == "SORTING") {

			$event = "Sorting Facility";
			$data = array();
		    $data = array('track_no'=>$trackno,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);

		 $this->Box_Application_model->save_location($data);
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
		 	
		}elseif($getInfo->em_sub_role  == "COUNTER"){
			$event = "Counter";
			$data = array();
		    $data = array('track_no'=>$trackno,'location'=>$loc,'user'=>$user,'pos_id'=>$posid,'event'=>$event);
		    $this->Box_Application_model->save_location($data);
		    $value = "Successful Item Updated";

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
		}else{
			$value = "Your Not Authorised to Scan";
		}
		
		header('Content-Type: application/json');
            echo json_encode($value);
		
	}
	public function post_derivery_list_post(){
       
	$getValue = json_decode( file_get_contents( 'php://input' ), true );

	$id      = $getValue['emid'];

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

  public function post_derivery_response_post(){
       
	$getValue = json_decode( file_get_contents( 'php://input' ), true );

	// $id      = $getValue['emid'];
	
	$trackno = $getValue['identifier'];
	$receiver = $getValue['receiver'];
	$phone = $getValue['phone'];
	$identity_type = $getValue['identity_type'];
	$identity_no = $getValue['identity_no'];
	$date_printed = $getValue['date_printed'];
	$image        = $getValue['date_printed'];
	$last_id = $getValue['sender_id'];
	$operator = $getValue['operator'];
	$image = $getValue['image'];

	if ($getValue['service'] == "ems") {

		$data1 = array();
		$data1 = array('item_status'=>'Derivered');
		$update = $this->billing_model->update_sender_info($last_id,$data1);

	} else {

		$data1 = array();
		$data1 = array('sender_status'=>'Derivery');
		$update = $this->billing_model->update_sender_info_mails($last_id,$data1);

	}

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
		'location'=>$getValue['street']

		);

	$this->Box_Application_model->update_assign_derivery($save,$last_id);

	$data = array();
    $data = array('response'=>json_encode($getValue));
	$this->employee_model->save_login_log2($data);

  	$value = array();
	$value = array('code'=>'200','description'=>'Successful Open');
	
	header('Content-Type: application/json');
    echo json_encode($value);
	
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

}
