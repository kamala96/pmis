<?php

class Posta_Cash_Model extends CI_Model{
          
          public function regselect(){
		  //$query = $this->db->get('em_region');
		  $sql = "SELECT * FROM em_region ORDER BY region_name ASC";
		  $query  = $this->db->query($sql);
		  $result = $query->result();
		  return $result;
		  }

		  public function regselect_by_restriction(){
		  $Region = $this->session->userdata('user_region');
		  if($this->session->userdata('user_type') == 'SUPER ADMIN' || $this->session->userdata('user_type') == 'ADMIN'){
		  $sql = "SELECT * FROM em_region ORDER BY region_name ASC";
		  } else {
		  $sql = "SELECT * FROM em_region WHERE region_name='$Region' ORDER BY region_name ASC";
		  }
		  $query  = $this->db->query($sql);
		  $result = $query->result();
		  return $result;
		  }
	
	public function find_agents($fromdate,$todate,$region,$branch){
	$otheruser = $this->session->userdata('user_region');
	$empid = $this->session->userdata('user_emid');
	$otherstatus = "Pending";

    $db2 = $this->load->database('otherdb', TRUE);
	$qry = "SELECT * from postacash_agents WHERE ";

    if($fromdate != '' && $todate != '') {
    $qry .= "DATE(agent_registered_date) BETWEEN '$fromdate' AND '$todate' AND ";
    }

    if($this->session->userdata('user_type') == 'SUPER ADMIN' || $this->session->userdata('user_type') == 'ADMIN'){
    if($region != '') {
    $qry .= "agent_region='".$region."' AND ";
    }
    } elseif($this->session->userdata('user_type') == 'SUPERVISOR'){
    if($empid != ''){
    $qry .= "agent_registered_by='".$empid."' AND ";
    }
    } else {
    if($otheruser != ''){
    $qry .= "agent_region='".$otheruser."' AND ";
    }
    }

    if($branch != '') {
    $qry .= "agent_branch='".$branch."' AND ";
    }

    if($otherstatus != '') {
    $qry .= "agent_status!='".$otherstatus."' AND ";
    }

    $qry .= '1 ORDER BY agent_registered_date DESC';
    $query = $db2->query($qry);
    $result = $query->result();
    return $result;
	}

	public function find_agent_wallat_transactions($fromdate,$todate,$region,$branch){
	$otheruser = $this->session->userdata('user_region');
	$empid = $this->session->userdata('user_emid');
	$paymentfor = "POSTACASHAGENT";

    $db2 = $this->load->database('otherdb', TRUE);
	$qry = "SELECT * FROM transactions INNER JOIN postacash_agents ON postacash_agents.agent_no=transactions.CustomerID WHERE ";

    if($fromdate != '' && $todate != '') {
    $qry .= "DATE(transactiondate) BETWEEN '$fromdate' AND '$todate' AND ";
    }

    if($this->session->userdata('user_type') == 'SUPER ADMIN' || $this->session->userdata('user_type') == 'ADMIN'){
    if($region != '') {
    $qry .= "region='".$region."' AND ";
    }
    } elseif($this->session->userdata('user_type') == 'SUPERVISOR'){
    if($empid != ''){
    $qry .= "agent_registered_by='".$empid."' AND ";
    }
    } else {
    if($otheruser != ''){
    $qry .= "region='".$otheruser."' AND ";
    }
    }

    if($branch != '') {
    $qry .= "district='".$branch."' AND ";
    }

    if($paymentfor != '') {
    $qry .= "PaymentFor='".$paymentfor."' AND ";
    }

    $qry .= '1 ORDER BY transactiondate DESC';
    $query = $db2->query($qry);
    $result = $query->result();
    return $result;
	}

	public function find_postacash_transactions($fromdate,$todate,$keywords){
    $db2 = $this->load->database('otherdb', TRUE);
	$qry = "SELECT * FROM postacash_transfer_monery WHERE ";

    if($fromdate != '' && $todate != '') {
    $qry .= "DATE(transfered_created_at) BETWEEN '$fromdate' AND '$todate' AND ";
    }

    if($keywords != '') {
    $qry .= "sender_phone='$keywords' AND ";
    }

    $qry .= '1 ORDER BY transfered_created_at DESC';
    $query = $db2->query($qry);
    $result = $query->result();
    return $result;
	}

	public function find_postacash_commissions($fromdate,$todate,$keywords){
	$db2 = $this->load->database('otherdb', TRUE);
	$qry = "SELECT * FROM postacash_commission WHERE ";

    if($fromdate != '' && $todate != '') {
    $qry .= "DATE(commision_created_at) BETWEEN '$fromdate' AND '$todate' AND ";
    }

    if($keywords != '') {
    $qry .= "agent_no='$keywords' AND ";
    }

    $qry .= '1 ORDER BY commision_created_at DESC';
    $query = $db2->query($qry);
    $result = $query->result();
    return $result;
	}
	
	public function save_sendmoney($sender_money){
    $db2 = $this->load->database('otherdb', TRUE);
    $db2->insert('postacash_sendmoney',$sender_money);
	}

	public function Save_logs($SaveLogs){
	$db2 = $this->load->database('otherdb', TRUE);
    $db2->insert('postacash_agents_logs',$SaveLogs);
	}

	public function save_agent($data){
    $db2 = $this->load->database('otherdb', TRUE);
    $db2->insert('postacash_agents',$data);
	}

	public function save_receivemoney($receive_money,$sendmoneyid){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('sendmoney_id',$sendmoneyid);
	$db2->update('postacash_sendmoney',$receive_money);
	}

	public function update_agent($data,$agentid){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('agent_id',$agentid);
	$db2->update('postacash_agents',$data);
	}

	public function update_postacash_transfer($data,$transfer_id){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('transfer_id',$transfer_id);
		$db2->update('postacash_transfer_monery',$data);
		}

	public function list_sendmoney(){
        $regionfrom = $this->session->userdata('user_region');
		$empid = $this->session->userdata('user_login_id');
		$Region = $this->session->userdata('user_region');
        $Branch = $this->session->userdata('user_branch');
		$db2 = $this->load->database('otherdb', TRUE);

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
        $sql = "SELECT * FROM postacash_sendmoney WHERE operator='$empid' ORDER BY sendmoney_id DESC";
		}
		elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){
        $sql = "SELECT * FROM postacash_sendmoney WHERE receiver_region='$Region' ORDER BY sendmoney_id DESC";
		}
	    else
	    {
        $sql = "SELECT * FROM postacash_sendmoney ORDER BY sendmoney_id DESC";
		}
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public function check_transaction($pin){
        $regionfrom = $this->session->userdata('user_region');
		$empid = $this->session->userdata('user_login_id');
		$Region = $this->session->userdata('user_region');
        $Branch = $this->session->userdata('user_branch');
		$db2 = $this->load->database('otherdb', TRUE);

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
        $sql = "SELECT * FROM postacash_sendmoney WHERE receiver_region='$Region' AND receiver_branch='$Branch' AND pin='$pin'";
		}
		elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){
        $sql = "SELECT * FROM postacash_sendmoney WHERE receiver_region='$Region' AND pin='$pin'";
		}
	    else
	    {
        $sql = "SELECT * FROM postacash_sendmoney WHERE pin='$pin'";
		}
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

		public function get_senderinfo($sendmoneyid){
		$db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM postacash_sendmoney WHERE sendmoney_id='$sendmoneyid'";
		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	    }

	    public function get_postacash_agent($email,$phone){
	    $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM postacash_agents WHERE agent_email='$email' OR agent_phone='$phone'";
		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	    }

		

	    public function agent_details($agentid){
	    $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM postacash_agents WHERE agent_id='$agentid'";
		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	    }

		public function agent_detailsby_agentno($agentno){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql = "SELECT * FROM postacash_agents WHERE agent_no='$agentno'";
			$query=$db2->query($sql);
			$result = $query->row();
			return $result;
			}

			public function agent_Deposite_detailsby_controlnumb($control_number){
				$db2 = $this->load->database('otherdb', TRUE);
				$sql = "SELECT * FROM postacash_agent_deposit_wallet WHERE control_number='$control_number'";
				$query=$db2->query($sql);
				$result = $query->row();
				return $result;
				}

				public function postakiganyanirealestate_controlnumbercheck($control_number){
					$db2 = $this->load->database('otherdb', TRUE);
					$sql = "SELECT * FROM real_estate_transactions WHERE billid='$control_number'";
					$query=$db2->query($sql);
					$result = $query->row();
					return $result;
					}
	

	    public function get_pending_agents(){
	    $Region = $this->session->userdata('user_region');
	    $db2 = $this->load->database('otherdb', TRUE);
	    if($this->session->userdata('user_type') == 'SUPER ADMIN' || $this->session->userdata('user_type') == 'ADMIN'){
        $sql = "SELECT * FROM postacash_agents WHERE agent_status='Pending' ORDER BY agent_registered_date DESC";
        } else {
        $sql = "SELECT * FROM postacash_agents WHERE agent_status='Pending' AND agent_region='$Region' ORDER BY agent_registered_date DESC";
        }
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	    }

	    public function counter_get_pending_agents(){
	    $Region = $this->session->userdata('user_region');
	    $db2 = $this->load->database('otherdb', TRUE);
	    if($this->session->userdata('user_type') == 'SUPER ADMIN' || $this->session->userdata('user_type') == 'ADMIN'){
        $sql = "SELECT * FROM postacash_agents WHERE agent_status='Pending' ORDER BY agent_registered_date DESC";
        } else {
        $sql = "SELECT * FROM postacash_agents WHERE agent_status='Pending' AND agent_region='$Region' ORDER BY agent_registered_date DESC";
        }
		$query=$db2->query($sql);
		$result = $query->num_rows();
		return $result;
	    }
	
}