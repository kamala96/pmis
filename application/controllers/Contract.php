 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract extends CI_Controller {
	
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
		
		if ($this->session->userdata('user_login_access') == false){
			redirect(base_ur());
		}
		
    }
	
	public function tpc_contract()
	{
            $data['design'] = $this->employee_model->getdesignation();
            $this->load->view('tpc_contract/contract',$data);
    }
	
	public function reports()
	{
            $data['design'] = $this->employee_model->getdesignation();
            $this->load->view('tpc_contract/reports',$data);
    }

    public function task_performance_reports(){
    $data['design'] = $this->employee_model->getdesignation();
    $data['regions'] = $this->employee_model->regselect();
    $this->load->view('tpc_contract/assigned_task_performace_reports',$data);
    }


    public function receiver_performance_reports(){
    $data['design'] = $this->employee_model->getdesignation();
    $data['regions'] = $this->employee_model->regselect();
    $this->load->view('tpc_contract/received_task_performace_reports',$data);
    }

    public function general_receiver_performance_reports(){
    $data['design'] = $this->employee_model->getdesignation();
    $this->load->view('tpc_contract/general_receiver_performance_reports',$data);
    }

    public function find_receiver_task_performance_reports(){
            $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
			$todate = date("Y-m-d",strtotime($this->input->post('todate')));
			$empid = $this->input->post('empid');

			$list = $this->ContractModel->received_get_assigned_task_performance($fromdate,$todate,$empid);
			if(!empty($list))
			{
			$data['list'] = $this->ContractModel->received_get_assigned_task_performance($fromdate,$todate,$empid);
			$data['design'] = $this->employee_model->getdesignation();	
			$data['regions'] = $this->employee_model->regselect();
			$this->load->view('tpc_contract/received_task_performace_reports',$data);
			}
			else
			{
			$this->session->set_flashdata('smessage','Report not found, Please try again');	
            redirect('Contract/receiver_performance_reports');		
			}
            
    }

    public function view_find_receiver_task_performance_reports(){
            $fromdate = base64_decode($this->input->get('F'));
			$todate = base64_decode($this->input->get('T'));
			$empid = base64_decode($this->input->get('I'));

			$list = $this->ContractModel->received_get_assigned_task_performance($fromdate,$todate,$empid);
			if(!empty($list))
			{
			$data['list'] = $this->ContractModel->received_get_assigned_task_performance($fromdate,$todate,$empid);
			$data['design'] = $this->employee_model->getdesignation();	
			$data['regions'] = $this->employee_model->regselect();
            $info = $this->ContractModel->get_employee_info($empid);
            $data['ename'] = 'PF Number '.@$info->em_code.'-'.@$info->first_name.' '.@$info->middle_name.' '.@$info->last_name;
			$this->load->view('tpc_contract/view_employee_received_performance',$data);
			}
			else
			{
			$this->session->set_flashdata('smessage','Report not found, Please try again');	
            redirect('Contract/receiver_performance_reports');		
			}
            
    }

        public function find_general_received_task_general_reports(){
            $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
			$todate = date("Y-m-d",strtotime($this->input->post('todate')));

			$individuallist = $this->ContractModel->group_general_received_get_assigned_task_performance($fromdate,$todate);
			$list = $this->ContractModel->general_received_get_assigned_task_performance($fromdate,$todate);
            
            $itemdata = array();

			if(!empty($individuallist)){

            ///Individual List
			foreach($individuallist as $value){
			//////Loop1
			$emid = $value->received_by;
            
            $totalweight=0; $sumtotalmarks=0;

			foreach($list as $row){
            /////looop2

			if($row->received_by==$emid){

			$totalweight+=@$row->weight;
			$sumtotalmarks+=@$row->rating;

			}

			}

			//////
		//$overalper = number_format(@$sumtotalmarks)/number_format(@$totalweight)*100;
		$itemdata[] = array('received_by'=>@$emid,'weight'=>@$totalweight,'rating'=>@$sumtotalmarks);

			}
              
            //$listdata=

            $data['listdata'] = @$itemdata;

            //print_r($data['listdata']);

			//$data['regions'] = $this->employee_model->regselect();
			$data['fromdate'] = $fromdate;
			$data['todate'] = $todate;
		    $data['design'] = $this->employee_model->getdesignation();	
			$this->load->view('tpc_contract/general_receiver_performance_reports',$data);
			}
			else
			{
			$this->session->set_flashdata('smessage','Report not found, Please try again');	
            redirect('Contract/general_reports');		
			}
    }

    public function general_reports(){
    $data['design'] = $this->employee_model->getdesignation();
    $this->load->view('tpc_contract/general_report',$data);
    }

    public function find_task_performance_reports(){
            $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
			$todate = date("Y-m-d",strtotime($this->input->post('todate')));
			$empid = $this->input->post('empid');

			$list = $this->ContractModel->new_get_assigned_task_performance($fromdate,$todate,$empid);
			if(!empty($list))
			{
			$data['list'] = $this->ContractModel->new_get_assigned_task_performance($fromdate,$todate,$empid);
			$data['design'] = $this->employee_model->getdesignation();	
			$data['regions'] = $this->employee_model->regselect();
			$this->load->view('tpc_contract/assigned_task_performace_reports',$data);
			}
			else
			{
			$this->session->set_flashdata('smessage','Report not found, Please try again');	
            redirect('Contract/task_performance_reports');		
			}
            
    }

    public function view_assigned_task_performance_reports(){
            $fromdate = base64_decode($this->input->get('F'));
			$todate = base64_decode($this->input->get('T'));
			$empid = base64_decode($this->input->get('I'));

			$list = $this->ContractModel->new_get_assigned_task_performance($fromdate,$todate,$empid);
			if(!empty($list))
			{
			$data['list'] = $this->ContractModel->new_get_assigned_task_performance($fromdate,$todate,$empid);
			$data['design'] = $this->employee_model->getdesignation();	
			//$data['regions'] = $this->employee_model->regselect();
			$info = $this->ContractModel->get_employee_info($empid);
            $data['ename'] = 'PF Number '.@$info->em_code.'-'.@$info->first_name.' '.@$info->middle_name.' '.@$info->last_name;
			$this->load->view('tpc_contract/view_assiged_task_performace',$data);
			}
			else
			{
			$this->session->set_flashdata('smessage','Report not found, Please try again');	
            redirect('Contract/task_performance_reports');		
			}
            
    }

    public function find_task_general_reports(){
            $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
			$todate = date("Y-m-d",strtotime($this->input->post('todate')));

			$individuallist = $this->ContractModel->individaul_general_report_assigned_task_performance($fromdate,$todate);
			$list = $this->ContractModel->general_report_assigned_task_performance($fromdate,$todate);
            
            $itemdata = array();

			if(!empty($individuallist)){

            ///Individual List
			foreach($individuallist as $value){
			//////Loop1
			$emid = $value->provided_by;
            
            $sumweight=0; $sumassigned=0; $sumtotalmarks=0; $sumavg=0;

			foreach($list as $row){
            /////looop2

			if($row->provided_by==$emid){
			$sumweight+=@$row->weight;
			$sumassigned+=@$row->totalassigned;
			$sumtotalmarks+=@$row->totalmarks;
			$sumavg+=@$row->taskaverage;
			}

			}

			////////
		$itemdata[] = array('provided_by'=>$emid,'weight'=>$sumweight,'totalassigned'=>$sumassigned,'totalmarks'=>$sumtotalmarks,'taskaverage'=>$sumavg);

			}
              
            //$listdata=

            $data['listdata'] = @$itemdata;

            //print_r($data['listdata']);

			//$data['regions'] = $this->employee_model->regselect();
			$data['fromdate'] = $fromdate;
			$data['todate'] = $todate;
		    $data['design'] = $this->employee_model->getdesignation();	
			$this->load->view('tpc_contract/general_report',$data);
			}
			else
			{
			$this->session->set_flashdata('smessage','Report not found, Please try again');	
            redirect('Contract/general_reports');		
			}
    }
	
	public function findbesttaff_report()
	{
            $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
			$todate = date("Y-m-d",strtotime($this->input->post('todate')));
			$results = $this->ContractModel->find_reports($fromdate,$todate);
			if($results)
			{
			$this->session->set_userdata('fromdate',$fromdate);
			$this->session->set_userdata('todate',$todate);
			$data['design'] = $this->employee_model->getdesignation();	
			$data['listbeststaff'] = $this->ContractModel->find_reports($fromdate,$todate);
			$this->load->view('tpc_contract/reports',$data);
			}
			else
			{
			$this->session->set_flashdata('message','Report not found, Please try again');	
            redirect(base_url('Contract/reports'));			
			}
            
    }
	
	public function view_task_list(){
	$fromdate = $this->input->get('fromdate');
	$todate = $this->input->get('todate');
	$empid = $this->input->get('empid');
	$data['info'] = $this->ContractModel->get_employee_info($empid);
	$data['design'] = $this->employee_model->getdesignation();
	$data['listtasks'] = $this->ContractModel->view_task_list($empid,$fromdate,$todate);
	$this->load->view('tpc_contract/view_task_list',$data);
	}
	
	public function bop_pmg_contract()
	{
            $data['design'] = $this->employee_model->getdesignation();
            $this->load->view('tpc_contract/bop_pmg_contract',$data);
    }
	
	public function pmg_gmcrm_contract()
	{
            $data['design'] = $this->employee_model->getdesignation();
            $this->load->view('tpc_contract/pmg_gmcrm_contract',$data);
    }
	
	public function performace_targets()
	{
            $empid = $this->session->userdata('user_emid');
			$data['design'] = $this->employee_model->getdesignation();
			$data['totalpending'] = $this->ContractModel->count_pending_targets();
			//$data['listtarget'] = $this->ContractModel->get_performance_target_list($empid);
			$data['listtarget'] = $this->ContractModel->get_performance_employee_target_list();
			//$data['markscounter'] = $this->ContractModel->counter_get_performance_employee_target_list();
            $this->load->view('tpc_contract/performace_targets',$data);
    }
	
	public function list_pending_targets()
	{
            $empid = $this->session->userdata('user_emid');
			$data['design'] = $this->employee_model->getdesignation();
			$data['totalpending'] = $this->ContractModel->count_pending_targets();
			$data['listtarget'] = $this->ContractModel->list_pending_targets();
            $this->load->view('tpc_contract/pending_targets',$data);
    }
	
	public function add_target(){
		$db2 = $this->load->database('otherdb', TRUE);
		$name = $this->input->post('name');
		$marks = $this->input->post('marks');
		$empid = $this->session->userdata('user_emid');
		
		$sumtotal=0;
		foreach($name as $key=>$value){
		$tmarks = $marks[$key];
		$sumtotal+=$tmarks;
		//$results = $this->ContractModel->add_target($value,$empid,$tmarks);
		}

		$marksinfo = $this->ContractModel->counter_get_performance_employee_target_list();
		$overallmarks =  @$marksinfo->totalmarks+$sumtotal;

		//////////message
		$getoverallmarks = 100-@$marksinfo->totalmarks;

		if($overallmarks<=100){
		////////SUCCESS
		foreach($name as $key=>$value){
		$tmarks = $marks[$key];
		$sumtotal+=$tmarks;
		$this->ContractModel->add_target($value,$empid,$tmarks);
		}
		$this->session->set_flashdata('message','Target has been successfully added');

		} else {
        $this->session->set_flashdata('feedback','Failed to add target, Your remaining marks: '.$getoverallmarks.'');	
		}
		
		/*if($results){
		$this->session->set_flashdata('message','Target has been successfully added');	
		}
		else
		{
		$this->session->set_flashdata('message','Failed to add new target, Please try again');	
		}*/
		
	redirect(base_url('Contract/performace_targets')); 
	}

	public function update_assigned_task_appraise(){
    $taskid = $this->input->post('taskid');
    $appraise = $this->input->post('appraise');

    $data = array();
    $data = array('appraise'=>$appraise);
	$this->ContractModel->update_assigned_task_information($data,$taskid);

	$this->session->set_flashdata('message','Appraise has been successfully updated');	
	redirect(base_url('Contract/my_tasks')); 
	}
	
	public function delete_target(){
		$targetid = $this->input->get('id');
		$results = $this->ContractModel->delete_target($targetid);
		if($results){
		$this->session->set_flashdata('message','Target has been successfully deleted');	
		}else
		{
		$this->session->set_flashdata('message','Failed to delete target, Please try again');		
		}
	redirect(base_url('Contract/performace_targets'));
	}
	
	public function delete_indicator(){
		$indicatorid = $this->input->get('id');
		$results = $this->ContractModel->delete_indicator($indicatorid);
		if($results){
		$this->session->set_flashdata('message','Activity has been successfully deleted');	
		}else
		{
		$this->session->set_flashdata('message','Failed to delete activity, Please try again');		
		}
	redirect($this->agent->referrer());
	}
	
	    public function approve_target_status(){
		$targetid = $this->input->post('targetid');
		$status = $this->input->post('status');
		
		foreach($targetid as $target){
		//retrieve all activities to approve_target_status
		$value = $this->ContractModel->list_approved_activities($target);
		foreach($value as $data){
		$activityid = $data->performance_indicators_id;
		$this->ContractModel->update_approved_activity($activityid,$status);
		}
		//update target status
        $results = $this->ContractModel->approve_target_selected($target,$status);	
		//SMS to the Target Creator
		$row = $this->ContractModel->get_target_creator_info($target);
		$empid = $row->empid;
		$info = $this->ContractModel->get_employee_info($empid);
		$name = $info->first_name.' '.$info->middle_name.' '.$info->last_name; 
		$phone = $info->em_phone;
		$sms ="Hello $name!, Your target has been $status, Please login PMIS for more details";	
        $this->send_sms($phone,$sms);
		}	
		
		if($results){
		$this->session->set_flashdata('message','Target status has been successfully updated');	
		}
		else
		{
		$this->session->set_flashdata('message','Failed to delete upadate target status, Please try again');		
		}
		
	redirect($this->agent->referrer());
	}
	
	public function delete_sub_activity(){
		$activityid = $this->input->get('id');
		$results = $this->ContractModel->delete_sub_activity($activityid);
		if($results){
		$this->session->set_flashdata('message','Sub Activity has been successfully deleted');	
		}else
		{
		$this->session->set_flashdata('message','Failed to delete sub activity, Please try again');		
		}
	redirect($this->agent->referrer());
	}
	
	public function update_sub_activity(){
		$activityid = $this->input->post('activityid');
		$name = $this->input->post('name');
		$results = $this->ContractModel->update_sub_activity($activityid,$name);
		if($results){
		$this->session->set_flashdata('message','Sub activity has been successfully updated');	
		}else
		{
		$this->session->set_flashdata('message','Failed to update sub activity, Please try again');		
		}
	redirect($this->agent->referrer());
	}
	
	public function update_target(){
		$targetid = $this->input->post('targetid');
		//$status = $this->input->post('status');
		$name = $this->input->post('name');
		$marks = $this->input->post('marks');

        $targetinfo = $this->ContractModel->get_target_creator_info($targetid);
		$marksinfo = $this->ContractModel->counter_get_performance_employee_target_list();
		$overallmarks =  @$marksinfo->totalmarks-@$targetinfo->marks;

		$finaloveralmarks = $overallmarks+$marks;

		//////////message
		$getoverallmarks = 100-@$marksinfo->totalmarks;

		if($finaloveralmarks<=100){
		////////SUCCESS

		$results = $this->ContractModel->update_target($targetid,$name,$marks);
		if($results){
		$this->session->set_flashdata('message','Target has been successfully updated');	
		} else {
		$this->session->set_flashdata('message','Failed to update target, Please try again');		
		}

		} else {
        $this->session->set_flashdata('feedback','Failed to update target, Your remaining marks: '.$getoverallmarks.' ');	
		}

	redirect(base_url('Contract/performace_targets'));
	}
	
	public function view_activities(){
		$targetid = base64_decode($this->input->get('I'));
		//$targetname = $this->input->get('targetname');
		$empid = $this->session->userdata('user_emid');
		$targetinfo = $this->ContractModel->get_target_creator_info($targetid);
		$data['targetmarks'] = $targetinfo->marks;
		$data['Targetname'] = $this->session->set_userdata('targetname',$targetinfo->target_name);
		$data['Targetid'] = $this->session->set_userdata('targetid',$targetid);
		$data['listindicators'] = $this->ContractModel->view_target_activities($targetid);
        $this->load->view('tpc_contract/target_activities',$data);		
	}

	public function view_approved_activities(){
		$targetid = $this->input->get('targetid');
		$targetname = $this->input->get('targetname');
		$data['Targetname'] = $this->session->set_userdata('targetname',$targetname);
		$data['listemployee'] = $this->ContractModel->assign_list_employees();
		$data['listindicators'] = $this->ContractModel->view_target_activities($targetid);
        $this->load->view('tpc_contract/view_approved_activity',$data);		
	}
	
	public function sub_activities(){
		$activityid = base64_decode($this->input->get('I'));
		//$activityname = $this->input->get('activityname');
		$empid = $this->session->userdata('user_emid');

		/////////Get indicators Information
        $indicatorinfo = $this->ContractModel->get_indicator_full_information($activityid);
		
		$data['ActivityName'] = $this->session->set_userdata('activityname',$indicatorinfo->indicator_name);
		$data['ActivityID'] = $this->session->set_userdata('activityid',$activityid);
		$data['listindicators'] = $this->ContractModel->view_sub_activities($activityid);
        $this->load->view('tpc_contract/sub_activities',$data);		
	}

	public function approved_sub_activity(){
		$activityid = $this->input->get('activityid');
		$activityname = $this->input->get('activityname');
		$empid = $this->session->userdata('user_emid');
		
		$data['ActivityName'] = $this->session->set_userdata('activityname',$activityname);
		$data['ActivityID'] = $this->session->set_userdata('activityid',$activityid);
		$data['listindicators'] = $this->ContractModel->view_sub_activities($activityid);
        $this->load->view('tpc_contract/approved_sub_activity',$data);		
	}

	public function attach_sub_activity_evidence(){
		$activityid = $this->input->get('activityid');
		$activityname = $this->input->get('activityname');
		$empid = $this->session->userdata('user_emid');
		
		$data['ActivityName'] = $this->session->set_userdata('activityname',$activityname);
		$data['ActivityID'] = $this->session->set_userdata('activityid',$activityid);
		$data['listindicators'] = $this->ContractModel->attach_view_sub_activities($activityid);
        $this->load->view('tpc_contract/attach_sub_activity_evidence',$data);		
	}
	
	public function update_indicator(){
		$indicatorid = $this->input->post('indicatorid');
	    $name = $this->input->post('name');
		$weight = $this->input->post('weight');

		/////////Get indicators Information
		$indicatorinfo = $this->ContractModel->get_indicator_full_information($indicatorid);
        
          /////////target information
		$targetinfo = $this->ContractModel->get_target_creator_info($indicatorinfo->performace_target_id);
		$targettotal = $targetinfo->marks;

		/////////Target Activity Current Total
		$activityinfo = $this->ContractModel->counter_target_activity_info($indicatorinfo->performace_target_id);
		$totalmarks = $activityinfo->totalmarks-$indicatorinfo->weight;

		//////////message
		$getoverallmarks = $targettotal-$activityinfo->totalmarks;

		$finalmarks = $totalmarks+$weight;

		if($finalmarks<=$targettotal){

		//////SUCCESS
		$this->ContractModel->update_indicator($indicatorid,$name,$weight);
		$this->session->set_flashdata('message','Activity has been successfully updated');	

		} else {

		 $this->session->set_flashdata('feedback','Failed to update activity, Your remaing marks: '.$getoverallmarks.'');

		}


	    redirect($this->agent->referrer());
	}
	
		public function update_status_indicator(){
		$indicatorid = $this->input->post('indicatorid');
	    $status = $this->input->post('status');
		$results = $this->ContractModel->update_status_indicator($indicatorid,$status);
		if($results){
		$this->session->set_flashdata('message','Key performace indicator status has been successfully updated');	
		}else
		{
		$this->session->set_flashdata('message','Failed to update key performace indicator status, Please try again');		
		}
	redirect(base_url('Contract/performace_indicators'));
	}
	
		public function reset_assigned_tasks(){
		$results = $this->ContractModel->reset_assigned_tasks();
		if($results){
		$this->session->set_flashdata('message','All Key performace indicators has been successfully reseted');	
		}else
		{
		$this->session->set_flashdata('message','Failed to reset all key performace indicators, Please try again');		
		}
	redirect(base_url('Contract/performace_indicators'));
	}
		
	
	public function submit_rating_task(){
		$empid = $this->session->userdata('user_emid');
		$evidenceid = $this->input->post('evidenceid');
		$rating = $this->input->post('rating');
		
		$results = $this->ContractModel->submit_task_rating($evidenceid,$rating,$empid);
		if($results){
		$this->session->set_flashdata('message','Rating has been successfully submitted');	
		}else
		{
		$this->session->set_flashdata('message','Failed! Please rating again');		
		}
	redirect(base_url('Contract/assigned_tasks'));
	}
	
	public function performace_indicators()
	{       
	        $empid = $this->session->userdata('user_emid');
            $data['design'] = $this->employee_model->getdesignation();
			$data['listtarget'] = $this->ContractModel->get_performance_target_list($empid);
			$data['listindicators'] = $this->ContractModel->get_performance_indicators_list();
			$data['listusertype'] = $this->ContractModel->list_usertype();
            $this->load->view('tpc_contract/performace_indicators',$data);
    }
	
	public function approved_targets()
	{ 
            
            $empid = $this->session->userdata('user_emid');
			$data['design'] = $this->employee_model->getdesignation();
			//$data['listtarget'] = $this->ContractModel->get_approved_performance_target_list($empid);
			$data['listtarget'] = $this->ContractModel->get_performance_employee_target_list_approved();
            $this->load->view('tpc_contract/approved_targets',$data);

            /*$data['design'] = $this->employee_model->getdesignation();
			$data['listindicators'] = $this->ContractModel->assigned_indicators_list();
			$data['listemployee'] = $this->ContractModel->assign_list_employees();*/
            
    }
	
	
	public function assigned_tasks()
	{       $empid = $this->session->userdata('user_emid');
            $data['design'] = $this->employee_model->getdesignation();
			$data['listassignedtask'] = $this->ContractModel->assigned_employee_task($empid);
            $this->load->view('tpc_contract/assigned_tasks',$data);
    }
	
	public function my_tasks()
	{       $empid = $this->session->userdata('user_emid');
            $data['design'] = $this->employee_model->getdesignation();
			$data['listmytask'] = $this->ContractModel->my_task($empid);
			$data['listemployee'] = $this->ContractModel->assign_list_employees();
            $this->load->view('tpc_contract/my_tasks',$data);
    }
	
	public function unassigned_task(){
		$taskid = $this->input->get('taskid');
		$indicatorid = $this->input->get('indicatorid');
		//update task 
		$taskupdate = $this->ContractModel->update_task_status($taskid);
		$indicatorupdate = $this->ContractModel->update_indicator_status($indicatorid);
		if($taskupdate && $indicatorupdate){
		$this->session->set_flashdata('message','Un-assigned task has been successfully');	
		}
		else
		{
		$this->session->set_flashdata('message','Un-assigned task failed');	
		}
        redirect(base_url('Contract/assigned_tasks'));
	}
	
	public function submit_attached_evidence(){
		 $empid = $this->session->userdata('user_emid');
		 $taskid = $this->input->post('taskid');
		 $subtaskid = $this->input->post('subtaskid');

         //Check if evidence already published
         $countevd =  $this->ContractModel->check_evidence($empid,$taskid,$subtaskid);
         if($countevd==0){

		 $emrand1 = substr($empid,0,3).rand(1000,2000); 
         $emrand = str_replace("'", '', $emrand1);
		 if($_FILES['image_url']['name']){

            $file_name = $_FILES['image_url']['name'];
			$fileSize = $_FILES["image_url"]["size"]/1024;
			$fileType = $_FILES["image_url"]["type"];
			$new_file_name='';
            $new_file_name .= $emrand;

            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./assets/images/task_evidence",
                'allowed_types' => "pdf",
                'overwrite' => False,
                'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "800",
                'max_width' => "800"
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('image_url')) {
                echo $this->upload->display_errors();
			}
			else 
			{
                $path = $this->upload->data();
                $img_url = $path['file_name'];
                $data = array();
                $data = array(
                    'task_id' => $taskid,
                    'sub_actid' => $subtaskid,
                    'attached_by' => $empid,
                    'attach_evidence' => $img_url
                );
            $this->ContractModel->submit_evidence($data); 
			$this->session->set_flashdata('message','Sub Activity Evidence has been successfully added');
			//redirect(base_url('Contract/my_tasks'));
			redirect($this->agent->referrer());
			}
		 }
         
         }
         else{
         $this->session->set_flashdata('feedback','You cannot publish multiple evidence on the same sub-activity, Please try again');
		 //redirect(base_url('Contract/my_tasks'));
		  redirect($this->agent->referrer());
         }
 
	}
	
		public function add_indicator(){
		$name = $this->input->post('name');
		$weight = $this->input->post('weight');
		$targetid = $this->input->post('targetid');
		$usertype = $this->session->userdata('user_type');
		$empid = $this->session->userdata('user_emid');

		/////////target information
		$targetinfo = $this->ContractModel->get_target_creator_info($targetid);
		$targettotal = $targetinfo->marks;

		/////////Target Activity Current Total
		$activityinfo = $this->ContractModel->counter_target_activity_info($targetid);
		$totalmarks = $activityinfo->totalmarks;

		//////////message
		$getoverallmarks = $targettotal-@$totalmarks;


        $sumtotal=0;
		foreach($name as $key=>$value){
		$tmarks = $weight[$key];
		$sumtotal+=$tmarks;
		//$results = $this->ContractModel->add_indicator($value,$tmarks,$targetid,$usertype,$empid);
		}

		$finalmarks = $totalmarks+$sumtotal;

		if($finalmarks<=$targettotal){

		/////////SUCCESS
		foreach($name as $key=>$value){
		$tmarks = $weight[$key];
		$results = $this->ContractModel->add_indicator($value,$tmarks,$targetid,$usertype,$empid);
		}
		$this->session->set_flashdata('message','Activity has been successfully added');


		} else {

        $this->session->set_flashdata('feedback','Failed to add activity, Your remaining marks: '.$getoverallmarks.'');	

		}

	    redirect($this->agent->referrer());
	    }
		
		public function add_sub_activity(){
		$name = $this->input->post('name');
		$activityid = $this->input->post('activityid');
		$empid = $this->session->userdata('user_emid');

		foreach($name as $value){
		$results = $this->ContractModel->add_sub_activity($value,$activityid,$empid);
		}
		if($results){
		$this->session->set_flashdata('message','Sub Activity has been successfully added');	
		}else
		{
		$this->session->set_flashdata('message','Failed to add new sub activity, Please try again');		
		}
	    redirect($this->agent->referrer());
	    }
	
        public function assign_employee_task(){
		$providedby = $this->session->userdata('user_emid');
		$taskid = $this->input->post('taskid');
		$receivedby = $this->input->post('receivedby');
		
		//Receiver Information
        $info = $this->ContractModel->get_employee_info($receivedby);
		$name = $info->first_name.' '.$info->middle_name.' '.$info->last_name;
		$phone = $info->em_phone;
		$sms ="Hello $name!, You have a new activity, Please log in PMIS for more details";	
		
		$results = $this->ContractModel->add_assigned_task($providedby,$receivedby,$taskid);
		if($results){
		//update task or indicator
		$this->ContractModel->update_assigned_task($taskid);
		//Send SMS
		$this->send_sms($phone,$sms);
		$this->session->set_flashdata('message','Activity has been successfully assisgned');	
		}else
		{
		$this->session->set_flashdata('message','Failed to add new activity, Please try again');		
		}
	    redirect($this->agent->referrer());
	    }
		
		
	
	public function search_usertype_indicator(){
		$target = $this->input->post('target');
		$usertype = $this->input->post('usertype');
		
		$results = $this->ContractModel->search_performance_indicators_list($target,$usertype);
		if($results){
		$value = $this->ContractModel->get_single_target($target);
		$targetname = $value->target_name;
		$data['usertype'] = $usertype;
		$data['target'] = $targetname;
		$data['design'] = $this->employee_model->getdesignation();
		$data['listtarget'] = $this->ContractModel->get_performance_target_list();
		$data['listusertype'] = $this->ContractModel->list_usertype();
        $data['searchlistindicator'] = $this->ContractModel->search_performance_indicators_list($target,$usertype);
		$this->load->view('tpc_contract/performace_indicators',$data);
		}
		else
		{
		$this->session->set_flashdata('message','No results found, Please try again');	
        redirect(base_url('Contract/performace_indicators'));		
		}
	}
	
	
		public function search_usertype_assigned_indicator(){
		$target = $this->input->post('target');
		$usertype = $this->session->userdata('user_type');
		
		$results = $this->ContractModel->usertype_search_indicators_list($target,$usertype);
		if($results){
		$value = $this->ContractModel->get_single_target($target);
		$targetname = $value->target_name;
		$data['target'] = $targetname;
		$data['design'] = $this->employee_model->getdesignation();
		$data['listtarget'] = $this->ContractModel->list_user_type_active_target($usertype);
        $data['searchlistindicator'] = $this->ContractModel->usertype_search_indicators_list($target,$usertype);
		$this->load->view('tpc_contract/assigned_usertype_performance_indicator',$data);
		}
		else
		{
		$this->session->set_flashdata('message','No results found, Please try again');	
        redirect(base_url('Contract/assigned_usertype_performance_indicator'));		
		}
	}

	public function GetEmployee(){
	$region = $this->input->post('region');
    echo $this->ContractModel->GetEmployeeById($region);
	}
	
	/// ********* SEND SMS FUNCTION ************
   function send_sms($s_mobile,$sms)
    {
         $mobile = trim($s_mobile);
         $mobile = str_replace(array(' ','-'), '',  $mobile);
        $mobile = '255'.substr($mobile, -9);
        $url = 'http://192.168.33.2/modules/otsms/process.php?msisdn='.$mobile.'&message='.urlencode($sms);
      
                $urloutput=file_get_contents($url);
           
              
    }

}