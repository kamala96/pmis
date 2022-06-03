	<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Realestate extends CI_Controller
	{


		function __construct()
		{
			parent::__construct();
			$this->load->database();
			//$db2 = $this->load->database('otherdb', TRUE);
			$this->load->model('login_model');
			$this->load->model('dashboard_model');
			$this->load->model('employee_model');
			$this->load->model('notice_model');
			$this->load->model('settings_model');
			$this->load->model('leave_model');
			$this->load->model('billing_model');
			$this->load->model('organization_model');
			$this->load->model('Box_Application_model');
			$this->load->model('Stampbureau');
			$this->load->model('Estatemodel');
			$this->load->model('Control_Number_model');
			$this->load->model('Sms_model');
		}



		public function Propertylist()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$data['region'] = $this->employee_model->regselect();
				$data1 = "0";

				$data['property'] = $this->Estatemodel->propertylist($data1);

				$this->load->view('estate/Propertylist', $data);
			} else {
				redirect(base_url());
			}
		}
		public function clients_tenants_dashboard()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->load->view('estate/clients-tenants-dashboard');
			} else {
				redirect(base_url());
			}
		}
		public function Add_Tenant_information()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->load->view('estate/add-residential-information');
			} else {
				redirect(base_url());
			}
		}

		public function Add_Office_Information()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->load->view('estate/add-offices-information');
			} else {
				redirect(base_url());
			}
		}

		public function Add_Land_Information()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->load->view('estate/add-land-information');
			} else {
				redirect(base_url());
			}
		}

		public function Residential_list()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->session->set_userdata('heading','Residential List');

				$type = "Residential";
				$regid = trim($this->input->post('regid'));
				$disid = trim($this->input->post('disid'));
				$status = trim($this->input->post('status'));
				$estatus = trim($this->input->post('estatus'));
				$button = $this->input->post('search');

				if($button == "search"){
					$data['tenant'] = $this->dashboard_model->get_tenant_information_search($type,$regid,$disid,$status,$estatus);
				}else{
					$data['tenant'] = $this->dashboard_model->get_tenant_information($type);
				}

				$this->load->view('estate/Residential-list',$data);
			} else {
				redirect(base_url());
			}
		}

		public function Save_Tenant_Information()
		{
			if ($this->session->userdata('user_login_access') != false) {
				
				$first_name = $this->input->post('first_name');
				$middle_name = $this->input->post('middle_name');
				$last_name = $this->input->post('last_name');
				$mobile = $this->input->post('mobile_number');
				$address = $this->input->post('address');

				$regid = $this->input->post('region');
				$disid = $this->input->post('district');
				$estate_name = $this->input->post('estate_name');
				$status = $this->input->post('status');
				$floor = $this->input->post('floor');
				$room_number = $this->input->post('room_number');
				$square_meter = $this->input->post('square_meters');
				$estateType = $this->input->post('type');

				$contract_number = $this->input->post('contarct_number');
				$currency_type = $this->input->post('currency_type');
				$amount = $this->input->post('amount');
				$payment_cycle = $this->input->post('payment_cycle');
				$start_date = $this->input->post('start_date');
				$monthrange = $this->input->post('monthrange');

				if ($payment_cycle == "Monthly") {
					if (!empty($monthrange)) {
						$days = 30*$monthrange;
					} else {
						$days = 30;
					}
				} elseif($payment_cycle == "Quartery") {
					$days = 120;
				}elseif ($payment_cycle == "Semi Annual") {
					$days = 180;
				}else{
					$days = 360;
				}
				
				$end_date =  date('Y-m-d', strtotime($start_date. ' +'.$days.' days'));

				$em_id = $this->session->userdata('user_login_id');

				$getr = $this->dashboard_model->getRegion_ById($regid);
				$getd = $this->dashboard_model->getDistrict_ById($disid);

				$region = $getr->region_name;
			    $district = $getd->district_name;

				 $resident = array();
				 $resident = array(
				 	'first_name'=>$first_name,
					'middle_name'=>$middle_name,
					'last_name'=>$last_name,
				 	'mobile_number'=>$mobile,
				 	'address'=>$address,
				 	'operator'=>$em_id
				    ); 

				 $db2 = $this->load->database('otherdb', TRUE);
				 $db2->insert('estate_tenant_information',$resident);
				 $tenant_id = $db2->insert_id();

				 $estate = array();
				 $estate = array(
				 	'estate_name'=>$estate_name,
				 	'region'=>$regid,
				 	'district'=>$disid,
				 	'estate_status'=>$status,
				 	'floor'=>$floor,
				 	'room_number'=>$room_number,
				 	'estate_square_meter'=>$square_meter,
				 	'estate_type'=>$estateType
				   ); 

				 $db2->insert('estate_information',$estate);
				 $estate_id = $db2->insert_id();

				 $contract = array();
				 $contract = array(
				 	'estate_id'=>$estate_id,
				 	'tenant_id'=>$tenant_id,
				 	'contract_number'=>$contract_number,
				 	'currency_type'=>$currency_type,
				 	'amount'=>$amount,
				 	'payment_cycle'=>$payment_cycle,
				 	'start_date'=>$start_date,
				 	'end_date'=>$end_date
				 ); 

				 $db2->insert('estate_contract_information',$contract);

				
			     $serial    = 'real-estate'.date("YmdHis").$this->session->userdata('user_emid');

			 	 $data = array();
                  $data = array(

                  'serial'=>$serial,
                  'paidamount'=>$amount,
                  'tenant_id'=>$tenant_id,
                  'transactionstatus'=>'POSTED',
                  'bill_status'=>'PENDING'

	              );

	              $db2->insert('real_estate_transactions',$data);

	              $paidamount = $amount;
	              $renter   = $contract_number;
	              $serviceId = 'RENTAL';
	              $trackno = 00;

	              $transaction = $this->Control_Number_model->get_control_number($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

	              @$serial1 = $transaction->billid;
                  $update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
                  $this->dashboard_model->update_transactions_real_estate($update,$serial1);

                  	$message['sms'] = '<h3>Successfull Saved'. '         '.'Umepatiwa ankara namba hii hapa'.'      '.$transaction->controlno.'</h3>';

                  if ($estateType == "Residential") {
                       $this->load->view('estate/add-residential-information',$message);    
                   }elseif($estateType == "Land"){
                   	$this->load->view('estate/add-land-information',$message);
                   }else {
                  		$this->load->view('estate/add-offices-information',$message);
                  }

				} else {
					redirect(base_url());
				}
		}
		public function Land_list()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->session->set_userdata('heading','Land List');
				$type = "Land";
				$regid = trim($this->input->post('regid'));
				$disid = trim($this->input->post('disid'));
				$status = trim($this->input->post('status'));
				$estatus = trim($this->input->post('estatus'));
				$button = $this->input->post('search');

				if($button == "search"){
					$data['tenant'] = $this->dashboard_model->get_tenant_information_search($type,$regid,$disid,$status,$estatus);
				}else{
					$data['tenant'] = $this->dashboard_model->get_tenant_information($type);
				}
				$this->load->view('estate/Land-list',$data);
			} else {
				redirect(base_url());
			}
		}
		public function getPaymentTrend()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->session->set_userdata('heading','Payment Trend List');

				$controlno = $this->input->get('controlno');
				$data['tenant'] = $this->dashboard_model->get_payment_information($controlno);
				$this->load->view('estate/Payment-list',$data);

			} else {
				redirect(base_url());
			}
		}
		public function Office_list()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$this->session->set_userdata('heading','Office List');

				$type = "Offices";
				$regid = trim($this->input->post('regid'));
				$disid = trim($this->input->post('disid'));
				$status = trim($this->input->post('status'));
				$estatus = trim($this->input->post('estatus'));
				$button = $this->input->post('search');

				if($button == "search"){
					$data['tenant'] = $this->dashboard_model->get_tenant_information_search($type,$regid,$disid,$status,$estatus);
				}else{
					$data['tenant'] = $this->dashboard_model->get_tenant_information($type);
				}
				$this->load->view('estate/Office-list',$data);
			} else {
				redirect(base_url());
			}
		}
		public function Propertyprofile($id)
		{
			if ($this->session->userdata('user_login_access') != false) {
				$data['region'] = $this->employee_model->regselect();
				//$id = "0";propertyimages

				$data['propertyimages'] = $this->Estatemodel->propertyimages($id);
				$data['property'] = $this->Estatemodel->propertyprofile($id);
				$this->load->view('estate/Propertyprofile', $data);
			} else {
				redirect(base_url());
			}
		}


		public function editproperty($id)
		{
			if ($this->session->userdata('user_login_access') != false) {
				//$data['philatel'] = $this->Stampbureau->philatelist();
				$data['region'] = $this->employee_model->regselect();
				//$data['category'] = $this->billing_model->getAllCategory();
				//$data['listItem'] = $this->billing_model->getAllCategoryBill();

				$data['propertyimages'] = $this->Estatemodel->propertyimages($id);
				$data['property'] = $this->Estatemodel->propertyprofile($id);
				$this->load->view('estate/editproperty', $data);
			} else {
				redirect(base_url());
			}
		}
		public function AddProperty()
		{
			if ($this->session->userdata('user_login_access') != false) {
				$data['philatel'] = $this->Stampbureau->philatelist();
				$data['region'] = $this->employee_model->regselect();
				$data['category'] = $this->billing_model->getAllCategory();
				$data['listItem'] = $this->billing_model->getAllCategoryBill();

				//$this->load->view('billing/Stock',$data);
				$this->load->view('estate/addproperty', $data);
			} else {
				redirect(base_url());
			}
		}


		public function UploadAttachment()
		{
			if ($this->session->userdata('user_login_access') != false) {
				if (!empty($_FILES)) {

					$upload_dir = "./images/";   ////"../record-documents/";
					$fileName = $_FILES['file']['name'];
					$property_id = 0;
					$date = date("Y-m-d H:i:s");

					$uploaded_file = $upload_dir . $fileName;

					if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaded_file)) {

						//insert file information into db table
						//$mysql_insert = "INSERT INTO propertyuploads (file_name, upload_time,property_id)VALUES('".$fileName."','".date("Y-m-d H:i:s")."','".$property_id."')";
						//mysqli_query($mysqli, $mysql_insert) or die("database error:". mysqli_error($mysqli));
						$data = array();
						$data = array(
							'file_name' => $fileName,
							'upload_time' => $date,

							'property_id' => $property_id,


						);

						$success = $this->Estatemodel->Addattachment($data);
					}
				}
				//$this->load->view('billing/Stock',$data);
				//$this->load->view('Estate/Propertylist',$data);
			} else {
				redirect(base_url());
			}
		}

		public function Requisition_Form() //unissued requisition
		{
			// $info = $this->Stampbureau->requestlist1($serialno);
			// $id = $info->RequestedBy;
			if ($this->session->userdata('user_login_access') != false) {
				$empid = $this->session->userdata('user_login_id');

				$basicinfo = $this->employee_model->GetBasic($empid);
				$em_sub_role = $basicinfo->em_sub_role;
				$em_region = $basicinfo->em_region;
				$em_branch = $basicinfo->em_branch;
				if ($em_sub_role == "BRANCH") {
					//aone request zote za branch yake kutoka kwa counter
					$data1 = "0";
					$takefromrole = "COUNTER";
					$data['stock'] = $this->Stampbureau->requisationbranch($data1, $em_branch, $takefromrole);
					$this->load->view('Stock/RequisitionForm', $data);
				} elseif ($em_sub_role == "STRONGROOM") {
					//aone request zote za mkoa wake kutoka kwa branch
					$data1 = "0";
					$takefromrole = "BRANCH";
					$data['stock'] = $this->Stampbureau->requisationstrong($data1, $em_region, $takefromrole);
					$this->load->view('Stock/RequisitionForm', $data);
				} elseif ($em_sub_role == "STORE") {
					//aone request zote za mikoa yote kutoka kwa strongroom
					$data1 = "0";
					$takefromrole = "STRONGROOM";
					$data['stock'] = $this->Stampbureau->requisationlistStore($data1, $takefromrole);
					$this->load->view('Stock/RequisitionForm', $data);
				}

				//redirect(base_url());
			} else {
				redirect(base_url());
			}
		}






		public function Saveproperty()
		{
			if ($this->session->userdata('user_login_access') != False) {

				$DateofRegs = $this->input->post('DateofReg');
				$dayissue = date('d', strtotime($DateofRegs));
				$monthissue = date('m', strtotime($DateofRegs));
				$yearissue = date('Y', strtotime($DateofRegs));
				$DateofReg = ($yearissue) . '-' . $monthissue . '-' . $dayissue;

				$property_name = $this->input->post('property_name');
				$RegistrationNo = $this->input->post('RegistrationNo');
				$Status = $this->input->post('Status');
				$Plot = $this->input->post('Plot');
				$block = $this->input->post('block');
				//$lot = $this->input->post('lot');
				$Region = $this->input->post('Region');
				$District = $this->input->post('District');
				$addresss = $this->input->post('address');
				$city = $Region;
				$postal_code = $this->input->post('postal_code');
				$property_size = $this->input->post('property_size');
				$price_per_sqm = $this->input->post('price_per_sqm');
				$PropertyValue = $this->input->post('PropertyValue');
				$Totalprice = $this->input->post('Totalprice');
				$size_unit = $this->input->post('size_unit');
				$monthly_paymentRent = $this->input->post('monthly_paymentRent');
				$property_type = $this->input->post('property_type');
				$caretaker = " ";
				$payment_mode = " ";
				$additional_info = $this->input->post('additional_info');

				$property_condition = $this->input->post('property_condition');
				$image_path = "";
				$isdevided = 0;
				$PropertyUsage = $this->input->post('PropertyUsage');
				$LandValue = $this->input->post('LandValue');

				$address = 'Plot No ' . $Plot . ' Block ' . $block . ' ' . $addresss;

				$upload_dir = "./images/";
				if (!empty($_FILES)) {

					if (getimagesize($_FILES['image']['tmp_name']) == FALSE) {
						$image_path = "no-image.png";
					} else {

						$myFile = $_FILES["image"];

						if ($myFile["error"] !== UPLOAD_ERR_OK) {
							echo "<p>An error occurred.</p>";
							exit;
						}

						// ensure a safe filename
						//$name = pFreg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);
						$name = $myFile["name"];

						// don't overwrite an existing file
						$i = 0;
						$parts = pathinfo($name);
						while (file_exists($upload_dir . $name)) {
							$i++;
							$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
						}


						// preserve file from temporary directory
						$success = move_uploaded_file(
							$myFile["tmp_name"],
							$upload_dir . $name
						);
						if (!$success) {
							echo "<p>Unable to save file.</p>";
							//   exit;
						}

						// set proper permissions on the new file
						chmod($upload_dir . $name, 0644);
						$image_path = $name;
					}
				} else {

					$image_path = "no-image.png";
				}


				$this->load->library('form_validation');
				// $this->form_validation->set_error_delimiters();



				$id = $this->session->userdata('user_login_id');
				$basicinfo = $this->employee_model->GetBasic($id);
				$em_id = $basicinfo->em_id;
				$date = date('Y-m-d');

				$date = $date;
				$createdby = $em_id;


				$data = array();
				$data = array(
					'property_name' => $property_name,
					'RegistrationNo' => $RegistrationNo,
					'DateofReg' => $DateofReg,
					'date' => $date,
					'Status' => $Status,
					'Plot' => $Plot,
					'block' => $block,
					//'lot' => $lot,
					'Region' => $Region,
					'District' => $District,
					'address' => $address,
					'city' => $city,
					'postal_code' => $postal_code,
					'property_size' => $property_size,
					'price_per_sqm' => $price_per_sqm,
					'PropertyValue' => $PropertyValue,
					'Totalprice' => $Totalprice,
					'size_unit' => $size_unit,
					'monthly_paymentRent' => $monthly_paymentRent,
					'property_type' => $property_type,
					'createdby' => $createdby,
					'caretaker' => $caretaker,
					'additional_info' => $additional_info,
					'image_path' => $image_path,
					'isdevided' => $isdevided,
					'payment_mode' => $payment_mode,
					'PropertyUsage' => $PropertyUsage,
					'LandValue' => $LandValue

				);
				//echo $data;
				$success = $this->Estatemodel->Addproperty($data);
				#$this->confirm_mail_send($email,$pass_hash);        
				echo "Successfully Added" . $success;
				#redirect('employee/Add_employee');   
				//$this->session->set_flashdata('feedback','Successfully Created');                  



			} else {
				redirect(base_url(), 'refresh');
			}
		}

		public function SaveEditproperty()
		{
			echo "IMEPA4343RF";
			if ($this->session->userdata('user_login_access') != False) {
				echo "IMEPA4343RF";
				$DateofRegs = $this->input->post('DateofReg');
				$dayissue = date('d', strtotime($DateofRegs));
				$monthissue = date('m', strtotime($DateofRegs));
				$yearissue = date('Y', strtotime($DateofRegs));
				$DateofReg = ($yearissue) . '-' . $monthissue . '-' . $dayissue;

				$property_name = $this->input->post('property_name');
				$RegistrationNo = $this->input->post('RegistrationNo');
				$Status = $this->input->post('Status');
				$Plot = $this->input->post('Plot');
				$block = $this->input->post('block');
				//$lot = $this->input->post('lot');
				$Region = $this->input->post('Region');
				$District = $this->input->post('District');
				$addresss = $this->input->post('address');
				$city = $Region;
				$postal_code = $this->input->post('postal_code');
				$property_size = $this->input->post('property_size');
				$price_per_sqm = $this->input->post('price_per_sqm');
				$PropertyValue = $this->input->post('PropertyValue');
				$Totalprice = $this->input->post('Totalprice');
				$size_unit = $this->input->post('size_unit');
				$monthly_paymentRent = $this->input->post('monthly_paymentRent');
				$property_type = $this->input->post('property_type');
				$caretaker = " ";
				$payment_mode = " ";
				$additional_info = $this->input->post('additional_info');

				$property_condition = $this->input->post('property_condition');
				$image_path = "";
				$isdevided = 0;
				$PropertyUsage = $this->input->post('PropertyUsage');
				$LandValue = $this->input->post('LandValue');

				$address = 'Plot No ' . $Plot . ' Block ' . $block . ' ' . $addresss;

				echo "IMEPA4343RF";

				$upload_dir = "./images/";
				if (!empty($_FILES)) {

					if (getimagesize($_FILES['image']['tmp_name']) == FALSE) {
						$image_path = "no-image.png";
					} else {

						$myFile = $_FILES["image"];

						if ($myFile["error"] !== UPLOAD_ERR_OK) {
							echo "<p>An error occurred.</p>";
							exit;
						}

						// ensure a safe filename
						//$name = pFreg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);
						$name = $myFile["name"];

						// don't overwrite an existing file
						$i = 0;
						$parts = pathinfo($name);
						while (file_exists($upload_dir . $name)) {
							$i++;
							$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
						}


						// preserve file from temporary directory
						$success = move_uploaded_file(
							$myFile["tmp_name"],
							$upload_dir . $name
						);
						if (!$success) {
							echo "<p>Unable to save file.</p>";
							//   exit;
						}

						// set proper permissions on the new file
						chmod($upload_dir . $name, 0644);
						$image_path = $name;
					}
				} else {

					$image_path = "no-image.png";
				}


				$this->load->library('form_validation');
				// $this->form_validation->set_error_delimiters();



				$id = $this->session->userdata('user_login_id');
				$basicinfo = $this->employee_model->GetBasic($id);
				$em_id = $basicinfo->em_id;
				$date = date('Y-m-d');
				$Id= $this->input->post('id');
				$date = $date;
				$createdby = $em_id;
				echo "IMEPA";
				if($Id != "")
				{
					echo "IMEPITAAAAAAAAA";
					$data = array();
					$data = array(
						'property_name' => $property_name,
						'RegistrationNo' => $RegistrationNo,
						'DateofReg' => $DateofReg,
						'date' => $date,
						'Status' => $Status,
						'Plot' => $Plot,
						'block' => $block,
						//'lot' => $lot,
						'Region' => $Region,
						'District' => $District,
						'address' => $address,
						'city' => $city,
						'postal_code' => $postal_code,
						'property_size' => $property_size,
						'price_per_sqm' => $price_per_sqm,
						'PropertyValue' => $PropertyValue,
						'Totalprice' => $Totalprice,
						'size_unit' => $size_unit,
						'monthly_paymentRent' => $monthly_paymentRent,
						'property_type' => $property_type,
						'createdby' => $createdby,
						'caretaker' => $caretaker,
						'additional_info' => $additional_info,
						'image_path' => $image_path,
						'isdevided' => $isdevided,
						'payment_mode' => $payment_mode,
						'PropertyUsage' => $PropertyUsage,
						'LandValue' => $LandValue
	
					);
					//echo $data;Update_property($data,$Id)
					$success = $this->Estatemodel->Update_property($data,$Id);
					#$this->confirm_mail_send($email,$pass_hash);        
					echo "Successfully Added" . $success;
					#redirect('employee/Add_employee');   
					//$this->session->set_flashdata('feedback','Successfully Created');
				}

				
			} else {
				redirect(base_url(), 'refresh');
			}

			//redirect(base_url(), 'refresh');
		}




		public function Savestrongroomrequest()
		{
			if ($this->session->userdata('user_login_access') != False) {


				for ($i = 0; $i < count($this->input->post('QuantityReq')); $i++) {

					$formno = $this->input->post('formno');
					$serialno = $this->input->post('serialno');
					$issuedby = $this->input->post('issuedby');
					//$stampname = $this->input->post('stampname');
					$RequestedBy = $this->input->post('RequestedBy');
					$QuantityReq = $this->input->post('QuantityReq[' . $i . ']');
					$StockId = $this->input->post('StockId[' . $i . ']');

					//$Totalamount = $price * $QuantityReq;

					$date = date('Y-m-d H:i:s');

					$RequestedDate = $date;


					$this->load->library('form_validation');
					// $this->form_validation->set_error_delimiters();

					{
						$data = array();
						$data = array(
							'serialno' => $serialno,
							'RequestedBy' => $RequestedBy,
							'QuantityReq' => $QuantityReq,
							'StockId' => $StockId,
							'formno' => $formno,
							'RequestedDate' => $RequestedDate,
							'issuedby' => $issuedby,

						);

						$success = $this->Stampbureau->Addstockrequest($data);
					}
				}



				#$this->confirm_mail_send($email,$pass_hash);        
				echo "Successfully Added" . $success;
				#redirect('employee/Add_employee');   
				//$this->session->set_flashdata('feedback','Successfully Created');


			} else {
				redirect(base_url(), 'refresh');
			}
		}


	public function getDistrict(){

      if ($this->input->post('region_id') != '') {
          echo $this->dashboard_model->GetDistrictById($this->input->post('region_id'));
      }
  }
}
