<?php

class Job_assign_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}

        public function Update_Counterss($csup1,$counter1){
                $db2 = $this->load->database('otherdb', TRUE);
                $db2->where('counter_id', $counter1);
                $db2->update('counters',$csup1);
            }
        public function Update_Ccounter_Assign($csup2,$counter){
                $db2 = $this->load->database('otherdb', TRUE);
                $db2->where('counter_id', $counter);
                $db2->update('counters',$csup2);
            }
        public function delete_service($jobid){
              $db2 = $this->load->database('otherdb', TRUE);
              $db2->delete('service_job_counter',array('jobassign_id'=> $jobid));
          }
       
}
?>