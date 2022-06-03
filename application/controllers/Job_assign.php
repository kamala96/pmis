 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_assign extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('unregistered_model');
        $this->load->model('leave_model');
        $this->load->model('job_assign_model');
        $this->load->model('Box_Application_model');
        $this->load->helper('url');
    }
    
public function  Assign_Service()
    {
        if($this->session->userdata('user_login_access') != False) {
            
            $data['emid']= base64_decode($this->input->get('I'));
            $id = base64_decode($this->input->get('I'));
            $data['service2'] = $this->Box_Application_model->get_services_byEmIds($id); 

            $this->load->view('inlandMails/assign_job',$data);

        }else{
            redirect(base_url());
        }
    }
    public function Assign_Service_Action(){
        if ($this->session->userdata('user_login_access') != false) {

            $db2 = $this->load->database('otherdb', TRUE);

            $counter = $this->input->post('counter');
            $service = $this->input->post('serv_id');
            $id = $ids = $assign_to = $this->input->post('emid');
            $assign_by = $this->session->userdata('user_login_id');



            $getCI =  $this->unregistered_model->check_job_assign($ids);

            if (!empty($getCI)) {
            
                $counter1 = $getCI->counter_id;
                $csup1 = array();
                $csup1 = array('c_status'=>'NotAssign');
                $this->job_assign_model->Update_Counterss($csup1,$counter1);
                $jobid = $getCI->task_id;
                $this->job_assign_model->delete_service($jobid);

                $task_id = $getCI->task_id;
                $db2->set('counter_id',$counter);//if 2 columns
                $db2->where('task_id', $task_id);
                $db2->update('taskjobassign');

                 for ($i=0; $i <@sizeof($service) ; $i++) {
                    $jsc = array();
                    $jsc = array('jobassign_id'=>$task_id,'service_id'=>$service[$i]);
                    $db2->insert('service_job_counter',$jsc);
                 }

                $csup2 = array();
                $csup2 = array('c_status'=>'Assign');
                $this->job_assign_model->Update_Ccounter_Assign($csup2,$counter);

            }else{

                $jobssign = array();
                $jobssign = array('assign_to'=>$assign_to,'assign_by'=>$assign_by,'counter_id'=>$counter);

                $db2->insert('taskjobassign',$jobssign);
                $last_id = $db2->insert_id();

                for ($i=0; $i <@sizeof($service) ; $i++) {
                    $jsc = array();
                    $jsc = array('jobassign_id'=>$last_id,'service_id'=>$service[$i]);
                    $db2->insert('service_job_counter',$jsc);
                }

                $csup = array();
                $csup = array('c_status'=>'Assign');
                $this->job_assign_model->Update_Counterss($csup,$counter);
            }
            
            echo "Successfull Job Assign";

        } else {
            redirect(base_url());
        }
        
    }
    
}