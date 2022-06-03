<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_box extends CI_Controller {
	
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
		
		if ($this->session->userdata('user_login_access') == false){
			redirect(base_ur());
		}
		
    }
	
	public function callnote(){	
	$data['design'] = $this->employee_model->getdesignation();
    $this->load->view('inlandMails/mails_callnote',$data);	
	}
	
	public function print_callnote(){
	$name = $this->input->post('name');
	$address = $this->input->post('address');
	$identifier = $this->input->post('identifier');
	$name2 = $this->input->post('name');
	$address2 = $this->input->post('address');
	$identifier2 = $this->input->post('identifier');
	//$fplno = $this->input->post('fplno');
	$emid = $this->session->userdata('user_login_id');
	       $basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$branch = $basicinfo->em_branch;
	    
	 
	        $data = [];
	         $data123 = [];
			foreach($name as $key => $value) {
			
					$name =$value;
					$addressk =$address[$key];
					//$fplno =$fplno[$key];
					$barcode =$identifier[$key];
					$senderid ="";

					if($barcode==''){
					    redirect('Mail_box/callnote');	
					    }
						//check if barcode already exist
						//$checking = $this->Mail_box_callnote_model->track_waiting_info($barcode);
						// if($checking==1)
						// {
						//  $this->session->set_flashdata('feedback','Warning! Barcode already exist in Bulk Call Note, Please enter different barcode');	
						// }
						// else
						// {
						$values = $this->Mail_box_callnote_model->search_mail_bulk_paid($barcode);

						if($values)
						{
							$getcounterletter = $this->Mail_box_callnote_model-> getmailTracingCounter($barcode);
							if(!empty($getcounterletter)){

							 $office_name = $getcounterletter->office_name;
							 $counterletter = str_replace('Counter ', '', $office_name);
							 $fplno=$this->getserial($counterletter);
							
							}else{
								if($region == 'GPO'){
									$getcounterletter = $this->Mail_box_callnote_model->getmailTracingCounterbylast_emid($emid);
									$office_name = $getcounterletter->office_name;
									 $counterletter = str_replace('Counter ', '', $office_name);
									 $fplno=$this->getserial($counterletter);

								}else{
									 $fplno=$this->getserial2();
								}

								

							}
							
				            $senderid = $values->register_id;
				     //    echo 'fplno '.$fplno.' address id '.$address.' name'.$emid;
					    // $this->Mail_box_callnote_model->insert_callnotes($emid,$barcode,$senderid,$name,$address,$fplno);
				            

					    $callnote = array(
						'name' =>$name,
						'address' =>$addressk, 
						'fplno' =>$fplno,
						'barcode'=>$barcode, 
						'callnote_senderid' =>$senderid,
						'branch'=>$branch, 
						'region' =>$region,
						'counter' =>$counterletter,
						'callnote_type' =>'single',
						'empid' =>$emid
					);

					//$save_callnote = $this->Mail_box_callnote_model->save_callnote($callnote);
					  $db2 = $this->load->database('otherdb', TRUE);
                      $db2->insert('bulk_callnote',$callnote);


                     $last_id = $db2->insert_id();

                     $createddate = date("YmdHis");
					   $mailnotiffication = array(
						'callnoteid' =>$last_id,
						'boxnumber' =>$addressk, 
						'fplno' =>$fplno,
						'barcode'=>$barcode,
						'createddate'=>$createddate
						
					);
                      $db2->insert('mailboxnotification',$mailnotiffication);



							$data[] = array (
					'name' => $name,
		            'address' => $addressk,
					'identifier' => $barcode,
					'branch' => $branch,
					 'fplno' => $fplno	);//$branch



					 //load library
					    $this->load->library('zend');
					    //load in folder Zend
					    $this->zend->load('Zend/Barcode');
					    $this->zend->load('Zend');
					  
					      //generate barcode
					     $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$barcode), array())->draw();
					     imagepng($imageResource, './assets/'.$fplno.'.png');
					     $barcodegenerator = './assets/'.$fplno.'.png';




						}else{
							
						 $this->session->set_flashdata('feedback','Warning! Barcode Not Paid, Please enter different barcode');	
						 redirect($this->agent->referrer());
						
						}


						

						//}
            }

            foreach($name2 as $key => $value) {
			
					$name=$value;
					$addressg =$address2[$key];
					//$fplno =$fplno[$key];
					$barcode =$identifier2[$key];
	               $get_callnote = $this->Mail_box_callnote_model->get_callnote_byBarcode($barcode);

						$data123[] = array (
					'name' => $name,
		            'address' => $addressg,
					'identifier' => $barcode,
					'branch' => $branch,
					 'fplno' => $get_callnote->fplno	);//$branch
				}

				//echo json_encode($data123);

            $checked_services['services'] = $data123;
 
		            $this->load->library('Pdf');
		            $html= $this->load->view('inlandMails/mails_callnote_print',$checked_services,TRUE);
		            $this->load->library('Pdf');
		            $this->dompdf->loadHtml($html);
		            $this->dompdf->setPaper('A4','potrait');
		            $this->dompdf->render();
		            ob_end_clean();
		            $this->dompdf->stream('callnote.pdf', array("Attachment"=>0));	 	


           // $this->load->view('inlandMails/mails_callnote',$data);	
			
		
	}

	public function getserial($counterletter){
	$emid = $this->session->userdata('user_login_id');
       $basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$branch = $basicinfo->em_branch;
        $getuniquelastnumber= $this->Mail_box_callnote_model->get_last_flpnumber($branch,$region,$counterletter);
     // $numbers = @$getuniquelastnumber->fplno;  //A-01
            //check length
            if(empty(@$getuniquelastnumber->fplno) ){
            	
                $number = 1;

            }else{
                $numbers = @$getuniquelastnumber->fplno;  //A-01
                $str2 = substr($numbers, 2);//01
                $number=(int)$str2+1;
            }

            return $counterletter.'-'.$number;
    }

    public function getserial2(){
	$emid = $this->session->userdata('user_login_id');
       $basicinfo = $this->employee_model->GetBasic($emid);
			$region = $basicinfo->em_region;
			$branch = $basicinfo->em_branch;
        $getuniquelastnumber= $this->Mail_box_callnote_model->get_last_flpnumbers($branch,$region);
     // $numbers = @$getuniquelastnumber->fplno;  //A-01
            //check length
            if(empty(@$getuniquelastnumber->fplno) ){
            	
                $number = 1;

            }else{
                $numbers = @$getuniquelastnumber->fplno;  //A-01
                //$str2 = substr($numbers, 2);//01
                $number=(int)$numbers+1;
            }

            return $number;
    }

    public function single_callnote(){	
    	$empid =  $this->session->userdata('user_emid');
    	  $basicinfo = $this->employee_model->GetBasic($empid);
			$region = $basicinfo->em_region;
			$data['branch'] = $branch = $basicinfo->em_branch;
	$data['maillist'] = $this->Mail_box_callnote_model->get_callnote_list($empid,$region,$branch);
    $this->load->view('inlandMails/mails_single_callnote',$data);	
	}

		public function print_single_callnote(){
	$empid =  $this->session->userdata('user_emid');
    $callnote_id = $this->input->get('id');
	 $get_callnote = $this->Mail_box_callnote_model->get_callnote_byid($callnote_id);
      $data123 = [];
						$data123[] = array (
					'name' => $get_callnote->name,
		            'address' => $get_callnote->address,
					'identifier' => $get_callnote->barcode,
					'branch' => $get_callnote->branch,
					 'fplno' => $get_callnote->fplno	);//$branch

           
     
                   $checked_services['services'] = $data123;
 
		            $this->load->library('Pdf');
		            $html= $this->load->view('inlandMails/mails_callnote_print',$checked_services,TRUE);
		            $this->load->library('Pdf');
		            $this->dompdf->loadHtml($html);
		            $this->dompdf->setPaper('A4','potrait');
		            $this->dompdf->render();
		            ob_end_clean();
		            $this->dompdf->stream('callnote.pdf', array("Attachment"=>0));
	}
	
	public function bulk_callnote(){	
	$data['maillist'] = $this->Mail_box_callnote_model->get_mail_bulk_callnote();
    $this->load->view('inlandMails/mails_bulk_callnote',$data);	
	}
	
	public function group_bulk_callnote(){	
	$data['maillist'] = $this->Mail_box_callnote_model->get_group_bulk_callnote();
    $this->load->view('inlandMails/mails_bulk_callnote_group',$data);	
	}
	
	public function print_bulk_callnote(){
	$empid =  $this->session->userdata('user_emid');
    $groupid = $this->input->get('groupid');
	$data['info'] = $this->ContractModel->get_employee_info($empid);
    $data['emslist'] =$emslist= $this->Mail_box_callnote_model->print_group_bulk_callnote($groupid);
	$data['receipient'] =$receipient= $this->Mail_box_callnote_model->receipient_group_bulk_callnote($groupid);
	$this->Mail_box_callnote_model->update_printed_status($groupid);

           $basicinfo = $this->employee_model->GetBasic($empid);
			$region = $basicinfo->em_region;
			$data['branch'] = $branch = $basicinfo->em_branch;


$fplno=@$receipient->fplno;
$barcode=@$receipient->barcode;


 //load library
    $this->load->library('zend');
    //load in folder Zend
    $this->zend->load('Zend/Barcode');
    $this->zend->load('Zend');
  
      //generate barcode
       $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$barcode), array())->draw();
       imagepng($imageResource, './assets/'.$fplno.'.png');
           $data['barcodegenerator'] = $barcodegenerator = './assets/'.$fplno.'.png';
           
     

    $this->load->library('Pdf');
    $html= $this->load->view('inlandMails/mails_bulk_callnote_print',$data,TRUE);
    $this->load->library('Pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('A4','potrait');
    $this->dompdf->render();
    ob_end_clean();
    $this->dompdf->stream('bulk-callnote.pdf', array("Attachment"=>0));	
	}
	
	public function find_barcode(){
	$empid = $this->session->userdata('user_emid');
	$barcode = $this->input->post('code');
	if($barcode==''){
    redirect('Mail_box/bulk_callnote');	
    }
	//check if barcode already exist
	$checking = $this->Mail_box_callnote_model->track_waiting_info($barcode);
	if($checking==1)
	{
	 $this->session->set_flashdata('feedback','Warning! Barcode already exist in Bulk Call Note, Please enter different barcode');	
	}
	else
	{
    $value = $this->Mail_box_callnote_model->search_mail_bulk($barcode);
	if($value)
	{
	$senderid = $value->register_id;
	//insert bulk call note
	//$this->Mail_box_callnote_model->insert_callnote($empid,$barcode,$senderid);
	$basicinfo = $this->employee_model->GetBasic($empid);
								$region = $basicinfo->em_region;
								$branch = $basicinfo->em_branch;

							

							 		$getcounterletter = $this->Mail_box_callnote_model->getmailTracingCounter($barcode);
							if(!empty($getcounterletter)){

							 $office_name = $getcounterletter->office_name;
							 $counterletter = str_replace('Counter ', '', $office_name);
							

							}else{
								if($region == 'GPO'){
									$getcounterletter = $this->Mail_box_callnote_model->getmailTracingCounterbylast_emid($empid);
									$office_name = $getcounterletter->office_name;
									 $counterletter = str_replace('Counter ', '', $office_name);
									

								}else{
									 $counterletter = '';
								}

								

							}



							 //$fplno=$this->getserial($counterletter);
							   
							
				            

					    $callnote = array(
						
						'barcode'=>$barcode, 
						'callnote_senderid' =>$senderid,
						'branch'=>$branch, 
						'region' =>$region,
						'counter' =>$counterletter,
						'empid' =>$empid
					);

					$save_callnote = $this->Mail_box_callnote_model->save_callnote($callnote);


    $this->session->set_flashdata('success','Barcode number has been successfully added on the bulk call note');	
	}
    else
	{
    $this->session->set_flashdata('feedback','Warning! Barcode number does not exit, Please try again');	
	}
	}
	redirect($this->agent->referrer());
	}
	
	public function delete_callnote_item(){
	$delete = $this->input->get('id');
    $results = $this->Mail_box_callnote_model->delete_callnote($delete);
	if($results)
	{
    $this->session->set_flashdata('success','Item has been successfully deleted on the bulk call note');
	}
    else
	{
	$this->session->set_flashdata('feedback','Warning! failed to delete item on the bulk call note');
	}
	redirect($this->agent->referrer());
	}
	
	public function create_callnote_group(){
	$empid = $this->session->userdata('user_emid');
	$address = $this->input->post('address');
	$customerid = $this->input->post('senderid');
	$groupname = $this->input->post('groupname');
	if(!empty($groupname) && !empty($customerid)){
	$groupno = $this->input->post('groupno');
	//insert group
	$results = $this->Mail_box_callnote_model->add_callnote_group($groupname,$empid,$groupno);

    if($results){
   //retrieve group ID		
	$value = $this->Mail_box_callnote_model->get_callnote_groupid($groupno);
	$groupid = $value->callnote_groupid;
	foreach($customerid as $senderid){

		$barcodes = $this->Mail_box_callnote_model->get_callnote_byid($senderid);
		$counterletter = @$barcodes->counter;
							 $fplno=@$this->getserial($counterletter);
							 echo 'counterletter '.$counterletter.' fplno '.$fplno;
							 //update flpno

							    $data2 = array(); 
							    $data2 = array(
								  	'fplno'=>$fplno,
						            'address' =>$address,
									'callnote_groupid'=>$groupid,
									'callnote_type'=>'bulk'
							    );

							 $callnote_id = $senderid;
							 $this->Mail_box_callnote_model->update_bulk_callnotes($callnote_id,$data2);
			//$this->Mail_box_callnote_model->update_bulk_callnote($groupid,$senderid);

					 $db2 = $this->load->database('otherdb', TRUE);
					 $barcode = @$barcodes->barcode;
					 $createddate = date("YmdHis");
					   $mailnotiffication = array(
						'callnoteid' =>$callnote_id,
						'boxnumber' =>$address, 
						'fplno' =>$fplno,
						'barcode'=>$barcode, 
						'createddate'=>$createddate
						
					);
                      $db2->insert('mailboxnotification',$mailnotiffication);
	}
	$this->session->set_flashdata('success','Bulk call note group has been successfully created');
	}
    else
	{
	$this->session->set_tempdata('groupfailed',TRUE,1);
	redirect('Delivery/mail_bulk_delivery');	
	}	
	}
	else
	{
	$this->session->set_flashdata('feedback','Warning! Bulk call note group cannot be empty and you must select atleast one item or more, Try again');
	}
	redirect($this->agent->referrer());
	}
	
	
	
	
	
}