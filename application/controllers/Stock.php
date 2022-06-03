	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Stock extends CI_Controller {


		function __construct() {
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
			$this->load->model('inventory_model');
		}

			public function Stock()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				$data['region'] = $this->employee_model->regselect();
				$data['category'] = $this->billing_model->getAllCategory();
				$data['listItem'] = $this->billing_model->getAllCategoryBill();

				//$this->load->view('billing/Stock',$data);
				$this->load->view('Stock/Stock',$data);
			}
			else{
				redirect(base_url());
			}
		}

		public function Stocks()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				 $data['philatel'] = $this->Stampbureau->philatelist();
				$data['region'] = $this->employee_model->regselect();
				$data['category'] = $this->billing_model->getAllCategory();
				$data['listItem'] = $this->billing_model->getAllCategoryBill();

				//$this->load->view('billing/Stock',$data);
				$this->load->view('Stock/StockList',$data);
			}
			else{
				redirect(base_url());
			}
		}

			public function StockList()
			{
			if ($this->session->userdata('user_login_access') != false)
			{

				$data['stocklist'] = $this->inventory_model->Stock_List();
                $data['stockno'] = $this->inventory_model->Count_Stock();
                $data['cashno'] = $this->inventory_model->Count_Cash();
                $data['locksno'] = $this->inventory_model->Count_Locks();
                $data['stampno'] = 0;//$this->inventory_model->Count_Stampbureau();
				

				$empid = $this->session->userdata('user_login_id');

				$basicinfo = $this->employee_model->GetBasic($empid);
	            $em_sub_role = $basicinfo->em_sub_role;
	            $em_region = $basicinfo->em_region;
	            $em_branch = $basicinfo->em_branch;
	            if($em_sub_role == "COUNTER"){

				 $data['philatel'] = $this->Stampbureau->getCounterstock($empid);
				 $data['area'] =$basicinfo->em_branch;

				$this->load->view('Stock/CounterStockList',$data);
	            }
	            elseif ($em_sub_role == "BRANCH") {	 
	             $data['philatel'] = $this->Stampbureau->getBranchstock($em_branch);
				 $data['area'] =$basicinfo->em_branch;	

				$this->load->view('Stock/BranchStockList',$data);	            	
	            }
	             elseif ($em_sub_role == "STRONGROOM") {
	             $data['philatel'] = $this->Stampbureau->getStrongstock($em_region);
				 $data['area'] =$basicinfo->em_region;	

				$this->load->view('Stock/StrongroomStockList',$data);	            	
	            }
	            elseif ($em_sub_role == "STORE") {

	             $data['philatel'] = $this->Stampbureau->getMainstock();
				 $data['area'] ="PHQ";	

				$this->load->view('Stock/MainStockList',$data);
			}
			}
			else{
				redirect(base_url());
				}
		
}


		public function Add_Stock()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				
				 $data['philatel'] = $this->Stampbureau->philatelist();
				$this->load->view('Stock/add-Stock',$data);
			}
			else{
				redirect(base_url());
			}
		}

		public function Counter_Request()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				
				 $data['philatel'] = $this->Stampbureau->philatelist();
				  $data['serial'] = $this->Stampbureau->lastserialnumber() ;

				 $data['stock'] = $this->Stampbureau->getstocklist();
				$this->load->view('Stock/CounterRequest',$data);
			}
			else{
				redirect(base_url());
			}
		}

		public function printstock($serialno)
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				
				 $data['request2'] = $this->Stampbureau->requestlist($serialno);
				 $data['request23'] = $this->Stampbureau->requestlist1($serialno);
				 $info = $this->Stampbureau->requestlist1($serialno);
				 $id = $info->RequestedBy;
				 $data['serial'] = $serialno;
				 $basicinfofrom = $this->employee_model->GetBasic($id);
				 $data['from'] = @$basicinfofrom->first_name.' '.@$basicinfofrom->last_name;
				 
				 $basicinfoto = $this->employee_model->GetBasic($info->issuedby);
				 $data['to'] = $basicinfoto->first_name.' '.$basicinfoto->last_name; 

				
				 $data['serial'] = $serialno;
				 $data['serial'] = $serialno;
				 $data['serial'] = $serialno;

				  
				 
		          $formno = "P86";//$requestinfo->formno;
				 if ($formno = "P86")
			{
				$this->load->view('Stock/pdf',$data);
			}
			elseif($formno = "P93")
			{
				$this->load->view('Stock/pdf',$data);
			}
			 else{
				$this->load->view('Stock/pdf',$data);

			 }
			 
			}
			else{
				$this->load->view('Stock/StockList');
				//
				redirect(base_url());
			}
		}
	public function viewrequest($serialno)
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				
				 $data['request2'] = $this->Stampbureau->requestlist($serialno);
				 $data['request23'] = $this->Stampbureau->requestlist1($serialno);
				 $info = $this->Stampbureau->requestlist1($serialno);
				 $id = $info->RequestedBy;
				 $data['serial'] = $serialno;
				 $basicinfofrom = $this->employee_model->GetBasic($id);
				 $data['from'] = $basicinfofrom->first_name.' '.$basicinfofrom->last_name;
				 
				 // $basicinfoto = $this->employee_model->GetBasic($info->issuedby);
				 // $data['to'] = $basicinfoto->first_name.' '.$basicinfoto->last_name; 

				
				 $data['serial'] = $serialno;
				
		          $formno = $info->formno;
				 if ($formno = "P86")
			{
				$this->load->view('Stock/viewrequest',$data);
			}
			elseif($formno = "P93")
			{
				$this->load->view('Stock/viewrequest',$data);
			}
			 else{
				$this->load->view('Stock/viewrequest',$data);

			 }
			 
			}
			else{
				//$this->load->view('Stock/StockList');
				//
				redirect(base_url());
			}
		}


public function ViewReceived($serialno)
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				
				 $data['request2'] = $this->Stampbureau->requestlist($serialno);
				 $data['request23'] = $this->Stampbureau->requestlist1($serialno);
				 $info = $this->Stampbureau->requestlist1($serialno);
				 $id = $info->RequestedBy;
				 $data['serial'] = $serialno;
				 $basicinfofrom = $this->employee_model->GetBasic($id);
				 $data['from'] = @$basicinfofrom->first_name.' '.@$basicinfofrom->last_name;
				 
				 $basicinfoto = $this->employee_model->GetBasic($info->issuedby);
				 $data['to'] = $basicinfoto->first_name.' '.$basicinfoto->last_name; 

				
				 $data['serial'] = $serialno;

				  
				 
		          $formno = $info->formno;
				 if ($formno = "P86")
			{
				$this->load->view('Stock/ViewReceived',$data);
			}
			elseif($formno = "P93")
			{
				$this->load->view('Stock/ViewReceived',$data);
			}
			 else{
				$this->load->view('Stock/ViewReceived',$data);

			 }
			 
			}
			else{
				$this->load->view('Stock/StockList');
				//
				redirect(base_url());
			}
		}

		public function acceptReceived($serialno)
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				
				 $data['request2'] = $this->Stampbureau->requestlist($serialno);
				 $data['request23'] = $this->Stampbureau->requestlist1($serialno);
				 $info = $this->Stampbureau->requestlist1($serialno);
				 $id = $info->RequestedBy;
				 $data['serial'] = $serialno;
				 $basicinfofrom = $this->employee_model->GetBasic($id);
				 $data['from'] = @$basicinfofrom->first_name.' '.@$basicinfofrom->last_name;
				 
				 $basicinfoto = $this->employee_model->GetBasic($info->issuedby);
				 $data['to'] = $basicinfoto->first_name.' '.$basicinfoto->last_name; 

				
				 $data['serial'] = $serialno;

				  
				 
		          $formno = $info->formno;
				 if ($formno == "P86")
			{
				$this->load->view('Stock/acceptReceivedP86',$data);
			}
			elseif($formno == "P93")
			{
				$this->load->view('Stock/acceptReceived',$data);
			}
			 else{
				$this->load->view('Stock/acceptReceivedS64',$data);

			 }
			 
			}
			else{
				//$this->load->view('Stock/StockList');
				//
				redirect(base_url());
			}
		}

 public function Receivestock()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				  $id = $this->session->userdata('user_login_id');
				  //$serialno = base64_decode($this->input->get('k'));
				  $serialno=$this->input->post('serialno');
				  $ReceivedBy= $id;
				  $date = date('Y-m-d H:i:s');
				  $ReceivedDate=  $date ;
				  $IsReceved= "1";

				  $data = array(
						'ReceivedBy' => $ReceivedBy,
						'ReceivedDate' => $ReceivedDate,
						'IsReceved'=> $IsReceved,
					);
				  
		          
				$success = $this->Stampbureau->Update_stock_Request($data,$serialno);
				//add to its table
				$basicinfo = $this->employee_model->GetBasic($id);
	            $em_sub_role = $basicinfo->em_sub_role;
	            $em_region = $basicinfo->em_region;
	            $em_branch = $basicinfo->em_branch;

	            $list = $this->Stampbureau->requestlist($serialno);

	            if ($em_sub_role == "COUNTER") {
					foreach ($list as $key => $value) {
	            		$StockId = $value->StockId;
	            		//get stock by stock id
	            		$stock = $this->Stampbureau->getstockinfo($StockId);
	            		//save to db
				        $createddate= date('Y-m-d H:i:s');

				        $db="counterstock";
				
				$quantity = 0;
				$quantityy = $value->QuantitySupp;
				$lastquantity = $this->Stampbureau->getlastQuantity($StockId,$db);
				if ($lastquantity === null) {
					# code...
					$quantity =  $value->QuantitySupp;
				} else {
					# code...
					$quantity = $lastquantity->quantity + $quantityy;
				}
				


                $Stock_Categoryid =$stock->Stock_Categoryid;
                $StockId =$stock->StockId;
                $issuedate =$stock->issuedate;
                $enddate =$stock->enddate;
                $releasedate =$stock->releasedate;
                $stampname =$stock->stampname;
                $denomination =$stock->denomination;
                $pricepermint =$stock->pricepermint;
                $RequisitionFormId =$value->RequisitionFormId;
                $priceperfdcover =$stock->priceperfdcover;
                $totalpricepermint =$stock->totalpricepermint;
                $pricepersouverantsheet  =$stock->pricepersouverantsheet;
                $totalpricepersouverantsheet =$stock->totalpricepersouverantsheet;
                $totalpriceperfdcover =$stock->totalpriceperfdcover;
                
                          




                $data = array();
                $data = array(
					 'Stock_Categoryid' => $Stock_Categoryid,
					 'StockId' => $StockId,
                    'issuedate' => $issuedate,
                    'enddate' => $enddate,
                    'releasedate'=> $releasedate,
                    'stampname' => $stampname,
                    'denomination' => $denomination,

                    'quantity' => $quantity,

                    'pricepermint' => $pricepermint,
                    'pricepersouverantsheet' => $pricepersouverantsheet,
					'priceperfdcover' => $priceperfdcover,

					'createddate' => $createddate,
					'emp_id' => $id,
					'requisitionformId' => $RequisitionFormId,
					'Region' => $em_region,
					'RegionBranch' => $em_branch,

                    'totalpricepermint' => $totalpricepermint,
                    'totalpricepersouverantsheet'=>$totalpricepersouverantsheet ,
                    'totalpriceperfdcover'=> $totalpriceperfdcover ,
                );
               
                 $success = $this->Stampbureau->Addstocks($data,$db);


	            		# code...
	            	}

	            }

	            elseif($em_sub_role == "BRANCH"){
              

					foreach ($list as $key => $value) {
	            		$StockId = $value->StockId;
	            		//get stock by stock id

	            		 $stock = $this->Stampbureau->getstockinfo($StockId);


	            		//save to db
				$createddate= date('Y-m-d H:i:s');

				$db="branchstock";
				
				$quantity = 0;
				$quantityy = $value->QuantitySupp;
				$lastquantity = $this->Stampbureau->getlastQuantity($StockId,$db);
				if ($lastquantity === null) {
					# code...
					$quantity =  $value->QuantitySupp;
				} else {
					# code...
					$quantity = $lastquantity->quantity + $quantityy;
				}
				


                $Stock_Categoryid =$stock->Stock_Categoryid;
                $StockId =$stock->StockId;
                $issuedate =$stock->issuedate;
                $enddate =$stock->enddate;
                $releasedate =$stock->releasedate;
                $stampname =$stock->stampname;
                $denomination =$stock->denomination;
                $pricepermint =$stock->pricepermint;
                $RequisitionFormId =$value->RequisitionFormId;
                $priceperfdcover =$stock->priceperfdcover;
                $totalpricepermint =$stock->totalpricepermint;
                $pricepersouverantsheet  =$stock->pricepersouverantsheet;
                $totalpricepersouverantsheet =$stock->totalpricepersouverantsheet;
                $totalpriceperfdcover =$stock->totalpriceperfdcover;
                
                          




                $data = array();
                $data = array(
					 'Stock_Categoryid' => $Stock_Categoryid,
					 'StockId' => $StockId,
                    'issuedate' => $issuedate,
                    'enddate' => $enddate,
                    'releasedate'=> $releasedate,
                    'stampname' => $stampname,
                    'denomination' => $denomination,

                    'quantity' => $quantity,

                    'pricepermint' => $pricepermint,
                    'pricepersouverantsheet' => $pricepersouverantsheet,
					'priceperfdcover' => $priceperfdcover,

					'createddate' => $createddate,
					'emp_id' => $id,
					'requisitionformId' => $RequisitionFormId,
					'Region' => $em_region,
					'RegionBranch' => $em_branch,

                    'totalpricepermint' => $totalpricepermint,
                    'totalpricepersouverantsheet'=>$totalpricepersouverantsheet ,
                    'totalpriceperfdcover'=> $totalpriceperfdcover ,
                );
               
                 $success = $this->Stampbureau->Addstocks($data,$db);
                 


	            }
	        }
	            elseif ($em_sub_role == "STRONGROOM") {

	            	foreach ($list as $key => $value) {
	            		$StockId = $value->StockId;
	            		//get stock by stock id

	            		 $stock = $this->Stampbureau->getstockinfo($StockId);


	            		//save to db
				$createddate= date('Y-m-d H:i:s');

				
				 $db="strongroomstock";
				$quantity = 0;
				$quantityy = $value->QuantitySupp;
				$lastquantity = $this->Stampbureau->getlastQuantity($StockId,$db);
				if ($lastquantity === null) {
					# code...
					$quantity =  $value->quantityy;
				} else {
					# code...
					$quantity = $lastquantity->quantity + $quantityy;
				}
				


                $Stock_Categoryid =$stock->Stock_Categoryid;
                $StockId =$stock->StockId;
                $issuedate =$stock->issuedate;
                $enddate =$stock->enddate;
                $releasedate =$stock->releasedate;
                $stampname =$stock->stampname;
                $denomination =$stock->denomination;
                $pricepermint =$stock->pricepermint;
                $RequisitionFormId =$value->RequisitionFormId;
                $priceperfdcover =$stock->priceperfdcover;
                $totalpricepermint =$stock->totalpricepermint;
                $pricepersouverantsheet  =$stock->pricepersouverantsheet;
                $totalpricepersouverantsheet =$stock->totalpricepersouverantsheet;
                $totalpriceperfdcover =$stock->totalpriceperfdcover;
                
                          




                $data = array();
                $data = array(
					 'Stock_Categoryid' => $Stock_Categoryid,
					 'StockId' => $StockId,
                    'issuedate' => $issuedate,
                    'enddate' => $enddate,
                    'releasedate'=> $releasedate,
                    'stampname' => $stampname,
                    'denomination' => $denomination,

                    'quantity' => $quantity,

                    'pricepermint' => $pricepermint,
                    'pricepersouverantsheet' => $pricepersouverantsheet,
					'priceperfdcover' => $priceperfdcover,

					'createddate' => $createddate,
					'emp_id' => $id,
					'requisitionformId' => $RequisitionFormId,
					'Region' => $em_region,
					'RegionBranch' => $em_branch,

                    'totalpricepermint' => $totalpricepermint,
                    'totalpricepersouverantsheet'=>$totalpricepersouverantsheet ,
                    'totalpriceperfdcover'=> $totalpriceperfdcover ,
                );

                 $success = $this->Stampbureau->Addstocks($data,$db);
                 //$success = $this->Stampbureau->AddstocksStrong($data);


                 //apunguze kwenye higher rank db
                 

	              }
	           
			
			    echo "Successfully Added" . $success;
			
			 //$this->load->view('Stock/ReceivedList');
			}
		}
			else{
				//$this->load->view('Stock/ViewReceived');
				//
				redirect(base_url());
			}
		}


      public function Counter_RequestEdit()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				  $serialno = base64_decode($this->input->get('k'));
				
				 $data['request2'] = $this->Stampbureau->requestlist($serialno);
				 $info = $this->Stampbureau->requestlist1($serialno);
				
				 $basicinfofrom = $this->employee_model->GetBasic($info->RequestedBy);
				 $data['from'] = @$basicinfofrom->first_name.' '.@$basicinfofrom->last_name;
				  
				  $data['serial'] = $serialno;
		          $formno = $info->formno;
				 if ($formno == "P86")
			{
				$this->load->view('Stock/CounterRequestEdit',$data);
			}
			elseif($formno == "P93")
			{
				$this->load->view('Stock/BranchRequestEdit',$data);
			}
			 elseif($formno == "S64"){
				$this->load->view('Stock/StrongroomRequestEdit',$data);

			 }
			 
			}
			else{
				//$this->load->view('Stock/stocklistid');
				//
				redirect(base_url());
			}
		}

// public function Branch_RequestEdit($serialno)
// 		{
// 			if ($this->session->userdata('user_login_access') != false)
// 			{
				
// 				 $data['request2'] = $this->Stampbureau->requestlist($serialno);
// 				 $info = $this->Stampbureau->requestlist1($serialno);
				
// 				 $basicinfofrom = $this->employee_model->GetBasic($info->RequestedBy);
// 				 $data['from'] = @$basicinfofrom->first_name.' '.@$basicinfofrom->last_name;
				  
// 				  $data['serial'] = $serialno;
// 		          $formno = $info->formno;
// 				 if ($formno = "P86")
// 			{
// 				$this->load->view('Stock/CounterRequestEdit',$data);
// 			}
// 			elseif($formno = "P93")
// 			{
// 				$this->load->view('Stock/BranchRequestEdit',$data);
// 			}
// 			 else{
// 				$this->load->view('Stock/StrongroomRequestEdit',$data);

// 			 }
			 
// 			}
// 			else{
// 				$this->load->view('Stock/stocklistid');
// 				//
// 				redirect(base_url());
// 			}
// 		}

// public function StrongRoom_RequestEdit($serialno)
// 		{
// 			if ($this->session->userdata('user_login_access') != false)
// 			{
				
// 				 $data['request2'] = $this->Stampbureau->requestlist($serialno);
// 				 $info = $this->Stampbureau->requestlist1($serialno);
				
// 				 $basicinfofrom = $this->employee_model->GetBasic($info->RequestedBy);
// 				 $data['from'] = @$basicinfofrom->first_name.' '.@$basicinfofrom->last_name;
				  
// 				  $data['serial'] = $serialno;
// 		          $formno = "P86";//$requestinfo->formno;
// 				 if ($formno = "P86")
// 			{
// 				$this->load->view('Stock/CounterRequestEdit',$data);
// 			}
// 			elseif($formno = "P93")
// 			{
// 				$this->load->view('Stock/BranchRequestEdit',$data);
// 			}
// 			 else{
// 				$this->load->view('Stock/StrongroomRequestEdit',$data);

// 			 }
			 
// 			}
// 			else{
// 				$this->load->view('Stock/stocklistid');
// 				//
// 				redirect(base_url());
// 			}
// 		}


		public function Branch_Request()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				
				 $data['philatel'] = $this->Stampbureau->philatelist();
				  $data['serial'] = $this->Stampbureau->lastserialnumber() ;
				   $data['stock'] = $this->Stampbureau->getstocklist();
				$this->load->view('Stock/BranchRequest',$data);
			}
			else{
				redirect(base_url());
			}
		}
		public function stocklistid(){
			$stockid = $this->input->post('stock',TRUE);  
			//run the query for the cities we specified earlier  
			echo $this->Stampbureau->Getprice($stockid);
		  
		  }
		public function StrongRoom()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				
				 $data['philatel'] = $this->Stampbureau->philatelist();
				 $data['serial'] = $this->Stampbureau->lastserialnumber() ;
				 $data['stock'] = $this->Stampbureau->getstocklist();
				$this->load->view('Stock/StrongRoomRequest',$data);
			}
			else{
				redirect(base_url());
			}
		}

		public function StockBoard()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				 $data['stocklist'] = $this->inventory_model->Stock_List();
                $data['stockno'] = $this->inventory_model->Count_Stock();
                $data['cashno'] = $this->inventory_model->Count_Cash();
                $data['locksno'] = $this->inventory_model->Count_Locks();
                $data['stampno'] = 0;//$this->inventory_model->Count_Stampbureau();
				
				 $data['philatel'] = $this->Stampbureau->philatelist();
				$this->load->view('Stock/StampBureauandStock',$data);
			}
			else{
				redirect(base_url());
			}
		}
	public function StockRequest()
		{
			if ($this->session->userdata('user_login_access') != false)
			{

                $empid = $this->session->userdata('user_login_id');

				 $data1 = "0";
				 $data['stock'] = $this->Stampbureau->requestedrequisation($data1,$empid);
				$this->load->view('Stock/Request',$data);
			}
			else{
				redirect(base_url());
			}
		}
		
		public function StampBureauandStock()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				$data['region'] = $this->employee_model->regselect();
				$data['category'] = $this->billing_model->getAllCategory();
				$data['listItem'] = $this->billing_model->getAllCategoryBill();

				$this->load->view('Stock/Stock-Board',$data);
			}
			else{
				redirect(base_url());
			}
		}

		public function StampBureau()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				$data1 = "1";
				 $data['stock'] = $this->Stampbureau->stocklist($data1);
				$this->load->view('Stock/StampBureau',$data);
			}
			else{
				redirect(base_url());
			}
		}


		public function Stamplist()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				$data1 = "2";
				
				 $data['stock'] = $this->Stampbureau->stocklist($data1);
				$this->load->view('Stock/Stamplist',$data);
			}
			else{
				redirect(base_url());
			}
		}


		public function Cashlist()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				$data1 = "8";
				
				 $data['stock'] = $this->Stampbureau->stocklist($data1);
				$this->load->view('Stock/Cashlist',$data);
			}
			else{
				redirect(base_url());
			}
		}

		public function Locklist()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				$data1 = "9";
				
				 $data['stock'] = $this->Stampbureau->stocklist($data1);
				$this->load->view('Stock/Locklist',$data);
			}
			else{
				redirect(base_url());
			}
		}

		public function Otherlist()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				$data1 = "3";
				
				 $data['stock'] = $this->Stampbureau->stocklist($data1);
				$this->load->view('Stock/Otherlist',$data);
			}
			else{
				redirect(base_url());
			}
		}
		public function Requisition_Form()//unissued requisition
		{
			 // $info = $this->Stampbureau->requestlist1($serialno);
			 // $id = $info->RequestedBy;
			if ($this->session->userdata('user_login_access') != false)
			{
				$empid = $this->session->userdata('user_login_id');

				$basicinfo = $this->employee_model->GetBasic($empid);
	            $em_sub_role = $basicinfo->em_sub_role;
	            $em_region = $basicinfo->em_region;
	            $em_branch = $basicinfo->em_branch;
	            if($em_sub_role == "BRANCH"){
	            	 //aone request zote za branch yake kutoka kwa counter
				  $data1 = "0";
				  $takefromrole = "COUNTER";
				 $data['stock'] = $this->Stampbureau->requisationbranch($data1,$em_branch,$takefromrole);
				$this->load->view('Stock/RequisitionForm',$data);

	            }
	            elseif ($em_sub_role == "STRONGROOM") {
	             //aone request zote za mkoa wake kutoka kwa branch
				  $data1 = "0";
				  $takefromrole = "BRANCH";
				 $data['stock'] = $this->Stampbureau->requisationstrong($data1,$em_region,$takefromrole);
				$this->load->view('Stock/RequisitionForm',$data);
	            	
	            }
	            elseif ($em_sub_role == "STORE") {
	            	 //aone request zote za mikoa yote kutoka kwa strongroom
				  $data1 = "0";
				   $takefromrole = "STRONGROOM";
				 $data['stock'] = $this->Stampbureau->requisationlistStore($data1,$takefromrole);
				$this->load->view('Stock/RequisitionForm',$data);
	            	
	            }

	           //redirect(base_url());
			}
			else{
				redirect(base_url());
			}
		}


		public function IssuedList()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				$empid = $this->session->userdata('user_login_id');

				$basicinfo = $this->employee_model->GetBasic($empid);
	            $em_sub_role = $basicinfo->em_sub_role;
	            $em_region = $basicinfo->em_region;
	            $em_branch = $basicinfo->em_branch;
	            if($em_sub_role == "BRANCH"){
	            	 //aone request zote za branch yake kutoka kwa counter
				  $data1 = "1";
				  $takefromrole = "COUNTER";
				 $data['stock'] = $this->Stampbureau->requisationbranch($data1,$em_branch,$takefromrole);
				$this->load->view('Stock/IssuedList',$data);
	            }
	            elseif ($em_sub_role == "STRONGROOM") {
	             //aone request zote za mkoa wake kutoka kwa branch
				  $data1 = "1";
				  $takefromrole = "BRANCH";
				 $data['stock'] = $this->Stampbureau->requisationstrong($data1,$em_region,$takefromrole);
				$this->load->view('Stock/IssuedList',$data);
	            	
	            }
	            elseif ($em_sub_role == "STORE") {
	            	 //aone request zote za mikoa yote kutoka kwa strongroom
				  $data1 = "1";
				   $takefromrole = "STRONGROOM";
				 $data['stock'] = $this->Stampbureau->requisationlistStore($data1,$takefromrole);
				$this->load->view('Stock/IssuedList',$data);
	            	
	            }

				//$this->load->view('Stock/IssuedList',$data);
			}
			else{
				redirect(base_url());
			}
		}

public function ReceivedList()
		{

			if ($this->session->userdata('user_login_access') != false)
			{
				$empid = $this->session->userdata('user_login_id');
				$data1 = "1";
				
				 $data['stock'] = $this->Stampbureau->received($data1,$empid);
				$this->load->view('Stock/ReceivedList',$data);
			}
			else{
				redirect(base_url());
			}
		}

public function Receive()
		{

			if ($this->session->userdata('user_login_access') != false)
			{
				$empid = $this->session->userdata('user_login_id');
				$data1 = "0";
				
				 $data['stock'] = $this->Stampbureau->receive($data1,$empid);
				$this->load->view('Stock/Receive',$data);
			}
			else{
				redirect(base_url());
			}
		}



	 public function Add_philatel(){
        if($this->session->userdata('user_login_access') != False) { 
            $data['region'] = $this->employee_model->regselect();
        $this->load->view('Stock/add-philatel',$data);
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }

     public function Add_stamp(){
        if($this->session->userdata('user_login_access') != False) { 
            $data['region'] = $this->employee_model->regselect();
        $this->load->view('Stock/add-stamp',$data);
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
		public function Add_cash(){
        if($this->session->userdata('user_login_access') != False) { 
            $data['region'] = $this->employee_model->regselect();
        $this->load->view('Stock/add-cash',$data);
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
    public function Add_lock(){
        if($this->session->userdata('user_login_access') != False) { 
            $data['region'] = $this->employee_model->regselect();
        $this->load->view('Stock/add-lock',$data);
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
public function Add_other(){
        if($this->session->userdata('user_login_access') != False) { 
            $data['region'] = $this->employee_model->regselect();
        $this->load->view('Stock/add-other',$data);
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }




public function Savephilatel(){ 
    if($this->session->userdata('user_login_access') != False) {     
    $issuedates = $this->input->post('issuedate');  
      $dayissue = date('d', strtotime($issuedates)); $monthissue = date('m', strtotime($issuedates)); $yearissue = date('Y', strtotime($issuedates));
    $issuedate =($yearissue).'-'.$monthissue.'-'.$dayissue; 

    $enddates = $this->input->post('enddate');   
     $dayend = date('d', strtotime($enddates)); $monthend = date('m', strtotime($enddates)); $yearend = date('Y', strtotime($enddates));
    $enddate =($yearend).'-'.$monthend.'-'.$dayend; 

	$stampname = $this->input->post('stampname');
    $denomination = $this->input->post('denomination');
	$quantity = $this->input->post('quantity');
   
	$pricepermint = $this->input->post('pricepermint');
	$pricepersouverantsheet = $this->input->post('pricepersouverantsheet');
	$priceperfdcover = $this->input->post('priceperfdcover');

	$totalpricepermint = $pricepermint * $quantity;
	$totalpricepersouverantsheet = $pricepersouverantsheet * $quantity;
	$totalpriceperfdcover = $priceperfdcover * $quantity;
    $this->load->library('form_validation');
	   // $this->form_validation->set_error_delimiters();
 //get last stockid
 $result= $this->Stampbureau->getlastStockId();
 $StockId= $result + 1;
 
	   
	   $id = $this->session->userdata('user_login_id');
	   $basicinfo = $this->employee_model->GetBasic($id);
	   $em_id = $basicinfo->em_id;
	   $date = date('Y-m-d H:i:s');
		 $Stock_Categoryid = "1";   
		 $createddate = $date;
		 $createdby = $em_id ;
			{
                $data = array();
                $data = array(
					 'Stock_Categoryid' => $Stock_Categoryid,
					 'StockId' => $StockId,
                    'issuedate' => $issuedate,
                    'enddate' => $enddate,
                    'releasedate'=> $enddate,
                    'stampname' => $stampname,
                    'denomination' => $denomination,
                    'quantity' => $quantity,
                    'pricepermint' => $pricepermint,
                    'pricepersouverantsheet' => $pricepersouverantsheet,
					'priceperfdcover' => $priceperfdcover,

					'createddate' => $createddate,
					'createdby' => $createdby,
					

                    'totalpricepermint' => $totalpricepermint,
                    'totalpricepersouverantsheet'=>$totalpricepersouverantsheet ,
                    'totalpriceperfdcover'=> $totalpriceperfdcover ,
                );
               
            $success = $this->Stampbureau->Addstamp($data);
            #$this->confirm_mail_send($email,$pass_hash);        
            echo "Successfully Added" . $success;
            #redirect('employee/Add_employee');   
             //$this->session->set_flashdata('feedback','Successfully Created');                  
               
            }
            
        }
        
      else{
		redirect(base_url() , 'refresh');
	       }   
		}
public function Savestamp(){ 
    if($this->session->userdata('user_login_access') != False) {     
    $issuedates = $this->input->post('issuedate');  
      $dayissue = date('d', strtotime($issuedates)); $monthissue = date('m', strtotime($issuedates)); $yearissue = date('Y', strtotime($issuedates));
    $issuedate =($yearissue).'-'.$monthissue.'-'.$dayissue; 

    $enddates = $this->input->post('enddate');   
     $dayend = date('d', strtotime($enddates)); $monthend = date('m', strtotime($enddates)); $yearend = date('Y', strtotime($enddates));
    $enddate =($yearend).'-'.$monthend.'-'.$dayend; 

	$stampname = $this->input->post('stampname');
    $denomination = $this->input->post('denomination');
	$quantity = $this->input->post('quantity');
   
	$pricepermint = $this->input->post('pricepermint');
	$pricepersouverantsheet = $this->input->post('pricepersouverantsheet');
	$priceperfdcover = $this->input->post('priceperfdcover');

	$totalpricepermint = $pricepermint * $quantity;
	$totalpricepersouverantsheet = $pricepersouverantsheet * $quantity;
	$totalpriceperfdcover = $priceperfdcover * $quantity;
    $this->load->library('form_validation');
       // $this->form_validation->set_error_delimiters();
    //get last stockid
 $result= $this->Stampbureau->getlastStockId();
 $StockId= $result + 1;
 
	   
	   $id = $this->session->userdata('user_login_id');
	   $basicinfo = $this->employee_model->GetBasic($id);
	   $em_id = $basicinfo->em_id;
	   $date = date('Y-m-d H:i:s');
		 $Stock_Categoryid = "2";   
		 $createddate = $date;
		 $createdby = $em_id ;
			{
                $data = array();
                $data = array(
					 'Stock_Categoryid' => $Stock_Categoryid,
					 'StockId' => $StockId,
		   
					 'createddate' => $createddate,
					'createdby' => $createdby,
					

                    'issuedate' => $issuedate,
                    'enddate' => $enddate,
                    'releasedate'=> $enddate,
                    'stampname' => $stampname,
                    'denomination' => $denomination,
                    'quantity' => $quantity,
                    'pricepermint' => $pricepermint,
                    'pricepersouverantsheet' => $pricepersouverantsheet,
					'priceperfdcover' => $priceperfdcover,
					

                    'totalpricepermint' => $totalpricepermint,
                    'totalpricepersouverantsheet'=>$totalpricepersouverantsheet ,
                    'totalpriceperfdcover'=> $totalpriceperfdcover ,
                );
               
            $success = $this->Stampbureau->Addstamp($data);
            #$this->confirm_mail_send($email,$pass_hash);        
            echo "Successfully Added" . $success;
            #redirect('employee/Add_employee');   
             //$this->session->set_flashdata('feedback','Successfully Created');                  
               
            }
            
        }
        
      else{
		redirect(base_url() , 'refresh');
	       }   
		}

	public function Savelock(){ 
    if($this->session->userdata('user_login_access') != False) {     
    $issuedates = $this->input->post('issuedate');  
      $dayissue = date('d', strtotime($issuedates)); $monthissue = date('m', strtotime($issuedates)); $yearissue = date('Y', strtotime($issuedates));
    $issuedate =($yearissue).'-'.$monthissue.'-'.$dayissue; 

    $enddates = $this->input->post('enddate');   
     $dayend = date('d', strtotime($enddates)); $monthend = date('m', strtotime($enddates)); $yearend = date('Y', strtotime($enddates));
    $enddate =($yearend).'-'.$monthend.'-'.$dayend; 

	$stampname = $this->input->post('stampname');
    //$denomination = $this->input->post('denomination');
	$quantity = $this->input->post('quantity');
   
	$pricepermint = $this->input->post('pricepermint');
	//$pricepersouverantsheet = $this->input->post('pricepersouverantsheet');
	//$priceperfdcover = $this->input->post('priceperfdcover');

	$totalpricepermint = $pricepermint * $quantity;
	//$totalpricepersouverantsheet = $pricepersouverantsheet * $quantity;
	//$totalpriceperfdcover = $priceperfdcover * $quantity;
    $this->load->library('form_validation');
       //get last stockid
 $result= $this->Stampbureau->getlastStockId();
 $StockId= $result + 1;
 
	   
	   $id = $this->session->userdata('user_login_id');
	   $basicinfo = $this->employee_model->GetBasic($id);
	   $em_id = $basicinfo->em_id;
	   $date = date('Y-m-d H:i:s');
		 $Stock_Categoryid = "9";   
		 $createddate = $date;
		 $createdby = $em_id ;
			{
                $data = array();
                $data = array(
					 'Stock_Categoryid' => $Stock_Categoryid,
					 'StockId' => $StockId,
		   
					 'createddate' => $createddate,
					'createdby' => $createdby,
                    'issuedate' => $issuedate,
                    'enddate' => $enddate,
                    'releasedate'=> $enddate,
                    'stampname' => $stampname,
                    //'denomination' => $denomination,
                    'quantity' => $quantity,
                    'pricepermint' => $pricepermint,
                    //'pricepersouverantsheet' => $pricepersouverantsheet,
					//'priceperfdcover' => $priceperfdcover,
					

                    'totalpricepermint' => $totalpricepermint,
                   // 'totalpricepersouverantsheet'=>$totalpricepersouverantsheet ,
                    //'totalpriceperfdcover'=> $totalpriceperfdcover ,
                );
               
            $success = $this->Stampbureau->Addstamp($data);
            #$this->confirm_mail_send($email,$pass_hash);        
            echo "Successfully Added" . $success;
            #redirect('employee/Add_employee');   
             //$this->session->set_flashdata('feedback','Successfully Created');                  
               
            }
            
        }
        
      else{
		redirect(base_url() , 'refresh');
	       }   
		}

public function Savecash(){ 
    if($this->session->userdata('user_login_access') != False) {     
    $issuedates = $this->input->post('issuedate');  
      $dayissue = date('d', strtotime($issuedates)); $monthissue = date('m', strtotime($issuedates)); $yearissue = date('Y', strtotime($issuedates));
    $issuedate =($yearissue).'-'.$monthissue.'-'.$dayissue; 

    $enddates = $this->input->post('enddate');   
     $dayend = date('d', strtotime($enddates)); $monthend = date('m', strtotime($enddates)); $yearend = date('Y', strtotime($enddates));
    $enddate =($yearend).'-'.$monthend.'-'.$dayend; 

	$stampname = $this->input->post('stampname');
    //$denomination = $this->input->post('denomination');
	$quantity = $this->input->post('quantity');
   
	$pricepermint = $this->input->post('pricepermint');
	//$pricepersouverantsheet = $this->input->post('pricepersouverantsheet');
	//$priceperfdcover = $this->input->post('priceperfdcover');

	$totalpricepermint = $pricepermint * $quantity;
	//$totalpricepersouverantsheet = $pricepersouverantsheet * $quantity;
	//$totalpriceperfdcover = $priceperfdcover * $quantity;
    $this->load->library('form_validation');
       // $this->form_validation->set_error_delimiters();
    
        //get last stockid
 $result= $this->Stampbureau->getlastStockId();
 $StockId= $result + 1;
 
	   
	   $id = $this->session->userdata('user_login_id');
	   $basicinfo = $this->employee_model->GetBasic($id);
	   $em_id = $basicinfo->em_id;
	   $date = date('Y-m-d H:i:s');
		 $Stock_Categoryid = "8";   
		 $createddate = $date;
		 $createdby = $em_id ;
			{
                $data = array();
                $data = array(
					 'Stock_Categoryid' => $Stock_Categoryid,
					 'StockId' => $StockId,
		   
					 'createddate' => $createddate,
					'createdby' => $createdby,
                    'issuedate' => $issuedate,
                    'enddate' => $enddate,
                    'releasedate'=> $enddate,
                    'stampname' => $stampname,
                    //'denomination' => $denomination,
                    'quantity' => $quantity,
                    'pricepermint' => $pricepermint,
                   // 'pricepersouverantsheet' => $pricepersouverantsheet,
					//'priceperfdcover' => $priceperfdcover,
					

                    'totalpricepermint' => $totalpricepermint,
                   // 'totalpricepersouverantsheet'=>$totalpricepersouverantsheet ,
                   // 'totalpriceperfdcover'=> $totalpriceperfdcover ,
                );
               
            $success = $this->Stampbureau->Addstamp($data);
            #$this->confirm_mail_send($email,$pass_hash);        
            echo "Successfully Added" . $success;
            #redirect('employee/Add_employee');   
             //$this->session->set_flashdata('feedback','Successfully Created');                  
               
            }
            
        }
        
      else{
		redirect(base_url() , 'refresh');
	       }   
		}
		
		public function SaveRequest(){
        if($this->session->userdata('user_login_access') != False) { 
           echo "kiwi";
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
		



	public function Savestrongroomrequest(){ 
		if($this->session->userdata('user_login_access') != False) {  
			

			for ($i = 0; $i<count($this->input->post('QuantityReq')); $i++){
				
				$formno=$this->input->post('formno');
				$serialno=$this->input->post('serialno');
				$issuedby=$this->input->post('issuedby');
				//$stampname = $this->input->post('stampname');
				$RequestedBy = $this->input->post('RequestedBy');
				$QuantityReq = $this->input->post('QuantityReq['.$i.']');
				$StockId = $this->input->post('StockId['.$i.']');

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
							   'StockId'=> $StockId,
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
		
				
			}
			
		  else{
			redirect(base_url() , 'refresh');
			   }   
			}


		public function IssueRequisition(){ 
		
		if($this->session->userdata('user_login_access') != False) {  

         


			
			for ($i = 0; $i<count($this->input->post('QuantitySupp')); $i++){

				$StockId=$this->input->post('StockIdd['.$i.']');
			$serialno=$this->input->post('serialno');
			$issuedby=$this->input->post('issuedby');
			$QuantitySupp = $this->input->post('QuantitySupp['.$i.']');
 			$date = date('Y-m-d H:i:s');
		     $issuedate = $date; 
			 $IsIssued =1;  
			
		
		          $id = $this->session->userdata('user_login_id');
                	$basicinfo = $this->employee_model->GetBasic($id);
		            $em_sub_role = $basicinfo->em_sub_role;
		            $em_region = $basicinfo->em_region;
		            $em_branch = $basicinfo->em_branch;
		             $em_id = $basicinfo->em_id;
				     $date = date('Y-m-d H:i:s'); 
					 $createddate = $date;
					 $createdby = $em_id ;


					 $QuantitySupp = (int)$QuantitySupp;



					 $reqzform= $this->Stampbureau->requestlist12($serialno,$StockId);
					  $RequisitionFormId = $reqzform->RequisitionFormId;
        //check kama aredy approved
			$isaproved= $this->Stampbureau->getisapproved($serialno);
			$stockprice = $this->Stampbureau->geStockprice($StockId);
			$Totalamount = $QuantitySupp * $stockprice;
            //echo $isaproved.'knecec';
			if($isaproved == 0)
			{

                  
					
					$data = array();
					$data = array(
						'issuedby' => $issuedby,
						'issuedate' => $issuedate,
						'QuantitySupp'=> $QuantitySupp,
						'IsIssued' =>$IsIssued,
						'Totalamount' =>$Totalamount,
						
					);
				  
		
					$success = $this->Stampbureau->Update_stock_Request_form($data,$serialno,$StockId);
					
			
				{
					
		           
		             if($em_sub_role == "BRANCH"){

		             			//reduce from stock-pmu
                   //by stockid get  previous quantity
		            $db="branchstock";
				   $result= $this->Stampbureau->getpreviousQuantity($db,$StockId);
				   $previousQuantity= $result->quantity;

				   $latestquantity = $previousQuantity-$QuantitySupp;
				   //create new stock
							$data2 = array();
							$data2 = array(
								'StockId' => $result->StockId,
								 'Stock_Categoryid' => $result->Stock_Categoryid,

								'issuedate' => $result->issuedate,
								'enddate' => $result->enddate,
								'releasedate'=> $issuedate,
								'stampname' => $result->stampname,
								'denomination' => $result->denomination,
								'quantity' => $latestquantity,
								'pricepermint' => $result->pricepermint,
								'pricepersouverantsheet' => $result->pricepersouverantsheet,
								'priceperfdcover' => $result->priceperfdcover,
			
								'createddate' => $createddate,
								//'createdby' => $createdby,
								
								'emp_id' => $em_id,
								'requisitionformId' => $RequisitionFormId,
								'Region' => $em_region,
								'RegionBranch' => $em_branch,
			
								'totalpricepermint' => $result->totalpricepermint,
								'totalpricepersouverantsheet'=>$result->totalpricepersouverantsheet ,
								'totalpriceperfdcover'=> $result->totalpriceperfdcover ,
							);
						   
						$success = $this->Stampbureau->Addstocks2($data2,$db);
		            	
		            }
		             elseif($em_sub_role == "STRONGROOM"){
		             		//reduce from stock-pmu
                   //by stockid get  previous quantity
		            $db="strongroomstock";
				   $result= $this->Stampbureau->getpreviousQuantity($db,$StockId);
				   $latestquantity =0;
				   if ($result === null) {
				   $latestquantity =0;

				   } else {
				   	$previousQuantity= $result->quantity;

				   $latestquantity = $previousQuantity-$QuantitySupp;
				   //create new stock
				   	# code...
				   }
				  

			    $Stock_Categoryid =@$result->Stock_Categoryid;
                $StockId =@$result->StockId;
               
                $enddate =@$result->enddate;
                $releasedate =@$result->releasedate;
                $stampname =@$result->stampname;
                $denomination =@$result->denomination;
                $pricepermint =@$result->pricepermint;
                $priceperfdcover =@$result->priceperfdcover;
                $totalpricepermint =@$result->totalpricepermint;
                $pricepersouverantsheet  =@$result->pricepersouverantsheet;
                $totalpricepersouverantsheet =@$result->totalpricepersouverantsheet;
                $totalpriceperfdcover =@$result->totalpriceperfdcover;
				   
				   
							$data2 = array();
							$data2 = array(
								'StockId' => $StockId,
								 'Stock_Categoryid' => $Stock_Categoryid,

								'issuedate' =>  $issuedate,
								'enddate' => $enddate,
								'releasedate'=> $issuedate,
								'stampname' => $stampname,
								'denomination' => $denomination,
								'quantity' => $latestquantity,
								'pricepermint' => $pricepermint,
								'pricepersouverantsheet' => $pricepersouverantsheet,
								'priceperfdcover' => $priceperfdcover,
			
								'createddate' => $createddate,
								//'createdby' => $createdby,

								'Emp_id' => $em_id,
								'requisitionformId' => $RequisitionFormId,
								'Region' => $em_region,
								'RegionBranch' => $em_branch,
								
								'totalpricepermint' => $totalpricepermint,
								'totalpricepersouverantsheet'=>$totalpricepersouverantsheet,
								'totalpriceperfdcover'=> $totalpriceperfdcover,
							);
						   
						$success = $this->Stampbureau->Addstocks2($data2,$db);
						echo "Successfully " ;
		            	
		            }

		             elseif($em_sub_role == "STORE"){

		             	//reduce from stock-pmu
                   //by stockid get  previous quantity
		            $db="stock";
				   $result= $this->Stampbureau->getpreviousQuantity($db,$StockId);
				   $previousQuantity= $result->quantity;

				   $latestquantity = $previousQuantity-$QuantitySupp;
				   //create new stock
							$data2 = array();
							$data2 = array(
								'StockId' => $result->StockId,
								 'Stock_Categoryid' => $result->Stock_Categoryid,

								'issuedate' => $result->issuedate,
								'enddate' => $result->enddate,
								'releasedate'=> $issuedate,
								'stampname' => $result->stampname,
								'denomination' => $result->denomination,
								'quantity' => $latestquantity,
								'pricepermint' => $result->pricepermint,
								'pricepersouverantsheet' => $result->pricepersouverantsheet,
								'priceperfdcover' => $result->priceperfdcover,
			
								'createddate' => $createddate,
								'createdby' => $createdby,
								
			
								'totalpricepermint' => $result->totalpricepermint,
								'totalpricepersouverantsheet'=>$result->totalpricepersouverantsheet ,
								'totalpriceperfdcover'=> $result->totalpriceperfdcover ,
							);
						   
						$success = $this->Stampbureau->Addstocks2($data2,$db);

		            }



                  
               
				   
				}
                


			}
			else
			{

				
					$data = array();
					$data = array(
						'issuedby' => $issuedby,
						'issuedate' => $issuedate,
						'QuantitySupp'=> $QuantitySupp,
						'IsIssued' =>$IsIssued,
						'Totalamount' =>$Totalamount,
						
					);
				  
		
					$success = $this->Stampbureau->Update_stock_Request_form($data,$serialno,$StockId);


                {
                	
                  //reduce from stock-pmu
                   //by stockid get  previous quantity
                	 if($em_sub_role == "BRANCH"){

                	 	 $db="branchstock";
				   $result= $this->Stampbureau->getpreviousQuantity($db,$StockId);
				   $previousQuantity= $result->quantity;

				   $latestquantity = $previousQuantity-$QuantitySupp;
				   //create new stock
							$data2 = array();
							$data2 = array(
								'StockId' => $result->StockId,
								 'Stock_Categoryid' => $result->Stock_Categoryid,

								'issuedate' => $result->issuedate,
								'enddate' => $result->enddate,
								'releasedate'=> $issuedate,
								'stampname' => $result->stampname,
								'denomination' => $result->denomination,
								'quantity' => $latestquantity,
								'pricepermint' => $result->pricepermint,
								'pricepersouverantsheet' => $result->pricepersouverantsheet,
								'priceperfdcover' => $result->priceperfdcover,
			
								'createddate' => $createddate,
								//'createdby' => $createdby,
								
								'emp_id' => $em_id,
								'requisitionformId' => $RequisitionFormId,
								'Region' => $em_region,
								'RegionBranch' => $em_branch,
								

								'totalpricepermint' => $result->totalpricepermint,
								'totalpricepersouverantsheet'=>$result->totalpricepersouverantsheet ,
								'totalpriceperfdcover'=> $result->totalpriceperfdcover ,
							);
						   
						$success = $this->Stampbureau->Addstocks2($data2,$db);
		            	
		            }
		             elseif($em_sub_role == "STRONGROOM"){
		             	//reduce from stock-pmu

		             	 $db="strongroomstock";
				   $result= $this->Stampbureau->getpreviousQuantity($db,$StockId);
				   $latestquantity = 0;
				   if ( $result === null) {
				   	# code...
				   	$latestquantity = 0;
				   } else {
				   	 $previousQuantity= $result->quantity;

				   $latestquantity = $previousQuantity-$QuantitySupp;
				   	# code...
				   }
				   
				  
				   //create new stock
							$data2 = array();
							$data2 = array(
								'StockId' => $result->StockId,
								 'Stock_Categoryid' => $result->Stock_Categoryid,

								'issuedate' => $result->issuedate,
								'enddate' => $result->enddate,
								'releasedate'=> $issuedate,
								'stampname' => $result->stampname,
								'denomination' => $result->denomination,
								'quantity' => $latestquantity,
								'pricepermint' => $result->pricepermint,
								'pricepersouverantsheet' => $result->pricepersouverantsheet,
								'priceperfdcover' => $result->priceperfdcover,
			
								'createddate' => $createddate,
								//'createdby' => $createdby,
								

								'Emp_id' => $em_id,
								'requisitionformId' => $RequisitionFormId,
								'Region' => $em_region,
								'RegionBranch' => $em_branch,
			
								'totalpricepermint' => $result->totalpricepermint,
								'totalpricepersouverantsheet'=>$result->totalpricepersouverantsheet,
								'totalpriceperfdcover'=> $result->totalpriceperfdcover,
							);
						   
						$success = $this->Stampbureau->Addstocks2($data2,$db);

		            	echo "Successfully 123" . $success;
		            }

		             elseif($em_sub_role == "STORE"){


				   $db="stock";
				   $result= $this->Stampbureau->getpreviousQuantity($db,$StockId);
				   $previousQuantity= $result->quantity;

				   $latestquantity = $previousQuantity-$QuantitySupp;
				   //create new stock
							$data2 = array();
							$data2 = array(
								'StockId' => $result->StockId,
								 'Stock_Categoryid' => $result->Stock_Categoryid,

								'issuedate' => $result->issuedate,
								'enddate' => $result->enddate,
								'releasedate'=> $issuedate,
								'stampname' => $result->stampname,
								'denomination' => $result->denomination,
								'quantity' => $latestquantity,
								'pricepermint' => $result->pricepermint,
								'pricepersouverantsheet' => $result->pricepersouverantsheet,
								'priceperfdcover' => $result->priceperfdcover,
			
								'createddate' => $createddate,
								'createdby' => $createdby,
								
			
								'totalpricepermint' => $result->totalpricepermint,
								'totalpricepersouverantsheet'=>$result->totalpricepersouverantsheet ,
								'totalpriceperfdcover'=> $result->totalpriceperfdcover ,
							);
						   
						$success = $this->Stampbureau->Addstocks2($data2,$db);
					}
				
			}
		

			echo "Successfully Added" . $success;

				
			}
		}
	}
			
		  else{
				//$this->load->view('Stock/add-other',$data);
				redirect(base_url() , 'refresh');
			  }   
		}

}
