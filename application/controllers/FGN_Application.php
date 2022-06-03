<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FGN_Application extends CI_Controller {

	
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

// if ($this->session->userdata('user_login_access') == false){
// 			redirect(base_ur());
// }

}

   public function add_fgn() {
   	$data['region'] = $this->employee_model->regselect();
   	//$data['outsidesmallpacket'] = $this->FGN_Application_model->outside_small_parcket();
    $this->load->view('FGN/add_fgn',$data);
   }



    public function Receive() {
    	$emid = $this->session->userdata('user_login_id');
       $basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$em_branch = $basicinfo->em_branch;

   	$data['region'] = $this->employee_model->regselect();
   	$data['outsidesmallpacket'] = $this->FGN_Application_model->receive_small_parcket_list($region,$em_branch);
    $this->load->view('FGN/Receive',$data);
   }

    public function Itemize() {
   	$data['region'] = $this->employee_model->regselect();
   	$data['outsidesmallpacket'] = $this->FGN_Application_model->outside_small_parcket();
    $this->load->view('FGN/Itemize',$data);
   }

    public function Pass() {
   	$data['region'] = $this->employee_model->regselect();
   	$data['outsidesmallpacket'] = $this->FGN_Application_model->outside_small_parcket();
    $this->load->view('FGN/Pass',$data);
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


public function print_Packet_reports()
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

        


$data['reports'] =$reports = $this->FGN_Application_model->pending_small_parcket($emid,$rec_branch);
//  $this->FGN_Application_model->pending_small_parcket_list($emid,$rec_branch);
$data['report'] =$report = $reports[0];
//echo json_encode($reports);
  $data['staff'] = $user ;

  //$result= json_encode($report);
 // echo  $report->created_by;

 if(!empty($report->created_by)){
			
 $this->load->library('Pdf');
 $html= $this->load->view('FGN/Print_small_Packets',$data,TRUE);
 $this->dompdf->loadHtml($html);
 $this->dompdf->setPaper('A4','potrait');
 $this->dompdf->render();
 ob_end_clean();
 $this->dompdf->stream('Print_small_Packets'.date('d-m-Y').'.pdf', array("Attachment"=>FALSE));
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

		if (!empty($emid)) {
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
						'branch_from' =>$em_branch
					);

					$bagnoId = $this->FGN_Application_model->save_small_packet($packet);

					//$bagnoId = $this->Box_Application_model->save_bag($bagInfor);

					//$select = '<option selected value="'.$bagnoId.'">'.$bagno['num'].'</option>';
						//$select = '<option selected value="'.$bagnoId.'">'.$bagno.'</option>';

					//$bagnoText = $bagno;//bag name

					$emslist = $this->FGN_Application_model->pending_small_parcket($emid,$rec_branch);

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
     		$response['msg'] = "No pf number";
		}

		print_r(json_encode($response));
	}else{
		redirect(base_url());
	}
}


}