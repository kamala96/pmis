<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Parking extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('login_model');
		$this->load->model('dashboard_model');
		$this->load->model('employee_model');
		$this->load->model('loan_model');
		$this->load->model('settings_model');
		$this->load->model('leave_model');
		$this->load->model('parking_model');
		$this->load->model('Control_Number_model');
	}

	public function vehicle_in()
	{
		if ($this->session->userdata('user_login_access') != false) {
			

			$vehicle = $this->parking_model->get_vehicle_in_info();
			$tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d H:i:s');
            $date1 = $today->format('Y-m-d');

            $status = $this->input->post('status');
            $datese = $this->input->post('date');
            $month = $this->input->post('month');

			foreach ($vehicle as $value) {
				
				 if ($date1 == date('Y-m-d',strtotime($value->entry_time))) {

				 	$hr  = date('H',strtotime($date));
                    $hre = date('H',strtotime($value->entry_time));

                    $min  = date('i',strtotime($date));
                    $mine = date('i',strtotime($value->entry_time));
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

                        $id = $value->parking_id;
                        $data = array();
                        $data = array(
                               'cost'=>$cost);
                        $this->parking_model->update_time_cash($id,$data);
				 }
			}

            

            if (empty($status)) {
            
            $data['parking'] = $this->parking_model->get_vehicle_in_info();
            $data['sum'] = $this->parking_model->get_vehicle_in_info_search_sum($status,$datese,$month);

            } else {
                $data['parking'] = $this->parking_model->get_vehicle_in_info_search($status,$datese,$month);
                $data['sum'] = $this->parking_model->get_vehicle_in_info_search_sum($status,$datese,$month);
            }
            
			$data['countTrans'] = $this->parking_model->get_to_day_trans();
            $data['countIn'] = $this->parking_model->get_to_day_vehicle_In();
            $data['countOutn'] = $this->parking_model->get_to_day_vehicle_Out();
            $data['countWallet'] = $this->parking_model->get_wallet_custom_trans();

			$this->load->view('parking/vehicle-in', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function vehicle_out()
	{
		if ($this->session->userdata('user_login_access') != false) {
			
			
			$data['parking'] = $this->parking_model->get_vehicle_out_info();
			$data['countTrans'] = $this->parking_model->get_to_day_trans();
            $data['countIn'] = $this->parking_model->get_to_day_vehicle_In();
            $data['countOutn'] = $this->parking_model->get_to_day_vehicle_Out();
            $data['countWallet'] = $this->parking_model->get_wallet_custom_trans();

			$this->load->view('parking/vehicle-out', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function transanctions()
        {
            if ($this->session->userdata('user_login_access') != false)
            {
                $date = $this->input->post('date');
                $month = $this->input->post('month');
                $status = $this->input->post('status');

                if (empty($status)) {
                $data['trans'] = $this->parking_model->getAllTransaction();
                }else{
                $data['trans'] = $this->parking_model->getAllTransactionSearched($date,$status,$month);
                }

                $data['countIn'] = $this->parking_model->get_to_day_vehicle_In();
                $data['countOutn'] = $this->parking_model->get_to_day_vehicle_Out();
                $data['countTrans'] = $this->parking_model->get_to_day_trans();
                $data['countWallet'] = $this->parking_model->get_wallet_custom_trans();

                $this->load->view('parking/transactions-list',$data);

            }
            else{
                redirect(base_url());
            }
        }


        public function Customer_Wallet()
        {
            if ($this->session->userdata('user_login_access') != false)
            {
                $custType = $this->input->post('cust_type');
                $comname = $this->input->post('comname');
                $s_mobile = $this->input->post('mobile');
                $tin = $this->input->post('tin');
                $vrn = $this->input->post('vrn');
                $paidamount = $this->input->post('amount');
                $walletid = $this->input->post('walletid');

                $serial = 'PW'.rand(1000,9999);
                $sender_region = $this->session->userdata('user_region');
                $sender_branch = $this->session->userdata('user_branch');
                $renter = 'CARPARKING';
		        $serviceId = 'PARKING';
		        $trackno = 00;

                
                $tz = 'Africa/Nairobi';
		        $tz_obj = new DateTimeZone($tz);
		        $today = new DateTime("now", $tz_obj);
		        $date = $today->format('Y-m-d H:i:s');
		        if (!empty($custType)) {


                if (!empty($walletid)) {
                    
                    $cust = array();
                    $cust = array(
                	'cust_type'=>$custType,
                	'comp_name'=>$comname,
                	'tin_number'=>$tin,
                	'vrn'=>$vrn,
                	'paidamount'=>$paidamount,
                	'mobile'=>$s_mobile

                );
                	$this->parking_model->update_wallet_cust_info($cust,$walletid);
                    echo "Successfull Updated";
                } else {

                	$postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

		        	$cust = array();
                    $cust = array(
                	'cust_type'=>$custType,
                	'comp_name'=>$comname,
                	'tin_number'=>$tin,
                	'vrn'=>$vrn,
                	'date_created'=>$date,
                	'serial'=>$serial,
                	'paidamount'=>$paidamount,
                	'status'=>'NotPaid',
                	'controlno'=>$postbill->controlno,
                	'mobile'=>$s_mobile,

                 );
                	$this->parking_model->save_wallet_cust_info($cust);
                    echo "Successfull Added";
                }
                
		        }else{
		        $data['countIn'] = $this->parking_model->get_to_day_vehicle_In();
                $data['countOutn'] = $this->parking_model->get_to_day_vehicle_Out();
                $data['countTrans'] = $this->parking_model->get_to_day_trans();
                $data['countWallet'] = $this->parking_model->get_wallet_custom_trans();
                $data['trans'] = $this->parking_model->getAllTransaction();
                $data['wallet'] = $this->parking_model->get_wallet_transactions();

                $this->load->view('parking/wallet-registration',$data);
		        }
                

            }
            else{
                redirect(base_url());
            }
        }


        public function Save_vehicle()
        {
            if ($this->session->userdata('user_login_access') != false)
            {
                
               $vehicle  = $this->input->post('regno');
               $walletid = $this->input->post('walletid');

               $url = "http://154.118.230.75/tollbridge/getData.php?vehicle=$vehicle";
               $info = file_get_contents($url);
               $tra = json_decode($info);

               $wallet = array();
               $wallet = array(
            	'vehicle_regno'=>$tra->regno,
            	'wallet_id'=>$walletid,
            	'vehicle_name'=>$tra->vehicle,
            	'vehicle_owner'=>$tra->owner,
            	'tin_number'=>$tra->tin
                );

               $this->parking_model->save_wallet_vehicle_info($wallet);

               echo "Successfull Vehicle Added";

            }
            else{
                redirect(base_url());
            }
        }

        public function getWalletInfo()
        {
            if ($this->session->userdata('user_login_access') != false)
            {
                $wid = $this->input->post('walletid');
                $pay = $this->parking_model->get_payment_info($wid);
                $vehicle = $this->parking_model->get_veicle_wallet_info($wid);
                echo "<table class='table table-bordered table-striped' width='100%'>";
                echo "<tr>";
                echo "<th colspan='2' width='50%'>";
                echo "<h3>Payment Information</h3>";
                echo "</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>";
                echo "Pay Channel";
                echo "</td>";
                echo "<td>";
                echo $pay->paychannel;
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>";
                echo "Pay Receipt";
                echo "</td>";
                echo "<td>";
                echo $pay->receipt;
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>";
                echo "Pay Date";
                echo "</td>";
                echo "<td>";
                echo $pay->paymentdate;
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th colspan='2' width='50%'>";
                echo "<h3>Vehicle Associated With</h3>";
                echo "</th>";
                echo "</tr>";
                echo "<tr>";
                echo "<th>";
                echo "Registration No.";
                echo "</th>";
                echo "<th>";
                echo "Vehicle Type.";
                echo "</th>";
                echo "</tr>";
                foreach ($vehicle as $value) {
                echo "<tr>";
                echo "<td>";
                echo $value->vehicle_regno;
                echo "</td>";
                echo "<td>";
                echo $value->vehicle_name;
                echo "</td>";
                echo "</tr>";
                }
                echo "</table>";

            }
            else{
                redirect(base_url());
            }
        }


   public function vehicle_associated_with()
	{
		if ($this->session->userdata('user_login_access') != false) {
			
			$controlno = $this->input->get('controlno');
			$data['parking'] = $this->parking_model->get_vehicle_associated_with_info($controlno);
			$data['countTrans'] = $this->parking_model->get_to_day_trans();
            $data['countIn'] = $this->parking_model->get_to_day_vehicle_In();
            $data['countOutn'] = $this->parking_model->get_to_day_vehicle_Out();
            $data['countWallet'] = $this->parking_model->get_wallet_custom_trans();
            $data['sumAmount'] = $this->parking_model->get_vehicle_associated_with_sum($controlno);

			$this->load->view('parking/vehicle-associated-with', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}
    
	
}
?>