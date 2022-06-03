<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FP_Application extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('login_model');
		$this->load->model('dashboard_model');
		$this->load->model('employee_model');
		$this->load->model('notice_model');
		$this->load->model('settings_model');
		$this->load->model('leave_model');
		$this->load->model('billing_model');
		$this->load->model('organization_model');
		$this->load->model('Box_Application_model');
		$this->load->model('Sms_model');
		$this->load->model('unregistered_model');
		$this->load->model('Control_Number_model');
		$this->load->model('Supervisor_ViewModel');
		$this->load->model('ReceivedBranch_ViewModel');
		$this->load->model('Pcum_model');
		$this->load->model('Bill_Customer_model');
		$this->load->model('FGN_Application_model');
		$this->load->model('FP_Application_model');

		if ($this->session->userdata('user_login_access') == false){
			redirect(base_ur());
		}

	}


		public function Receive() {
		   	$data['region'] = $this->employee_model->regselect();
		    $this->load->view('FP/Receive',$data);
	   }

	   public function foreign_parcel_zone_pass(){
	    if ($this->session->userdata('user_login_access') != false){

	        $data['sectiondata'] = $this->employee_model->getDepartmentSections(23);
	        $data['fromzone'] = $_GET['fromzone'];

	        $createdby = $this->session->userdata('user_login_id');

	        //section details
	        $data['current_section'] = 'Foreign parcel';//$staff_section[0]['name'];
	        $data['current_controller'] = 'fgn_zone_pass';//$staff_section[0]['controller'];

	        $this->load->view('FP/zone_passing_process.php',$data);
	    }else{
	        redirect(base_url());
	    }
	}

	public function item_foreign_parcel_transfer(){
    if ($this->session->userdata('user_login_access') != false){
        $emid = $this->session->userdata('user_login_id');
        $data['emselect'] = $this->employee_model->delivereselect();
        $operator = $this->input->post('operator');
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');

        $fromzone = $this->input->post('fromzone');
        $print_status = $this->input->post('print_status');

        $data['selected_section'] = $this->input->post('searched_name');

        $data['sectiondata'] = $this->employee_model->getDepartmentSections(23);

        $data['fromzone'] = (!empty($_GET['fromzone']))? $_GET['fromzone']:$fromzone;
        $data['print_status'] = (!empty($_GET['print_status']))? $_GET['print_status']:$print_status;


        if (!empty($operator) && !empty($fromdate) && !empty($todate)) {

            $data['info'] = $this->ContractModel->get_employee_info($operator);
            $data['info_assignedby'] = $this->ContractModel->get_employee_info($emid);
            $data['fromdate'] = $fromdate;
            $data['todate'] = $todate;

            $listdata = $this->FP_Application_model->get_foreign_parcel_passed_to_date($operator,$Barcode='',$pass_to_status='Cage In',$office_name='Foreign parcel cage',$emid,$fromdate,$todate);

            if ($listdata) {

            	foreach ($listdata as $key => $tranDetails) {
            		$newList[$tranDetails['Barcode']]['Barcode'] = $tranDetails['Barcode'];
            		$newList[$tranDetails['Barcode']]['addressedto'] = $tranDetails['addressedto'];
            		$newList[$tranDetails['Barcode']]['serial'] = $tranDetails['serial'];
            		$newList[$tranDetails['Barcode']]['hndlcharges'] = $tranDetails['hndlcharges'];
            		$newList[$tranDetails['Barcode']]['boxnumber']  = $tranDetails['boxnumber'];
            		$newList[$tranDetails['Barcode']]['phone']  = $tranDetails['phone'];
            		$newList[$tranDetails['Barcode']]['identity']  = $tranDetails['identity'];
            	}

            	$data['listdata'] = $newList;

            }
        }

        $this->load->view('FP/transfer_foreign_parcel_list',$data);
    }else{
        redirect(base_url());
    }
}

	public function print_foreign_parcel_reports(){
		$rec_region = $this->input->post('rec_region');
		$rec_branch = $this->input->post('rec_branch');
		$emid = $this->session->userdata('user_login_id');
		$basicinfo = $this->employee_model->GetBasic($emid);

		 $user = $basicinfo->em_code.'  '.$basicinfo->first_name.' '.$basicinfo->middle_name.' '.$basicinfo->last_name;
		 $region = $basicinfo->em_region;
		 $em_branch = $basicinfo->em_branch;

		 $now = date("Y-m-d H:i:s");
		 $data['emid'] = $emid;
		 $data['reports'] =$reports = $this->FP_Application_model->pending_foreign_parcel_list($emid,$rec_branch);

		 if (!empty($data['reports'])) {
		 	$data['report'] = $reports[0];
		 }
		 
		 $data['staff'] = $user ;
		 $this->FP_Application_model->Update_foreign_parcel($emid,$rec_branch);

		if(!empty($reports[0]->created_by)){
		      $this->load->view('FP/Print_fp',$data);
		}
	}

	public function assign_item_general_process(){
	if ($this->session->userdata('user_login_access') != false){
		$barcode = $this->input->post('barcode');
		$rec_region = $this->input->post('rec_region');
		$rec_branch = $this->input->post('rec_branch');
		$sn = $this->input->post('sn');
	
		$emid = $this->session->userdata('user_login_id');		

		if (!empty($emid)) {
			//user information
			$basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;
			 $user = $basicinfo->em_code.'  '.$basicinfo->first_name.' '.$basicinfo->middle_name.' '.$basicinfo->last_name;

			 if($rec_region == $region ) $FGN_category ='within';
			 else  $FGN_category ='outside';
			 
					//process of saving the bag information
					$now = date("Y-m-d H:i:s");
					// 'date_created' =>$now, 
					$packet = array(
						'Barcode' =>$barcode,
						'region' =>$rec_region, 
						'branch' =>$rec_branch,
						'created_at'=>$now, 
						'created_by' =>$emid,
						'status' =>'pending',
						'category' =>$FGN_category, 
						'region_from' =>$region,
						'office_name' =>'Foreign parcel receive',
						'branch_from' =>$em_branch
					);

					$FGN_small_packet_id = $this->FP_Application_model->save_foreign_parcel($packet);
					$emslist = $this->FP_Application_model->pending_foreign_parcel_byBarcode($barcode);

					$temp = '';
					if($sn == 'NaN')$sn = '1';
					
					foreach ($emslist as $key => $value) {

						$temps ="<tr data-transid='".$value['id']."' class='".$value['Barcode']." tr".$value['id']." receiveRowd'
						id='tr".$value['id']."'
						> <td>".$sn."</td>
			                 <td>".$value['Barcode']."</td>
			                 <td>".$value['region']."</td>
			                 <td>".$value['branch']."</td>
			                 <td>".$value['branch_from']."</td><td>
                            <button data-transid='".$value['id']."' href='#' onclick='Deletevalue(this)' title='Cancel' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-trash-o'></i></button>
                            </td></tr>";

                            $sn++;
                            $temp = $temp.$temps;
					}

					$response['status'] = "Success";
	     			$response['msg'] = $temp;
	     			$response['total'] = sizeof($emslist);
		}else{
			$response['status'] = "Error";
     		$response['msg'] = "No pf number";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}


public function itemize_item_general_process(){
	if ($this->session->userdata('user_login_access') != false){
		$barcode = $this->input->post('barcode');
			$emid = $this->session->userdata('user_login_id');	
			$basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$branch = $basicinfo->em_branch;
			 $user = $basicinfo->em_code.'  '.$basicinfo->first_name.' '.$basicinfo->middle_name.' '.$basicinfo->last_name;
	
		$emslist = $this->FP_Application_model->Itemize_foreign_parcel($region,$branch,$barcode);

		if (!empty($emslist)) {
			//user information
					$temp = '';
					// $temp = json_encode($emslist).'  hii';
					foreach ($emslist as $key => $value) {

		if(@$value['pocharges'] == '' || empty($value['pocharges'])){$pocharges=0;}else{$pocharges=$value['pocharges'];}
		if(@$value['hndlcharges'] == '' || empty($value['hndlcharges'])){$hndlcharges=5900;}else{$hndlcharges=$value['hndlcharges'];}
		if(@$value['customsfee'] == '' || empty($value['customsfee'])){$customsfee=0;}else{$customsfee=$value['customsfee'];}
		if(@$value['demurragefee'] == '' || empty($value['demurragefee'])){$demurragefee=0;}else{$demurragefee=$value['demurragefee'];}
		if(@$value['othercharges'] == '' || empty($value['othercharges'])){$othercharges=0;}else{$othercharges=$value['othercharges'];}


		         $temps =" 
		           <br />

                     <div class='form-group row'>
				    <div class='col-sm-3'>
					<label> Item Number </label>
				     <input type='text' class='form-control' placeholder='Item Number' value='".$value['Barcode']."' id='itemnumber' name='itemnumber' required>
				    </div>
				    <div class='col-sm-3'>
					<label> Posted At </label>
				     <input type='text' class='form-control' placeholder='Posted At' value='".@$value['postedat']."' name='postedat' id='postedat' required>
				    </div>
				     <div class='col-sm-3'>
					<label> P O Charges due</label>
				     <input type='number' class='form-control' placeholder='Enter Charges' value='".@$pocharges."'  name='pocharges' id='pocharges' required>
				    </div>
				    <div class='col-sm-3'>
					<label> Handling Charges </label>
				     <input type='number' class='form-control' placeholder='Enter Charges' value='".@$hndlcharges."'  name='hndlcharges' id='hndlcharges' required>
				    </div>
				    <div class='col-sm-3'>
					<label>Customs Fee</label> 
				     <input type='number' class='form-control' placeholder='Enter Fee' value='".@$customsfee."'   name='customsfee' id='customsfee' required>
				    </div>
				     <div class='col-sm-3'>
					<label>Demurrage Fee</label>
				     <input type='number' class='form-control' placeholder='Enter Fee' value='".@$demurragefee."'   name='demurragefee' id='demurragefee' required>
				    </div>
				     <div class='col-sm-3'>
					<label> Other Charges </label>
				     <input type='number' class='form-control' placeholder='Enter Charges' value='".@$othercharges."' name='othercharges' id='othercharges' required>
				    </div>
				    <div class='col-sm-3'>
					<label> Addressed To </label>
				     <input type='text' class='form-control' placeholder='Enter Fullname' value='".@$value['addressedto']."'  name='addressedto' id='addressedto'  required>
				    </div>

				   
				     <div class='col-sm-3'>
					<label> Delivery against Authority Card No </label>
				     <input type='text' class='form-control' placeholder='Enter Delivery Card No' value='".@$value['cardno']."'   name='cardno' id='cardno' required>
				    </div>

				     <div class='col-sm-3'>
					<label> Box Number </label>
				     <input type='text' class='form-control' placeholder='Enter Box Number' value='".@$value['boxnumber']."'  name='boxnumber' id='boxnumber' required>
				    </div>

					<div class='col-sm-3'>
					<label> Phone Number</label>
				     <input type='text' class='form-control' placeholder='Enter Phone # eg 255xxxxxxxxx' value='".@$value['phone']."'  name='phone' id='phone' required>
				    </div>
				    <div class='col-sm-3'>
					<label> Identity </label>
				     <input type='text' class='form-control' placeholder='Enter Identity' name='identity' value='".@$value['identity']."'  id='identity'>
				    </div>
	                 </div>   
					 
			        <div class='form-group row'>
                    <div class='col-6' style=''>
                     <button data-transid='".$value['id']."' href='#' onclick='Cancelvalue(this)' title='Cancel' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-trash-o'></i>Cancel</button>
                    <button data-transid='".$value['id']."' href='#' onclick='Submitvalue(this)' title='Submit' class='btn btn-sm btn-success waves-effect waves-light'><i class='fa fa-trash-o'></i>Submit</button>
                   
                    </div>
                    </div>";
                    $temp = $temps;

					}

					$response['status'] = "Success";
	     			$response['msg'] = $temp;
	     			$response['total'] = sizeof($emslist);
		}else{
			$response['status'] = "Error";
     		$response['msg'] = "Barcode exist";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}

public function getserial(){
	$emid = $this->session->userdata('user_login_id');
       $basicinfo = $this->employee_model->GetBasic($emid);
		$region = $basicinfo->em_region;
		$branch = $basicinfo->em_branch;

        $getuniquelastnumber= $this->FP_Application_model->get_last_dpnumber($branch,$region);
            //check length
            if(empty($getuniquelastnumber) || is_null($getuniquelastnumber)
              || strpos($getuniquelastnumber->serial, 'DP') !== false){
            	
                $number = 1;
            }else{
                $numbers = @$getuniquelastnumber->serial;
                $number=(int)$numbers+1;
            }

            return $number;
    }


public function submit_Packet_itemized_scanned(){
	if ($this->session->userdata('user_login_access') != false){
		$emid=   $this->session->userdata('user_login_id');
		$foreignId = $this->input->post('transactionid');

		$itemnumber       = $this->input->post('  itemnumber');
		$postedat   = $this->input->post('postedat');
		$pocharges= $this->input->post('pocharges');
		$hndlcharges= $this->input->post('hndlcharges');
		$demurragefee= $this->input->post('demurragefee');
		$customsfee= $this->input->post('customsfee');
		$othercharges= $this->input->post('othercharges');
		$addressedto= $this->input->post('addressedto');
		
		$cardno= $this->input->post('cardno');
		$boxnumber= $this->input->post('boxnumber');
		$phone= $this->input->post('phone');
		$identity= $this->input->post('identity');


        $getpacket = $this->FP_Application_model->get_Packet_byID($foreignId);

		if(@$getpacket->status == "Itemized"){$serials=$getpacket->serial;}
		else{$serials= $this->getserial();}
		
		//create serial
		//$serials= $this->getserial();
		$itemized_date= date("Y-m-d H:i:s"); //

		$response = array();

		if ($foreignId) {
			//save values
			  //'itemnumber'=>$itemnumber, itemized_date
	    $data = array(
		  	'postedat'=>$postedat,
			'pocharges'=>$pocharges,
			'hndlcharges'=>$hndlcharges,
			'customsfee'=>$customsfee,
			'demurragefee'=>$demurragefee,
			'othercharges'=>$othercharges,
			'addressedto'=>$addressedto,
			'serial'=>$serials,
			'cardno'=>$cardno,
			'boxnumber'=>$boxnumber,
			'phone'=>$phone,
			'identity'=>$identity,
			'status'=>'Itemized',
			'received_by'=>$emid,
			'itemized_date'=>$itemized_date,
			'itemized_by'=>$emid
	    );


			$update = $this->FP_Application_model->Update_foreign_parcelById($foreignId,$data);

			$response['status'] = 'Success';
			$response['msg'] = 'Item is Submited successfully '.'RDP-'.$serials;
			$response['msg2'] = '';

		}else{
			$response['status'] = 'Error';
			$response['msg'] = 'No Packet id';
		}
		//produce result to the server
		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}

public function getForeignParcelPassedItemsByOperator(){
    if ($this->session->userdata('user_login_access') != false){
        $assignedby = $this->session->userdata('user_login_id');
        
        $operator = $this->input->post('operator');

        $tz = 'Africa/Nairobi';
        $tz_obj = new DateTimeZone($tz);
        $today = new DateTime("now", $tz_obj);
        $date = $today->format('Y-m-d');

        $fromdate = $date;
        $todate = $date;
        $selected_section = $this->input->post('zonetype');
        $removefunction = $this->input->post('removefunction');
        $forditributer = $this->input->post('forditributer');


        $emid = $this->session->userdata('user_login_id');
        $basicinfo = $this->employee_model->GetBasic($emid);
		$region = $basicinfo->em_region;
		$em_branch = $basicinfo->em_branch;

        if (!empty($operator) && !empty($fromdate) && !empty($todate)) {

               $listdata = $this->FP_Application_model->get_foreign_parcel_passed_to($operator,$Barcode='',$pass_to_status='Cage In',$office_name='',$pass_to_by='');

            if ($listdata) {

            	$count = 1;
            	$temp = '';
            	foreach ($listdata as $key => $tranDetails) {
            		$sn = $count++;

            		$temp .="<tr data-transid='".$tranDetails['id']."' 
            		class='".$tranDetails['Barcode']." tr".$tranDetails['id']." receiveRow'> <td>".$sn."</td>
		                 <td>".$tranDetails['addressedto']."</td>
		                 <td>".$tranDetails['Barcode']."</td>
		                 <td>".$tranDetails['serial']."</td>
		                 <td>".$tranDetails['hndlcharges']."</td>
		                 <td>".$tranDetails['boxnumber']."</td>
		                 <td>".$tranDetails['phone']."</td>
		                 <td>".$tranDetails['identity']."</td>
		                 <td><a href='#' 
		                 data-transid='".$tranDetails['id']."'
		                 data-barcode='".$tranDetails['Barcode']."' onclick='".$removefunction."(this)' 
		                 class=''><i class='fa fa-trash-o'></i> Remove</a></td>
		                 <td>
		                 <div class='form-check' style='padding-left: 53px;float:left'>
		                 <input type='checkbox' name='transactions' value='".$tranDetails['id']."' class='form-check-input ".$tranDetails['Barcode']."' style='padding-right:50px;' />
	                            <label class='form-check-label' for='remember-me'></label>
	                            </div></td></tr>";

            	}

            	$response['status'] = "Success";
				$response['msg'] = $temp;
				$response['total'] = sizeof($listdata);

            }else{
            	$response['status'] = "Error";
     		$response['msg'] = "Transaction not found";
            }
            print_r(json_encode($response));
        }
    }else{
        redirect(base_url());
    }
}

public function ForeignParcelPassToCage(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$Barcode = $this->input->post('Barcode');
		$operator = $this->input->post('operator');
		$zonetype = $this->input->post('zonetype');
		$sn = $this->input->post('sn');
		$office_name = $this->input->post('office_name');


		//Time stamp
		$tz = 'Africa/Nairobi';
        $tz_obj = new DateTimeZone($tz);
        $today = new DateTime("now", $tz_obj);
        $date = $today->format('Y-m-d');
		
		if (!empty($Barcode) && !empty($emid)) {
			//filter data by using barcode
			$listdata = $this->FP_Application_model->get_foreign_parcel_passed_to($whom_passed_to='',$Barcode,$pass_to_status='',$office_name,$pass_to_by='');
		
			if ($listdata) {

				//process of passing
				$data = array(
				'pass_to'=>$operator,
				'office_name'=>'Foreign parcel cage',
				'pass_to_by'=>$emid,
				'pass_to_status'=>'Cage In',
				'pass_to_date'=>$date);

				$this->FP_Application_model->Update_foreign_parcelById($listdata[0]['id'],$data);

				$count = 1;
				$temp = '';
				$removefunction = 'test';
				foreach ($listdata as $key => $tranDetails) {
					$sn = (!empty($sn))? $sn:$count++;

					$temp .="<tr data-transid='".$tranDetails['id']."' 
            		class='".$tranDetails['Barcode']." tr".$tranDetails['id']." receiveRow'> <td>".$sn."</td>
		                 <td>".$tranDetails['addressedto']."</td>
		                 <td>".$tranDetails['Barcode']."</td>
		                 <td>".$tranDetails['serial']."</td>
		                 <td>".$tranDetails['hndlcharges']."</td>
		                 <td>".$tranDetails['boxnumber']."</td>
		                 <td>".$tranDetails['phone']."</td>
		                 <td>".$tranDetails['identity']."</td>
		                 <td><a href='#' 
		                 data-transid='".$tranDetails['id']."'
		                 data-barcode='".$tranDetails['Barcode']."' onclick='".$removefunction."(this)' 
		                 class=''><i class='fa fa-trash-o'></i> Remove</a></td>
		                 <td>
		                 <div class='form-check' style='padding-left: 53px;float:left'>
		                 <input type='checkbox' name='transactions' value='".$tranDetails['id']."' class='form-check-input ".$tranDetails['Barcode']."' style='padding-right:50px;' />
	                            <label class='form-check-label' for='remember-me'></label>
	                            </div></td></tr>";

				}

				$response['status'] = "Success";
     			$response['msg'] = $temp;
     			$response['total'] = sizeof($listdata);
				
			}else{
				$response['status'] = "Error";
     			$response['msg'] = "Transaction not found";
			}

		}else{
			$response['status'] = "Error";
     		$response['msg'] = "Please enter barcode";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}

public function packet_cage(){
    if ($this->session->userdata('user_login_access') != false){
        $emid = $this->session->userdata('user_login_id');

        $listdata = $this->FP_Application_model->get_foreign_parcel_passed_to($emid,$FGN_number='',$pass_to_status='Cage In',$office_name='Foreign parcel cage',$pass_to_by='');

        $data['current_section'] = 'Foreign parcel cage';//$staff_section[0]['name'];
        $data['current_controller'] = 'Foreign_parcel';//$staff_section[0]['controller'];

       if (!empty($listdata)) {
        
           foreach ($listdata as $key => $list) {
                $emplyo = $this->employee_model->GetBasic($list['pass_to_by']);
                $NewList[$list['pass_to_by']]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                $NewList[$list['pass_to_by']]['em_sub_role'] = 'Foreign Parcel';
                $NewList[$list['pass_to_by']]['em_image'] = $emplyo->em_image;
                $NewList[$list['pass_to_by']]['pass_from'] = 'Foreign Parcel';
                $NewList[$list['pass_to_by']]['last_name'] = $emplyo->last_name;
                
            }
            $data['counter_list'] = $NewList;
       }

        $this->load->view('FP/parcel_cage.php',$data);
    }else{
        redirect(base_url());
    }
}

public function get_Foreign_parcel_sentList(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$pass_to_by = $this->input->post('emid');
		$office_name = $this->input->post('office_name');
		$return_to = 'packet_cage';//$this->input->post('controller');

		if (!empty($emid)) {

			$listdata = $this->FP_Application_model->get_foreign_parcel_passed_to($emid,$FGN_number='',$pass_to_status='Cage In',$office_name,$pass_to_by);


			if ($listdata) {

				$count = 1;
				$temp = '';
				foreach ($listdata as $key => $tranDetails) {
					$sn = $count++;

					$temp .="<tr data-emid='".$emid."' data-transid='".$tranDetails['id']."' class='".$tranDetails['Barcode']." tr".$tranDetails['id']." receiveRow'> 
						<td>".$sn."</td>
		                 <td>".$tranDetails['addressedto']."</td>
		                 <td>".$tranDetails['Barcode']."</td>
		                 <td>".$tranDetails['serial']."</td>
		                 <td>".$tranDetails['hndlcharges']."</td>
		                 <td>".$tranDetails['boxnumber']."</td>
		                 <td>".$tranDetails['phone']."</td>
		                 <td>".$tranDetails['identity']."</td>
		                 <td>
		                 <div class='form-check' style='padding-left: 53px;float:left'>
		                 <input type='checkbox' name='transactions' value='".$tranDetails['id']."' class='form-check-input ".$tranDetails['Barcode']."' style='padding-right:50px;' />
	                            <label class='form-check-label' for='remember-me'></label>
	                            </div></td></tr>";

				}

				$temp .='<tr><td colspan="7"></td><td style="float: right;">
				<a class="btn btn-success" href="'.base_url().'FP_Application/'.$return_to.'" class="text-white"><i class="" aria-hidden="true"></i> Receive </a>
					</td></tr>';

				$response['status'] = "Success";
     			$response['msg'] = $temp;
				
			}else{
				$response['status'] = "Error";
     			$response['msg'] = "No data";
			}
		}else{
			$response['status'] = "Error";
     		$response['msg'] = "No pf number";
		}

		print_r(json_encode($response));

	}else{
		redirect(base_url());
	}
}

public function ForeignParcel_cage_receive(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$Barcode = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$passfrom = $this->input->post('passfrom');

		if (!empty($Barcode) && !empty($transid)) {

			//Time stamp
			$tz = 'Africa/Nairobi';
	        $tz_obj = new DateTimeZone($tz);
	        $today = new DateTime("now", $tz_obj);
	        $date = $today->format('Y-m-d');
			
			//process of passing
			$data = array(
			'office_name'=>'Foreign parcel cage receive',
			'pass_to_status'=>'Cage In receive',
			'pass_to_receive_date'=>$date);

			$this->FP_Application_model->Update_foreign_parcelById($transid,$data);

			$response['status'] = "Success";
			$response['transid'] = $transid;
			$response['barcode'] = $barcode;
     		$response['msg'] = "received";

		}else{
			$response['status'] = "Error";
     		$response['msg'] = "Please specify the fromdate and todate";
		}

		print_r(json_encode($response));

	}else{
		redirect(base_url());
	}
}






}