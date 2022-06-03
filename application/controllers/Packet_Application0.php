<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packet_Application extends CI_Controller {


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
$this->load->model('Sms_model');
$this->load->model('unregistered_model');
$this->load->model('Control_Number_model');
$this->load->model('Supervisor_ViewModel');
$this->load->model('ReceivedBranch_ViewModel');
$this->load->model('Pcum_model');
$this->load->model('Bill_Customer_model');
$this->load->model('FGN_Application_model');

$this->redirecttohome();

}

   public function add_fgn() {
   	$data['region'] = $this->employee_model->regselect();
   	//$data['outsidesmallpacket'] = $this->FGN_Application_model->outside_small_parcket();
    $this->load->view('FGN/add_fgn',$data);
   }

   public function redirecttohome() {
   	 if ($this->session->userdata('user_login_access') == false){
 			//redirect(base_ur());
 			redirect('Services/Small_Packets');
      }
   }



    public function Receive() {

   //  	$emid = $this->session->userdata('user_login_id');
   //     $basicinfo = $this->employee_model->GetBasic($emid);
			// $region = $basicinfo->em_region;
			// $em_branch = $basicinfo->em_branch;

   	$data['region'] = $this->employee_model->regselect();
   	//$data['outsidesmallpacket'] = $this->FGN_Application_model->receive_small_parcket_list($region,$em_branch);
    $this->load->view('FGN/Receive',$data);
   }

   

    public function Itemize() {
    		$emid = $this->session->userdata('user_login_id');
       $basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;

   	$data['region'] = $this->employee_model->regselect();
   	$data['outsidesmallpacket'] = $this->FGN_Application_model->Itemize_small_parcket_list($region,$em_branch);
    $this->load->view('FGN/Itemize',$data);
   }

    public function Pass() {

    	if ($this->session->userdata('user_login_access') != false)
        {

    	$emid = $this->session->userdata('user_login_id');
       $basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;
   	$data['region'] = $this->employee_model->regselect();
   	$data['outsidesmallpacket'] = $this->FGN_Application_model->passto_small_parcket_list($region,$em_branch);
    $this->load->view('FGN/Pass',$data);
   }
else{
redirect(base_url());
}
}

    public function Itemized_Submitted() {

    	if ($this->session->userdata('user_login_access') != false)
        {
        	$fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
		    $todate =  date("Y-m-d",strtotime($this->input->post('todate')));

    	$emid = $this->session->userdata('user_login_id');
       $basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;
   	        $data['smallpacket'] =$smallpackets= $this->FGN_Application_model->submitted_itemized_small_parcket_list($region,$em_branch,$fromdate,$todate);

   	        if (!empty(@$smallpackets)) {
			

					$emslist = $smallpackets;

					$temp = '';
					//if($sn == 'NaN')$sn = '1';
					$sn = 1;
					foreach ($emslist as $key => $value) {

						// $tempsform ='<form class="row" method="post" action="'.site_url('leave/Get_LeaveDetailss').'>';

						$temps ="<tr data-transid='".$value['FGN_small_packet_id']."' class='".$value['FGN_number']." tr".$value['FGN_small_packet_id']." receiveRowd'
						id='tr".$value['FGN_small_packet_id']."'
						> 
						<td>".$sn."</td>
			                 <td>".$value['FGN_number']."</td>
			                 <td>".$value['region']."</td>
			                 <td>".$value['branch']."</td>
			                 <td>".$value['branch_from']."</td>
			                
			              <td>

			                <a href='".base_url()."Packet_Application/print_Packet_Passto_report?FGN_number=".$value['FGN_number']."' class='btn btn-sm btn-danger waves-effect waves-light'> <i class='fa fa-print'></i>Print</a>
		                            </td></tr>";
		                            // $tempsformend ='</form>';

		                            $sn++;
		                            $temp = $temp.$temps;

					}

					$response['status'] = "Success";
	     			$response['msg'] = $temp;
	     			$response['total'] = sizeof($emslist);
	     			//$response['select'] = $select;

			
		}else{
			$response['status'] = "Error";
     		$response['msg'] = "Items dont exist";
		}

		//produce result to the server
		print_r(json_encode($response));

            // $this->load->view('FGN/Pass',$data);




   }
else{
redirect(base_url());
}
}


 public function Itemized_Print_Submitted() {

    	if ($this->session->userdata('user_login_access') != false)
        {
        	$fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
		    $todate =  date("Y-m-d",strtotime($this->input->post('todate')));

    	$emid = $this->session->userdata('user_login_id');
       $basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;
   	        $data['outsidesmallpacket'] = $this->FGN_Application_model->submitted_itemized_small_parcket_list($region,$em_branch,$fromdate,$todate);



             $this->load->view('FGN/Pass',$data);




   }
else{
redirect(base_url());
}
}


		



   public function insert_small_packet(){
		$value = $this->input->post('fgn_no');
		$region = $this->input->post('region');
		$branch = $this->input->post('branch');
		
		$results = $this->FGN_Application_model->add_small_packet($value,$region,$branch);

		if($results){
		$this->session->set_flashdata('message','FGN Small Packet has been successfully added');	
		}
		else
		{
		$this->session->set_flashdata('feedback','Failed to add FGN Small Packet, Please try again');	
		}
		
	redirect($this->agent->referrer());
	}


	public function delete_Packet_item_scanned(){
	if ($this->session->userdata('user_login_access') != false){
		$emid=   $this->session->userdata('user_login_id');
		$FGN_small_packet_id = $this->input->post('transactionid');
		$response = array();
		if ($FGN_small_packet_id) {
			$this->FGN_Application_model->delete_small_parcket($FGN_small_packet_id);

			$response['status'] = 'Success';
			$response['msg'] = 'Item is removed';

		}else{
			$response['status'] = 'Error';
			$response['msg'] = 'No transaction id';
		}
		//produce result to the server
		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}

public function cancel_Packet_itemized_scanned(){
	if ($this->session->userdata('user_login_access') != false){
		$emid=   $this->session->userdata('user_login_id');
		$FGN_small_packet_id = $this->input->post('transactionid');
		$response = array();
		if ($FGN_small_packet_id) {
			//$this->FGN_Application_model->delete_small_parcket($FGN_small_packet_id);

			$response['status'] = 'Success';
			$response['msg'] = 'Item is canceled';
			$response['msg2'] = '';

		}else{
			$response['status'] = 'Error';
			$response['msg'] = 'No Packet Id';
		}
		//produce result to the server
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

        $getuniquelastnumber= $this->FGN_Application_model->get_last_dpnumber($branch,$region);

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

    public function getserial2(){
	$emid = $this->session->userdata('user_login_id');
       $basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$branch = $basicinfo->em_branch;

        $getuniquelastnumber= $this->FGN_Application_model->get_last_dpnumber($branch,$region);

            //check length
            if(empty($getuniquelastnumber) || is_null($getuniquelastnumber)
              || strpos($getuniquelastnumber->serial, 'DP') !== false){
            	
                $number = 1;
            // //update number
            //      $nmbur = array();
            //      $nmbur = array('number'=>$number);

            //      $db2 = $this->load->database('otherdb', TRUE);
            //      $db2->insert('bagnumber',$nmbur);
               
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
                $numbers = @$getuniquelastnumber->serial;
                $numbers=(int)$numbers+1;
                $number = @$getuniquelastnumber->serial;

              $length = strlen((string)$number);
             //$length = 0;
             $numbera='';
            for($i = $length;$i<$no_of_digit;$i++)
            {
                $numbera = '0'.$numbera;
            }
              $number=$numbera.$numbers;

                
                 // $nmbur = array();
                 // $nmbur = array('number'=>$numbers);
                 // $db2 = $this->load->database('otherdb', TRUE);
                 // $db2->insert('bagnumber',$nmbur);
               

            }

            return $number;
    }

public function submit_Packet_itemized_scanned(){
	if ($this->session->userdata('user_login_access') != false){
		$emid=   $this->session->userdata('user_login_id');
		$FGN_small_packet_id = $this->input->post('transactionid');
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


        $getpacket = $this->FGN_Application_model->get_Packet_byID($FGN_small_packet_id);
		if(@$getpacket->status == "Itemized"){$serials=$getpacket->serial;}
		else{$serials= $this->getserial();}
		
		//create serial
		//$serials= $this->getserial();
		$itemized_date= date("Y-m-d H:i:s"); //

		$response = array();
		if ($FGN_small_packet_id) {
			//save values
			  //'itemnumber'=>$itemnumber, itemized_date
			$data = array(); 
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


			$update = $this->FGN_Application_model->update_itemize_small_parcket($FGN_small_packet_id,$data);

			$response['status'] = 'Success';
			$response['msg'] = 'Item is Submited successfully '.'DP-'.$serials;
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

public function receive_Packet_item_scannedOLD(){
	if ($this->session->userdata('user_login_access') != false){
		$emid=   $this->session->userdata('user_login_id');
		$FGN_small_packet_id = $this->input->post('transactionid');
		$response = array();
		if ($FGN_small_packet_id) {
			$status ='received';
			$this->FGN_Application_model->Update_small_packet_byID($FGN_small_packet_id,$status,$emid);

			$response['status'] = 'Success';
			$response['msg'] = 'Item is received';

		}else{
			$response['status'] = 'Error';
			$response['msg'] = 'No packet id';
		}
		//produce result to the server
		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}

public function receive_Packet_item_scanned(){
	if ($this->session->userdata('user_login_access') != false){
		$emid=   $this->session->userdata('user_login_id');
		$FGN_number = $this->input->post('transactionid');

		$sn = $this->input->post('sn');
		$response = array();
		if ($FGN_number) {
			$status ='received';
			$this->FGN_Application_model->Update_small_packet_byBarcode($FGN_number,$status,$emid);

		     //$emslist = $this->FGN_Application_model->pending_small_parcket($emid,$rec_branch);
           $basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;

   	//$data['region'] = $this->employee_model->regselect();
   	$data['outsidesmallpacket'] =$emslist= $this->FGN_Application_model->receive_small_parcket_array($region,$em_branch,$emid);

					$temp = '';
					if($sn == 'NaN')$sn = '1';
					$sn = 1;
					foreach ($emslist as $key => $value) {


						$temps ="<tr data-transid='".$value['FGN_small_packet_id']."' class='".$value['FGN_number']." tr".$value['FGN_small_packet_id']." receiveRowd'
						id='tr".$value['FGN_small_packet_id']."'
						> <td>".$sn."</td>
			                 <td>".$value['FGN_number']."</td>
			                 <td>".$value['region']."</td>
			                 <td>".$value['branch']."</td>
			                 <td>".$value['branch_from']."</td>
			                
			              <td>
			                 
		                            <button data-transid='".$value['FGN_small_packet_id']."' href='#' onclick='dontreceivevalue(this)' title='Cancel' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-trash-o'></i>Delete</button>
		                            </td></tr>";

		                            $sn++;
		                            $temp = $temp.$temps;

					}

					$response['status'] = "Success";
	     			$response['msg'] = $temp;
	     			$response['total'] = sizeof($emslist);

		}else{
			$response['status'] = 'Error';
			$response['msg'] = 'No packet id';
		}
		//produce result to the server
		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}


public function dontreceive_Packet_item_scanned(){
	if ($this->session->userdata('user_login_access') != false){
		$emid=   $this->session->userdata('user_login_id');
		$FGN_small_packet_id = $this->input->post('transactionid');

		$sn = $this->input->post('sn');
		$response = array();
		if ($FGN_small_packet_id) {
			$status ='sent';
			$this->FGN_Application_model->Update_small_packet_receive_status_byID($FGN_small_packet_id,$status,$emid);

		     //$emslist = $this->FGN_Application_model->pending_small_parcket($emid,$rec_branch);
           $basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;

   	//$data['region'] = $this->employee_model->regselect();
   	$data['outsidesmallpacket'] =$emslist= $this->FGN_Application_model->receive_small_parcket_array($region,$em_branch,$emid);

					$temp = '';
					if($sn == 'NaN')$sn = '1';
					$sn = 1;
					foreach ($emslist as $key => $value) {


						$temps ="<tr data-transid='".$value['FGN_small_packet_id']."' class='".$value['FGN_number']." tr".$value['FGN_small_packet_id']." receiveRowd'
						id='tr".$value['FGN_small_packet_id']."'
						> <td>".$sn."</td>
			                 <td>".$value['FGN_number']."</td>
			                 <td>".$value['region']."</td>
			                 <td>".$value['branch']."</td>
			                 <td>".$value['branch_from']."</td>
			                
			              <td>
			                 
		                            <button data-transid='".$value['FGN_small_packet_id']."' href='#' onclick='dontreceivevalue(this)' title='Cancel' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-trash-o'></i>Delete</button>
		                            </td></tr>";

		                            $sn++;
		                            $temp = $temp.$temps;

					}

					$response['status'] = "Success";
	     			$response['msg'] = $temp;
	     			$response['total'] = sizeof($emslist);

		}else{
			$response['status'] = 'Error';
			$response['msg'] = 'No packet id';
		}
		//produce result to the server
		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}



public function print_Packet_reports(){
	
$rec_region = $this->input->post('rec_region');
$rec_branch = $this->input->post('rec_branch');
$emid = $this->session->userdata('user_login_id');
$basicinfo = $this->employee_model->GetBasic($emid);
 $user = $basicinfo->em_code.'  '.$basicinfo->first_name.' '.$basicinfo->middle_name.' '.$basicinfo->last_name;
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;
			$now = date("Y-m-d H:i:s");	
         $data['emid'] = $emid;

$data['reports'] =$reports = $this->FGN_Application_model->pending_small_parcket_list($emid,$rec_branch);
//  $this->FGN_Application_model->pending_small_parcket_list($emid,$rec_branch);
$data['report'] =$report = $reports[0];
//echo json_encode($reports);
  $data['staff'] = $user ;
//   foreach ($reports as $key => $value) {
//   	// code...
//   	$FGN_small_packet_id=$value->FGN_small_packet_id;
// }
  	//$this->FGN_Application_model->Update_small_packet($emid,$rec_branch);

  //$result= json_encode($report);
 // echo  $report->created_by;

 if(!empty($report->created_by)){

      $this->load->view('FGN/Print_small_Packets',$data);
}


}


public function print_Packet_report()
{
	if ($this->session->userdata('user_login_access') != false){
	
$rec_region = $this->input->post('rec_region');
$rec_branch = $this->input->post('rec_branch');
$emid = $this->session->userdata('user_login_id');
$basicinfo = $this->employee_model->GetBasic($emid);
 $user = $basicinfo->em_code.'  '.$basicinfo->first_name.' '.$basicinfo->middle_name.' '.$basicinfo->last_name;
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;
			$now = date("Y-m-d H:i:s");	
         $data['emid'] = $emid;


$data['reports'] =@$reports = $this->FGN_Application_model->pending_small_parcket_list($emid,$rec_branch);
//  $this->FGN_Application_model->pending_small_parcket_list($emid,$rec_branch);
$data['report'] =$report = @$reports[0];
echo json_encode($reports);
  $data['staff'] = $user ;

 	


  //$result= json_encode($report);
 // echo  $report->created_by;

 if(!empty($report->created_by)){
      //$this->load->view('FGN/Print_small_Packets',$data);
   
 $this->load->library('Pdf');
 $html= $this->load->view('FGN/Print_small_Packet',$data,TRUE);
 $this->dompdf->loadHtml($html);
 $this->dompdf->setPaper('A4','potrait');
 $this->dompdf->render();
 ob_end_clean();
 $this->dompdf->stream('Small_Packet'.date('d-m-Y').'.pdf', array("Attachment"=>FALSE));

 //update
  $data = array();
				$data = array(
					'status' => 'sent'
				);
		 @$this->FGN_Application_model->Update_small_packet($emid,$rec_branch,$data);
}

}else{
		redirect(base_url());
	}


}



public function print_Packets_Passto_reports()//many intimation reports
{
	if ($this->session->userdata('user_login_access') != false){
	
$fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
		    $todate =  date("Y-m-d",strtotime($this->input->post('todate')));

$emid = $this->session->userdata('user_login_id');
$basicinfo = $this->employee_model->GetBasic($emid);
 $user = $basicinfo->first_name.' '.$basicinfo->middle_name.' '.$basicinfo->last_name;
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;
			$now = date("Y-m-d H:i:s");	
         $data['emid'] = $emid;
          $data['pf'] = $basicinfo->em_code;

          $data['smallpackets'] =$smallpackets= $this->FGN_Application_model->Printed_itemized_small_parcket_list($region,$em_branch,$fromdate,$todate);


//$data['reports'] =@$reports = $this->FGN_Application_model->small_parcket_array_byBarcode($FGN_number);
//$data['report'] =$report = @$reports[0];
//echo json_encode($reports);
  $data['staff'] = $user ;

  //$result= json_encode($report);
 // echo  $report->created_by;

  //create barcode

foreach ($smallpackets as $report){
$FGN_number=$report->FGN_number;

 //load library
    $this->load->library('zend');
    //load in folder Zend
    $this->zend->load('Zend/Barcode');
    $this->zend->load('Zend');
  
      //generate barcode
       $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$FGN_number), array())->draw();
       imagepng($imageResource, './assets/'.$FGN_number.'.png');
           $barcodegenerator = './assets/'.$FGN_number.'.png';
           
       }
   
 $this->load->library('Pdf');
 $html= $this->load->view('FGN/Print_bulk_intimation_Packet',$data,TRUE);
 $this->dompdf->loadHtml($html);
 $this->dompdf->setPaper('A4','potrait');
 $this->dompdf->render();
 ob_end_clean();
 $this->dompdf->stream('intimation_Packet'.date('d-m-Y').'.pdf', array("Attachment"=>FALSE));


 //update
  // $data = array();
		// 		$data = array(
		// 			'status' => 'sent'
		// 		);
		//  @$this->FGN_Application_model->Update_small_packet($emid,$rec_branch,$data);

}else{
		redirect(base_url());
	}


}

public function print_Packet_Passto_report()
{
	if ($this->session->userdata('user_login_access') != false){
	
$FGN_number = $this->input->get('FGN_number');
$emid = $this->session->userdata('user_login_id');
$basicinfo = $this->employee_model->GetBasic($emid);
 $user = $basicinfo->first_name.' '.$basicinfo->middle_name.' '.$basicinfo->last_name;
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;
			$now = date("Y-m-d H:i:s");	
         $data['emid'] = $emid;
          $data['pf'] = $basicinfo->em_code;


$data['reports'] =@$reports = $this->FGN_Application_model->small_parcket_array_byBarcode($FGN_number);
$data['report'] =$report = @$reports[0];
//echo json_encode($reports);
  $data['staff'] = $user ;

  //$result= json_encode($report);
 // echo  $report->created_by;



 //load library
		$this->load->library('zend');
		//load in folder Zend
		$this->zend->load('Zend/Barcode');
		$this->zend->load('Zend');


	
			//generate barcode
		   $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$FGN_number), array())->draw();
		   imagepng($imageResource, './assets/'.$FGN_number.'.png');
           $barcodegenerator = './assets/'.$FGN_number.'.png';
           $data['barcodegenerator'] = $barcodegenerator ;
           $data['barcodee'] = $barcodegenerator ;






 if(!empty($report->created_by)){

      //$this->load->view('FGN/Print_small_Packets',$data);
   
 $this->load->library('Pdf');
 $html= $this->load->view('FGN/Print_intimation_Packet',$data,TRUE);
 $this->dompdf->loadHtml($html);
 $this->dompdf->setPaper('A4','landscape');
 $this->dompdf->render();
 ob_end_clean();
 $this->dompdf->stream('intimation_Packet'.date('d-m-Y').'.pdf', array("Attachment"=>FALSE));

 //update
  // $data = array();
		// 		$data = array(
		// 			'status' => 'sent'
		// 		);
		//  @$this->FGN_Application_model->Update_small_packet($emid,$rec_branch,$data);
}

}else{
		redirect(base_url());
	}


}




public function assign_item_general_process(){
	if ($this->session->userdata('user_login_access') != false){
		$barcode = $this->input->post('barcode');
		$rec_region = $this->input->post('rec_region');
		$rec_branch = $this->input->post('rec_branch');
			$sn = $this->input->post('sn');
	
		$emid = $this->session->userdata('user_login_id');	

			$barcode2 = $this->FGN_Application_model->small_parcket_array_byBarcode($barcode);

		if (empty(@$barcode2)) {
			//user information
			$basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;
			 $user = $basicinfo->em_code.'  '.$basicinfo->first_name.' '.$basicinfo->middle_name.' '.$basicinfo->last_name;

			 if($rec_region == $region ) $FGN_category ='within';
			 else  $FGN_category ='outside';

					//$bagno = "test2";
					//process of saving the bag information
					$now = date("Y-m-d H:i:s");
					// 'date_created' =>$now, 
					$packet = array(
						'FGN_number' =>$barcode,
						'region' =>$rec_region, 
						'branch' =>$rec_branch,
						'FGN_created_at'=>$now, 
						'created_by' =>$emid,
						'status' =>'pending',
						'FGN_category' =>$FGN_category, 
						'region_from' =>$region,
						'office_name' =>'Foreign latter receive',
						'branch_from' =>$em_branch
					);

					$FGN_small_packet_id = $this->FGN_Application_model->save_small_packet($packet);

					//$bagnoId = $this->Box_Application_model->save_bag($bagInfor);

					//$select = '<option selected value="'.$bagnoId.'">'.$bagno['num'].'</option>';
						//$select = '<option selected value="'.$bagnoId.'">'.$bagno.'</option>';

					//$bagnoText = $bagno;//bag name

					//$emslist = $this->FGN_Application_model->pending_small_parcket_byBarcode($barcode);
					 $emslist = $this->FGN_Application_model->pending_small_parcket($emid,$rec_branch);

					$temp = '';
					if($sn == 'NaN')$sn = '1';
					//$sn = 1;
					foreach ($emslist as $key => $value) {


						$temps ="<tr data-transid='".$value['FGN_small_packet_id']."' class='".$value['FGN_number']." tr".$value['FGN_small_packet_id']." receiveRowd'
						id='tr".$value['FGN_small_packet_id']."'
						> <td>".$sn."</td>
			                 <td>".$value['FGN_number']."</td>
			                 <td>".$value['region']."</td>
			                 <td>".$value['branch']."</td>
			                 <td>".$value['branch_from']."</td>
			                
			              <td>
			                 
		                            <button data-transid='".$value['FGN_small_packet_id']."' href='#' onclick='Deletevalue(this)' title='Cancel' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-trash-o'></i></button>
		                            </td></tr>";

		                            $sn++;
		                            $temp = $temp.$temps;

					}

					$response['status'] = "Success";
	     			$response['msg'] = $temp;
	     			$response['total'] = sizeof($emslist);
	     			//$response['select'] = $select;

			
		}else{
			$response['status'] = "Error";
     		$response['msg'] = "Barcode exist";
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
	
		
		$emslist = $this->FGN_Application_model->itemize_small_parcket($region,$branch,$barcode);

		if (!empty($emslist)) {
			//user information
		

			
					$temp = '';
					// $temp = json_encode($emslist).'  hii';
					foreach ($emslist as $key => $value) {

		if(@$value['pocharges'] == '' || empty($value['pocharges'])){$pocharges=0;}else{$pocharges=$value['pocharges'];}
		if(@$value['hndlcharges'] == '' || empty($value['hndlcharges'])){$hndlcharges=2350;}else{$hndlcharges=$value['hndlcharges'];}
		if(@$value['customsfee'] == '' || empty($value['customsfee'])){$customsfee=0;}else{$customsfee=$value['customsfee'];}
		if(@$value['demurragefee'] == '' || empty($value['demurragefee'])){$demurragefee=0;}else{$demurragefee=$value['demurragefee'];}
		if(@$value['othercharges'] == '' || empty($value['othercharges'])){$othercharges=0;}else{$othercharges=$value['othercharges'];}


		         $temps =" 
		           <br />

                     <div class='form-group row'>
				    <div class='col-sm-3'>
					<label> Item Number </label>
				     <input type='text' class='form-control' placeholder='Item Number' value='".$value['FGN_number']."' id='itemnumber' name='itemnumber' required>
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
                     <button data-transid='".$value['FGN_small_packet_id']."' href='#' onclick='Cancelvalue(this)' title='Cancel' class='btn btn-sm btn-danger waves-effect waves-light'><i class='fa fa-trash-o'></i>Cancel</button>
                    <button data-transid='".$value['FGN_small_packet_id']."' href='#' onclick='Submitvalue(this)' title='Submit' class='btn btn-sm btn-success waves-effect waves-light'><i class='fa fa-trash-o'></i>Submit</button>
                   
                    </div>
                    </div>
							
                     ";

     //                   <div class='col-sm-3'>
					// <label> Delivery Serial </label>
				 //     <input type='text' class='form-control' placeholder='Enter Delivery Serial' name='serial' id='serial' required>
				 //    </div>



		                           // $sn++;
		                            //$temp = $temp.$temps;
		                             $temp = $temps;

					}

					$response['status'] = "Success";
	     			$response['msg'] = $temp;
	     			$response['total'] = sizeof($emslist);
	     			//$response['select'] = $select;

			
		}else{
			$response['status'] = "Error";
     		$response['msg'] = "Barcode exist";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}


public function fgn_zone_pass(){
    if ($this->session->userdata('user_login_access') != false){

        $data['sectiondata'] = $this->employee_model->getDepartmentSections(23);
        $data['fromzone'] = $_GET['fromzone'];

        $createdby = $this->session->userdata('user_login_id');

        //section details
        $data['current_section'] = 'Foreign latter';//$staff_section[0]['name'];
        $data['current_controller'] = 'fgn_zone_pass';//$staff_section[0]['controller'];

        $this->load->view('FGN/zone_passing_process.php',$data);
    }else{
        redirect(base_url());
    }
}

public function getSmallPacketPassedItemsByOperator(){
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

               $listdata = $this->FGN_Application_model->get_small_parcket_passed_to($operator,$FGN_number='',$pass_to_status='Cage In',$office_name='',$pass_to_by='');

            if ($listdata) {

            	$count = 1;
            	$temp = '';
            	foreach ($listdata as $key => $tranDetails) {
            		$sn = $count++;

            		$temp .="<tr data-transid='".$tranDetails['FGN_small_packet_id']."' 
            		class='".$tranDetails['FGN_number']." tr".$tranDetails['FGN_small_packet_id']." receiveRow'> <td>".$sn."</td>
		                 <td>".$tranDetails['addressedto']."</td>
		                 <td>".$tranDetails['FGN_number']."</td>
		                 <td>".$tranDetails['serial']."</td>
		                 <td>".$tranDetails['hndlcharges']."</td>
		                 <td>".$tranDetails['boxnumber']."</td>
		                 <td>".$tranDetails['phone']."</td>
		                 <td>".$tranDetails['identity']."</td>
		                 <td><a href='#' 
		                 data-transid='".$tranDetails['FGN_small_packet_id']."'
		                 data-barcode='".$tranDetails['FGN_number']."' onclick='".$removefunction."(this)' 
		                 class=''><i class='fa fa-trash-o'></i> Remove</a></td>
		                 <td>
		                 <div class='form-check' style='padding-left: 53px;float:left'>
		                 <input type='checkbox' name='transactions' value='".$tranDetails['FGN_small_packet_id']."' class='form-check-input ".$tranDetails['FGN_number']."' style='padding-right:50px;' />
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


public function SmallPacketPassToCage(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$FGN_number = $this->input->post('FGN_number');
		$operator = $this->input->post('operator');
		$zonetype = $this->input->post('zonetype');
		$sn = $this->input->post('sn');
		$office_name = $this->input->post('office_name');

		//Time stamp
		$tz = 'Africa/Nairobi';
        $tz_obj = new DateTimeZone($tz);
        $today = new DateTime("now", $tz_obj);
        $date = $today->format('Y-m-d');
		
		if (!empty($FGN_number) && !empty($emid)) {
			//filter data by using barcode
			$listdata = $this->FGN_Application_model->get_small_parcket_passed_to($whom_passed_to='',$FGN_number,$pass_to_status='',$office_name,$pass_to_by='');
		
			if ($listdata) {

				//process of passing
				$data = array(
				'pass_to'=>$operator,
				'office_name'=>'Small Packet cage',
				'pass_to_by'=>$emid,
				'pass_to_status'=>'Cage In',
				'pass_to_date'=>$date);

				$this->FGN_Application_model->update_small_packet_data($data,$listdata[0]['FGN_small_packet_id']);

				$count = 1;
				$temp = '';
				$removefunction = 'test';
				foreach ($listdata as $key => $tranDetails) {
					$sn = (!empty($sn))? $sn:$count++;

					$temp .="<tr data-transid='".$tranDetails['FGN_small_packet_id']."' 
            		class='".$tranDetails['FGN_number']." tr".$tranDetails['FGN_small_packet_id']." receiveRow'> <td>".$sn."</td>
		                 <td>".$tranDetails['addressedto']."</td>
		                 <td>".$tranDetails['FGN_number']."</td>
		                 <td>".$tranDetails['serial']."</td>
		                 <td>".$tranDetails['hndlcharges']."</td>
		                 <td>".$tranDetails['boxnumber']."</td>
		                 <td>".$tranDetails['phone']."</td>
		                 <td>".$tranDetails['identity']."</td>
		                 <td><a href='#' 
		                 data-transid='".$tranDetails['FGN_small_packet_id']."'
		                 data-barcode='".$tranDetails['FGN_number']."' onclick='".$removefunction."(this)' 
		                 class=''><i class='fa fa-trash-o'></i> Remove</a></td>
		                 <td>
		                 <div class='form-check' style='padding-left: 53px;float:left'>
		                 <input type='checkbox' name='transactions' value='".$tranDetails['FGN_small_packet_id']."' class='form-check-input ".$tranDetails['FGN_number']."' style='padding-right:50px;' />
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

        $listdata = $this->FGN_Application_model->get_small_parcket_passed_to($emid,$FGN_number='',$pass_to_status='Cage In',$office_name='Small Packet cage',$pass_to_by='');

        /*$service_type = 'OutBound';

        $this->session->set_userdata('Ask_for','Parcels-Post');
        $this->session->set_userdata('service_type',$service_type);
        $this->session->set_userdata('service_type_new','OutBound');

        $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

        $data['despout'] = $this->unregistered_model->count_despatch();
        $data['despin'] = $this->unregistered_model->count_despatch_in();
        $data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
        $data['bags'] = $this->Box_Application_model->count_bags();*/

        $data['current_section'] = 'Small Packet cage';//$staff_section[0]['name'];
        $data['current_controller'] = 'Small_Packets';//$staff_section[0]['controller'];

       if (!empty($listdata)) {
        
           foreach ($listdata as $key => $list) {
                $emplyo = $this->employee_model->GetBasic($list['pass_to_by']);

                $NewList[$list['pass_to_by']]['fullname'] = $emplyo->first_name.' '.$emplyo->middle_name.' '.$emplyo->last_name;
                $NewList[$list['pass_to_by']]['em_sub_role'] = 'Foreign latter';
                //$NewList[$list['pass_to_by']]['em_sub_role'] = $emplyo->em_sub_role;
                $NewList[$list['pass_to_by']]['em_image'] = $emplyo->em_image;
                $NewList[$list['pass_to_by']]['pass_from'] = 'Foreign latter';
                //$NewList[$list['pass_to_by']]['pass_from'] = $list['pass_to_by'];
                $NewList[$list['pass_to_by']]['last_name'] = $emplyo->last_name;
                //$NewList[$list['created_by']]['total'] = count($list['created_by']);
            }
            $data['counter_list'] = $NewList;
       }

        $this->load->view('FGN/packet_cage.php',$data);
    }else{
        redirect(base_url());
    }
}

public function get_Foreign_latter_sentList(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$pass_to_by = $this->input->post('emid');
		$office_name = $this->input->post('office_name');
		$return_to = 'packet_cage';//$this->input->post('controller');

		if (!empty($emid)) {

			$listdata = $this->FGN_Application_model->get_small_parcket_passed_to($emid,$FGN_number='',$pass_to_status='Cage In',$office_name,$pass_to_by);


			if ($listdata) {

				$count = 1;
				$temp = '';
				foreach ($listdata as $key => $tranDetails) {
					$sn = $count++;

					$temp .="<tr data-emid='".$emid."' data-transid='".$tranDetails['FGN_small_packet_id']."' class='".$tranDetails['FGN_number']." tr".$tranDetails['FGN_small_packet_id']." receiveRow'> 
						<td>".$sn."</td>
		                 <td>".$tranDetails['addressedto']."</td>
		                 <td>".$tranDetails['FGN_number']."</td>
		                 <td>".$tranDetails['serial']."</td>
		                 <td>".$tranDetails['hndlcharges']."</td>
		                 <td>".$tranDetails['boxnumber']."</td>
		                 <td>".$tranDetails['phone']."</td>
		                 <td>".$tranDetails['identity']."</td>
		                 <td>
		                 <div class='form-check' style='padding-left: 53px;float:left'>
		                 <input type='checkbox' name='transactions' value='".$tranDetails['FGN_small_packet_id']."' class='form-check-input ".$tranDetails['FGN_number']."' style='padding-right:50px;' />
	                            <label class='form-check-label' for='remember-me'></label>
	                            </div></td></tr>";

				}

				$temp .='<tr><td colspan="7"></td><td style="float: right;">
				<a class="btn btn-success" href="'.base_url().'Packet_Application/'.$return_to.'" class="text-white"><i class="" aria-hidden="true"></i> Receive </a>
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


public function SmallPacket_cage_receive(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$FGN_number = $this->input->post('barcode');
		$transid = $this->input->post('transid');
		$passfrom = $this->input->post('passfrom');

		if (!empty($FGN_number) && !empty($transid)) {

			//Time stamp
			$tz = 'Africa/Nairobi';
	        $tz_obj = new DateTimeZone($tz);
	        $today = new DateTime("now", $tz_obj);
	        $date = $today->format('Y-m-d');
			
			//process of passing
			$data = array(
			'office_name'=>'Small Packet cage receive',
			'pass_to_status'=>'Cage In receive',
			'pass_to_receive_date'=>$date);

			$this->FGN_Application_model->update_small_packet_data($data,$transid);

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

public function getBarcodeData(){
	if ($this->session->userdata('user_login_access') != false){
		$emid = $this->session->userdata('user_login_id');
		$FGN_number = $this->input->post('barcode');

		if (!empty($emid)) {

			$listdata = $this->FGN_Application_model->get_small_parcket_passed_to($operator='',$FGN_number,$pass_to_status='',$office_name='',$pass_to_by='');

			if ($listdata) {

				$response['status'] = "Success";
     			$response['msg'] = $listdata[0];
				
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

public function item_packet_transfer(){
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

            $listdata = $this->FGN_Application_model->get_small_parcket_passed_to_date($operator,$FGN_number='',$pass_to_status='Cage In',$office_name='Small Packet cage',$emid,$fromdate,$todate);

            if ($listdata) {

            	foreach ($listdata as $key => $tranDetails) {
            		$newList[$tranDetails['FGN_number']]['FGN_number'] = $tranDetails['FGN_number'];
            		$newList[$tranDetails['FGN_number']]['addressedto'] = $tranDetails['addressedto'];
            		$newList[$tranDetails['FGN_number']]['serial'] = $tranDetails['serial'];
            		$newList[$tranDetails['FGN_number']]['hndlcharges'] = $tranDetails['hndlcharges'];
            		$newList[$tranDetails['FGN_number']]['boxnumber']  = $tranDetails['boxnumber'];
            		$newList[$tranDetails['FGN_number']]['phone']  = $tranDetails['phone'];
            		$newList[$tranDetails['FGN_number']]['identity']  = $tranDetails['identity'];
            	}

            	$data['listdata'] = $newList;

            }
        }

        $this->load->view('FGN/transfer_packet_list',$data);
    }else{
        redirect(base_url());
    }
}


}