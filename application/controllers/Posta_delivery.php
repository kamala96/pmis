<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Posta_delivery extends CI_Controller {
	
	    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('kpi_model');
		$this->load->model('Mail_box_callnote_model');
	    $this->load->model('ContractModel');
	    $this->load->model('Delivery_Model');
		
		if ($this->session->userdata('user_login_access') == false){
			redirect(base_url());
		}
		
    }


    public function mails_dashboard(){
    $this->load->view('delivery/mails_dashboard');
    }

    public function callnote(){	
	$data['design'] = $this->employee_model->getdesignation();
    $this->load->view('delivery/register_callnote',$data);	
	}

	public function print_callnote(){
	$name = $this->input->post('name');
	$address = $this->input->post('address');
	$identifier = $this->input->post('identifier');

		//load library
		$this->load->library('zend');
		//load in folder Zend
		$this->zend->load('Zend/Barcode');
		$this->zend->load('Zend');


	
	        $data = [];
			foreach($name as $key => $value) {  
			//generate barcode
		   $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$identifier[$key]), array())->draw();
		   imagepng($imageResource, './assets/'.$identifier[$key].'.png');
           $barcodegenerator = './assets/'.$identifier[$key].'.png';

         
           //  imagepng($imageResource, './assets/Barcode/'.$identifier[$key].'.png');
           // $barcodegenerator = './assets/Barcode/'.$identifier[$key].'.png';

			$data[] = array (
			'name' => $value,
            'address' => $address[$key],
			'identifier' => $identifier[$key],
			'barcodegenerator' => $barcodegenerator
			);
            }



          $check= $barcodegenerator.'   na hii '.$imageResource.' '.$identifier[$key].'  image source'.$imageResource;





// $this->load->library('zend');
//   $this->zend->load('Zend/Barcode');
//   $id=$this->input->post('id');
//         $barcodeOptions = array('text' => $id);
//         $rendererOptions = array('imageType'          =>'png', 
//                                  'horizontalPosition' => 'center', 
//                                  'verticalPosition'   => 'middle');
//   $imageResource=Zend_Barcode::factory('code128', 'image', $barcodeOptions, $rendererOptions)->render();
//         return $imageResource;
     

//      $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$barcode), array())->draw();
// imagepng($imageResource, 'public_html/img/barcode.png');



			
			$checked_services['services'] = $data;
			$checked_services['check'] = $check;
 
            $this->load->library('Pdf');
            $html= $this->load->view('delivery/register_callnote_print',$checked_services,TRUE);
            $this->load->library('Pdf');
            $this->dompdf->loadHtml($html);
            $this->dompdf->setPaper('A4','potrait');
            $this->dompdf->render();
            ob_end_clean();
            $this->dompdf->stream('callnote.pdf', array("Attachment"=>0));	 
	}

    public function mail_single_delivery(){
	$this->load->view('delivery/mail_single_delivery');
	}

		//SINGLE SINGLE
	public function search_single_mail_bulk(){
	$barcode = $this->input->post('code');

	if(empty($barcode)){
	redirect('Posta_delivery/mail_single_delivery');
	}
    ///if barcode is delivery or not
    $checkBarcode = $this->Delivery_Model->search_mail_bulk($barcode);
	if($checkBarcode){

	if(@$checkBarcode->sender_status=="Derivery"){
	$deliveryinfo = $this->Delivery_Model->get_delivery_full_information(@$checkBarcode->senderp_id);
	$this->session->set_flashdata('feedback','Barcode number hii '.strtoupper(@$barcode).' imeshafanyiwa Delivery. <hr> Taarifa za Mpokeaji:- <hr> Jina: '.@$deliveryinfo->deliverer_name.'<br> Namba ya Simu: '.@$deliveryinfo->phone.'<br> Tarehe Aliyopokea: '.@$deliveryinfo->datetime.'<br> Kitambulisho: '.@$deliveryinfo->identity.' - '.@$deliveryinfo->identityno.'');
	redirect('Posta_delivery/mail_single_delivery');

	} else {

	///////Check if barcode exist on bulk call note
	$callnoteinfo =  $this->Delivery_Model->check_bulk_callnote_information($barcode);

	if($callnoteinfo->callnote_type=="single"){
	$value = $this->Delivery_Model->get_mail_info($barcode);
	$data['deliveryinformation'] = "Single Register Delivery information";
	$data['deliverytype'] = "single";
	$data['senderid'] = $value->register_id;
	$data['barcode'] = $barcode;
	$data['origin'] =  $value->sender_region.'-'.$value->sender_branch;
	$data['destination'] = $value->receiver_region.'-'.$value->reciver_branch;
	$this->load->view('delivery/mail_single_delivery',$data);
	////////////Single Call Note information
	} elseif($callnoteinfo->callnote_type=="bulk"){
	//////////Bulk Call Note Information
	//$this->session->set_flashdata('message','Bulk Delivery');
	//redirect('Posta_delivery/mail_single_delivery');
	$data['list'] = $this->Delivery_Model->get_group_barcode_items(@$callnoteinfo->callnote_groupid);
	$data['groupid'] = @$callnoteinfo->callnote_groupid;
	$this->load->view('delivery/mail_single_delivery',$data);
	} elseif($callnoteinfo->callnote_type=="pending") {
	/////////Pending Call note Information
	$this->session->set_flashdata('feedback','Huwezi kuendelea kufanya Delivery kwa sababu Barcode bado ipo pending, Tafadhali Jaribu Tena au wasiliana na watu wa support kwa ajili ya msaada zaidi!');
	redirect('Posta_delivery/mail_single_delivery');
	} else {

	$this->session->set_flashdata('feedback','Sahamani! Barcode number haipo kwenye orodha ya Bulk Call Note, Tafadhali jaribu tena');
	redirect('Posta_delivery/mail_single_delivery');

	}


	}

	
	} else {
	$this->session->set_flashdata('feedback','Tafadhali weka barcode number sahihi kuendelea na huduma');
	redirect('Posta_delivery/mail_single_delivery');
	}

	
	}

	public function submit_group_mail_single_delivery(){
	$region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
    $location = $branch.'-'.$region;

	$groupid = $this->input->post('groupid');
	$empid = $this->session->userdata('user_emid');
	$phone = $this->input->post('phone');
	$name = $this->input->post('name');
	$identity = $this->input->post('identity');
	$identityno = $this->input->post('identityno');
	$deliverydate = date("Y-m-d",strtotime($this->input->post('deliverydate')));

	$list = $this->Delivery_Model->get_group_barcode_items($groupid);
	foreach($list as $data){
	$value = $this->Delivery_Model->get_mail_info($data->barcode);

	$SaveDelivery = array(
    'em_id'=>@$empid,
    'item_id'=>@$value->senderp_id,
    'deliverer_name'=>@$name,
    'phone'=>@$phone,
    'identity'=>@$identity,
    'identityno'=>@$identityno,
    'd_status'=>'Yes',
    'operator'=>@$empid,
    'image'=>'',
    'service_type'=>'POS',
    'location'=>@$location,
    'deriveryDate'=>@$deliverydate
	);
    $this->Delivery_Model->insert_delivery_information($SaveDelivery);

    ///////Update Delivery Information
    $UpdateDelivery = array('sender_status'=>'Derivery');
    $this->Delivery_Model->Update_delivery_information($UpdateDelivery,@$value->senderp_id);
 
    }

	//$this->Delivery_Model->update_mail_sender_info_status($senderid);
	$this->session->set_flashdata('success','Bulk Delivery information has been successfully submitted');
	redirect('Posta_delivery/mail_single_delivery');

	}

		//PRINT SINGLE MAIL
	public function print_mail_single_delivery_report(){
    $empid = $this->session->userdata('user_emid');
    $printcode = rand();
    $data['emslist'] = $this->Delivery_Model->get_single_mail_virtuebox($empid);
    $this->load->library('Pdf');
    $html= $this->load->view('delivery/delivery_bulk_mail_reports',$data,TRUE);
    $this->load->library('Pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('A4','potrait');
    $this->dompdf->render();
    ob_end_clean();
    $this->dompdf->stream($printcode, array("Attachment"=>0));	
	}

	public function delete_single_mail_delivery(){
	$delete = $this->input->get('id');
    $results = $this->Delivery_Model->delete_virtue_box($delete);
	if($results)
	{
    $this->session->set_tempdata('successdeleted',TRUE,1);
	redirect('Posta_delivery/mail_single_delivery');
	}
    else
	{
	$this->session->set_tempdata('failed',TRUE,1);
	redirect('Posta_delivery/mail_single_delivery');
	}	
	}

	//MAIL assign delivery
	public function submit_mail_single_delivery(){
	$region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
    $location = $branch.'-'.$region;

	$senderid = $this->input->post('senderid');
	$empid = $this->session->userdata('user_emid');
	$phone = $this->input->post('phone');
	$name = $this->input->post('name');
	$identity = $this->input->post('identity');
	$identityno = $this->input->post('identityno');
	$deliverydate = date("Y-m-d",strtotime($this->input->post('deliverydate')));

	$SaveDelivery = array(
    'em_id'=>@$empid,
    'item_id'=>@$senderid,
    'deliverer_name'=>@$name,
    'phone'=>@$phone,
    'identity'=>@$identity,
    'identityno'=>@$identityno,
    'd_status'=>'Yes',
    'operator'=>@$empid,
    'image'=>'',
    'service_type'=>'POS',
    'location'=>@$location,
    'deriveryDate'=>@$deliverydate
	);
    $this->Delivery_Model->insert_delivery_information($SaveDelivery);

    ///////Update Delivery Information
    $UpdateDelivery = array('sender_status'=>'Derivery');
    $this->Delivery_Model->Update_delivery_information($UpdateDelivery,$senderid);

	//$this->Delivery_Model->update_mail_sender_info_status($senderid);
	$this->session->set_flashdata('success','Single Delivery information has been successfully submitted');
	redirect('Posta_delivery/mail_single_delivery');

	}


	
	
}